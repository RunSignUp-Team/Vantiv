<?php

require_once('../../VantivConfig.php');
require_once('../../src/vantiv/Vantiv.class.php');
use vantiv\utils\XmlValue;
use vantiv\Vantiv;
use vantiv\utils\VantivException;

try
{
	$vantivApi = new Vantiv(VantivConfig::API_USERNAME, VantivConfig::API_PASSWORD, VantivConfig::PROXY, VantivConfig::PROXY_USER_PSWD);
	$onlineTransactionApi = new \vantiv\api\OnlineTransaction($vantivApi, VantivConfig::TRANSACTION_API_ENDPOINT);
	$onlineTransactionApi->debug(true);
	
	$merchantId = '01131037';
	
	// Start batch
	//$batch = $vantivApi->startNonAtomicBatch();
	$sales = array();
	
	$data = new XmlValue(array(
		'orderId' => date('Ymd').'-1',
		'amount' => 10010,
		'orderSource'=>'retail',
		'billToAddress' => array(
			'name' => 'John Smith',
			'addressLine1' => '1 Main St.',
			'city' => 'Burlington',
			'state' => 'MA',
			'zip' => '01803-3747',
			'country' => 'US'
		),
		'pos' => array(
			'capability' => 'magstripe',
			'entryMode' => 'completeread',
			'cardholderId' => 'nopin',
			'catLevel' => 'self service'
		),
		'card' => array(
			'track' =>'%B4054820004342984^VISA CARDHOLDER/^1710121000000195000000?U',
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