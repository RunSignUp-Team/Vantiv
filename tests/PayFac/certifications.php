<?php

require_once('../../VantivConfig.php');
require_once('../../src/vantiv/Vantiv.class.php');
use vantiv\Vantiv;
use vantiv\utils\VantivException;
use vantiv\utils\XmlValue;

/** Vantiv Certifications */
class VantivCertifications
{
	/** PayFac API */
	private $payFacApi = null;
	
	/** Test response data */
	private $testRespData = array();

	/** Test data */
	private $testData = array();

	/** Constructor */
	public function __construct()
	{
		$vantivApi = new Vantiv(VantivConfig::API_USERNAME, VantivConfig::API_PASSWORD, VantivConfig::PROXY, VantivConfig::PROXY_USER_PSWD);

		$this->payFacApi = new \vantiv\api\PayFac($vantivApi, VantivConfig::SUBMERCHANT_API_ENDPOINT);
		//$this->payFacApi->debug(true);
	}
	
	/**
	 * Generate a random tax ID
	 * @return string Random tax ID
	 */
	private function generateRandomTaxId() {
		return sprintf('%09d', rand(0, 999999999));
	}
	
	/** Run Certifications */
	public function runCertifications()
	{
		$this->runCreateLegalEntityCertificationTest1();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runCreateLegalEntityCertificationTest2();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runCreateLegalEntityCertificationTest3();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runUpdateLegalEntityCertificationTest4();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runUpdateLegalEntityCertificationTest5();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runRetrieveLegalEntityCertificationTest6();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runRetrieveLegalEntityCertificationTest7();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runCreateSubmerchantCertificationTest8();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runCreateSubmerchantCertificationTest9();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runCreateSubmerchantCertificationTest10();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runUpdateSubmerchantCertificationTest11();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runUpdateSubmerchantCertificationTest12();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runUpdateSubmerchantCertificationTest13();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runRetrieveSubmerchantCertificationTest14();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runRetrieveSubmerchantCertificationTest15();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runRetrieveSubmerchantCertificationTest16();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runRetrieveLegalEntityCertificationTest2a();
		print("\n" . str_repeat('-', 80) . "\n\n");
		$this->runRetrieveLegalEntityCertificationTest2b();
	}
	
