<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\utils;

/** Vantiv XML Utils */
class Xml
{
	/**
	 * Generate XML from array
	 *
	 * @param string $rootElem Root element
	 * @param string $xmlns xmlns string
	 * @param array $specs Specs
	 * @param array $data Data
	 * @param array $attrs Optional attributes
	 *
	 * @throws InvalidRequestException
	 * @return string XML
	 */
	public static function generateXmlFromArray($rootElem, $xmlns, array &$specs, array &$data, $attrs = array())
	{
		$str = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
		$str .= '<' . $rootElem . ($xmlns !== null ? ' xmlns="' . htmlspecialchars($xmlns) . '"' : '');
		foreach ($attrs as $attr=>$value)
			$str .= ' '.$attr.'="' . htmlspecialchars($value) . '"';
		$str .= '>';
		$rtn = self::_generateXmlFromArray($specs, $data);
		if (is_array($rtn))
			throw new InvalidRequestException('Invalid request.', 0, $rtn);
		else
			$str .= $rtn;
		$str .= '</' . $rootElem . '>';
		
		return $str;
	}
	
	/**
	 * Generate sub-XML from array
	 * 
	 * @param array $specs Specs
	 * @param array $data Data
	 *
	 * @return string|array XML string or array of errors
	 */
	private static function _generateXmlFromArray(array &$specs, array &$data)
	{
		$error = array();
		$str = '';
		
		// Make sure spec and data contain the same fields
		foreach (array_keys($data) as $field)
			if (!isset($specs[$field]))
				$error[$field] = 'Unknown field "' . $field . '" in request data.';
		
		foreach ($specs as $key=>$spec)
		{
			$fieldStr = '';
			$attrStr = '';
			
			// Get sub data
			$subdata = isset($data[$key]) ? $data[$key] : null;
			
			// Get attributes
			$attrs = array();
			if (is_object($subdata))
				$attrs = $subdata->attrs;
			
			if ($spec->subspecs !== null)
			{
				// Missing subdata
				if ($subdata === null)
				{
					$subdata = array();
					
					// Check if field is required
					if (($spec->flags & XmlSpec::XML_SPEC_REQUIRED))
						$error[$key] = 'Field "' . $key . '" is required.';
				}
				// Convert object to array
				else if (is_object($subdata))
					$subdata = $subdata->value;
				
				// Check for array
				if (!is_array($subdata))
					$error[$key] = 'Field "' . $key . '" must be an array.';
				else
				{
					// List
					if ($spec->flags & XmlSpec::XML_SPEC_LIST)
					{
						foreach ($subdata as $idx=>&$subsubdata)
						{
							if (!is_array($subsubdata))
								$error[$key] = 'Child ' . $idx . ' of field "' . $key . '" must be array.';
							else
							{
								// Check for required
								if (($spec->flags & XmlSpec::XML_SPEC_REQUIRED) && empty($subsubdata))
									$error[$key] = 'Field "' . $key . '" is required.';
								else
								{
									// Build XML
									$rtn = self::_generateXmlFromArray($spec->subspecs, $subsubdata);
									
									// Check for error
									if (is_array($rtn))
										$error[$key][$idx] = $rtn;
									else
										$fieldStr .= '<' . $spec->listKey . '>' . $rtn . '</' . $spec->listKey . '>';
								}
							}
						}
					}
					// Non-list
					else
					{
						// Build XML
						$rtn = self::_generateXmlFromArray($spec->subspecs, $subdata);
						
						// Check for error
						if (is_array($rtn))
							$error[$key] = $rtn;
						else
							$fieldStr .= $rtn;
					}
				}
			}
			else
			{
				// Get value
				$value = is_object($subdata) ? $subdata->value : $subdata;
				
				// Check for required
				if (($spec->flags & XmlSpec::XML_SPEC_REQUIRED) && ($value === null || $value === ''))
					$error[$key] = 'Field "' . $key . '" is required.';
				else
				{
					// Validate int
					if (($spec->flags & XmlSpec::XML_SPEC_INT) && $value !== null && !is_int($value))
						$error[$key] = 'Field "' . $key . '" must be an integer.';
					
					// Convert bool to proper value
					if ($spec->flags & XmlSpec::XML_SPEC_BOOL)
					{
						if ($value === true)
							$value = 'true';
						else if ($value === false)
							$value = 'false';
						else
							$value = '';
					}
				}
				
				// Add to XML
				$fieldStr .= htmlspecialchars($value);
			}
			
			// Check for attributes
			if (!empty($spec->attrs))
			{
				foreach ($spec->attrs as $attr=>$attrSpecFlags)
				{
					if (isset($attrs[$attr]))
					{
						$value = $attrs[$attr];
						
						// Validate int
						if (($attrSpecFlags & XmlSpec::XML_SPEC_INT) && $value !== null && !is_int($value))
							$error[$key] = 'Attribute "' . $attr . '" of field "' . $key . '" must be an integer.';
						
						// Convert bool to proper value
						if ($attrSpecFlags & XmlSpec::XML_SPEC_BOOL)
						{
							if ($value === true)
								$value = 'true';
							else if ($value === false)
								$value = 'false';
							else
								$value = '';
						}
						
						// Add to string
						$attrStr .= ' ' . $attr . '="' . htmlspecialchars($value) . '"';
					}
					// No data
					else
					{
						// Is there field data?
						if ($fieldStr !== '')
						{
							// Check if attribute is required
							if (($attrSpecFlags & XmlSpec::XML_SPEC_REQUIRED))
								$error[$key] = 'Attribute "' . $attr . '" of field "' . $key . '" is required.';
						}
					}
				}
			}
			
			// Add if not empty
			if ($fieldStr !== '' || $attrStr !== '' || ($spec->flags & XmlSpec::XML_SPEC_INCLUDE_NULL))
				$str .= '<'.$key.$attrStr.'>' . $fieldStr . '</'.$key.'>';
		}
		
		return !empty($error) ? $error : $str;
	}
}