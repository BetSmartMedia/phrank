<?php
namespace Phrank\Base;

abstract class Model extends \Model
{
	// Column names that can be loaded in from input data (eg, POST)
	public $_fields = [];

	/**
	 * Given a map of data, load fields into the model.
	 */
	public function populate($data, $fields=null)
	{
		if(is_null($fields)) {
			$fields = $this->_fields;
		}
		foreach($fields as $field) {
			if(isset($data[$field])) $this->{$field} = $data[$field];
		}
	}
}

?>
