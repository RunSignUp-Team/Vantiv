<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\objs;
use vantiv\utils\VantivResponseCodes;

/** Vantiv Void Object */
class VantivVoid extends VantivObj
{
	/**
	 * Get transaction id
	 *
	 * @return string Transaction id
	 */
	public function getTransactionId()
	{
		return isset($this->voidResponse['litleTxnId']) ? $this->voidResponse['litleTxnId'] : null;
	}
	
	/**
	 * Get response code
	 *
	 * @return string Response code
	 */
	public function getResponse()
	{
		return isset($this->voidResponse['response']) ? $this->voidResponse['response'] : null;
	}
	
	/**
	 * Get response message
	 *
	 * @return string Response message
	 */
	public function getResponseMessage()
	{
		return isset($this->voidResponse['message']) ? $this->voidResponse['message'] : null;
	}
	
	/**
	 * Was this a successful transaction
	 *
	 * @return bool True if successful
	 */
	public function wasSuccessful()
	{
		return $this->getResponse() === VantivResponseCodes::TRANS_RESP_CODE_APPROVED;
	}
}