<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\utils;

/** SFTP Exception */
class SFTPException extends \Exception
{
	/** Output */
	public $output = null;
	
	/**
	 * Constructor
	 *
	 * @param string $msg Error message
	 * @param int $code Error code
	 * @param string $output
	 */
	public function __construct($msg = null, $code = 0, $output = null)
	{
		parent::__construct($msg, $code);
		$this->output = $output;
	}
}