<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\objs;

/** Vantiv Legal Entity Object */
class VantivLegalEntity extends VantivObj
{
	/** Was this a duplicate create request */
	protected $isDupCreateReq = false;
	
	/**
	 * Parse SimpleXML element
	 *
	 * @param SimpleXMLElement $elem SimpleXML Element
	 * @param array $destArr Destination array
	 */
	protected function parseSimpleXmlElem($elem, array &$destArr = null)
	{
		// If root element, check for duplicate create request
		if ($destArr === null)
		{
			if ($elem->getName() === 'legalEntityCreateResponse')
				$this->isDupCreateReq = (isset($elem['duplicate']) && (string)$elem['duplicate'] === 'true');
		}
		
		// Call parent
		parent::parseSimpleXmlElem($elem, $destArr);
	}
	
	/**
	 * Was this a duplicate create request
	 *
	 * @return bool True if this was a duplicate create request
	 */
	public function wasDuplicateCreateRequest() {
		return $this->isDupCreateReq;
	}
	
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
	
	// TODO: Look at backgroundCheckResults > business > verificationResults and backgroundCheckResults > principal > verificationResults?
}