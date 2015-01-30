<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\utils;
use \vantiv\objs\VantivObj;
use \vantiv\objs\VantivError;
use \vantiv\utils\VantivException;
use \vantiv\utils\VantivErrorException;

/** Vantiv Response */
class VantivResponse
{
	/** Response string */
	public $respStr = null;
	
	/** Response */
	public $resp = null;
	
	/** HTTP Status code */
	public $statusCode = null;
	
	/**
	 * Constructor
	 *
	 * @param string $resp Response string
	 * @param int $statusCode HTTP status code
	 * @param string $classname Classname
	 * @throws VantivException
	 */
	public function __construct($respStr, $statusCode, $classname)
	{
		$this->respStr = $respStr;
		$this->statusCode = $statusCode;
		
		// Parse response
		if ($this->respStr !== null)
		{
			// Valid response
			if ($this->statusCode == 200 || $this->statusCode == 201)
			{
				$this->resp = new $classname($this->respStr);
				if ($this->resp === false)
					$this->resp = null;
			}
			// Error response with message
			else if ($this->statusCode == 400 || $this->statusCode == 401)
				throw new VantivErrorException(new VantivError($this->respStr));
		}
	}
}