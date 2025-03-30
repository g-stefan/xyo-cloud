<?php
//
// XYO Crypt Library
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT


defined("XYO_CLOUD") or die("Access is denied");

class xyo_Crypt{

	static function xorOperation(&$a, $aIndex, $aLn, $b, $bIndex, $bLn){
		while(($aLn>0)&&($bLn>0)) {
			$a[$aIndex]=chr(ord($a[$aIndex]) ^ ord($b[$bIndex]));
			--$aLn;
			--$bLn;
			++$aIndex;
			++$bIndex;
		};
	}

	static function copy(&$a, $aIndex, $aLn, $b, $bIndex, $bLn){
		while(($aLn>0)&&($bLn>0)) {
			$a[$aIndex]=chr(ord($b[$bIndex]));
			--$aLn;
			--$bLn;
			++$aIndex;
			++$bIndex;
		};
	}

	static function u64FromU8($in){
		$retV=0;
		$retV = ord($in[7]);
		$retV <<= 8;
		$retV |= ord($in[6]);
		$retV <<= 8;
		$retV |= ord($in[5]);
		$retV <<= 8;
		$retV |= ord($in[4]);
		$retV <<= 8;
		$retV |= ord($in[3]);
		$retV <<= 8;
		$retV |= ord($in[2]);
		$retV <<= 8;
		$retV |= ord($in[1]);
		$retV <<= 8;
		$retV |= ord($in);
		return $retV;
	}

	static function u64ToU8($in, &$out) {
		$out[0] = chr(($in)&0x00FF);
		$in>>=8;
		$out[1] = chr(($in)&0x00FF);
		$in>>=8;
		$out[2] = chr(($in)&0x00FF);
		$in>>=8;
		$out[3] = chr(($in)&0x00FF);
		$in>>=8;
		$out[4] = chr(($in)&0x00FF);
		$in>>=8;
		$out[5] = chr(($in)&0x00FF);
		$in>>=8;
		$out[6] = chr(($in)&0x00FF);
		$in>>=8;
		$out[7] = chr(($in)&0x00FF);
	}

	static function timestampInMilliseconds() {
		$microTime= explode(" ", microtime());
		return sprintf("%d%03d", $microTime[1], $microTime[0] * 1000);
	}

	static function passwordEncrypt($password,$data,&$output) {
		$dataSize=strlen($data);
		//
		$dataLn=(floor($dataSize/64)+1)*64;
		$outputSize=64+64+8+$dataLn;
		$output=str_repeat("X",$outputSize);
		//
		$randomSalt=hash_init("sha512");
		hash_update($randomSalt,$password);
		hash_update($randomSalt,$data);
		hash_update($randomSalt,self::timestampInMilliseconds());
		$randomSalt=hash_final($randomSalt,true);
		self::copy($output,0,64,$randomSalt,0,64);
		//
		$keyBase=hash_init("sha512");
		hash_update($keyBase,substr($randomSalt,0,64));
		hash_update($keyBase,$password);
		$keyBase=hash_final($keyBase,true);	
		self::copy($output,64,64,$keyBase,0,64);
		//
		$lnBuffer=str_repeat("X",8);	
		$xorBuffer=str_repeat("X",64);
		//
		$key=hash_init("sha512");
		hash_update($key,$randomSalt);
		hash_update($key,$keyBase);
		//
		self::u64ToU8(0,$lnBuffer);
		$keyActive=hash_copy($key);
		hash_update($keyActive,substr($lnBuffer,0,8));
		$xorBuffer=hash_final($keyActive,true);
		self::u64ToU8($dataSize,$lnBuffer);
		self::xorOperation($xorBuffer,0,8,$lnBuffer,0,8);
		self::copy($output,64+64,8,$xorBuffer,0,8);
		//
		$dataLnX=0;
		$dataToProcess=$dataSize;
		for($k=0,$counter=1; $k<$dataLn; $k+=64,$dataToProcess-=64,++$counter) {
			self::u64ToU8($counter,$lnBuffer);
			$keyActive=hash_copy($key);
			hash_update($keyActive,substr($lnBuffer,0,8));
			$xorBuffer=hash_final($keyActive,true);

			if($dataToProcess>64) {
				$dataLnX=64;
			} else {
				$dataLnX=$dataToProcess;
			};

			self::xorOperation($xorBuffer,0,64,$data,$k,$dataLnX);
			self::copy($output,64+64+8+$k,64,$xorBuffer,0,64);
		};
		//
		//
		$checkHash=hash_init("sha512");
		hash_update($checkHash,$output);
		$checkHash=hash_final($checkHash,true);
		self::copy($output,64,64,$checkHash,0,64);
		//
	}

