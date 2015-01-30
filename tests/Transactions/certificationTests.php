<?php

require_once('../../VantivConfig.php');
require_once('../../src/vantiv/Vantiv.class.php');
use vantiv\utils\XmlValue;
use vantiv\Vantiv;
use vantiv\utils\VantivException;

try
{
	$vantivApi = new Vantiv(VantivConfig::API_USERNAME, VantivConfig::API_PASSWORD);
	$onlineTransactionApi = new \vantiv\api\OnlineTransaction($vantivApi, VantivConfig::TRANSACTION_API_ENDPOINT);
	$onlineTransactionApi->debug(true);
	
	$merchantId = '01131037';
	
	// Start batch
	//$batch = $vantivApi->startNonAtomicBatch();
	$sales = array();
	
	// Order ID: 1
	$data = new XmlValue(array(
		'orderId' => '1',
		'amount' => 10010,
		'orderSource'=>'ecommerce',
		'billToAddress' => array(
			'name' => 'John Smith',
			'addressLine1' => '1 Main St.',
			'city' => 'Burlington',
			'state' => 'MA',
			'zip' => '01803-3747',
			'country' => 'US'
		),
		'card' => array(
			'number' =>'4457010000000009',
			'expDate' => '0116',
			'cardValidationNum' => '349',
			'type' => 'VI'
		)
	), array(
		'reportGroup' => 'Certification Test'
	));
	//$onlineTransactionApi->addSaleToBatch($batch, $merchantId, $data);
	$sales[] = $data;
	
	// Order ID: 2
	$data = new XmlValue(array(
		'orderId' => '2',
		'amount' => 10010,
		'orderSource'=>'ecommerce',
		'billToAddress' => array(
			'name' => 'Mike J. Hammer',
			'addressLine1' => '2 Main St.',
			'addressLine2' => 'Apt. 222',
			'city' => 'Riverside',
			'state' => 'RI',
			'zip' => '02915',
			'country' => 'US'
		),
		'card' => array(
			'number' =>'5112010000000003',
			'expDate' => '0216',
			'cardValidationNum' => '261',
			'type' => 'MC'
		),
		'cardholderAuthentication' => array(
			'authenticationValue' => 'BwABBJQ1AgAAAAAgJDUCAAAAAAA='
		)
	), array(
		'reportGroup' => 'Certification Test'
	));
	//$onlineTransactionApi->addSaleToBatch($batch, $merchantId, $data);
	$sales[] = $data;
	
	
	
	// Order ID: 3
	$data = new XmlValue(array(
		'orderId' => '3',
		'amount' => 10010,
		'orderSource'=>'ecommerce',
		'billToAddress' => array(
			'name' => 'Eileen Jones',
			'addressLine1' => '3 Main St.',
			'city' => 'Bloomfield',
			'state' => 'CT',
			'zip' => '06002',
			'country' => 'US'
		),
		'card' => array(
			'number' =>'6011010000000003',
			'expDate' => '0316',
			'cardValidationNum' => '758',
			'type' => 'DI'
		)
	), array(
		'reportGroup' => 'Certification Test'
	));
	//$onlineTransactionApi->addSaleToBatch($batch, $merchantId, $data);
	$sales[] = $data;
	
	
	
	// Order ID: 4
	$data = new XmlValue(array(
		'orderId' => '4',
		'amount' => 10010,
		'orderSource'=>'ecommerce',
		'billToAddress' => array(
			'name' => 'Bob Black',
			'addressLine1' => '4 Main St.',
			'city' => 'Laurel',
			'state' => 'MD',
			'zip' => '20708',
			'country' => 'US'
		),
		'card' => array(
			'number' =>'375001000000005',
			'expDate' => '0416',
			'type' => 'AX'
		)
	), array(
		'reportGroup' => 'Certification Test'
	));
	//$onlineTransactionApi->addSaleToBatch($batch, $merchantId, $data);
	$sales[] = $data;
	
	
	
	// Order ID: 5
	$data = new XmlValue(array(
		'orderId' => '5',
		'amount' => 10010,
		'orderSource'=>'ecommerce',
		'card' => array(
			'number' =>'4100200300011001',
			'expDate' => '0516',
			'cardValidationNum' => '463',
			'type' => 'VI'
		),
		'cardholderAuthentication' => array(
			'authenticationValue' => 'BwABBJQ1AgAAAAAgJDUCAAAAAAA='
		)
	), array(
		'reportGroup' => 'Certification Test'
	));
	//$onlineTransactionApi->addSaleToBatch($batch, $merchantId, $data);
	$sales[] = $data;
	
	
	
	// Order ID: 6
	$data = new XmlValue(array(
		'orderId' => '6',
		'amount' => 10010,
		'orderSource'=>'ecommerce',
		'billToAddress' => array(
			'name' => 'Joe Green',
			'addressLine1' => '6 Main St.',
			'city' => 'Derry',
			'state' => 'NH',
			'zip' => '03038',
			'country' => 'US'
		),
		'card' => array(
			'number' =>'4457010100000008',
			'expDate' => '0616',
			'cardValidationNum' => '992',
			'type' => 'VI'
		)
	), array(
		'reportGroup' => 'Certification Test'
	));
	//$onlineTransactionApi->addSaleToBatch($batch, $merchantId, $data);
	$sales[] = $data;
	
	
	
	// Order ID: 7
	$data = new XmlValue(array(
		'orderId' => '7',
		'amount' => 10010,
		'orderSource'=>'ecommerce',
		'billToAddress' => array(
			'name' => 'Jane Murray',
			'addressLine1' => '7 Main St.',
			'city' => 'Amesbury',
			'state' => 'MA',
			'zip' => '01913',
			'country' => 'US'
		),
		'card' => array(
			'number' =>'5112010100000002',
			'expDate' => '0716',
			'cardValidationNum' => '251',
			'type' => 'MC'
		)
	), array(
		'reportGroup' => 'Certification Test'
	));
	//$onlineTransactionApi->addSaleToBatch($batch, $merchantId, $data);
	$sales[] = $data;
	
	
	
	// Order ID: 8
	$data = new XmlValue(array(
		'orderId' => '8',
		'amount' => 10010,
		'orderSource'=>'ecommerce',
		'billToAddress' => array(
			'name' => 'Mark Johnson',
			'addressLine1' => '8 Main St.',
			'city' => 'Manchester',
			'state' => 'NH',
			'zip' => '03101',
			'country' => 'US'
		),
		'card' => array(
			'number' =>'6011010100000002',
			'expDate' => '0816',
			'cardValidationNum' => '184',
			'type' => 'DI'
		)
	), array(
		'reportGroup' => 'Certification Test'
	));
	//$onlineTransactionApi->addSaleToBatch($batch, $merchantId, $data);
	$sales[] = $data;
	
	
	
	
	// Order ID: 9
	$data = new XmlValue(array(
		'orderId' => '9',
		'amount' => 10010,
		'orderSource'=>'ecommerce',
		'billToAddress' => array(
			'name' => 'James Miller',
			'addressLine1' => '9 Main St.',
			'city' => 'Boston',
			'state' => 'MA',
			'zip' => '02134',
			'country' => 'US'
		),
		'card' => array(
			'number' =>'375001010000003',
			'expDate' => '0916',
			'cardValidationNum' => '0421',
			'type' => 'AX'
		)
	), array(
		'reportGroup' => 'Certification Test'
	));
	//$onlineTransactionApi->addSaleToBatch($batch, $merchantId, $data);
	$sales[] = $data;
	
	/*
	$resps = $vantivApi->executeNonAtomicBatch($batch);
	foreach ($resps as $idx=>$resp)
	{
		echo "\n================================================================================\n\n";
		if ($resp instanceof VantivException)
			print_r($resp);
		else
		{
			$saleResp = $resp->resp;
			print_r($saleResp);
		}
	}
	*/
	foreach ($sales as $sale)
	{
		echo "\n================================================================================\n\n";
		$saleResp = $onlineTransactionApi->sale($merchantId, $sale);
		print_r($saleResp);
	}
} catch (\vantiv\utils\InvalidRequestException $e) {
	print_r($e->error);
} catch (\vantiv\utils\VantivException $e) {
	var_dump($e->getMessage());
}