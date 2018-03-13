<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\utils;

/** Vantiv Invalid Request Exception */
class InvalidRequestException extends VantivException
{
	/** Error array */
	public $error = null;
	
	/**
	 * Constructor
	 *
	 * @param string $msg Error message
	 * @param int $code Error code
	 * @param array $error Error array
	 * 
	 */
	public function __construct($msg = null, $code = 0, $error)
	{
		parent::__construct($msg, $code);
		$this->error = $error;
	}
}