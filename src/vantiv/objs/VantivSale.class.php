<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\objs;
use vantiv\utils\VantivResponseCodes;

/** Vantiv Sale Object */
class VantivSale extends VantivObj
{
	/**
	 * Get transaction id
	 *
	 * @return string Transaction id
	 */
	public function getTransactionId()
	{
		return isset($this->saleResponse['litleTxnId']) ? $this->saleResponse['litleTxnId'] : null;
	}

	/**
	 * Check if a duplicate was detected
	 *
	 * @return bool True if a duplicate
	 */
	public function isDuplicate()
	{
		return isset($this->xmlAttrs['saleResponse']['duplicate']) && $this->xmlAttrs['saleResponse']['duplicate'] === 'true';
	}

	/**
	 * Get response code
	 *
	 * @return string Response code
	 */
	public function getResponse()
	{
		return isset($this->saleResponse['response']) ? $this->saleResponse['response'] : null;
	}
	
	/**
	 * Get response message
	 *
	 * @return string Response message
	 */
	public function getResponseMessage()
	{
		return isset($this->saleResponse['message']) ? $this->saleResponse['message'] : null;
	}

	/**
	 * Get network transaction ID
	 *
	 * @return string|null Network transaction ID
	 */
	public function getNetworkTransactionId()
	{
		return isset($this->saleResponse['networkTransactionId']) ? $this->saleResponse['networkTransactionId'] : null;
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