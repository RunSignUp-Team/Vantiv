<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\api;
use \vantiv\Vantiv;
use \vantiv\utils\VantivException;
use \vantiv\utils\Xml;
use \vantiv\utils\XmlValue;
use \vantiv\utils\XmlSpec;
use \vantiv\api\BatchTransaction;

/** Vantiv Instruction Based Funding Helper */
class InstructionBasedFunding extends BatchTransaction
{
	/** Funding merchant ID */
	protected $fundingMerchantId = null;
	
	/** PayFac credits */
	private $payFacCredits = array();
	
	/** PayFac debits */
	private $payFacDebits = array();
	
	/** Reserve credits */
	private $reserveCredits = array();
	
	/** Reserve debits */
	private $reserveDebits = array();
	
	/** Submerchant credits */
	private $submerchantCredits = array();
	
	/** Submerchant debits */
	private $submerchantDebits = array();
	
	/** Physical check credits */
	private $physicalCheckCredits = array();
	
	/** Physical check debits */
	private $physicalCheckDebits = array();
	
	/**
	 * Constructor
	 *
	 * @param Vantiv $vantiv Vantiv object
	 * @param string $fundingMerchantId Funding merchant ID
	 */
	public function __construct(Vantiv $vantiv, $fundingMerchantId)
	{
		parent::__construct($vantiv);
		$this->fundingMerchantId = $fundingMerchantId;
	}
	
	/**
	 * Add PayFac credit
	 *
	 * @param string $fundingSubMerchantId Funding submerchant id
	 * @param int $fundsTransferId Funds transfer id
	 * @param int $amountInCents Amount in cents
	 */
	public function addPayFacCredit($fundingSubMerchantId, $fundsTransferId, $amountInCents)
	{
		$this->payFacCredits[] = array(
			'fundingSubmerchantId' => $fundingSubMerchantId,
			'fundsTransferId' => $fundsTransferId,
			'amount' => $amountInCents
		);
	}
	
	/**
	 * Add PayFac debit
	 *
	 * @param string $fundingSubMerchantId Funding submerchant id
	 * @param int $fundsTransferId Funds transfer id
	 * @param int $amountInCents Amount in cents
	 */
	public function addPayFacDebit($fundingSubMerchantId, $fundsTransferId, $amountInCents)
	{
		$this->payFacDebits[] = array(
			'fundingSubmerchantId' => $fundingSubMerchantId,
			'fundsTransferId' => $fundsTransferId,
			'amount' => $amountInCents
		);
	}
	
	/**
	 * Add Reserve credit
	 *
	 * @param string $fundingSubMerchantId Funding submerchant id
	 * @param int $fundsTransferId Funds transfer id
	 * @param int $amountInCents Amount in cents
	 */
	public function addReserveCredit($fundingSubMerchantId, $fundsTransferId, $amountInCents)
	{
		$this->reserveCredits[] = array(
			'fundingSubmerchantId' => $fundingSubMerchantId,
			'fundsTransferId' => $fundsTransferId,
			'amount' => $amountInCents
		);
	}
	
	/**
	 * Add Reserve debit
	 *
	 * @param string $fundingSubMerchantId Funding submerchant id
	 * @param int $fundsTransferId Funds transfer id
	 * @param int $amountInCents Amount in cents
	 */
	public function addReserveDebit($fundingSubMerchantId, $fundsTransferId, $amountInCents)
	{
		$this->reserveDebits[] = array(
			'fundingSubmerchantId' => $fundingSubMerchantId,
			'fundsTransferId' => $fundsTransferId,
			'amount' => $amountInCents
		);
	}
	
	/**
	 * Add submerchant credit
	 *
	 * @param string $fundingSubMerchantId Funding submerchant id
	 * @param string $submerchantName Submerchant name
	 * @param int $fundsTransferId Funds transfer id
	 * @param int $amountInCents Amount in cents
	 * @param string $acctType Account type: "Checking", "Savings", "Corporate", or "Corp Savings"
	 * @param int $routingNum Routing number
	 * @param int $acctNum Account number
	 */
	public function addSubmerchantCredit($fundingSubMerchantId, $submerchantName, $fundsTransferId, $amountInCents, $acctType, $routingNum, $acctNum)
	{
		$this->submerchantCredits[] = array(
			'fundingSubmerchantId' => $fundingSubMerchantId,
			'submerchantName' => $submerchantName,
			'fundsTransferId' => $fundsTransferId,
			'amount' => $amountInCents,
			'accountInfo' => array(
				'accNum' => $acctNum,
				'routingNum' => $routingNum,
				'accType' => $acctType
			)
		);
	}
	
