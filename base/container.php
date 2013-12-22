<?php
/**
 * A basic resource container.
 *
 * Usage:
 *   $container = \Phrank\Base\Container::getInstance();
 *   $container['logger'] = $logger;
 *
 */

namespace Phrank\Base;

class Container implements \ArrayAccess, \IteratorAggregate
{
	protected static $instance;
	protected $properties;

	/**
	 * Constructor (private)
	 */
	private function __construct()
	{
		$this->properties = [];
	}

	/**
	 * Return a singleton instance.
	 */
	public static function getInstance()
	{
		if(is_null(self::$instance)) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Array Access: Offset Exists
	 */
	public function offsetExists($offset)
	{
		return isset($this->properties[$offset]);
	}

	/**
	 * Array Access: Offset Get
	 */
	public function offsetGet($offset)
	{
		if (isset($this->properties[$offset])) {
			return $this->properties[$offset];
		} else {
			return null;
		}
	}

	/**
	 * Array Access: Offset Set
	 */
	public function offsetSet($offset, $value)
	{
		$this->properties[$offset] = $value;
	}

	/**
	 * Array Access: Offset Unset
	 */
	public function offsetUnset($offset)
	{
		unset($this->properties[$offset]);
	}

	/**
	 * IteratorAggregate
	 *
	 * @return \ArrayIterator
	 */
	public function getIterator()
	{
		return new \ArrayIterator($this->properties);
	}
}

?>
