<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\utils;

/** Vantiv XML Spec */
class XmlSpec
{
	/** Flags */
	public $flags = 0;
	
	// Spec flags
	const XML_SPEC_REQUIRED =		0x00000001;
	const XML_SPEC_BOOL =				0x00000002;
	const XML_SPEC_INT =				0x00000004;
	const XML_SPEC_LIST =				0x00000008;	// Only applicable with subspecs
	
	/** Sub-specs */
	public $subspecs = null;
	
	/** Attributes */
	public $attrs = null;
	
	/** Default spec */
	private static $defaultSpec = null;
	
	/** Required spec */
	private static $requiredSpec = null;
	
	/** Int spec */
	private static $intSpec = null;
	
	/** Required int spec */
	private static $requiredIntSpec = null;
	
	/** Bool spec */
	private static $boolSpec = null;
	
	/** Required bool spec */
	private static $requiredBoolSpec = null;
	
	/**
	 * Contructor
	 *
	 * @param int $flags Flags
	 * @param array $subspecs Sub-spec
	 * @param string $listKey List key for XML_SPEC_LIST
	 * @param array $attrs Attribute specs
	 */
	public function __construct($flags, $subspecs = null, $listKey = null, $attrs = array())
	{
		$this->flags = $flags;
		$this->subspecs = $subspecs;
		$this->listKey = $listKey;
		$this->attrs = $attrs;
	}
	
	/**
	 * Get default spec
	 * @return XmlSpec Default spec
	 */
	public function getDefaultSpec()
	{
		if (self::$defaultSpec === null)
			self::$defaultSpec = new XmlSpec(0);
		return self::$defaultSpec;
	}
	
	/**
	 * Get required spec
	 * @return XmlSpec Spec
	 */
	public function getRequiredSpec()
	{
		if (self::$requiredSpec === null)
			self::$requiredSpec = new XmlSpec(self::XML_SPEC_REQUIRED);
		return self::$requiredSpec;
	}
	
	/**
	 * Get int spec
	 * @return XmlSpec Spec
	 */
	public function getIntSpec()
	{
		if (self::$intSpec === null)
			self::$intSpec = new XmlSpec(self::XML_SPEC_INT);
		return self::$intSpec;
	}
	
	/**
	 * Get required int spec
	 * @return XmlSpec Spec
	 */
	public function getRequiredIntSpec()
	{
		if (self::$requiredIntSpec === null)
			self::$requiredIntSpec = new XmlSpec(self::XML_SPEC_REQUIRED | self::XML_SPEC_INT);
		return self::$requiredIntSpec;
	}
	
	/**
	 * Get bool spec
	 * @return XmlSpec Spec
	 */
	public function getBoolSpec()
	{
		if (self::$boolSpec === null)
			self::$boolSpec = new XmlSpec(self::XML_SPEC_BOOL);
		return self::$boolSpec;
	}
	
	/**
	 * Get required bool spec
	 * @return XmlSpec Spec
	 */
	public function getRequiredBoolSpec()
	{
		if (self::$requiredBoolSpec === null)
			self::$requiredBoolSpec = new XmlSpec(self::XML_SPEC_REQUIRED | self::XML_SPEC_BOOL);
		return self::$requiredBoolSpec;
	}
}