	/**
	 * Add submerchant debit
	 *
	 * @param string $fundingSubMerchantId Funding submerchant id
	 * @param string $submerchantName Submerchant name
	 * @param int $fundsTransferId Funds transfer id
	 * @param int $amountInCents Amount in cents
	 * @param string $acctType Account type: "Checking", "Savings", "Corporate", or "Corp Savings"
	 * @param int $routingNum Routing number
	 * @param int $acctNum Account number
	 */
	public function addSubmerchantDebit($fundingSubMerchantId, $submerchantName, $fundsTransferId, $amountInCents, $acctType, $routingNum, $acctNum)
	{
		$this->submerchantDebits[] = array(
			'fundingSubmerchantId' => $fundingSubMerchantId,
			'submerchantName' => $submerchantName,
			'fundsTransferId' => $fundsTransferId,
			'amount' => $amountInCents,
			'accountInfo' => array(
				'accNum' => $acctNum,
				'routingNum' => $routingNum,
				'accType' => $acctType
			)
		);
	}
	
	/**
	 * Add physical check credit
	 *
	 * @param string $fundingSubMerchantId Funding submerchant id
	 * @param int $fundsTransferId Funds transfer id
	 * @param int $amountInCents Amount in cents
	 */
	public function addPhysicalCheckCredit($fundingSubMerchantId, $fundsTransferId, $amountInCents)
	{
		$this->physicalCheckCredits[] = array(
			'fundingSubmerchantId' => $fundingSubMerchantId,
			'fundsTransferId' => $fundsTransferId,
			'amount' => $amountInCents
		);
	}
	
	/**
	 * Add physical check debit
	 *
	 * @param string $fundingSubMerchantId Funding submerchant id
	 * @param int $fundsTransferId Funds transfer id
	 * @param int $amountInCents Amount in cents
	 */
	public function addPhysicalCheckDebit($fundingSubMerchantId, $fundsTransferId, $amountInCents)
	{
		$this->physicalCheckDebits[] = array(
			'fundingSubmerchantId' => $fundingSubMerchantId,
			'fundsTransferId' => $fundsTransferId,
			'amount' => $amountInCents
		);
	}
	
	/**
	 * Build XML from array
	 *
	 * @param array &$data Data
	 *
	 * @return string $xml
	 */
	protected function buildXmlFromArray($data)
	{
		$xml = '';
		$value = null;
		foreach ($data as $field=>&$value)
		{
			$xml .= '<' . $field . '>';
			if (is_array($value))
				$xml .= $this->buildXmlFromArray($value);
			else
				$xml .= htmlspecialchars($value);
			$xml .= '</' . $field . '>';
		}
		unset($value);
		return $xml;
	}
	
