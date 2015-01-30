<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\utils;
use vantiv\objs\VantivError;

/** Vantiv Error Exception */
class VantivErrorException extends VantivException
{
	/** VantivError object */
	public $errorResp = null;
	
	/**
	 * Constructor
	 *
	 * @param VantivError $errorResp VantivError response
	 * 
	 */
	public function __construct(VantivError $errorResp)
	{
		parent::__construct(implode(";\n", $errorResp->getErrors()), 0);
		$this->errorResp = $errorResp;
	}
}