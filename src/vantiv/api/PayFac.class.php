<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\api;
use \vantiv\Vantiv;
use \vantiv\VantivException;
use vantiv\utils\Xml;
use vantiv\utils\XmlSpec;

/** PayFac */
class PayFac
{
	/** Vantiv Object */
	protected $vantiv = null;
	
	/** API Endpoint */
	protected $apiEndpoint = 'https://www.testlitle.com/sandbox';
	
	/** Debug */
	protected $debug = false;
	
	/** Last response data */
	protected $lastResponseData = null;
	
	/** XMLNS */
	const XMLNS = 'http://payfac.vantivcnp.com/api/merchant/onboard';
	
	/**
	 * Constructor
	 *
	 * @param Vantiv $vantiv Vantiv object
	 * @param string $apiEndpoint API Endpoint
	 */
	public function __construct(Vantiv $vantiv, $apiEndpoint)
	{
		$this->vantiv = $vantiv;
		$this->apiEndpoint = $apiEndpoint;
	}
	
	/**
	 * Toggle debug setting
	 * 
	 * @param bool $debugOn Is debug on?
	 */
	public function debug($debugOn) {
		$this->debug = $debugOn;
	}
	
	/**
	 * Create Legal Entity
	 *
	 * @param array $data Data
	 *
	 * @return \vantiv\objs\VantivLegalEntity
	 * @throws VantivException
	 */
	public function createLegalEntity($data)
	{
		$xml = $this->createLegalEntityXml($data);
		$url = $this->apiEndpoint . '/legalentity';
		$resp = $this->vantiv->makeBasicAuthRequest($url, 'POST', $xml, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivLegalEntity');
		$this->lastResponseData = $resp;
		$this->debugInfo();
		return $resp->resp;
	}
	
	/**
	 * Retrieve Legal Entity
	 *
	 * @param string $legalEntityId Legal entity id
	 *
	 * @return \vantiv\objs\VantivLegalEntity
	 * @throws VantivException
	 */
	public function retrieveLegalEntity($legalEntityId)
	{
		$url = $this->apiEndpoint . '/legalentity/'.$legalEntityId;
		$resp = $this->vantiv->makeBasicAuthRequest($url, 'GET', null, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivLegalEntity');
		$this->lastResponseData = $resp;
		$this->debugInfo();
		return $resp->resp;
	}
	
	/**
	 * Update Legal Entity
	 *
	 * @param string $legalEntityId Legal entity id
	 * @param array $data Data
	 *
	 * @return \vantiv\objs\VantivLegalEntityUpdateResponse
	 * @throws VantivException
	 */
	public function updateLegalEntity($legalEntityId, $data)
	{
		$xml = $this->updateLegalEntityXml($data);
		$url = $this->apiEndpoint . '/legalentity/' . $legalEntityId;
		$resp = $this->vantiv->makeBasicAuthRequest($url, 'PUT', $xml, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivLegalEntityUpdateResponse');
		$this->lastResponseData = $resp;
		$this->debugInfo();
		return $resp->resp;
	}

	/**
	 * Create a principal
	 *
	 * @param string $legalEntityId Legal entity id
	 * @param string $legalEntityType Legal entity type
	 * @param array $data Data
	 *
	 * @return \vantiv\objs\VantivLegalEntityPrincipalCreateResponse
	 * @throws VantivException
	 */
	public function createPrincipal($legalEntityId, $legalEntityType, $data)
	{
		$xml = $this->createPrincipalXml($data, $legalEntityType);
		$url = $this->apiEndpoint . '/legalentity/'.$legalEntityId.'/principal';
		$resp = $this->vantiv->makeBasicAuthRequest($url, 'POST', $xml, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivLegalEntityPrincipalCreateResponse');
		$this->lastResponseData = $resp;
		$this->debugInfo();
		return $resp->resp;
	}

	/**
	 * Delete a principal
	 *
	 * @param string $legalEntityId Legal entity id
	 * @param string $principalId Principal ID
	 *
	 * @return \vantiv\objs\VantivLegalEntityPrincipalCreateResponse
	 * @throws VantivException
	 */
	public function deletePrincipal($legalEntityId, $principalId)
	{
		$url = $this->apiEndpoint . '/legalentity/'.$legalEntityId.'/principal/'.$principalId;
		$resp = $this->vantiv->makeBasicAuthRequest($url, 'DELETE', null, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivLegalEntityPrincipalDeleteResponse');
		$this->lastResponseData = $resp;
		$this->debugInfo();
		return $resp->resp;
	}

	/**
	 * Create SubMerchant
	 *
	 * @param string $legalEntityId Legal entity id
	 * @param array $data Data
	 *
	 * @return \vantiv\objs\VantivSubMerchant
	 * @throws VantivException
	 */
	public function createSubMerchant($legalEntityId, $data)
	{
		$xml = $this->createSubmerchantXml($data);
		$url = $this->apiEndpoint . '/legalentity/'.$legalEntityId.'/submerchant';
		$resp = $this->vantiv->makeBasicAuthRequest($url, 'POST', $xml, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivSubMerchant');
		$this->lastResponseData = $resp;
		$this->debugInfo();
		return $resp->resp;
	}
	
	/**
	 * Retrieve submerchant
	 *
	 * @param string $legalEntityId Legal entity id
	 * @param string $subMerchantId Sub-merchant id
	 *
	 * @return \vantiv\objs\VantivSubMerchant
	 * @throws VantivException
	 */
	public function retrieveSubMerchant($legalEntityId, $subMerchantId)
	{
		$url = $this->apiEndpoint . '/legalentity/'.$legalEntityId.'/submerchant/'.$subMerchantId;
		$resp = $this->vantiv->makeBasicAuthRequest($url, 'GET', null, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivSubMerchant');
		$this->lastResponseData = $resp;
		$this->debugInfo();
		return $resp->resp;
	}
	
	/**
	 * Update SubMerchant
	 *
	 * @param string $legalEntityId Legal entity id
	 * @param string $subMerchantId Sub-merchant id
	 * @param array $data Data
	 *
	 * @return \vantiv\objs\VantivSubMerchantUpdateResponse
	 * @throws VantivException
	 */
	public function updateSubMerchant($legalEntityId, $subMerchantId, $data)
	{
		$xml = $this->updateSubmerchantXml($data);
		$url = $this->apiEndpoint . '/legalentity/'.$legalEntityId.'/submerchant/'.$subMerchantId;
		$resp = $this->vantiv->makeBasicAuthRequest($url, 'PUT', $xml, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivSubMerchantUpdateResponse');
		$this->lastResponseData = $resp;
		$this->debugInfo();
		return $resp->resp;
	}
	
	/**
	 * Retrieve MCC codes
	 *
	 * @param string $legalEntityId Legal entity id
	 * @param string $subMerchantId Sub-merchant id
	 *
	 * @return \vantiv\objs\VantivMccCodes
	 * @throws VantivException
	 */
	public function retrieveMccCodes()
	{
		$url = $this->apiEndpoint . '/mcc';
		$resp = $this->vantiv->makeBasicAuthRequest($url, 'GET', null, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivMccCodes');
		$this->lastResponseData = $resp;
		$this->debugInfo();
		return $resp->resp;
	}
	
	/**
	 * Get last response data
	 *
	 * @return VantivResponse Last response data
	 */
	public function getLastResponseData() {
		return $this->lastResponseData;
	}
	
	/**
	 * Get request HTTP Headers
	 *
	 * @return array Http Headers
	 */
	protected function getRequestHttpHeaders()
	{
		return array(
			'Content-Type: application/com.vantivcnp.payfac-v13+xml',
			'Accept: application/com.vantivcnp.payfac-v13+xml'
		);
	}
	
	/** Handle debug info */
	protected function debugInfo()
	{
		if ($this->debug)
		{
			echo "HTTP Status: {$this->lastResponseData->statusCode}\n";
			if ($this->lastResponseData->statusCode === 500)
				echo $this->lastResponseData->respStr . "\n";
			else
				print_r($this->lastResponseData->resp);
		}
	}
	
	/**
	 * Create Legal Entity XML
	 *
	 * @param array $data Data
	 * @return string XML
	 */
	protected function createLegalEntityXml(&$data)
	{
		// Get legal entity type
		$legalEntityType = isset($data['legalEntityType']) ? $data['legalEntityType'] : null;
		
		$spec = $this->legalEntityCreateRequestSpec($legalEntityType);
		$xml = Xml::generateXmlFromArray('legalEntityCreateRequest', self::XMLNS, $spec, $data);
		return $xml;
	}
	
	/**
	 * Get legalEntityCreateRequest spec
	 *
	 * @param string $legalEntityType Legal entity type
	 * 
	 * @return array Spec
	 */
	protected function legalEntityCreateRequestSpec($legalEntityType)
	{
		return array(
			'legalEntityName' => XmlSpec::getRequiredSpec(),
			'legalEntityType' => XmlSpec::getRequiredSpec(),
			'legalEntityOwnershipType' => XmlSpec::getRequiredSpec(),
			'doingBusinessAs' => XmlSpec::getDefaultSpec(),
			'taxId' => ($legalEntityType === 'INDIVIDUAL_SOLE_PROPRIETORSHIP') ? XmlSpec::getDefaultSpec() : XmlSpec::getRequiredSpec(),
			'contactPhone' => XmlSpec::getDefaultSpec(),
			'annualCreditCardSalesVolume' => XmlSpec::getRequiredIntSpec(),
			'hasAcceptedCreditCards' => new XmlSpec(XmlSpec::XML_SPEC_REQUIRED | XmlSpec::XML_SPEC_BOOL),
			'address' => $this->requiredAddressSpec(),
			'principal' => $this->principalSpec($legalEntityType),
			'yearsInBusiness' => new XmlSpec(XmlSpec::XML_SPEC_INT)
		);
	}
	
	/**
	 * Update Legal Entity XML
	 *
	 * @param array $data Data
	 * @return string XML
	 */
	protected function updateLegalEntityXml(&$data)
	{
		// Get legal entity type
		$legalEntityType = isset($data['legalEntityType']) ? $data['legalEntityType'] : null;
		
		$spec = $this->legalEntityUpdateRequestSpec($legalEntityType);
		$xml = Xml::generateXmlFromArray('legalEntityUpdateRequest', self::XMLNS, $spec, $data);
		return $xml;
	}

	/**
	 * Create Legal Entity Principal XML
	 *
	 * @param array $data Data
	 * @param string $legalEntityType Legal entity type
	 * @return string XML
	 */
	protected function createPrincipalXml(&$data, $legalEntityType)
	{
		$spec = ['principal' => $this->principalSpec($legalEntityType)];
		$xml = Xml::generateXmlFromArray('legalEntityPrincipalCreateRequest', self::XMLNS, $spec, $data);
		return $xml;
	}

	/**
	 * Get legalEntityUpdateRequestSpec spec
	 *
	 * @param string $legalEntityType Legal entity type
	 * 
	 * @return array Spec
	 */
	protected function legalEntityUpdateRequestSpec($legalEntityType)
	{
		return array(
			'address' => $this->optionalAddressSpec(),
			'contactPhone' => XmlSpec::getDefaultSpec(),
			'doingBusinessAs' => XmlSpec::getDefaultSpec(),
			'annualCreditCardSalesVolume' => new XmlSpec(XmlSpec::XML_SPEC_INT),
			'hasAcceptedCreditCards' => new XmlSpec(XmlSpec::XML_SPEC_BOOL),
			'principal' => new XmlSpec(0, array(
				'principalId' => new XmlSpec(XmlSpec::XML_SPEC_INCLUDE_NULL | XmlSpec::XML_SPEC_INT),
				'title' => XmlSpec::getDefaultSpec(),
				'emailAddress' => XmlSpec::getDefaultSpec(),
				'contactPhone' => XmlSpec::getDefaultSpec(),
				'address' => $this->optionalAddressSpec(),
				'stakePercent' => new XmlSpec(XmlSpec::XML_SPEC_INT),
				'backgroundCheckFields'=> $this->principalBackgroundCheckFieldsSpec()
			)),
			'backgroundCheckFields'=> $this->backgroundCheckFieldsSpec(),
			'legalEntityOwnershipType' => XmlSpec::getRequiredSpec(),
			'yearsInBusiness' => new XmlSpec(XmlSpec::XML_SPEC_INT)
		);
	}
	
	/**
	 * Get required address spec
	 *
	 * @return array Spec
	 */
	protected function requiredAddressSpec()
	{
		return new XmlSpec(XmlSpec::XML_SPEC_REQUIRED, array(
			'streetAddress1' => XmlSpec::getRequiredSpec(),
			'streetAddress2' => XmlSpec::getDefaultSpec(),
			'city' => XmlSpec::getRequiredSpec(),
			'stateProvince' => XmlSpec::getRequiredSpec(),
			'postalCode' => XmlSpec::getRequiredSpec(),
			'countryCode' => XmlSpec::getRequiredSpec()
		));
	}
	
	/**
	 * Get options address spec
	 *
	 * @return array Spec
	 */
	protected function requiredCountryAddressSpec()
	{
		return new XmlSpec(XmlSpec::XML_SPEC_REQUIRED, array(
			'streetAddress1' => XmlSpec::getDefaultSpec(),
			'streetAddress2' => XmlSpec::getDefaultSpec(),
			'city' => XmlSpec::getDefaultSpec(),
			'stateProvince' => XmlSpec::getDefaultSpec(),
			'postalCode' => XmlSpec::getDefaultSpec(),
			'countryCode' => XmlSpec::getRequiredSpec()
		));
	}
	
	/**
	 * Get options address spec
	 *
	 * @return array Spec
	 */
	protected function optionalAddressSpec()
	{
		return new XmlSpec(0, array(
			'streetAddress1' => XmlSpec::getDefaultSpec(),
			'streetAddress2' => XmlSpec::getDefaultSpec(),
			'city' => XmlSpec::getDefaultSpec(),
			'stateProvince' => XmlSpec::getDefaultSpec(),
			'postalCode' => XmlSpec::getDefaultSpec(),
			'countryCode' => XmlSpec::getDefaultSpec()
		));
	}
	
	/**
	 * Get principal spec
	 *
	 * @param string $legalEntityType Legal entity type
	 *
	 * @return array Spec
	 */
	protected function principalSpec($legalEntityType)
	{
		return new XmlSpec(XmlSpec::XML_SPEC_REQUIRED, array(
			'principalId' => new XmlSpec(XmlSpec::XML_SPEC_INCLUDE_NULL | XmlSpec::XML_SPEC_INT),
			'title' => XmlSpec::getDefaultSpec(),
			'firstName' => XmlSpec::getRequiredSpec(),
			'lastName' => XmlSpec::getRequiredSpec(),
			'emailAddress' => XmlSpec::getDefaultSpec(),
			'ssn' => ($legalEntityType === 'INDIVIDUAL_SOLE_PROPRIETORSHIP') ? XmlSpec::getRequiredSpec() : XmlSpec::getDefaultSpec(),
			'contactPhone' => XmlSpec::getDefaultSpec(),
			'dateOfBirth' => XmlSpec::getDefaultSpec(),
			'driversLicense' => XmlSpec::getDefaultSpec(),
			'driversLicenseState' => XmlSpec::getDefaultSpec(),
			'address' => new XmlSpec(XmlSpec::XML_SPEC_REQUIRED, array(
				'streetAddress1' => ($legalEntityType === 'INDIVIDUAL_SOLE_PROPRIETORSHIP') ? XmlSpec::getRequiredSpec() : XmlSpec::getDefaultSpec(),
				'streetAddress2' => XmlSpec::getDefaultSpec(),
				'city' => ($legalEntityType === 'INDIVIDUAL_SOLE_PROPRIETORSHIP') ? XmlSpec::getRequiredSpec() : XmlSpec::getDefaultSpec(),
				'stateProvince' => ($legalEntityType === 'INDIVIDUAL_SOLE_PROPRIETORSHIP') ? XmlSpec::getRequiredSpec() : XmlSpec::getDefaultSpec(),
				'postalCode' => ($legalEntityType === 'INDIVIDUAL_SOLE_PROPRIETORSHIP') ? XmlSpec::getRequiredSpec() : XmlSpec::getDefaultSpec(),
				'countryCode' => ($legalEntityType === 'INDIVIDUAL_SOLE_PROPRIETORSHIP') ? XmlSpec::getRequiredSpec() : XmlSpec::getDefaultSpec()
			)),
			'stakePercent' => new XmlSpec(XmlSpec::XML_SPEC_INT)
		));
	}
	
	/**
	 * Get backgroundCheckFields spec
	 *
	 * @return array Spec
	 */
	protected function backgroundCheckFieldsSpec()
	{
		return new XmlSpec(0, array(
			'legalEntityName' => XmlSpec::getDefaultSpec(),
			'legalEntityType' => XmlSpec::getDefaultSpec(),
			'taxId' => XmlSpec::getDefaultSpec()
		));
	}
	
	/**
	 * Get principal backgroundCheckFields spec
	 *
	 * @return array Spec
	 */
	protected function principalBackgroundCheckFieldsSpec()
	{
		return new XmlSpec(0, array(
			'firstName' => XmlSpec::getDefaultSpec(),
			'lastName' => XmlSpec::getDefaultSpec(),
			'ssn' => XmlSpec::getDefaultSpec(),
			'dateOfBirth' => XmlSpec::getDefaultSpec(),
			'driversLicense' => XmlSpec::getDefaultSpec(),
			'driversLicenseState' => XmlSpec::getDefaultSpec()
		));
	}
	
	/**
	 * Create Submerchant XML
	 *
	 * @param array $data Data
	 * @return string XML
	 */
	protected function createSubmerchantXml(&$data)
	{
		$spec = array(
			'merchantName' => XmlSpec::getRequiredSpec(),
			'amexMid' => XmlSpec::getDefaultSpec(),
			'discoverConveyedMid' => XmlSpec::getDefaultSpec(),
			'url' => XmlSpec::getDefaultSpec(),
			'customerServiceNumber' => XmlSpec::getRequiredSpec(),
			'hardCodedBillingDescriptor' => XmlSpec::getRequiredSpec(),
			'maxTransactionAmount' => XmlSpec::getRequiredIntSpec(),
			'purchaseCurrency' => XmlSpec::getDefaultSpec(),
			'merchantCategoryCode' => XmlSpec::getRequiredIntSpec(),
			'bankRoutingNumber' => XmlSpec::getRequiredSpec(),
			'bankAccountNumber' => XmlSpec::getRequiredSpec(),
			'pspMerchantId' => XmlSpec::getRequiredSpec(),
			'amexAcquired' => new XmlSpec(0, array(), null, array('enabled'=>XmlSpec::XML_SPEC_REQUIRED | XmlSpec::XML_SPEC_BOOL)),
			'address' => $this->optionalAddressSpec(),
			'primaryContact' => new XmlSpec(XmlSpec::XML_SPEC_REQUIRED, array(
				'firstName' => XmlSpec::getRequiredSpec(),
				'lastName' => XmlSpec::getRequiredSpec(),
				'emailAddress' => XmlSpec::getRequiredSpec(),
				'phone' => XmlSpec::getRequiredSpec()
			)),
			'eCheck' => new XmlSpec(0, array(
				'eCheckCompanyName' => XmlSpec::getDefaultSpec(),
				'eCheckBillingDescriptor' => XmlSpec::getDefaultSpec()
			), null, array('enabled'=>XmlSpec::XML_SPEC_REQUIRED | XmlSpec::XML_SPEC_BOOL)),
			'subMerchantFunding' => new XmlSpec(0, array(
				'feeProfile' => XmlSpec::getDefaultSpec(),
				'fundingSubmerchantId' => XmlSpec::getDefaultSpec()
			), null, array('enabled'=>XmlSpec::XML_SPEC_REQUIRED | XmlSpec::XML_SPEC_BOOL)),
			'settlementCurrency' => XmlSpec::getRequiredSpec()
		);
		$xml = Xml::generateXmlFromArray('subMerchantCreateRequest', self::XMLNS, $spec, $data);
		
		return $xml;
	}
	
	/**
	 * Update Submerchant XML
	 *
	 * @param array $data Data
	 * @return string XML
	 */
	protected function updateSubmerchantXml(&$data)
	{
		$spec = array(
			'amexMid' => XmlSpec::getDefaultSpec(),
			'discoverConveyedMid' => XmlSpec::getDefaultSpec(),
			'url' => XmlSpec::getDefaultSpec(),
			'customerServiceNumber' => XmlSpec::getDefaultSpec(),
			'hardCodedBillingDescriptor' => XmlSpec::getDefaultSpec(),
			'maxTransactionAmount' => XmlSpec::getIntSpec(),
			'bankRoutingNumber' => XmlSpec::getDefaultSpec(),
			'bankAccountNumber' => XmlSpec::getDefaultSpec(),
			'address' => $this->optionalAddressSpec(),
			'primaryContact' => new XmlSpec(0, array(
				'firstName' => XmlSpec::getDefaultSpec(),
				'lastName' => XmlSpec::getDefaultSpec(),
				'emailAddress' => XmlSpec::getDefaultSpec(),
				'phone' => XmlSpec::getDefaultSpec()
			)),
			'amexAcquired' => new XmlSpec(0, array(), null, array('enabled'=>XmlSpec::XML_SPEC_REQUIRED | XmlSpec::XML_SPEC_BOOL)),
			'eCheck' => new XmlSpec(0, array(
				'eCheckCompanyName' => XmlSpec::getDefaultSpec(),
				'eCheckBillingDescriptor' => XmlSpec::getDefaultSpec()
			), null, array('enabled'=>XmlSpec::XML_SPEC_REQUIRED | XmlSpec::XML_SPEC_BOOL))
		);
		$xml = Xml::generateXmlFromArray('subMerchantUpdateRequest', self::XMLNS, $spec, $data);
		return $xml;
	}
}