	static function passwordDecrypt($password,$data,&$output) {
		$dataSize_=strlen($data);
		//
		$lnBuffer=str_repeat("X",8);
		$xorBuffer=str_repeat("X",64);
		$dataSize=0;
		$dataLn=0;
		//
		if($dataSize_<64+64+8) {
			return false;
		};
		//
		$keyBase=hash_init("sha512");
		hash_update($keyBase,substr($data,0,64));
		hash_update($keyBase,$password);
		$keyBase=hash_final($keyBase,true);
		//
		$key=hash_init("sha512");
		hash_update($key,substr($data,0,64));	
		hash_update($key,substr($keyBase,0,64));
		//
		$keyActive=hash_copy($key);
		self::u64ToU8(0,$lnBuffer);
		hash_update($keyActive,substr($lnBuffer,0,8));
		$xorBuffer=hash_final($keyActive,true);
		self::copy($lnBuffer,0,8,$data,64+64,8);
		self::xorOperation($lnBuffer,0,8,$xorBuffer,0,8);
		//
		$dataSize=self::u64FromU8($lnBuffer);
		$dataLn=(floor($dataSize/64)+1)*64;
		if(64+64+8+$dataLn>$dataSize_) {
			return false;
		};
		//
		//
		$checkHash=hash_init("sha512");
		hash_update($checkHash,substr($data,0,64));
		hash_update($checkHash,substr($keyBase,0,64));
		hash_update($checkHash,substr($data,64+64,8));
		hash_update($checkHash,substr($data,64+64+8,$dataLn));
		$checkHash=hash_final($checkHash,true);
		//
		if(strcmp($checkHash,substr($data,64,64))!=0) {
			return false;
		};
		//
		$output=str_repeat("X",$dataSize);
		//
		//
		$dataLnX=0;
		$dataToProcess=$dataSize;
		for($k=0,$counter=1; $k<$dataLn; $k+=64,$dataToProcess-=64,++$counter) {
			self::u64ToU8($counter,$lnBuffer);
			$keyActive=hash_copy($key);
			hash_update($keyActive,substr($lnBuffer,0,8));
			$xorBuffer=hash_final($keyActive,true);

			if($dataToProcess>64) {
				$dataLnX=64;
			} else {
				$dataLnX=$dataToProcess;
			};

			self::xorOperation($xorBuffer,0,64,$data,64+64+8+$k,$dataLnX);
			self::copy($output,$k,$dataLnX,$xorBuffer,0,$dataLnX);
		};
		//	
		return true;
	}

	static function passwordEncryptFile($password,$fileNameIn,$fileNameOut) {
		$fileContents=file_get_contents($fileNameIn);
		if($fileContents!==false){
			$output="";
			self::passwordEncrypt($password,$fileContents,$output);
			return (file_put_contents($fileNameOut,$output)===strlen($output));
		};
		return false;
	}

	static function passwordDecryptFile($password,$fileNameIn,$fileNameOut) {
		$fileContents=file_get_contents($fileNameIn);
		if($fileContents!==false){
			$output="";
			self::passwordDecrypt($password,$fileContents,$output);
			return (file_put_contents($fileNameOut,$output)===strlen($output));
		};
		return false;
	}


	//
	// OpenSSL extension
	//

	static function privateEncrypt($privateKey,$data,&$output) {
		$rsaKey=openssl_pkey_get_private($privateKey);
		if($rsaKey!==false){
			$rsaInfo=openssl_pkey_get_details($rsaKey);
			if($rsaInfo!==false){
				$rsaSize=floor($rsaInfo["bits"]/8);
				if($rsaSize>=64){

					$randomSalt=hash_init("sha512");
					hash_update($randomSalt,$privateKey);
					hash_update($randomSalt,$data);
					hash_update($randomSalt,self::timestampInMilliseconds());
					$randomSalt=hash_final($randomSalt,true);

					$randomKey="";

					if(openssl_private_encrypt($randomSalt,$randomKey,$rsaKey,OPENSSL_PKCS1_PADDING)){
						$keyData=str_repeat("X",$rsaSize);
						self::copy($keyData,0,$rsaSize,$randomKey,0,$rsaSize);
						$outputData="";
						self::passwordEncrypt($randomSalt,$data,$outputData);
						$output=$keyData.$outputData;
						return true;
					};

				};
			};
	
		};
		return false;
	}

