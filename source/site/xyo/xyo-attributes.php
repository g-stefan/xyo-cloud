<?php
// Copyright (c) 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// MIT License (MIT) <http://opensource.org/licenses/MIT>
// SPDX-FileCopyrightText: 2009-2025 Grigore Stefan <g_stefan@yahoo.com>
// SPDX-License-Identifier: MIT

defined("XYO_CLOUD") or die("Access is denied");

class xyo_Attributes {

	protected $attributes_;

	public function __construct($defaultAttributes=null) {
		$this->attributes_ = array();
		if ($defaultAttributes) {
			foreach (array_keys($defaultAttributes) as $x) {
				$this->attributes_[$x] = $defaultAttributes[$x];
			};
		};
	}

	public function set($name, $value) {
		$this->attributes_[$name] = $value;
	}

	public function get($name, $default_=null) {
		if ($name) {
			if (array_key_exists($name, $this->attributes_)) {
				return $this->attributes_[$name];
			};
		};
		return $default_;
	}

	public function unsetAttribute($name) {
		if(array_key_exists($name,$this->attributes_)) {
			unset($this->attributes_[$name]);
		}
	}

	public function merge($value) {
		$this->attributes_=array_merge($this->attributes_,$value);
	}

	public function clear() {
		$this->attributes_=array();
	}

	public function is($name) {
		if ($name) {
			if (array_key_exists($name, $this->attributes_)) {
				return true;
			}
		};
		return false;
	}

	public function setAttributes($value) {
		$this->attributes_=$value;
	}

	public function getAttributes() {
		return $this->attributes_;
	}

	public function includeFile($name) {
		if (file_exists($name)) {
			include($name);
			return true;
		};
		return false;
	}

	public function mergeKey($name, $value) {
		if ($name) {
			if (array_key_exists($name, $this->attributes_)) {
				if(is_array($this->attributes_[$name])) {
					$this->attributes_[$name] = array_merge($this->attributes_[$name], $value);
					return;
				};
				$this->attributes_[$name] = array_merge(array($this->attributes_[$name]), $value);
				return;
			};
			$this->attributes_[$name] = $value;
		};
	}

	public function mergeKeyIndex($name, $key, $value) {
		if ($name) {
			if ($key) {
				if (array_key_exists($name, $this->attributes_)) {
					if (array_key_exists($key, $this->attributes_[$name])) {
						if(is_array($this->attributes_[$name][$key])) {
							$this->attributes_[$name][$key] = array_merge($this->attributes_[$name][$key], $value);
							return;
						};
						$this->attributes_[$name][$key] = array_merge(array($this->attributes_[$name][$key]), $value);
						return;
					};
					$this->attributes_[$name][$key] = $value;
					return;
				};
				$this->attributes_[$name] = array ();
				$this->attributes_[$name][$key]=$value;
			};
		};
	}
}

