<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\utils;

/** Vantiv Response Codes */
class VantivResponseCodes
{
	/** Approved */
	const TRANS_RESP_CODE_APPROVED = '000';
	/** Processor Network Unavailable */
	const TRANS_RESP_CODE_PROC_NET_UNAVAIL = '100';
	/** Issuer Unavailable */
	const TRANS_RESP_CODE_ISSUER_UNAVAIL = '101';
	/** Insufficient Funds */
	const TRANS_RESP_CODE_INSUFFICIENT_FUNDS = '110';
	/** Reversal unsuccessful */
	const TRANS_RESP_CODE_REVERSAL_UNSUCCESSFUL = '211';
	/** Incorrect CVV */
	const TRANS_RESP_CODE_INCORRET_CVV = '226';
	/** Duplicate transaction */
	const TRANS_RESP_CODE_DUP = '251';
	/** System error */
	const TRANS_RESP_CODE_SYS_ERR = '252';
	/** System error message format error) */
	const TRANS_RESP_CODE_SYS_ERR_MSG_FMT = '257';
	/** System error (Cannot Process) */
	const TRANS_RESP_CODE_SYS_ERR_CANT_PROCESS = '258';
	/** Invalid merchant */
	const TRANS_RESP_CODE_INVALID_MERCHANT = '321';
	
	// Legal Entity Response Codes
	/** Legal Entity Approved */
	const LEGAL_ENTITY_RESP_CODE_APPROVED = 10;
	/** Legal Entity Manual Review */
	const LEGAL_ENTITY_RESP_CODE_MANUAL_REVIEW = 20;
	/** Legal Entity Retry */
	const LEGAL_ENTITY_RESP_CODE_RETRY = 30;
	/** Legal Entity Manual Review Duplicate */
	const LEGAL_ENTITY_RESP_CODE_MANUAL_REVIEW_DUPLICATE = 35;
	/** Legal Entity Duplicate */
	CONST LEGAL_ENTITY_RESP_CODE_DUPLICATE = 36;
	/** Legal Entity Declined */
	const LEGAL_ENTITY_RESP_CODE_DECLINED = 40;
	/** Legal Entity Manual Review Background Check Error */
	const LEGAL_ENTITY_RESP_CODE_MANUAL_REVIEW_BG_CHECK_ERR = 99;
	
	// TIN Validation Status
	/** TIN Approved */
	const TIN_VALIDATION_APPROVED = 'Approved';
	/** TIN Validation Failed */
	const TIN_VALIDATION_FAILED = 'Failed';
	/** TIN Validation Pending */
	const TIN_VALIDATION_PENDING = 'Pending';
	
}