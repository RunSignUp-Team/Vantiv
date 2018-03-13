<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\objs;
use vantiv\utils\VantivResponseCodes;

/** Vantiv Credit Object */
class VantivCredit extends VantivObj
{
	/**
	 * Get transaction id
	 *
	 * @return string Transaction id
	 */
	public function getTransactionId()
	{
		return isset($this->creditResponse['litleTxnId']) ? $this->creditResponse['litleTxnId'] : null;
	}

	/**
	 * Check if a duplicate was detected
	 *
	 * @return bool True if a duplicate
	 */
	public function isDuplicate()
	{
		return isset($this->xmlAttrs['creditResponse']['duplicate']) && $this->xmlAttrs['creditResponse']['duplicate'] === 'true';
	}

	/**
	 * Get response code
	 *
	 * @return string Response code
	 */
	public function getResponse()
	{
		return isset($this->creditResponse['response']) ? $this->creditResponse['response'] : null;
	}
	
	/**
	 * Get response message
	 *
	 * @return string Response message
	 */
	public function getResponseMessage()
	{
		return isset($this->creditResponse['message']) ? $this->creditResponse['message'] : null;
	}
	
	/**
	 * Was this a successful transaction
	 *
	 * @return bool True if successful
	 */
	public function wasSuccessful()
	{
		return $this->getResponse() === VantivResponseCodes::TRANS_RESP_CODE_APPROVED && !$this->isDuplicate();
	}
}