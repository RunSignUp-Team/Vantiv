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
		// Use principal for individual
		if ($this->legalEntityType === 'INDIVIDUAL_SOLE_PROPRIETORSHIP')
			return isset($this->backgroundCheckResults['principal']['verificationResult']['overallScore']['score']) ? (int)$this->backgroundCheckResults['principal']['verificationResult']['overallScore']['score'] : null;
		else
			return isset($this->backgroundCheckResults['business']['verificationResult']['overallScore']['score']) ? (int)$this->backgroundCheckResults['business']['verificationResult']['overallScore']['score'] : null;
	}
	
	/**
	 * Get KYC description
	 *
	 * @return int KYC score (or null)
	 */
	public function getKycDesc()
	{
		// Use principal for individual
		if ($this->legalEntityType === 'INDIVIDUAL_SOLE_PROPRIETORSHIP')
			return isset($this->backgroundCheckResults['principal']['verificationResult']['overallScore']['description']) ? $this->backgroundCheckResults['principal']['verificationResult']['overallScore']['description'] : null;
		else
			return isset($this->backgroundCheckResults['business']['verificationResult']['overallScore']['description']) ? $this->backgroundCheckResults['business']['verificationResult']['overallScore']['description'] : null;
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