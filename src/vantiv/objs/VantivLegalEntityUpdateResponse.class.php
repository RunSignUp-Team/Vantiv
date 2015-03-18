<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\objs;

/** Vantiv Legal Entity Update Response Object */
class VantivLegalEntityUpdateResponse extends VantivObj
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
	 * Get legal entity ID
	 *
	 * @return string Legal entity id, or null
	 */
	public function getLegalEntityId()
	{
		return isset($this->legalEntityId) ? $this->legalEntityId : null;
	}
	
	/**
	 * Get KYC score
	 *
	 * @return int KYC score (or null)
	 */
	public function getKycScore()
	{
		return isset($this->backgroundCheckResults->business->verificationResults->overallScore->score) ? (int)$this->backgroundCheckResults->business->verificationResults->overallScore->score : null;
	}
	
	/**
	 * Get KYC description
	 *
	 * @return int KYC score (or null)
	 */
	public function getKycDesc()
	{
		return isset($this->backgroundCheckResults->business->verificationResults->overallScore->description) ? $this->backgroundCheckResults->business->verificationResults->overallScore->description : null;
	}
	
	/**
	 * Get background check results
	 *
	 * @return array Background check results (or null)
	 */
	public function getBackgroundCheckResults()
	{
		return isset($this->backgroundCheckResults) ? $this->backgroundCheckResults : null;
	}
}