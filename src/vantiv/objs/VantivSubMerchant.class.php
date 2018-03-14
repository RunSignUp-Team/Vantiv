<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\objs;

/** Vantiv Sub-merchant Object */
class VantivSubMerchant extends VantivObj
{
	/** Was this a duplicate create request */
	protected $isDupCreateReq = false;
	
	/**
	 * Parse SimpleXML element
	 *
	 * @param SimpleXMLElement $elem SimpleXML Element
	 * @param array $destArr Destination array
	 * @param array Destination XML attributes
	 */
	protected function parseSimpleXmlElem($elem, array &$destArr = null, array &$destXmlAttrs = null)
	{
		// If root element, check for duplicate create request
		if ($destArr === null)
		{
			if ($elem->getName() === 'subMerchantCreateResponse')
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
	 * Get sub-merchant ID
	 *
	 * @return string Sub-merchant id, or null
	 */
	public function getSubMerchantId()
	{
		return isset($this->subMerchantId) ? $this->subMerchantId : null;
	}
	
	/**
	 * Get merchant ident string
	 *
	 * @return string Merchant ident string, or null
	 */
	public function getMerchantIdentString()
	{
		return isset($this->merchantIdentString) ? $this->merchantIdentString : null;
	}
	
	/**
	 * Get funding submerchant id
	 *
	 * @return string Merchant ident string, or null
	 */
	public function getFundingSubMerchantId()
	{
		// According to Mike Olson, we should use merchantIdentString.
		return $this->getMerchantIdentString();
	}
}