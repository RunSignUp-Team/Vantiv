<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\utils;

/** Vantiv Exception */
class VantivException extends \Exception
{
	/**
	 * Constructor
	 *
	 * @param string $msg Error message
	 * @param int $code Error code
	 * @param array $error Error array
	 * 
	 */
	public function __construct($msg = null, $code = 0)
	{
		parent::__construct($msg, $code);
	}
}