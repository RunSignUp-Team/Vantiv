<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\api;
use \vantiv\Vantiv;
use \vantiv\VantivException;
use \vantiv\utils\Xml;
use \vantiv\utils\XmlSpec;

/** Batch Transaction */
class BatchTransaction
{
	/** Vantiv Object */
	protected $vantiv = null;
	
	/** XMLNS */
	const XMLNS = 'http://www.litle.com/schema';
	
	/** API Version */
	const API_VERSION = '9.2';
	
	/**
	 * Constructor
	 *
	 * @param Vantiv $vantiv Vantiv object
	 */
	public function __construct(Vantiv $vantiv)
	{
		$this->vantiv = $vantiv;
	}
	
	/**
	 * Create batch request
	 *
	 * @param array $batchRequestsXmls XML of batch requests
	 * 
	 * @return string XML
	 */
	protected function getBatchRequestXml($batchRequestsXmls)
	{
		// Build final data
		$finalData = array(
			'authentication' => array(
				'user' => $this->vantiv->getApiUsername(),
				'password' => $this->vantiv->getApiPassword(),
			),
			'batchRequest' => '***REPLACE_ME***'
		);
		
		$finalSpec = array(
			'authentication' => new XmlSpec(XmlSpec::XML_SPEC_REQUIRED, array(
				'user' => XmlSpec::getRequiredSpec(),
				'password' => XmlSpec::getRequiredSpec()
			)),
			'batchRequest' => XmlSpec::getRequiredSpec()
		);
		
		$xml = Xml::generateXmlFromArray('litleRequest', self::XMLNS, $finalSpec, $finalData, array(
			'version' => self::API_VERSION,
			'numBatchRequests' => count($batchRequestsXmls)
		));
		
		// Replace placeholder
		$replacementXml = '';
		$batchXml = null;
		foreach ($batchRequestsXmls as &$batchXml)
			$replacementXml .= $batchXml;
		unset($batchXml);
		$xml = str_replace('<batchRequest>***REPLACE_ME***</batchRequest>', $replacementXml, $xml);
		
		return $xml;
	}
}