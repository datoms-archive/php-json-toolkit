<?php
class PR_JSON_TOOL_KIT {
	//parsed json data as an associative array
	private $data, $key_separator;

	//constructor
	function __construct($json_string = '[]', $key_separator = ':') {
		$this->data = json_decode($json_string, true);
		$this->key_separator = $key_separator;
	}

	//get value of a key from the json data
	function get($key, $json_data="") {
		if($json_data == "") {
			$json_data = $this->data;
		}
		$keys = explode($this->key_separator, $key);
		while(count($keys) && is_array($json_data)) {
			if(array_key_exists($keys[0], $json_data)) {
				$json_data = $json_data[$keys[0]];
				array_shift($keys);
			} else {
				return false;
			}
		}
		if(!count($keys)) {
			return $json_data;
		} else {
			return false;
		}
	}
}