	static function privateDecrypt($privateKey,$data,&$output) {
		$rsaKey=openssl_pkey_get_private($privateKey);
		if($rsaKey!==false){
			$rsaInfo=openssl_pkey_get_details($rsaKey);
			if($rsaInfo!==false){
				$rsaSize=floor($rsaInfo["bits"]/8);
				if($rsaSize>=64){
					$randomKey=substr($data,0,$rsaSize);
					$randomSalt="";
					if(openssl_private_decrypt($randomKey,$randomSalt,$rsaKey)){
						return self::passwordDecrypt($randomSalt,substr($data,$rsaSize,strlen($data)-$rsaSize),$output);
					};
					echo openssl_error_string();
				};
			};
	
		};
		return false;
	}

	static function publicEncrypt($privateKey,$data,&$output) {
		$rsaKey=openssl_pkey_get_public($privateKey);
		if($rsaKey!==false){
			$rsaInfo=openssl_pkey_get_details($rsaKey);
			if($rsaInfo!==false){
				$rsaSize=floor($rsaInfo["bits"]/8);
				if($rsaSize>=64){

					$randomSalt=hash_init("sha512");
					hash_update($randomSalt,$privateKey);
					hash_update($randomSalt,$data);
					hash_update($randomSalt,self::timestampInMilliseconds());
					$randomSalt=hash_final($randomSalt,true);
					$randomKey="";

					if(openssl_public_encrypt($randomSalt,$randomKey,$rsaKey)){
						$keyData=str_repeat("X",$rsaSize);
						self::copy($keyData,0,$rsaSize,$randomKey,0,$rsaSize);
						$outputData="";
						self::passwordEncrypt($randomSalt,$data,$outputData);
						$output=$keyData.$outputData;
						return true;
					};

				};
			};

		};
		return false;
	}

	static function publicDecrypt($privateKey,$data,&$output) {
		$rsaKey=openssl_pkey_get_public($privateKey);
		if($rsaKey!==false){
			$rsaInfo=openssl_pkey_get_details($rsaKey);
			if($rsaInfo!==false){
				$rsaSize=floor($rsaInfo["bits"]/8);
				if($rsaSize>=64){
					$randomKey=substr($data,0,$rsaSize);
					$randomSalt="";
					if(openssl_public_decrypt($randomKey,$randomSalt,$rsaKey)){
						return self::passwordDecrypt($randomSalt,substr($data,$rsaSize,strlen($data)-$rsaSize),$output);
					};
				};
			};

		};
		return false;
	}

	static function privateEncryptFile($privateKey,$fileNameIn,$fileNameOut) {
		$fileContents=file_get_contents($fileNameIn);
		if($fileContents!==false){
			$output="";
			if(self::privateEncrypt($privateKey,$fileContents,$output)){
				return (file_put_contents($fileNameOut,$output)===strlen($output));
			};
		};
		return false;
	}

	static function privateDecryptFile($privateKey,$fileNameIn,$fileNameOut) {
		$fileContents=file_get_contents($fileNameIn);
		if($fileContents!==false){
			$output="";
			if(self::privateDecrypt($privateKey,$fileContents,$output)){
				return (file_put_contents($fileNameOut,$output)===strlen($output));
			};
		};
		return false;
	}

	static function publicEncryptFile($publicKey,$fileNameIn,$fileNameOut) {
		$fileContents=file_get_contents($fileNameIn);
		if($fileContents!==false){
			$output="";
			if(self::publicEncrypt($publicKey,$fileContents,$output)){
				return (file_put_contents($fileNameOut,$output)===strlen($output));
			};
		};
		return false;
	}

	static function publicDecryptFile($publicKey,$fileNameIn,$fileNameOut) {
		$fileContents=file_get_contents($fileNameIn);
		if($fileContents!==false){
			$output="";
			if(self::publicDecrypt($publicKey,$fileContents,$output)){
				return (file_put_contents($fileNameOut,$output)===strlen($output));
			};
		};
		return false;
	}

};

