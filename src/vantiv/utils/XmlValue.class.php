<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\utils;

/** Vantiv XML Value */
class XmlValue implements \ArrayAccess
{
	/** Value */
	public $value = null;
	
	/** Attributes */
	public $attrs = null;
	
	/**
	 * Contructor
	 *
	 * @param string $value Value
	 * @param array $attrs Attributes
	 */
	public function __construct($value, $attrs = array())
	{
		$this->value = $value;
		$this->attrs = $attrs;
	}
	
	/**
	 * Set array value
	 *
	 * @param mixed $offset Offset
	 * @param mixed $value Value
	 */
	public function offsetSet($offset, $value) {
		$this->value[$offset] = $value;
	}
	
	/**
	 * Check if offset exists
	 * @param mixed $offset Offset
	 */
	public function offsetExists($offset) {
		return isset($this->value[$offset]);
	}
	
	/**
	 * Unset offset
	 * @param mixed $offset Offset
	 */
	public function offsetUnset($offset) {
		unset($this->value[$offset]);
	}
	
	/**
	 * Get offset
	 * @param mixed $offset Offset
	 * @return mixed Value
	 */
	public function offsetGet($offset) {
		return isset($this->value[$offset]) ? $this->value[$offset] : null;
	}
}