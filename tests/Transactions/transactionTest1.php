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
			'number' =>'5112010000000003',
			'expDate' => '0112',
			'cardValidationNum' => '349',
			'type' => Vantiv::getCreditCardType('5112010000000003')
		),
		'customBilling' => array(
			'phone' => '5555555555',
			//'url' => 'https://runsignup.com',	// Note: Can't be used with phone.  Also, can't be more than 13 characters.
			'descriptor' => 'SignUp *CustomDescriptor#'
		)
	), array(
		// Note: If an id is set, duplicate transaction checking is performed
		// 'id' => '1',
		'reportGroup' => 'Test Report Group'
	));
	
	// Sale transaction
	$resp = $onlineTransactionApi->sale('01131037', $data);
	var_dump($resp->getTransactionId());
	var_dump($resp->getResponse());
	var_dump($resp->getResponseMessage());
	var_dump($resp->wasSuccessful());
	/*
	// Void transaction
	$voidData = new XmlValue(array(
		'litleTxnId' => $resp->getTransactionId()
	), array(
		'id' => '2',
		'reportGroup' => 'Test Report Group'
	));
	$resp = $onlineTransactionApi->void('01131037', $voidData);
	
	// Refund/Credit transaction
	$creditData = new XmlValue(array(
		'litleTxnId' => '82914396608185091',
		'amount' => 10
	), array(
		'id' => '3',
		'reportGroup' => 'Test Report Group'
	));
	$resp = $onlineTransactionApi->credit('01131037', $creditData);
	*/
	/*
	// Batch sale
	$t1 = microtime(true);
	$batch = $vantivApi->startNonAtomicBatch();
	$batchSize = 5;
	for ($i = 0; $i < $batchSize; $i++)
	{
		$data1 = clone $data;
		if ($i == 1)
		{
			$data1->value['card']['number'] = '4100500000000000';// CVV match
			$data1->value['card']['type'] = Vantiv::getCreditCardType($data1->value['card']['number']);
		}
		else if ($i == 2)
		{
			$data1->value['card']['number'] = '4886883711815110';// Error
			$data1->value['card']['type'] = Vantiv::getCreditCardType($data1->value['card']['number']);
		}
		else if ($i == 3)
		{
			$data1->value['card']['number'] = '4100500000000100';// Processing Network Unavailable
			$data1->value['card']['type'] = Vantiv::getCreditCardType($data1->value['card']['number']);
		}
		else if ($i == 4)
		{
			$data1->value['card']['number'] = '4886883711815120';// Error
			$data1->value['card']['type'] = Vantiv::getCreditCardType($data1->value['card']['number']);
		}
		$onlineTransactionApi->addSaleToBatch($batch, '01131037', $data1);
	}
	$resps = $vantivApi->executeNonAtomicBatch($batch);
	foreach ($resps as $idx=>$resp)
	{
		echo "> {$idx}\n";
		if ($resp instanceof VantivException)
			print_r($resp);
		else
		{
			$saleResp = $resp->resp;
			print_r($saleResp);
		}
	}
	$t2 = microtime(true);
	printf("%d transactions in %0.03f seconds.\n", $batchSize, $t2-$t1);
	*/
} catch (\vantiv\utils\InvalidRequestException $e) {
	print_r($e->error);
} catch (\vantiv\utils\VantivException $e) {
	var_dump($e->getMessage());
	print_r($e);
}
