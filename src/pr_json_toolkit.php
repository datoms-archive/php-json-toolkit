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
	function get_value_of($key, $json_data="") {
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

	//get an array of objects(or the values of specific keys of the objects) having a particular key=>value pair out of an array of objects
	function get_data($search_key_values, $return_value_of_keys, $json_array="") {
		if($json_array == "") {
			$json_array = $this->data;
		}

		//get the matching JSON objects
		$matched_json_objects = [];
		foreach($json_array as $json_data_key => $json_data_value) {
			$all_search_keys_matched = true;

			foreach($search_key_values as $search_key => $search_value) {
				if($this->get_value_of($search_key, $json_data_value) != $search_value) {
					$all_search_keys_matched = false;
					break;
				}
			}

			if($all_search_keys_matched) {
				$matched_json_objects []= $json_data_value;
			}
		}

		//get the values of the required keys of the matched json objects
		$final_results_array = [];
		foreach($matched_json_objects as $matched_json_key => $matched_json_value) {
			$json_object_to_be_returned = [];
			foreach($return_value_of_keys as $return_search_key) {
				$required_value = $this->get_value_of($return_search_key, $matched_json_value);
				if($required_value) {
					$json_object_to_be_returned[$return_search_key] = $required_value;
				} else {
					$json_object_to_be_returned[$return_search_key] = null;
				}
			}
			$final_results_array []= $json_object_to_be_returned;
		}

		//return the final array containing the required keys of the matched json objects
		return $final_results_array;
	}
}
