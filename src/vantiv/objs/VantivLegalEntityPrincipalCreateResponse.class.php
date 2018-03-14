<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\objs;

/** Vantiv Legal Entity Principal Create Response Object */
class VantivLegalEntityPrincipalCreateResponse extends VantivObj
{
	/**
	 * Get response code
	 *
	 * @return string Response code
	 */
	public function getResponseCode()
	{
		return isset($this->responseCode) ? $this->responseCode : null;
	}
	
	/**
	 * Get response message
	 *
	 * @return string Response message
	 */
	public function getResponseMessage()
	{
		return isset($this->responseDescription) ? $this->responseDescription : null;
	}
	
	/**
	 * Get principal ID
	 *
	 * @return int Principal ID, or null
	 */
	public function getPrincipalId()
	{
		return isset($this->principal['principalId']) ? (int)$this->principal['principalId'] : null;
	}
}