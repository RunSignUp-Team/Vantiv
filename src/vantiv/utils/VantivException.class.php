<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\utils;

/** Vantiv Exception */
class VantivException extends \Exception
{
	/**
	 * Constructor
	 *
	 * @param string $msg Error message
	 * @param int $code Error code
	 */
	public function __construct($msg = null, $code = 0)
	{
		parent::__construct($msg, $code);
	}
}