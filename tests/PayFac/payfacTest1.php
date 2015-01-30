<?php

require_once('../../VantivConfig.php');
require_once('../../src/vantiv/Vantiv.class.php');
use vantiv\Vantiv;
use vantiv\utils\VantivException;
use vantiv\utils\XmlValue;

try
{
	$vantivApi = new Vantiv(VantivConfig::API_USERNAME, VantivConfig::API_PASSWORD);
	$payFacApi = new \vantiv\api\PayFac($vantivApi, VantivConfig::SUBMERCHANT_API_ENDPOINT);
	$payFacApi->debug(true);
	
	// Create legal entity
	/*
	$resp = $payFacApi->createLegalEntity(array(
		'legalEntityName' => 'Legal Entity Name',
		'legalEntityType' => 'CORPORATION',
		'doingBusinessAs' => 'Alternate Business Name',
		'taxId' => '12345',
		'contactPhone' => '7817659800',
		'annualCreditCardSalesVolume' => 800000,
		'hasAcceptedCreditCards' => true,
		'address' => array(
			'streetAddress1' => 'Street Address 1',
			'streetAddress2' => 'Street Address 2',
			'city' => 'City',
			'stateProvince' => 'MA',
			'postalCode' => '01730',
			'countryCode' => 'USA'
		),
		'yearsInBusiness' => 12,
		'principals' => array(
			array(
				'title' => 'Chief Financial Officer',
				'firstName' => 'p first',
				'lastName' => 'p last',
				'emailAddress' => 'emailAddress',
				'ssn' => '123459876',
				'contactPhone' => '7817659800',
				'dateOfBirth' => '1980-10-12',
				'driversLicense' => '892327409832',
				'driversLicenseState' => 'MA',
				'address' => array(
					'countryCode' => 'USA'
				)
			)
		)
	));
	*/
	/*
	$resp = $payFacApi->createLegalEntity(array(
		'legalEntityName' => 'Single Person',
		'legalEntityType' => 'INDIVIDUAL_SOLE_PROPRIETORSHIP',
		'doingBusinessAs' => 'Doing Business As',
		'contactPhone' => '7817659800',
		'annualCreditCardSalesVolume' => 80000,
		'hasAcceptedCreditCards' => true,
		'address' => array(
			'streetAddress1' => 'Street Address 1',
			'streetAddress2' => 'Street Address 2',
			'city' => 'City',
			'stateProvince' => 'MA',
			'postalCode' => '01730',
			'countryCode' => 'USA'
		),
		'principals' => array(
			array(
				'firstName' => 'p first',
				'lastName' => 'p last',
				'emailAddress' => 'emailAddress',
				'ssn' => '123459876',
				'contactPhone' => '7817659800',
				'dateOfBirth' => '1980-10-12',
				'driversLicense' => '892327409832',
				'driversLicenseState' => 'MA',
				'address' => array(
					'streetAddress1' => 'p street address 1',
					'city' => 'Boston',
					'stateProvince' => 'MA',
					'postalCode' => '01890',
					'countryCode' => 'USA'
				)
			)
		)
	));
	*/
	/*
	var_dump($resp->getLegalEntityId());
	var_dump($resp->getResponseCode());
	var_dump($resp->getResponseMessage());
	var_dump($resp->wasDuplicateCreateRequest());
	*/
	
	// Retrieve legal entity
	/*
	$resp = $payFacApi->retrieveLegalEntity('82914395536588855');
	var_dump($resp->legalEntityName);
	*/
	
	// Update legal entity
	/*
	$resp = $payFacApi->updateLegalEntity('82914395536588855', array(
		'address' => array(
			'streetAddress1' => '300 Mill St.',
			'streetAddress2' => 'Suite 200',
			'city' => 'Moorestown',
			'stateProvince' => 'NJ',
			'postalCode' => '08057',
			'countryCode' => 'USA'
		)
	));
	*/
	
	// Create submerchant
	/*
	$resp = $payFacApi->createSubmerchant('82914395536588855', array(
		'merchantName' => 'RunSignUp Test',
		'pspMerchantId' => 'merchant_id_12345',
		'customerServiceNumber' => '5555555555',
		'hardCodedBillingDescriptor' => 'SignUp* Test',
		'maxTransactionAmount' => 100000000,
		'merchantCategoryCode' => 7941,
		'bankRoutingNumber' => 123456789,
		'bankAccountNumber' => 123456789,
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
		
		'url' => 'http://www.example.com',
		'subMerchantFunding' => new XmlValue(array(
			'fundingSubmerchantId' => 'AUTO_GENERATE'
		), array('enabled' => true))
	));
	*/
	/*
	$resp = $payFacApi->createSubmerchant('82914395536588889', array(
		'merchantName' => 'Merchant Name',
		'pspMerchantId' => 'merchant_id_11111',
		'amexMid' => '1234567890',
		'discoverConveyedMid' => '123456789012345',
		'url' => 'http://merchantUrl',
		'customerServiceNumber' => '8407809000',
		'hardCodedBillingDescriptor' => 'billingDescriptor',
		'maxTransactionAmount' => 8400,
		'purchaseCurrency' => 'USD',
		'merchantCategoryCode' => 7941,
		'bankRoutingNumber' => 840123124,
		'bankAccountNumber' => 84012312415,
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
		),
		'settlementCurrency' => 'USD',
		'subMerchantFunding' => new XmlValue(array(
			'fundingSubmerchantId' => 'AUTO_GENERATE'
		), array('enabled' => true))
	));
	*/
	
	// Get submerchant
	/*
	$resp = $payFacApi->retrieveSubMerchant('82914395536588855', '82914395537162320');
	var_dump($resp->pspMerchantId);
	var_dump($resp->merchantIdentString);
	var_dump($resp->getFundingSubMerchantId());
	*/
	
	// Update submerchant
	/*
	$resp = $payFacApi->updateSubmerchant('82914395536588855', '82914395537162320', array(
		'amexMid' => '1234567890',
		'discoverConveyedMid' => '123456789012345',
		'url' => 'http://merchantUrl',
		'customerServiceNumber' => '8407809000',
		'hardCodedBillingDescriptor' => 'RSU*RunSignUpTest',
		'maxTransactionAmount' => 8400,
		'bankRoutingNumber' => 840123124,
		'bankAccountNumber' => 84012312415,
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
	*/
	
	// Get MCC codes
	/*
	$resp = $payFacApi->retrieveMccCodes();
	print_r($resp->getMccCodes());
	*/
} catch (\vantiv\utils\VantivException $e) {
	print_r($e);
} catch (\vantiv\utils\InvalidRequestException $e) {
	print_r($e->error);
}