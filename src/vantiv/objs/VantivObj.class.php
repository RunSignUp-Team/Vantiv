<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\objs;
use \SimpleXMLElement;
use \vantiv\utils\VantivException;

/** Vantiv Object */
class VantivObj
{
	/** XML Error */
	private $xmlError = null;
	
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
	 */
	protected function parseSimpleXmlElem($elem, array &$destArr = null)
	{
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
				$this->parseSimpleXmlElem($node, $val);
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
					if (!is_array($this->$key))
						$this->$key = array($this->$key);
					$tmp = &$this->$key;
					$tmp[] = $val;
					unset($tmp);
				}
				else
					$this->$key = $val;
			}
		}
	}
}