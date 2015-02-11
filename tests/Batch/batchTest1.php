<?php

require_once('../../VantivConfig.php');
require_once('../../src/vantiv/Vantiv.class.php');
use vantiv\utils\XmlValue;
use vantiv\Vantiv;
use vantiv\utils\SFTP;

try
{
	$vantivApi = new Vantiv(VantivConfig::API_USERNAME, VantivConfig::API_PASSWORD);
	$vantivFundingApi = new \vantiv\api\InstructionBasedFunding($vantivApi, VantivConfig::FUNDING_INSTRUCTIONS_MERCHANT_ID);
	
	// Batch test 1
	$vantivFundingApi->addPayFacCredit(123, '00001', 1000);
	$vantivFundingApi->addSubmerchantCredit(123, 'Submerchant Name', '00003', 3000, 'Checking', '123456789', '114567895');
	$vantivFundingApi->addReserveCredit(123, '00005', 5000);
	$vantivFundingApi->addPhysicalCheckCredit(123, '00009', 9000);
	
	// Upload file
	$fundingXml = $vantivFundingApi->getFundingInstructionsXml();
	SFTP::uploadBatchFileContents(VantivConfig::SFTP_USERNAME, VantivConfig::SFTP_HOST, $fundingXml, date('YmdHis').'_certTest1.asc');
	
	// Batch test 2
	$vantivFundingApi->addPayFacDebit(123, '00002', 2000);
	$vantivFundingApi->addSubmerchantDebit(123, 'Submerchant Name', '00004', 4000, 'Checking', '123456789', '114567895');
	$vantivFundingApi->addReserveDebit(123, '00006', 6000);
	$vantivFundingApi->addPhysicalCheckDebit(123, '00010', 10000);
	
	// Upload file
	$fundingXml = $vantivFundingApi->getFundingInstructionsXml();
	SFTP::uploadBatchFileContents(VantivConfig::SFTP_USERNAME, VantivConfig::SFTP_HOST, $fundingXml, date('YmdHis').'_certTest2.asc');
} catch (Exception $e) {
	var_dump($e->getMessage());
	print_r($e);
}	