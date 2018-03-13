<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\utils;

/** Vantiv PayFac Validator */
class VantivPayFacValidator
{
	/** Legal entity name max length */
	const LEGAL_ENTITY_NAME_MAX_LENGTH = 60;
	
	/** DBA max length */
	const DBA_MAX_LENGTH = 60;
	
	/** Tax ID length */
	const TAX_ID_LENGTH = 9;
	
	/** SSN length */
	const SSN_LENGTH = 9;
	
	/** Street address 1 max length */
	const STREET_ADDR1_MAX_LENGTH = 60;
	
	/** Street address 2 max length */
	const STREET_ADDR2_MAX_LENGTH = 60;
	
	/** City max length */
	const CITY_MAX_LENGTH = 20;
	
	/** First name max length */
	const FIRST_NAME_MAX_LENGTH = 20;
	
	/** Last name max length */
	const LAST_NAME_MAX_LENGTH = 20;
	
	/** Principal title max length */
	const PRINCIPAL_TITLE_MAX_LENGTH = 60;
	
	/** E-mail address max length */
	const EMAIL_MAX_LENGTH = 100;
	
	/** Merchant name max length */
	const MERCHANT_NAME_MAX_LENGTH = 50;
	
	/** Billing descriptor REGEX */
	const BILLING_DESC_REGEX = '^[0-9a-zA-Z&,.# -]+$';
}