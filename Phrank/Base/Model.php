<?php
namespace Phrank\Base;

abstract class Model extends \Model
{
	// Column names that can be loaded in from input data (eg, POST)
	public $public_fields = [];

	/**
	 * Retrieve an instance of the logger singleton.
	 */
	public function getLogger()
	{
		$container = \Phrank\Base\Container::getInstance();
		return $container['logger'];
	}

	/**
	 * Given an assoc. array of data, load fields into the model.
	 * If `$fields` is unspecified, then the object's `$public_fields` list
	 * will be used.
	 *
	 * @param array $data   Data from which to import fields (eg: $_POST)
	 * @param array $fields Array of field names that will be copied.
	 */
	public function import($data, $fields=null)
	{
		if(is_null($fields)) {
			$fields = $this->public_fields;
		}
		foreach($fields as $field) {
			if(isset($data[$field])) $this->{$field} = $data[$field];
		}
	}

	/**
	 * Return an assoc. array of fields from the model object to the caller.
	 * If `$fields` is unspecified, then the object's `$public_fields` list
	 * will be used.
	 *
	 * @param array $fields Array of field names that will be copied.
	 * @return array
	 */
	public function export($fields=null)
	{
		if(is_null($fields)) {
			$fields = $this->public_fields;
		}
		$data = [];
		foreach($fields as $field) {
			if(isset($this->{$field})) $data[$field] = $this->{$field};
		}
		return $data;
	}
}

?>
