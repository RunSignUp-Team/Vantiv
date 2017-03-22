<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\api;
use \vantiv\Vantiv;
use \vantiv\VantivException;
use vantiv\utils\Xml;
use vantiv\utils\XmlSpec;
use vantiv\utils\VantivNonAtomicBatch;

/** Online Transaction */
class OnlineTransaction
{
	/** Vantiv Object */
	protected $vantiv = null;
	
	/** API Endpoint */
	protected $apiEndpoint = 'https://www.testlitle.com/sandbox/communicator/online';
	
	/** Debug */
	protected $debug = false;
	
	/** Last response data */
	protected $lastResponseData = null;
	
	/** XMLNS */
	const XMLNS = 'http://www.litle.com/schema';
	
	/** API Version */
	const API_VERSION = '9.2';
	
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
	 * Do Sale transaction
	 *
	 * @param string $merchantId Merchant id
	 * @param array $data Data
	 *
	 * @return \vantiv\objs\VantivSale
	 * @throws VantivException
	 */
	public function sale($merchantId, $data)
	{
		$xml = $this->createSaleXml($merchantId, $data);
		$resp = $this->vantiv->makeRequest($this->apiEndpoint, 'POST', $xml, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivSale');
		$this->lastResponseData = $resp;
		$this->debugInfo();
		return $resp->resp;
	}
	
	/**
	 * Add Sale transaction to batch
	 *
	 * @param VantivNonAtomicBatch Batch object
	 * @param string $merchantId Merchant id
	 * @param array $data Data
	 * 
	 * @throws VantivException
	 */
	public function addSaleToBatch(VantivNonAtomicBatch $batch, $merchantId, $data)
	{
		$xml = $this->createSaleXml($merchantId, $data);
		$batch->addRequest($this->apiEndpoint, 'POST', $xml, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivSale');
	}
	
	/**
	 * Add auth transaction to batch
	 *
	 * @param VantivNonAtomicBatch Batch object
	 * @param string $merchantId Merchant id
	 * @param array $data Data
	 * 
	 * @throws VantivException
	 */
	public function addAuthToBatch(VantivNonAtomicBatch $batch, $merchantId, $data)
	{
		$xml = $this->createAuthXml($merchantId, $data);
		$batch->addRequest($this->apiEndpoint, 'POST', $xml, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivAuth');
	}
	
	/**
	 * Do Credit transaction
	 *
	 * @param string $merchantId Merchant id
	 * @param array $data Data
	 *
	 * @return \vantiv\objs\VantivCredit
	 * @throws VantivException
	 */
	public function credit($merchantId, $data)
	{
		$xml = $this->createCreditXml($merchantId, $data);
		$resp = $this->vantiv->makeRequest($this->apiEndpoint, 'POST', $xml, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivCredit');
		$this->lastResponseData = $resp;
		$this->debugInfo();
		return $resp->resp;
	}
	
	/**
	 * Add Credit transaction to batch
	 *
	 * @param VantivNonAtomicBatch Batch object
	 * @param string $merchantId Merchant id
	 * @param array $data Data
	 * 
	 * @throws VantivException
	 */
	public function addCreditToBatch(VantivNonAtomicBatch $batch, $merchantId, $data)
	{
		$xml = $this->createCreditXml($merchantId, $data);
		$batch->addRequest($this->apiEndpoint, 'POST', $xml, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivCredit');
	}
	
	/**
	 * Do Void transaction
	 *
	 * @param string $merchantId Merchant id
	 * @param array $data Data
	 *
	 * @return \vantiv\objs\VantivVoid
	 * @throws VantivException
	 */
	public function void($merchantId, $data)
	{
		$xml = $this->createVoidXml($merchantId, $data);
		$resp = $this->vantiv->makeRequest($this->apiEndpoint, 'POST', $xml, $this->getRequestHttpHeaders(), '\vantiv\objs\VantivVoid');
		$this->lastResponseData = $resp;
		$this->debugInfo();
		return $resp->resp;
	}
	
	/**
	 * Get request HTTP Headers
	 *
	 * @return array Http Headers
	 */
	protected function getRequestHttpHeaders()
	{
		return array(
			'Content-Type: text/xml'
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
	 * Create online request
	 *
	 * @param string $merchantId Merchant id
	 * @param string $transactionType Transaction type
	 * @param XmlSpec $spec Transaction spec
	 * @param array $data Transaction data
	 * 
	 * @return string XML
	 */
	protected function onlineRequestXml($merchantId, $transactionType, XmlSpec $spec, &$data)
	{
		// Build final data
		$finalData = array(
			'authentication' => array(
				'user' => $this->vantiv->getApiUsername(),
				'password' => $this->vantiv->getApiPassword(),
			),
			$transactionType => &$data
		);
		
		$finalSpec = array(
			'authentication' => new XmlSpec(XmlSpec::XML_SPEC_REQUIRED, array(
				'user' => XmlSpec::getRequiredSpec(),
				'password' => XmlSpec::getRequiredSpec()
			)),
			$transactionType => $spec
		);
		
		$xml = Xml::generateXmlFromArray('litleOnlineRequest', self::XMLNS, $finalSpec, $finalData, array(
			'version' => self::API_VERSION,
			'merchantId' => $merchantId
		));
		return $xml;
	}
	
	/**
	 * Create Sale XML
	 *
	 * @param string $merchantId Merchant id
	 * @param array $data Data
	 * @return string XML
	 */
	protected function createSaleXml($merchantId, &$data)
	{
		$subspecs = array(
			'orderId' => XmlSpec::getRequiredSpec(),
			'amount' => XmlSpec::getRequiredIntSpec(),
			'orderSource' => XmlSpec::getRequiredSpec(),
			
			// Optional
			'litleTxnId' => XmlSpec::getDefaultSpec(),
			'customerInfo' => new XmlSpec(0, array(
				'ssn' => XmlSpec::getDefaultSpec(),
				'dob' => XmlSpec::getDefaultSpec(),
				'customerRegistrationDate' => XmlSpec::getDefaultSpec(),
				'customerType' => XmlSpec::getDefaultSpec(),
				'incomeAmount' => XmlSpec::getIntSpec(),
				'employerName' => XmlSpec::getDefaultSpec(),
				'customerWorkTelephone' => XmlSpec::getDefaultSpec(),
				'residenceStatus' => XmlSpec::getDefaultSpec(),
				'yearsAtResidence' => XmlSpec::getIntSpec(),
				'yearsAtEmployer' => XmlSpec::getIntSpec()
			)),
			'billToAddress' => new XmlSpec(0, array(
				'name' => XmlSpec::getDefaultSpec(),
				'firstName' => XmlSpec::getDefaultSpec(),
				'middleInitial' => XmlSpec::getDefaultSpec(),
				'lastName' => XmlSpec::getDefaultSpec(),
				'companyName' => XmlSpec::getDefaultSpec(),
				'addressLine1' => XmlSpec::getDefaultSpec(),
				'addressLine2' => XmlSpec::getDefaultSpec(),
				'addressLine3' => XmlSpec::getDefaultSpec(),
				'city' => XmlSpec::getDefaultSpec(),
				'state' => XmlSpec::getDefaultSpec(),
				'zip' => XmlSpec::getDefaultSpec(),
				'country' => XmlSpec::getDefaultSpec(),
				'email' => XmlSpec::getDefaultSpec(),
				'phone' => XmlSpec::getDefaultSpec()
			)),
			'shipToAddress' => new XmlSpec(0, array(
				'name' => XmlSpec::getDefaultSpec(),
				'companyName' => XmlSpec::getDefaultSpec(),
				'addressLine1' => XmlSpec::getDefaultSpec(),
				'addressLine2' => XmlSpec::getDefaultSpec(),
				'addressLine3' => XmlSpec::getDefaultSpec(),
				'city' => XmlSpec::getDefaultSpec(),
				'state' => XmlSpec::getDefaultSpec(),
				'zip' => XmlSpec::getDefaultSpec(),
				'country' => XmlSpec::getDefaultSpec(),
				'email' => XmlSpec::getDefaultSpec(),
				'phone' => XmlSpec::getDefaultSpec()
			))
		);
		
		// Check type
		// mpos - Mobile Point of Sale
		if (isset($data['mpos']))
		{
			$subspecs['mpos'] = new XmlSpec(0, array(
					'ksn' => XmlSpec::getRequiredSpec(),
					'formatId' => XmlSpec::getRequiredSpec(),
					'encryptedTrack' => XmlSpec::getRequiredSpec(),
					'track1Status' => XmlSpec::getRequiredIntSpec(),
					'track2Status' => XmlSpec::getRequiredIntSpec()
				));
		}
		// Assume credit card
		else
		{
			// Check for card present
			if (isset($data['card']['track']))
			{
				$subspecs['card'] = new XmlSpec(0, array(
					'track' => XmlSpec::getRequiredSpec()
				));
			}
			// Not present
			else
			{
				$subspecs['card'] = new XmlSpec(0, array(
					'type' => XmlSpec::getRequiredSpec(),
					'number' => XmlSpec::getRequiredSpec(),
					'expDate' => XmlSpec::getRequiredSpec(),
					'cardValidationNum' => XmlSpec::getDefaultSpec()
				));
			}
		}
		
		// $subspecs['billMeLaterRequest'] = ;// Not currenty supported
		$subspecs['cardholderAuthentication'] = new XmlSpec(0, array(
			'authenticationValue' => XmlSpec::getDefaultSpec(),
			'authenticationTransactionId' => XmlSpec::getDefaultSpec(),
			'customerIpAddress' => XmlSpec::getDefaultSpec(),
			'authenticatedByMerchant' => XmlSpec::getBoolSpec()
		));
		$subspecs['customBilling'] = new XmlSpec(0, array(
			'phone' => XmlSpec::getDefaultSpec(),
			'url' => XmlSpec::getDefaultSpec(),
			'city' => XmlSpec::getDefaultSpec(),
			'descriptor' => XmlSpec::getDefaultSpec()
		));
		$subspecs['taxType'] = XmlSpec::getDefaultSpec();
		//$subspecs['enhancedData'] = ;// Not currenty supported
		$subspecs['processingInstructions'] = new XmlSpec(0, array(
			'bypassVelocityCheck' => XmlSpec::getBoolSpec()
		));
		$subspecs['pos'] = new XmlSpec(0, array(
			'capability' => XmlSpec::getDefaultSpec(),
			'entryMode' => XmlSpec::getDefaultSpec(),
			'cardholderId' => XmlSpec::getDefaultSpec(),
			'terminalId' => XmlSpec::getDefaultSpec(),
			'catLevel' => XmlSpec::getDefaultSpec()
		));
		//$subspecs['payPalOrderComplete'] = ;// Not currenty supported
		$subspecs['amexAggregatorData'] = new XmlSpec(0, array(
			'sellerId' => XmlSpec::getDefaultSpec(),
			'sellerMerchantCategoryCode' => XmlSpec::getDefaultSpec()
		));
		$subspecs['allowPartialAuth'] = XmlSpec::getBoolSpec();
		//$subspecs['healthcareIIAS'] = ;// Not currenty supported
		$subspecs['merchantData'] = new XmlSpec(0, array(
			'affiliate' => XmlSpec::getDefaultSpec(),
			'campaign' => XmlSpec::getDefaultSpec(),
			'merchantGroupingId' => XmlSpec::getDefaultSpec()
		));
		
		// Create spec
		$spec = new XmlSpec(XmlSpec::XML_SPEC_REQUIRED, $subspecs, null, array(
			'id' => 0,
			'reportGroup' => XmlSpec::XML_SPEC_REQUIRED,
			'customerId' => 0
		));
		
		return $this->onlineRequestXml($merchantId, 'sale', $spec, $data);
	}
	
	/**
	 * Create auth XML
	 *
	 * @param string $merchantId Merchant id
	 * @param array $data Data
	 * @return string XML
	 */
	protected function createAuthXml($merchantId, &$data)
	{
		$subspecs = array(
			'orderId' => XmlSpec::getRequiredSpec(),
			'amount' => XmlSpec::getRequiredIntSpec(),
			'orderSource' => XmlSpec::getRequiredSpec(),
			
			// Optional
			'customerInfo' => new XmlSpec(0, array(
				'ssn' => XmlSpec::getDefaultSpec(),
				'dob' => XmlSpec::getDefaultSpec(),
				'customerRegistrationDate' => XmlSpec::getDefaultSpec(),
				'customerType' => XmlSpec::getDefaultSpec(),
				'incomeAmount' => XmlSpec::getIntSpec(),
				'employerName' => XmlSpec::getDefaultSpec(),
				'customerWorkTelephone' => XmlSpec::getDefaultSpec(),
				'residenceStatus' => XmlSpec::getDefaultSpec(),
				'yearsAtResidence' => XmlSpec::getIntSpec(),
				'yearsAtEmployer' => XmlSpec::getIntSpec()
			)),
			'billToAddress' => new XmlSpec(0, array(
				'name' => XmlSpec::getDefaultSpec(),
				'firstName' => XmlSpec::getDefaultSpec(),
				'middleInitial' => XmlSpec::getDefaultSpec(),
				'lastName' => XmlSpec::getDefaultSpec(),
				'companyName' => XmlSpec::getDefaultSpec(),
				'addressLine1' => XmlSpec::getDefaultSpec(),
				'addressLine2' => XmlSpec::getDefaultSpec(),
				'addressLine3' => XmlSpec::getDefaultSpec(),
				'city' => XmlSpec::getDefaultSpec(),
				'state' => XmlSpec::getDefaultSpec(),
				'zip' => XmlSpec::getDefaultSpec(),
				'country' => XmlSpec::getDefaultSpec(),
				'email' => XmlSpec::getDefaultSpec(),
				'phone' => XmlSpec::getDefaultSpec()
			)),
			'shipToAddress' => new XmlSpec(0, array(
				'name' => XmlSpec::getDefaultSpec(),
				'companyName' => XmlSpec::getDefaultSpec(),
				'addressLine1' => XmlSpec::getDefaultSpec(),
				'addressLine2' => XmlSpec::getDefaultSpec(),
				'addressLine3' => XmlSpec::getDefaultSpec(),
				'city' => XmlSpec::getDefaultSpec(),
				'state' => XmlSpec::getDefaultSpec(),
				'zip' => XmlSpec::getDefaultSpec(),
				'country' => XmlSpec::getDefaultSpec(),
				'email' => XmlSpec::getDefaultSpec(),
				'phone' => XmlSpec::getDefaultSpec()
			))
		);
		
		// Check type
		// mpos - Mobile Point of Sale
		if (isset($data['mpos']))
		{
			$subspecs['mpos'] = new XmlSpec(0, array(
					'ksn' => XmlSpec::getRequiredSpec(),
					'formatId' => XmlSpec::getRequiredSpec(),
					'encryptedTrack' => XmlSpec::getRequiredSpec(),
					'track1Status' => XmlSpec::getRequiredIntSpec(),
					'track2Status' => XmlSpec::getRequiredIntSpec()
				));
		}
		// Assume credit card
		else
		{
			// Check for card present
			if (isset($data['card']['track']))
			{
				$subspecs['card'] = new XmlSpec(0, array(
					'track' => XmlSpec::getRequiredSpec()
				));
			}
			// Not present
			else
			{
				$subspecs['card'] = new XmlSpec(0, array(
					'type' => XmlSpec::getRequiredSpec(),
					'number' => XmlSpec::getRequiredSpec(),
					'expDate' => XmlSpec::getRequiredSpec(),
					'cardValidationNum' => XmlSpec::getDefaultSpec()
				));
			}
		}
		
		// $subspecs['billMeLaterRequest'] = ;// Not currenty supported
		$subspecs['cardholderAuthentication'] = new XmlSpec(0, array(
			'authenticationValue' => XmlSpec::getDefaultSpec(),
			'authenticationTransactionId' => XmlSpec::getDefaultSpec(),
			'customerIpAddress' => XmlSpec::getDefaultSpec(),
			'authenticatedByMerchant' => XmlSpec::getBoolSpec()
		));
		$subspecs['customBilling'] = new XmlSpec(0, array(
			'phone' => XmlSpec::getDefaultSpec(),
			'url' => XmlSpec::getDefaultSpec(),
			'city' => XmlSpec::getDefaultSpec(),
			'descriptor' => XmlSpec::getDefaultSpec()
		));
		$subspecs['taxType'] = XmlSpec::getDefaultSpec();
		//$subspecs['enhancedData'] = ;// Not currenty supported
		$subspecs['processingInstructions'] = new XmlSpec(0, array(
			'bypassVelocityCheck' => XmlSpec::getBoolSpec()
		));
		$subspecs['pos'] = new XmlSpec(0, array(
			'capability' => XmlSpec::getDefaultSpec(),
			'entryMode' => XmlSpec::getDefaultSpec(),
			'cardholderId' => XmlSpec::getDefaultSpec(),
			'terminalId' => XmlSpec::getDefaultSpec(),
			'catLevel' => XmlSpec::getDefaultSpec()
		));
		//$subspecs['payPalOrderComplete'] = ;// Not currenty supported
		$subspecs['amexAggregatorData'] = new XmlSpec(0, array(
			'sellerId' => XmlSpec::getDefaultSpec(),
			'sellerMerchantCategoryCode' => XmlSpec::getDefaultSpec()
		));
		$subspecs['allowPartialAuth'] = XmlSpec::getBoolSpec();
		//$subspecs['healthcareIIAS'] = ;// Not currenty supported
		$subspecs['merchantData'] = new XmlSpec(0, array(
			'affiliate' => XmlSpec::getDefaultSpec(),
			'campaign' => XmlSpec::getDefaultSpec(),
			'merchantGroupingId' => XmlSpec::getDefaultSpec()
		));
		
		// Create spec
		$spec = new XmlSpec(XmlSpec::XML_SPEC_REQUIRED, $subspecs, null, array(
			'id' => 0,
			'reportGroup' => XmlSpec::XML_SPEC_REQUIRED,
			'customerId' => 0
		));
		
		return $this->onlineRequestXml($merchantId, 'authorization', $spec, $data);
	}
	
	/**
	 * Create Credit XML
	 *
	 * @param string $merchantId Merchant id
	 * @param array $data Data
	 * @return string XML
	 */
	protected function createCreditXml($merchantId, &$data)
	{
		$spec = new XmlSpec(XmlSpec::XML_SPEC_REQUIRED, array(
			'litleTxnId' => XmlSpec::getRequiredSpec(),
			
			// Optional
			'amount' => XmlSpec::getIntSpec(),
			'surchargeAmount' => XmlSpec::getIntSpec(),
			'customBilling' => new XmlSpec(0, array(
				'phone' => XmlSpec::getDefaultSpec(),
				'url' => XmlSpec::getDefaultSpec(),
				'city' => XmlSpec::getDefaultSpec(),
				'descriptor' => XmlSpec::getDefaultSpec()
			)),
			'taxType' => XmlSpec::getDefaultSpec(),
			//'enhancedData' => ,// Not currenty supported
			'processingInstructions' => new XmlSpec(0, array(
				'bypassVelocityCheck' => XmlSpec::getBoolSpec()
			)),
			'merchantData' => new XmlSpec(0, array(
				'affiliate' => XmlSpec::getDefaultSpec(),
				'campaign' => XmlSpec::getDefaultSpec(),
				'merchantGroupingId' => XmlSpec::getDefaultSpec()
			)),
			'actionReason' => XmlSpec::getDefaultSpec(),
			'pos' => new XmlSpec(0, array(
				'capability' => XmlSpec::getDefaultSpec(),
				'entryMode' => XmlSpec::getDefaultSpec(),
				'cardholderId' => XmlSpec::getDefaultSpec(),
				'terminalId' => XmlSpec::getDefaultSpec(),
				'catLevel' => XmlSpec::getDefaultSpec()
			))
		), null, array(
			'id' => 0,
			'reportGroup' => XmlSpec::XML_SPEC_REQUIRED,
			'customerId' => 0
		));
		
		return $this->onlineRequestXml($merchantId, 'credit', $spec, $data);
	}
	
	/**
	 * Create Void XML
	 *
	 * @param string $merchantId Merchant id
	 * @param array $data Data
	 * @return string XML
	 */
	protected function createVoidXml($merchantId, &$data)
	{
		$spec = new XmlSpec(XmlSpec::XML_SPEC_REQUIRED, array(
			'litleTxnId' => XmlSpec::getRequiredSpec(),
			
			// Optional
			'processingInstructions' => new XmlSpec(0, array(
				'bypassVelocityCheck' => XmlSpec::getBoolSpec()
			))
		), null, array(
			'id' => 0,
			'reportGroup' => XmlSpec::XML_SPEC_REQUIRED,
			'customerId' => 0
		));
		
		return $this->onlineRequestXml($merchantId, 'void', $spec, $data);
	}
}