	/** Run create legal entity certification test 1 */
	public function runCreateLegalEntityCertificationTest1()
	{
		print("Create legal entity test #1:\n");
		try
		{
			$resp = $this->payFacApi->createLegalEntity(array(
				'legalEntityName' => 'Legal Entity Name',
				'legalEntityType' => 'INDIVIDUAL_SOLE_PROPRIETORSHIP',
				'legalEntityOwnershipType' => 'PRIVATE',
				'doingBusinessAs' => 'Alternate Business Nsame',
				'taxId' => $this->generateRandomTaxId(),
				'contactPhone' => '7817659800',
				'annualCreditCardSalesVolume' => 800000,
				'hasAcceptedCreditCards' => true,
				'address' => array(
					'streetAddress1' => '900 Chelmsford St',
					'streetAddress2' => 'Street Address 2',
					'city' => 'City',
					'stateProvince' => 'MA',
					'postalCode' => '01730',
					'countryCode' => 'USA'
				),
				'yearsInBusiness' => 12,
				'principal' => array(
					'principalId' => 1,
					'title' => 'Chief Financial Officer',
					'firstName' => 'p first',
					'lastName' => 'p last',
					'emailAddress' => 'emailAddress',
					'ssn' => $this->generateRandomTaxId(),
					'contactPhone' => '7817659800',
					'dateOfBirth' => '1980-10-12',
					'driversLicense' => '892327409832',
					'driversLicenseState' => 'MA',
					'address' => array(
						'streetAddress1' => 'Street Address 1',
						'streetAddress2' => 'Street Address 2',
						'city' => 'City',
						'stateProvince' => 'MA',
						'postalCode' => '01730',
						'countryCode' => 'USA'
					),
					'stakePercent' => 100
				)
			));
			
			// Check for success
			if ($resp->responseCode == '10' && $resp->responseDescription == 'Approved')
			{
				print("Successful\n");
				print("Transaction ID: " . $resp->transactionId . "\n");
				print("Legal entity ID: " . $resp->legalEntityId . "\n");
				$this->testRespData[1] = $resp->legalEntityId;
			}
			else
			{
				print("Unexpected response:\n");
				print_r($resp);
			}
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run create legal entity certification test 2 */
	public function runCreateLegalEntityCertificationTest2()
	{
		print("Create legal entity test #2:\n");
		try
		{
			$this->testData[2] = [
				'taxId' => $this->generateRandomTaxId(),
				'ssn' => $this->generateRandomTaxId()
			];
			$resp = $this->payFacApi->createLegalEntity(array(
				'legalEntityName' => 'Legal Entity Name',
				'legalEntityType' => 'INDIVIDUAL_SOLE_PROPRIETORSHIP',
				'legalEntityOwnershipType' => 'PRIVATE',
				'doingBusinessAs' => 'Alternate Business Nsame',
				'taxId' => $this->testData[2]['taxId'],
				'contactPhone' => '7817659800',
				'annualCreditCardSalesVolume' => 800000,
				'hasAcceptedCreditCards' => true,
				'address' => array(
					'streetAddress1' => '912 Chelmsford St',
					'streetAddress2' => 'Street Address 2',
					'city' => 'City',
					'stateProvince' => 'MA',
					'postalCode' => '01730',
					'countryCode' => 'USA'
				),
				'yearsInBusiness' => 12,
				'principal' => array(
					'principalId' => 1,
					'title' => 'Chief Financial Officer',
					'firstName' => 'p first',
					'lastName' => 'p last',
					'emailAddress' => 'emailAddress',
					'ssn' => $this->testData[2]['ssn'],
					'contactPhone' => '7817659800',
					'dateOfBirth' => '1980-10-12',
					'driversLicense' => '892327409832',
					'driversLicenseState' => 'MA',
					'address' => array(
						'streetAddress1' => 'Street Address 1',
						'streetAddress2' => 'Street Address 2',
						'city' => 'City',
						'stateProvince' => 'MA',
						'postalCode' => '01730',
						'countryCode' => 'USA'
					),
					'stakePercent' => 100
				)
			));
			
			// Check for success
			if ($resp->responseCode == '20' && $resp->responseDescription == 'Manual Review')
			{
				print("Successful\n");
				print("Transaction ID: " . $resp->transactionId . "\n");
				print("Legal entity ID: " . $resp->legalEntityId . "\n");
				$this->testRespData[2] = $resp->legalEntityId;
			}
			else
			{
				print("Unexpected response:\n");
				print_r($resp);
			}
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}

	/** Run legal entity certification test 2a. */
	public function runRetrieveLegalEntityCertificationTest2a()
	{
		print("Retrieve legal entity test #2a:\n");
		try
		{
			$waiting = true;
			do
			{
				$resp = $this->payFacApi->retrieveLegalEntity($this->testRespData[2]);
				// Check for success
				if ($resp->responseCode == '30' && $resp->responseDescription == 'Retry')
				{
					print("Successful\n");
					print("Transaction ID: " . $resp->transactionId . "\n");
					print("Notes: " . $resp->backgroundCheckDecisionNotes . "\n");
					$waiting = false;
				}
				else
				{
					print("Waiting for Vantiv to update entity.  Current response: {$resp->responseCode} - {$resp->responseDescription} \n");
					sleep(120);
				}
			} while ($waiting);
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}

	/** Run legal entity certification test 2b. */
	public function runRetrieveLegalEntityCertificationTest2b()
	{
		print("Retrieve legal entity test #2b:\n");
		try
		{
			$resp = $this->payFacApi->updateLegalEntity($this->testRespData[1], array(
				'address' => array(
					'streetAddress1' => '900 Chelmsford St',
					'streetAddress2' => 'Street Address 2',
					'city' => 'City',
					'stateProvince' => 'MA',
					'postalCode' => '01730',
					'countryCode' => 'USA'
				),
				'principal' => array(
					'principalId' => 1,
					'title' => 'Chief Financial Officer',
					'emailAddress' => 'emailAddress',
					'contactPhone' => '7817659800',
					'address' => array(
						'streetAddress1' => 'Street Address 1',
						'streetAddress2' => 'Street Address 2',
						'city' => 'City',
						'stateProvince' => 'MA',
						'postalCode' => '01730',
						'countryCode' => 'USA'
					),
					'stakePercent' => 100,
					'backgroundCheckFields' => array(
						'firstName' => 'p first',
						'lastName' => 'p last',
						'ssn' => $this->testData[2]['ssn'],
						'dateOfBirth' => '1980-10-12',
						'driversLicense' => '892327409832',
						'driversLicenseState' => 'MA'
					)
				)
			));
			// Check for success
			if ($resp->responseCode == '10' && $resp->responseDescription == 'Approved')
			{
				print("Successful\n");
				print("Transaction ID: " . $resp->transactionId . "\n");
				$waiting = false;
			}
			else
			{
				print("Unexpected response:\n");
				print_r($resp);
			}
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}

	/** Run create legal entity certification test 3 */
	public function runCreateLegalEntityCertificationTest3()
	{
		print("Create legal entity test #3:\n");
		try
		{
			$resp = $this->payFacApi->createLegalEntity(array(
				'legalEntityName' => 'Legal Entity Name',
				'legalEntityType' => 'LIMITED_LIABILITY_COMPANY',
				'legalEntityOwnershipType' => 'PRIVATE',
				'doingBusinessAs' => 'Alternate Business Nsame',
				'taxId' => $this->generateRandomTaxId(),
				'contactPhone' => '7817659800',
				'annualCreditCardSalesVolume' => 800000,
				'hasAcceptedCreditCards' => true,
				'address' => array(
					'streetAddress1' => '914 Chelmsford St',
					'streetAddress2' => 'Street Address 2',
					'city' => 'City',
					'stateProvince' => 'MA',
					'postalCode' => '01730',
					'countryCode' => 'USA'
				),
				'yearsInBusiness' => 12,
				'principal' => array(
					'principalId' => 1,
					'title' => 'Chief Financial Officer',
					'firstName' => 'p first',
					'lastName' => 'p last',
					'emailAddress' => 'emailAddress',
					'ssn' => $this->generateRandomTaxId(),
					'contactPhone' => '7817659800',
					'dateOfBirth' => '1980-10-12',
					'driversLicense' => '892327409832',
					'driversLicenseState' => 'MA',
					'address' => array(
						'streetAddress1' => 'Street Address 1',
						'streetAddress2' => 'Street Address 2',
						'city' => 'City',
						'stateProvince' => 'MA',
						'postalCode' => '01730',
						'countryCode' => 'USA'
					),
					'stakePercent' => 100
				)
			));
			
			// Check for success
			if ($resp->responseCode == '10' && $resp->responseDescription == 'Approved')
			{
				print("Successful\n");
				print("Transaction ID: " . $resp->transactionId . "\n");
				print("Legal entity ID: " . $resp->legalEntityId . "\n");
			}
			else
			{
				print("Unexpected response:\n");
				print_r($resp);
			}
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run update legal entity certification test 4 */
	public function runUpdateLegalEntityCertificationTest4()
	{
		print("Update legal entity test #4:\n");
		try
		{
			$resp = $this->payFacApi->updateLegalEntity($this->testRespData[1], array(
				'address' => array(
					'streetAddress1' => '914 Chelmsford St',
					'streetAddress2' => 'Street Address 2',
					'city' => 'City',
					'stateProvince' => 'MA',
					'postalCode' => '01730',
					'countryCode' => 'USA'
				),
				'principal' => array(
					'principalId' => 1,
					'title' => 'Chief Financial Officer',
					'emailAddress' => 'emailAddress',
					'contactPhone' => '7817659800',
					'address' => array(
						'streetAddress1' => 'Street Address 1',
						'streetAddress2' => 'Street Address 2',
						'city' => 'City',
						'stateProvince' => 'MA',
						'postalCode' => '01730',
						'countryCode' => 'USA'
					),
					'stakePercent' => 100,
					'backgroundCheckFields' => array(
						'firstName' => 'p first',
						'lastName' => 'p last',
						'ssn' => $this->generateRandomTaxId(),
						'dateOfBirth' => '1980-10-12',
						'driversLicense' => '892327409832',
						'driversLicenseState' => 'MA'
					)
				)
			));
			
			// Output legal entity ID
			print("Transaction ID: " . $resp->transactionId . "\n");
			print("Legal entity ID: " . $resp->legalEntityId . "\n");
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run update legal entity certification test 5 */
	public function runUpdateLegalEntityCertificationTest5()
	{
		print("Update legal entity test #5:\n");
		try
		{
			$resp = $this->payFacApi->updateLegalEntity('123', array(
				'address' => array(
					'streetAddress1' => '914 Chelmsford St',
					'streetAddress2' => 'Street Address 2',
					'city' => 'City',
					'stateProvince' => 'MA',
					'postalCode' => '01730',
					'countryCode' => 'USA'
				)
			));
			
			// We shouldn't reach here
			print("Unexpected response:\n");
			print_r($resp);
		} catch (\vantiv\utils\VantivErrorException $e) {
			if ($e->getCode() == 400)
			{
				print("Successful\n");
				print("Transaction ID: " . $e->errorResp->transactionId . "\n");
			}
			else
			{
				print("VantivErrorException:\n");
				print_r($e);
			}
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run retreive legal entity certification test 6 */
	public function runRetrieveLegalEntityCertificationTest6()
	{
		print("Retrieve legal entity test #6:\n");
		try
		{
			$resp = $this->payFacApi->retrieveLegalEntity($this->testRespData[2]);
			
			// Check for success
			if ($resp->responseCode == '20' && $resp->responseDescription == 'Manual Review')
			{
				print("Successful\n");
				print("Transaction ID: " . $resp->transactionId . "\n");
				print("Legal entity ID: " . $resp->legalEntityId . "\n");
				$this->testRespData[2] = $resp->legalEntityId;
			}
			else
			{
				print("Unexpected response:\n");
				print_r($resp);
			}
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run retreive legal entity certification test 7 */
	public function runRetrieveLegalEntityCertificationTest7()
	{
		print("Retrieve legal entity test #7:\n");
		try
		{
			$resp = $this->payFacApi->retrieveLegalEntity('123');
			
			// We shouldn't reach here
			print("Unexpected response:\n");
			print_r($resp);
		} catch (\vantiv\utils\VantivErrorException $e) {
			if ($e->getCode() == 400)
			{
				print("Successful\n");
				print("Transaction ID: " . $e->errorResp->transactionId . "\n");
			}
			else
			{
				print("VantivErrorException:\n");
				print_r($e);
			}
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run create submerchant certification test 8 */
	public function runCreateSubmerchantCertificationTest8()
	{
		print("Create submerchant test #8:\n");
		try
		{
			$resp = $this->payFacApi->createSubmerchant($this->testRespData[1], array(
				'merchantName' => 'RunSignUp Test',
				'pspMerchantId' => 'merchant_id_'.time().'-'.rand(0, 999999),
				'customerServiceNumber' => '5555555555',
				'hardCodedBillingDescriptor' => 'SignUp * Test',
				'maxTransactionAmount' => 100000000,
				'merchantCategoryCode' => 7941,
				'bankRoutingNumber' => '011103093',
				'bankAccountNumber' => '123456789',
				'address' => array(
					'streetAddress1' => '300 Mill St',
					'streetAddress2' => 'Suite 200',
					'city' => 'Moorestown',
					'stateProvince' => 'NJ',
					'postalCode' => '08057',
					'countryCode' => 'USA'
				),
				'primaryContact' => array(
					'firstName' => 'Bob',
					'lastName' => 'Bickel',
					'emailAddress' => 'example@example.com',
					'phone' => '5555555555'
				),
				'settlementCurrency' => 'USD',
				'amexAcquired' => new XmlValue(array(), array('enabled' => true)),
				
				'url' => 'http://www.example.com',
				'subMerchantFunding' => new XmlValue(array(
					'fundingSubmerchantId' => 'AUTO_GENERATE'
				), array('enabled' => true))
			));
			
			// Check for success
			print("Successful\n");
			print("Transaction ID: " . $resp->transactionId . "\n");
			print("Submerchant ID: " . $resp->getSubMerchantId() . "\n");
			$this->testRespData[8] = $resp->getSubMerchantId();
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run create submerchant certification test 9 */
	public function runCreateSubmerchantCertificationTest9()
	{
		print("Create submerchant test #9:\n");
		try
		{
			$resp = $this->payFacApi->createSubmerchant('123', array(
				'merchantName' => 'RunSignUp Test',
				'pspMerchantId' => 'merchant_id_'.time().'-'.rand(0, 999999),
				'customerServiceNumber' => '5555555555',
				'hardCodedBillingDescriptor' => 'SignUp* Test',
				'maxTransactionAmount' => 100000000,
				'merchantCategoryCode' => 7941,
				'bankRoutingNumber' => '011103093',
				'bankAccountNumber' => '123456789',
				'address' => array(
					'streetAddress1' => '300 Mill St',
					'streetAddress2' => 'Suite 200',
					'city' => 'Moorestown',
					'stateProvince' => 'NJ',
					'postalCode' => '08057',
					'countryCode' => 'USA'
				),
				'primaryContact' => array(
					'firstName' => 'Bob',
					'lastName' => 'Bickel',
					'emailAddress' => 'example@example.com',
					'phone' => '5555555555'
				),
				'settlementCurrency' => 'USD',
				'amexAcquired' => new XmlValue(array(), array('enabled' => true)),
				
				'url' => 'http://www.example.com',
				'subMerchantFunding' => new XmlValue(array(
					'fundingSubmerchantId' => 'AUTO_GENERATE'
				), array('enabled' => true))
			));
			
			// We shouldn't reach here
			print("Unexpected response:\n");
			print_r($resp);
		} catch (\vantiv\utils\VantivErrorException $e) {
			if ($e->getCode() == 400)
			{
				print("Successful\n");
				print("Transaction ID: " . $e->errorResp->transactionId . "\n");
			}
			else
			{
				print("VantivErrorException:\n");
				print_r($e);
			}
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run create submerchant certification test 10 */
	public function runCreateSubmerchantCertificationTest10()
	{
		print("Create submerchant test #10:\n");
		try
		{
			$resp = $this->payFacApi->createSubmerchant($this->testRespData[2], array(
				'merchantName' => 'RunSignUp Test',
				'pspMerchantId' => 'merchant_id_'.time().'-'.rand(0, 999999),
				'customerServiceNumber' => '5555555555',
				'hardCodedBillingDescriptor' => 'SignUp* Test',
				'maxTransactionAmount' => 100000000,
				'merchantCategoryCode' => 7941,
				'bankRoutingNumber' => '011103093',
				'bankAccountNumber' => '123456789',
				'address' => array(
					'streetAddress1' => '300 Mill St',
					'streetAddress2' => 'Suite 200',
					'city' => 'Moorestown',
					'stateProvince' => 'NJ',
					'postalCode' => '08057',
					'countryCode' => 'USA'
				),
				'primaryContact' => array(
					'firstName' => 'Bob',
					'lastName' => 'Bickel',
					'emailAddress' => 'example@example.com',
					'phone' => '5555555555'
				),
				'settlementCurrency' => 'USD',
				'amexAcquired' => new XmlValue(array(), array('enabled' => true)),
				
				'url' => 'http://www.example.com',
				'subMerchantFunding' => new XmlValue(array(
					'fundingSubmerchantId' => 'AUTO_GENERATE'
				), array('enabled' => true))
			));
			
			// We shouldn't reach here
			print("Unexpected response:\n");
			print_r($resp);
		} catch (\vantiv\utils\VantivErrorException $e) {
			if ($e->getCode() == 400)
			{
				print("Successful\n");
				print("Transaction ID: " . $e->errorResp->transactionId . "\n");
			}
			else
			{
				print("VantivErrorException:\n");
				print_r($e);
			}
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run update submerchant certification test 11 */
	public function runUpdateSubmerchantCertificationTest11()
	{
		print("Update submerchant test #11:\n");
		try
		{
			$resp = $this->payFacApi->updateSubmerchant($this->testRespData[1], $this->testRespData[8], array(
				'amexAcquired' => new XmlValue(array(), array('enabled' => false)),
				'discoverConveyedMid' => '123456789012345',
				'url' => 'http://merchantUrl',
				'customerServiceNumber' => '8407809000',
				'hardCodedBillingDescriptor' => 'SignUp *RunSignUpTest',
				'maxTransactionAmount' => 8400,
				'bankRoutingNumber' => '011103093',
				'bankAccountNumber' => '84012312415',
				'address' => array(
					'streetAddress1' => 'Street Address 1',
					'streetAddress2' => 'Street Address 2',
					'city' => 'City',
					'stateProvince' => 'MA',
					'postalCode' => '01970',
					'countryCode' => 'USA'
				),
				'primaryContact' => array(
					'firstName' => 'John',
					'lastName' => 'Doe',
					'emailAddress' => 'John.Doe@company.com',
					'phone' => '9785552222'
				)
			));
			
			// Check for success
			print("Successful\n");
			print("Transaction ID: " . $resp->transactionId . "\n");
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run update submerchant certification test 12 */
	public function runUpdateSubmerchantCertificationTest12()
	{
		print("Update submerchant test #12:\n");
		try
		{
			$resp = $this->payFacApi->updateSubmerchant('123', '456', array(
				'amexAcquired' => new XmlValue(array(), array('enabled' => false)),
				'discoverConveyedMid' => '123456789012345',
				'url' => 'http://merchantUrl',
				'customerServiceNumber' => '8407809000',
				'hardCodedBillingDescriptor' => 'SignUp *RunSignUpTest',
				'maxTransactionAmount' => 8400,
				'bankRoutingNumber' => '011103093',
				'bankAccountNumber' => '84012312415',
				'address' => array(
					'streetAddress1' => 'Street Address 1',
					'streetAddress2' => 'Street Address 2',
					'city' => 'City',
					'stateProvince' => 'MA',
					'postalCode' => '01970',
					'countryCode' => 'USA'
				),
				'primaryContact' => array(
					'firstName' => 'John',
					'lastName' => 'Doe',
					'emailAddress' => 'John.Doe@company.com',
					'phone' => '9785552222'
				)
			));
			
			// We shouldn't reach here
			print("Unexpected response:\n");
			print_r($resp);
		} catch (\vantiv\utils\VantivErrorException $e) {
			if ($e->getCode() == 400)
			{
				print("Successful\n");
				print("Transaction ID: " . $e->errorResp->transactionId . "\n");
			}
			else
			{
				print("VantivErrorException:\n");
				print_r($e);
			}
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run update submerchant certification test 13 */
	public function runUpdateSubmerchantCertificationTest13()
	{
		print("Update submerchant test #13:\n");
		try
		{
			$resp = $this->payFacApi->updateSubmerchant($this->testRespData[1], '456', array(
				'amexAcquired' => new XmlValue(array(), array('enabled' => false)),
				'discoverConveyedMid' => '123456789012345',
				'url' => 'http://merchantUrl',
				'customerServiceNumber' => '8407809000',
				'hardCodedBillingDescriptor' => 'SignUp *RunSignUpTest',
				'maxTransactionAmount' => 8400,
				'bankRoutingNumber' => '011103093',
				'bankAccountNumber' => '84012312415',
				'address' => array(
					'streetAddress1' => 'Street Address 1',
					'streetAddress2' => 'Street Address 2',
					'city' => 'City',
					'stateProvince' => 'MA',
					'postalCode' => '01970',
					'countryCode' => 'USA'
				),
				'primaryContact' => array(
					'firstName' => 'John',
					'lastName' => 'Doe',
					'emailAddress' => 'John.Doe@company.com',
					'phone' => '9785552222'
				)
			));
			
			// We shouldn't reach here
			print("Unexpected response:\n");
			print_r($resp);
		} catch (\vantiv\utils\VantivErrorException $e) {
			if ($e->getCode() == 400)
			{
				print("Successful\n");
				print("Transaction ID: " . $e->errorResp->transactionId . "\n");
			}
			else
			{
				print("VantivErrorException:\n");
				print_r($e);
			}
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run retrieve submerchant certification test 14 */
	public function runRetrieveSubmerchantCertificationTest14()
	{
		print("Retrieve submerchant test #14:\n");
		try
		{
			$resp = $this->payFacApi->retrieveSubMerchant($this->testRespData[1], $this->testRespData[8]);
			print("Successful\n");
			print("Transaction ID: " . $resp->transactionId . "\n");
			print("Merchant Ident String: " . $resp->merchantIdentString . "\n");
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run retrieve submerchant certification test 15 */
	public function runRetrieveSubmerchantCertificationTest15()
	{
		print("Retrieve submerchant test #15:\n");
		try
		{
			$resp = $this->payFacApi->retrieveSubMerchant('123', '456');
			
			// We shouldn't reach here
			print("Unexpected response:\n");
			print_r($resp);
		} catch (\vantiv\utils\VantivErrorException $e) {
			if ($e->getCode() == 400)
			{
				print("Successful\n");
				print("Transaction ID: " . $e->errorResp->transactionId . "\n");
			}
			else
			{
				print("VantivErrorException:\n");
				print_r($e);
			}
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
	
	/** Run retrieve submerchant certification test 16 */
	public function runRetrieveSubmerchantCertificationTest16()
	{
		print("Retrieve submerchant test #16:\n");
		try
		{
			$resp = $this->payFacApi->retrieveSubMerchant($this->testRespData[1], '456');
			
			// We shouldn't reach here
			print("Unexpected response:\n");
			print_r($resp);
		} catch (\vantiv\utils\VantivErrorException $e) {
			if ($e->getCode() == 400)
			{
				print("Successful\n");
				print("Transaction ID: " . $e->errorResp->transactionId . "\n");
			}
			else
			{
				print("VantivErrorException:\n");
				print_r($e);
			}
		} catch (\vantiv\utils\InvalidRequestException $e) {
			print("InvalidRequestException:\n");
			print_r($e->error);
		} catch (\vantiv\utils\VantivException $e) {
			print("VantivException:\n");
			print_r($e);
		}
	}
}

$vantivCertifications = new VantivCertifications();
$vantivCertifications->runCertifications();