	/**
	 * Get funding instructions XML
	 *
	 * @return array Funding instructions XML, or null if there is no data
	 * @throws VantivException
	 */
	public function getFundingInstructionsXml()
	{
		// Batch requests as XML
		$batchRequestXmls = array();
		
		// Payfac credits
		$numPayFacCredits = count($this->payFacCredits);
		$payFacCreditAmount = 0;
		$payFacCredit = null;
		foreach ($this->payFacCredits as &$payFacCredit)
		{
			$batchRequestXmls[] = '<payFacCredit reportGroup="rsu_credit">' . $this->buildXmlFromArray($payFacCredit) . '</payFacCredit>' . "\n";
			$payFacCreditAmount += $payFacCredit['amount'];
		}
		unset($payFacCredit);
		
		// Payfac debits
		$numPayFacDebits = count($this->payFacDebits);
		$payFacDebitAmount = 0;
		$payFacDebit = null;
		foreach ($this->payFacDebits as &$payFacDebit)
		{
			$batchRequestXmls[] = '<payFacDebit reportGroup="rsu_debit">' . $this->buildXmlFromArray($payFacDebit) . '</payFacDebit>' . "\n";
			$payFacDebitAmount += $payFacDebit['amount'];
		}
		unset($payFacDebit);
		
		// Add submerchant credits
		$numSubmerchantCredits = count($this->submerchantCredits);
		$submerchantCreditAmount = 0;
		$submerchantCredit = null;
		foreach ($this->submerchantCredits as &$submerchantCredit)
		{
			$batchRequestXmls[] = '<submerchantCredit reportGroup="funding_credit">' . $this->buildXmlFromArray($submerchantCredit) . '</submerchantCredit>' . "\n";
			$submerchantCreditAmount += $submerchantCredit['amount'];
		}
		unset($submerchantCredit);
		
		// Add submerchant debits
		$numSubmerchantDebits = count($this->submerchantDebits);
		$submerchantDebitAmount = 0;
		$submerchantDebit = null;
		foreach ($this->submerchantDebits as &$submerchantDebit)
		{
			$batchRequestXmls[] = '<submerchantDebit reportGroup="funding_debit">' . $this->buildXmlFromArray($submerchantDebit) . '</submerchantDebit>' . "\n";
			$submerchantDebitAmount += $submerchantDebit['amount'];
		}
		unset($submerchantDebit);
		
		// Add physical check credits
		$numPhysicalCheckCredits = count($this->physicalCheckCredits);
		$physicalCheckCreditAmount = 0;
		$physicalCheckCredit = null;
		foreach ($this->physicalCheckCredits as &$physicalCheckCredit)
		{
			$batchRequestXmls[] = '<physicalCheckCredit reportGroup="funding_credit">' . $this->buildXmlFromArray($physicalCheckCredit) . '</physicalCheckCredit>' . "\n";
			$physicalCheckCreditAmount += $physicalCheckCredit['amount'];
		}
		unset($physicalCheckCredit);
		
		// Add physical check debits
		$numPhysicalCheckDebits = count($this->physicalCheckDebits);
		$physicalCheckDebitAmount = 0;
		$physicalCheckDebit = null;
		foreach ($this->physicalCheckDebits as &$physicalCheckDebit)
		{
			$batchRequestXmls[] = '<physicalCheckDebit reportGroup="funding_debit">' . $this->buildXmlFromArray($physicalCheckDebit) . '</physicalCheckDebit>' . "\n";
			$physicalCheckDebitAmount += $physicalCheckDebit['amount'];
		}
		unset($physicalCheckDebit);
		
		// Reserve credits
		$numReserveCredits = count($this->reserveCredits);
		$reserveCreditAmount = 0;
		$reserveCredit = null;
		foreach ($this->reserveCredits as &$reserveCredit)
		{
			$batchRequestXmls[] = '<reserveCredit reportGroup="reserve_credit">' . $this->buildXmlFromArray($reserveCredit) . '</reserveCredit>' . "\n";
			$reserveCreditAmount += $reserveCredit['amount'];
		}
		unset($reserveCredit);
		
		// Reserve debits
		$numReserveDebits = count($this->reserveDebits);
		$reserveDebitAmount = 0;
		$reserveDebit = null;
		foreach ($this->reserveDebits as &$reserveDebit)
		{
			$batchRequestXmls[] = '<reserveDebit reportGroup="reserve_debit">' . $this->buildXmlFromArray($reserveDebit) . '</reserveDebit>' . "\n";
			$reserveDebitAmount += $reserveDebit['amount'];
		}
		unset($reserveDebit);
		
		// Check for data
		if ($numSubmerchantCredits == 0 && $numSubmerchantDebits == 0 && $numPhysicalCheckCredits == 0 && $numPhysicalCheckDebits == 0 && $numPayFacCredits == 0 && $numPayFacDebits == 0 && $numReserveCredits == 0 && $numReserveDebits == 0)
			return null;
		
		// Add batchRequest element
		$batchRequestsXmls = array('<batchRequest
			merchantId="'.htmlspecialchars($this->fundingMerchantId).'"
			
			numPayFacCredit="'.$numPayFacCredits.'"
			payFacCreditAmount="'.$payFacCreditAmount.'"
			numPayFacDebit="'.$numPayFacDebits.'"
			payFacDebitAmount="'.$payFacDebitAmount.'"
			
			numSubmerchantCredit="'.$numSubmerchantCredits.'"
			submerchantCreditAmount="'.$submerchantCreditAmount.'"
			numSubmerchantDebit="'.$numSubmerchantDebits.'"
			submerchantDebitAmount="'.$submerchantDebitAmount.'"
			
			numPhysicalCheckCredit="'.$numPhysicalCheckCredits.'"
			physicalCheckCreditAmount="'.$physicalCheckCreditAmount.'"
			numPhysicalCheckDebit="'.$numPhysicalCheckDebits.'"
			physicalCheckDebitAmount="'.$physicalCheckDebitAmount.'"
			
			numReserveCredit="'.$numReserveCredits.'"
			reserveCreditAmount="'.$reserveCreditAmount.'"
			numReserveDebit="'.$numReserveDebits.'"
			reserveDebitAmount="'.$reserveDebitAmount.'"
			>'.implode('',$batchRequestXmls).'</batchRequest>'
		);
		
		// Clear data
		$this->submerchantCredits = array();
		
		// Build XML
		return $this->getBatchRequestXml($batchRequestsXmls);
	}
}