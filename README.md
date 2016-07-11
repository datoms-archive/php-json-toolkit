# php-json-toolkit

A simple php library to work with JSON data.

[![Build Status](https://travis-ci.org/Phoenix-Robotix/php-json-toolkit.svg?branch=master)](https://travis-ci.org/Phoenix-Robotix/php-json-toolkit)

# Usage
## Initialize an object to work with
```php
$json_toolkit = new PR_JSON_TOOL_KIT();
```
## Get value of a key
```php
$json_data = '{
	"a": 1,
	"b": {
		"c": 2,
		"d": 3
	}
}';
$value = $json_toolkit->get_value_of("a", $json_data);  //1
$value = $json_toolkit->get_value_of("e", $json_data);  //false
$value = $json_toolkit->get_value_of("b:c", $json_data);  //2
```
## Get objects matching certain criteria
```php
$value = $json_toolkit->get_data(["c" => 2], ["d"], $json_data);  //[{"d" => 3}]
$value = $json_toolkit->get_data(["c" => 2], [], $json_data); //[{"c" => 2, "d" => 3}]
$value = $json_toolkit->get_data(["c" => 4], [], $json_data); //[]
```

# Class
PR_JSON_TOOL_KIT

# Properties
## $data
- Private
- Associative array
- Parsed JSON data to work with

## $key_separator
- Private
- String
- The separator string to use for parsing a multi-level key.  
Ex:

```php
//JSON Data:
{
	"a": 1,
	"b": {
		"c": 2,
		"d": 3
	}
}
```
To get the value of `"d"` from the above JSON data, the key will be passed as follows:  
b**{key_separator}**d

# Methods
## __construct
__construct (string $json_string = '[]', string $key_separator = ':')
- Public
- Constructor function
- Parameters
  1. $json_string  
     The JSON string to parse and use as the data source `($data)`  
     Default value: `'[]'`
  2. $key_separator  
     The separator string to use for parsing a multi-level key  
     Default value: `':'`
- Return values
  1. Returns nothing

## get_value_of
public mixed get_value_of (string $key, string $json_data="")
- Public
- Get value of a key from the json data
- Parameters
  1. $key  
     The key to search for in the data source `($data)`  
     The key may be a simple key `("key")` or a multi-level key where the keys are separated by the `$key_separator ("lvl_1:lvl_2:lvl_3")`
  2. $json_data  
     The JSON string to parse and use as the data source `($data)`  
     If no string provided, then the data source initialized by the constructor function will be used.
- Return values
  1. Returns the value of the key on success
  2. Returns `false` if key not found

## get_data
public array get_data (array $search_key_values, array $return_value_of_keys=[], string $json_array="")
 - Public
 - Get an array of objects(or the values of specific keys of the objects) having a particular key=>value pair out of an array of objects
 - Parameters
  1. $search_key_values  
     An array containing the `key => value` pairs to search for
  2. $return_value_of_keys
     An array containing the keys whose values to be returned if a match found.  
     If no key specified, then the entire matched objects will be returned.
  3. $json_array
     The JSON string to parse and use as the data source `($data)`
     If no string provided, then the data source initialized by the constructor function will be used.
 - Return values
  1. Returns an array containing the objects with required key value pairs of the matched objects
  2. Returns an empty array `([])` if no match found