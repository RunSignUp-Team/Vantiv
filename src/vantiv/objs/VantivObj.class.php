<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\objs;
use \SimpleXMLElement;
use \vantiv\utils\VantivException;

/** Vantiv Object */
class VantivObj
{
	/** XML Error */
	private $xmlError = null;

	/** XML Attributes */
	protected $xmlAttrs = [];

	/**
	 * Constructor
	 *
	 * @param string $xml XML string
	 * @throws VantivException
	 */
	public function __construct($xml)
	{
		$xml = new SimpleXMLElement($xml);
		if (isset($xml['response']) && (string)$xml['response'] != '0')
			throw new VantivException((string)$xml['message'], (int)$xml['response']);
		$this->parseSimpleXmlElem($xml);
	}
	
	/**
	 * Parse SimpleXML element
	 *
	 * @param SimpleXMLElement $elem SimpleXML Element
	 * @param array $destArr Destination array
	 * @param array Destination XML attributes
	 */
	protected function parseSimpleXmlElem($elem, array &$destArr = null, array &$destXmlAttrs = null)
	{
		// Set up $destXmlAttrs
		if ($destXmlAttrs === null)
			$destXmlAttrs = &$this->xmlAttrs;

		$arrayifiedElems = array();
		foreach ($elem as $key=>$node)
		{
			// Get value
			if ($node->count() == 0)
			{
				// Get value
				$val = (string)$node;
				if ($val === '')
					$val = null;
			}
			else
			{
				$val = array();
				$xmlAttrs = array();
				$this->parseSimpleXmlElem($node, $val, $xmlAttrs);
				if (!empty($xmlAttrs))
					$destXmlAttrs[$key] = $xmlAttrs;
			}
			
			// Add value
			// Array
			if ($destArr !== null)
			{
				if (array_key_exists($key, $destArr))
				{
					if (!isset($arrayifiedElems[$key]))
					{
						$arrayifiedElems[$key] = true;
						$destArr[$key] = array($destArr[$key]);
					}
					$destArr[$key][] = $val;
				}
				else
					$destArr[$key] = $val;
			}
			// Object
			else
			{
				if (property_exists($this, $key))
				{
					// Is it an array yet?
					if (!is_array($this->$key) || !array_key_exists(0, $this->$key))
						$this->$key = array($this->$key);
					$tmp = &$this->$key;
					$tmp[] = $val;
					unset($tmp);
				}
				else
					$this->$key = $val;
			}

			// Add attributes
			foreach ($node->attributes() as $attr=>$attrVal)
				$destXmlAttrs[$key][$attr] = (string)$attrVal;
		}
	}
}