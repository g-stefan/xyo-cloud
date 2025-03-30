<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

$fileName = "config/config.website.php";
$fileHandle = null;
if (strlen($fileName)) {
	$fileHandle = fopen($fileName, "w");
};

if ($fileHandle) {
	fwrite($fileHandle, "<" . "?" . "php\r\n");
	fwrite($fileHandle, "defined(\"XYO_CLOUD\") or die(\"Access is denied\");\r\n");
	fwrite($fileHandle, "// \r\n");
	fwrite($fileHandle, "// Website Config\r\n");
	fwrite($fileHandle, "// \r\n");
	fwrite($fileHandle, "\$this->set(\"configured\",true);\r\n");
	fwrite($fileHandle, "\$this->set(\"default_language\",\"" . $this->getSystemLanguage() . "\");\r\n");
	fwrite($fileHandle, "\$this->set(\"locale_date_format\",\"Y-m-d\");\r\n");
	fwrite($fileHandle, "\$this->set(\"locale_datetime_format\",\"Y-m-d H:i:s\");\r\n");
	fwrite($fileHandle, "\$this->set(\"locale_time_format\",\"H:i:s\");\r\n");
	fwrite($fileHandle, "// \r\n");
	fwrite($fileHandle, "// \r\n");
	fwrite($fileHandle, "// \r\n");
	$salt=hash("sha512",date("Y-m-d H:i:s")." - ".rand(),false);
	fwrite($fileHandle, "\$this->set(\"user_login_salt\",\"" . $salt . "\");\r\n");
	$salt=hash("sha512",$salt.".".date("Y-m-d H:i:s")." - ".rand(),false);
	fwrite($fileHandle, "\$this->set(\"user_reco_salt\",\"" . $salt . "\");\r\n");
	$salt=hash("sha512",$salt.".".date("Y-m-d H:i:s")." - ".rand(),false);
	fwrite($fileHandle, "\$this->set(\"service_key\",\"" . $salt . "\");\r\n");

	$key = openssl_pkey_new(array(
		"digest_alg" => "sha512",
		"private_key_bits" => 4096,
		"private_key_type" => OPENSSL_KEYTYPE_RSA
	));

	if($key!==FALSE){

		openssl_pkey_export($key, $keyPrivate);
	
		$keyDetails = openssl_pkey_get_details($key);
		$keyPublic = $keyDetails["key"];
 
		if (PHP_VERSION_ID < 80000) {
			openssl_pkey_free($key);
		};

		fwrite($fileHandle, "\$this->set(\"crypt_rpc_private_key\",\"" . $keyPrivate . "\");\r\n");
		fwrite($fileHandle, "\$this->set(\"crypt_rpc_public_key\",\"" . $keyPublic . "\");\r\n");
	};

	fwrite($fileHandle, "\r\n\r\n");
	fclose($fileHandle);
} else {
	$this->setError(array("error.config_file_not_writable" => $fileName));
};
