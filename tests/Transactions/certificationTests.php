<?php

require_once('../../VantivConfig.php');
require_once('../../src/vantiv/Vantiv.class.php');
use vantiv\utils\XmlValue;
use vantiv\Vantiv;
use vantiv\utils\VantivException;

try
{
	$vantivApi = new Vantiv(
		VantivConfig::API_USERNAME, VantivConfig::API_PASSWORD,
		defined('VantivConfig::PROXY') ? VantivConfig::PROXY : null,
		defined('VantivConfig::PROXY_USER_PSWD') ? VantivConfig::PROXY_USER_PSWD : null
	);
	$onlineTransactionApi = new \vantiv\api\OnlineTransaction($vantivApi, VantivConfig::TRANSACTION_API_ENDPOINT);
	//$onlineTransactionApi->debug(true);

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
			'name' => 'John & Mary Smith',
			'addressLine1' => '1 Main St.',
			'city' => 'Burlington',
			'state' => 'MA',
			'zip' => '01803-3747',
			'country' => 'US'
		),
		'card' => array(
			'number' =>'4457010000000009',
			'expDate' => '0121',
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
			'expDate' => '0221',
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
			'expDate' => '0321',
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
			'expDate' => '0421',
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
			'expDate' => '0521',
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
			'expDate' => '0621',
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
			'expDate' => '0721',
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
			'expDate' => '0821',
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
			'expDate' => '0921',
			'cardValidationNum' => '0421',
			'type' => 'AX'
		)
	), array(
		'reportGroup' => 'Certification Test'
	));
	//$onlineTransactionApi->addSaleToBatch($batch, $merchantId, $data);
	$sales[] = $data;



	// Order ID: Net_Id1
	$data = new XmlValue(array(
		'orderId' => 'Net_Id1',
		'amount' => 4999,
		'orderSource'=>'ecommerce',
		'billToAddress' => array(
			'name' => 'John & Mary Smith',
			'addressLine1' => '1 Main St.',
			'city' => 'Burlington',
			'state' => 'MA',
			'zip' => '01803-3747',
			'country' => 'US'
		),
		'card' => array(
			'number' =>'4100200300011001',
			'expDate' => '0521',
			'cardValidationNum' => '463',
			'type' => 'VI'
		),
		'processingType' => 'initialRecurring'
	), array(
		'reportGroup' => 'Certification Test'
	));
	//$onlineTransactionApi->addSaleToBatch($batch, $merchantId, $data);
	$sales[] = $data;



	// Order ID: Net_Id2
	$data = new XmlValue(array(
		'orderId' => 'Net_Id2',
		'amount' => 5500,
		'orderSource'=>'ecommerce',
		'billToAddress' => array(
			'name' => 'John & Mary Smith',
			'addressLine1' => '1 Main St.',
			'city' => 'Burlington',
			'state' => 'MA',
			'zip' => '01803-3747',
			'country' => 'US'
		),
		'card' => array(
			'number' =>'4457010000000009',
			'expDate' => '0121',
			'cardValidationNum' => '349',
			'type' => 'VI'
		),
		'processingType' => 'initialInstallment'
	), array(
		'reportGroup' => 'Certification Test'
	));
	//$onlineTransactionApi->addSaleToBatch($batch, $merchantId, $data);
	$sales[] = $data;



	// Order ID: Net_Id3
	$data = new XmlValue(array(
		'orderId' => 'Net_Id3',
		'amount' => 5500,
		'orderSource'=>'ecommerce',
		'billToAddress' => array(
			'name' => 'John Smith',
			'addressLine1' => '1 Main St.',
			'city' => 'Waltham',
			'state' => 'MA',
			'zip' => '02453',
			'country' => 'US'
		),
		'card' => array(
			'number' =>'4457000800000002',
			'expDate' => '0121',
			'cardValidationNum' => '349',
			'type' => 'VI'
		),
		'processingType' => 'initialCOF'
	), array(
		'reportGroup' => 'Certification Test'
	));
	//$onlineTransactionApi->addSaleToBatch($batch, $merchantId, $data);
	$sales[] = $data;



	$round2Sales = [];
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

		// Check for order ID and verify
		$verified = false;
		if (isset($saleResp->saleResponse['orderId']))
		{
			$orderId = $saleResp->saleResponse['orderId'];
			print 'Order ID: ' . $orderId . PHP_EOL;

			switch ($orderId)
			{
				case '1':
					$verified = $saleResp->saleResponse['response'] == '000' &&
						$saleResp->saleResponse['message'] == 'Approved' &&
						trim($saleResp->saleResponse['authCode']) == '11111' &&
						$saleResp->saleResponse['fraudResult']['avsResult'] == '01' &&
						$saleResp->saleResponse['fraudResult']['cardValidationResult'] == 'M';
					break;
				case '2':
					$verified = $saleResp->saleResponse['response'] == '000' &&
						$saleResp->saleResponse['message'] == 'Approved' &&
						trim($saleResp->saleResponse['authCode']) == '22222' &&
						$saleResp->saleResponse['fraudResult']['avsResult'] == '10' &&
						$saleResp->saleResponse['fraudResult']['cardValidationResult'] == 'M';
					break;
				case '3':
					$verified = $saleResp->saleResponse['response'] == '000' &&
						$saleResp->saleResponse['message'] == 'Approved' &&
						trim($saleResp->saleResponse['authCode']) == '33333' &&
						$saleResp->saleResponse['fraudResult']['avsResult'] == '10' &&
						$saleResp->saleResponse['fraudResult']['cardValidationResult'] == 'M';
					break;
				case '4':
					$verified = $saleResp->saleResponse['response'] == '000' &&
						$saleResp->saleResponse['message'] == 'Approved' &&
						trim($saleResp->saleResponse['authCode']) == '44444' &&
						$saleResp->saleResponse['fraudResult']['avsResult'] == '13';
					break;
				case '5':
					$verified = $saleResp->saleResponse['response'] == '000' &&
						$saleResp->saleResponse['message'] == 'Approved' &&
						trim($saleResp->saleResponse['authCode']) == '55555' &&
						$saleResp->saleResponse['fraudResult']['avsResult'] == '32' &&
						$saleResp->saleResponse['fraudResult']['cardValidationResult'] == 'M';
					break;
				case '6':
					$verified = $saleResp->saleResponse['response'] == '110' &&
						$saleResp->saleResponse['message'] == 'Insufficient Funds' &&
						$saleResp->saleResponse['fraudResult']['avsResult'] == '34' &&
						$saleResp->saleResponse['fraudResult']['cardValidationResult'] == 'P';
					break;
				case '7':
					$verified = $saleResp->saleResponse['response'] == '301' &&
						$saleResp->saleResponse['message'] == 'Invalid Account Number' &&
						$saleResp->saleResponse['fraudResult']['avsResult'] == '34' &&
						$saleResp->saleResponse['fraudResult']['cardValidationResult'] == 'N';
					break;
				case '8':
					$verified = $saleResp->saleResponse['response'] == '123' &&
						$saleResp->saleResponse['message'] == 'Call Discover' &&
						$saleResp->saleResponse['fraudResult']['avsResult'] == '34' &&
						$saleResp->saleResponse['fraudResult']['cardValidationResult'] == 'P';
					break;
				case '9':
					$verified = $saleResp->saleResponse['response'] == '303' &&
						$saleResp->saleResponse['message'] == 'Pick Up Card' &&
						$saleResp->saleResponse['fraudResult']['avsResult'] == '34' &&
						$saleResp->saleResponse['fraudResult']['cardValidationResult'] == 'P';
					break;
				case 'Net_Id1':
					$verified = $saleResp->saleResponse['response'] == '000' &&
						$saleResp->saleResponse['message'] == 'Approved' &&
						$saleResp->getNetworkTransactionId() !== null;

					// Add next sale
					$data = new XmlValue(array(
						'orderId' => 'Net_Id1a',
						'amount' => 4999,
						'orderSource'=>'recurring',
						'billToAddress' => array(
							'name' => 'John & Mary Smith',
							'addressLine1' => '1 Main St.',
							'city' => 'Burlington',
							'state' => 'MA',
							'zip' => '01803-3747',
							'country' => 'US'
						),
						'card' => array(
							'number' =>'4100200300011001',
							'expDate' => '0521',
							'cardValidationNum' => '463',
							'type' => 'VI'
						),
						'originalNetworkTransactionId' => $saleResp->getNetworkTransactionId()
					), array(
						'reportGroup' => 'Certification Test'
					));
					$round2Sales[] = $data;
					break;
				case 'Net_Id2':
					$verified = $saleResp->saleResponse['response'] == '000' &&
						$saleResp->saleResponse['message'] == 'Approved' &&
						trim($saleResp->saleResponse['authCode']) == '11111' &&
						$saleResp->saleResponse['fraudResult']['avsResult'] == '01' &&
						$saleResp->saleResponse['fraudResult']['cardValidationResult'] == 'M' &&
						$saleResp->getNetworkTransactionId() !== null;

					// Add next sale
					$data = new XmlValue(array(
						'orderId' => 'Net_Id2a',
						'amount' => 5500,
						'orderSource'=>'installment',
						'billToAddress' => array(
							'name' => 'John & Mary Smith',
							'addressLine1' => '1 Main St.',
							'city' => 'Burlington',
							'state' => 'MA',
							'zip' => '01803-3747',
							'country' => 'US'
						),
						'card' => array(
							'number' =>'4457010000000009',
							'expDate' => '0121',
							'cardValidationNum' => '349',
							'type' => 'VI'
						),
						'originalNetworkTransactionId' => $saleResp->getNetworkTransactionId()
					), array(
						'reportGroup' => 'Certification Test'
					));
					$round2Sales[] = $data;
					break;
				case 'Net_Id3':
					$verified = $saleResp->saleResponse['response'] == '000' &&
						$saleResp->saleResponse['message'] == 'Approved' &&
						trim($saleResp->saleResponse['authCode']) == '11111' &&
						$saleResp->saleResponse['fraudResult']['avsResult'] == '00' &&
						$saleResp->saleResponse['fraudResult']['cardValidationResult'] == 'P' &&
						$saleResp->getNetworkTransactionId() !== null;

					// Add next sale
					$data = new XmlValue(array(
						'orderId' => 'Net_Id3a',
						'amount' => 2500,
						'orderSource'=>'ecommerce',
						'billToAddress' => array(
							'name' => 'John Smith',
							'addressLine1' => '1 Main St.',
							'city' => 'Waltham',
							'state' => 'MA',
							'zip' => '02453',
							'country' => 'US'
						),
						'card' => array(
							'number' =>'4457000800000002',
							'expDate' => '0121',
							'cardValidationNum' => '349',
							'type' => 'VI'
						),
						'processingType' => 'merchantInitiatedCOF',
						'originalNetworkTransactionId' => $saleResp->getNetworkTransactionId()
					), array(
						'reportGroup' => 'Certification Test'
					));
					$round2Sales[] = $data;
					// Add next sale
					$data = new XmlValue(array(
						'orderId' => 'Net_Id3b',
						'amount' => 4000,
						'orderSource'=>'ecommerce',
						'billToAddress' => array(
							'name' => 'John Smith',
							'addressLine1' => '1 Main St.',
							'city' => 'Waltham',
							'state' => 'MA',
							'zip' => '02453',
							'country' => 'US'
						),
						'card' => array(
							'number' =>'4457000800000002',
							'expDate' => '0121',
							'cardValidationNum' => '349',
							'type' => 'VI'
						),
						'processingType' => 'merchantInitiatedCOF',
						'originalNetworkTransactionId' => $saleResp->getNetworkTransactionId()
					), array(
						'reportGroup' => 'Certification Test'
					));
					$round2Sales[] = $data;
					break;
			}
		}

		// Output transaction ID
		print 'Transaction ID: ' . $saleResp->getTransactionId() . PHP_EOL;

		// Output verified message or returned info otherwise.
		if ($verified)
			print 'Verified' . PHP_EOL;
		else
			print_r($saleResp);
	}

	// Round 2 sales
	foreach ($round2Sales as $sale)
	{
		echo "\n================================================================================\n\n";
		$saleResp = $onlineTransactionApi->sale($merchantId, $sale);

		// Check for order ID and verify
		$verified = false;
		if (isset($saleResp->saleResponse['orderId']))
		{
			$orderId = $saleResp->saleResponse['orderId'];
			print 'Order ID: ' . $orderId . PHP_EOL;

			switch ($orderId)
			{
				case 'Net_Id1a':
				case 'Net_Id2a':
				case 'Net_Id3a':
				case 'Net_Id3b':
					$verified = $saleResp->saleResponse['response'] == '000' &&
						$saleResp->saleResponse['message'] == 'Approved';
					break;
			}
		}

		// Output transaction ID
		print 'Transaction ID: ' . $saleResp->getTransactionId() . PHP_EOL;

		// Output verified message or returned info otherwise.
		if ($verified)
			print 'Verified' . PHP_EOL;
		else
			print_r($saleResp);
	}
} catch (\vantiv\utils\InvalidRequestException $e) {
	print_r($e->error);
} catch (\vantiv\utils\VantivException $e) {
	var_dump($e->getMessage());
}