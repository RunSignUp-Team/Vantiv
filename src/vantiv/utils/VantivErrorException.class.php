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
	 * @param int $statusCode Status code
	 */
	public function __construct(VantivError $errorResp, $statusCode)
	{
		parent::__construct(implode(";\n", $errorResp->getErrors()), $statusCode);
		$this->errorResp = $errorResp;
	}
}