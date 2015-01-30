<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\objs;

/** Vantiv MCC Codes Object */
class VantivMccCodes extends VantivObj
{
	/**
	 * Get MCC codes
	 *
	 * @return array MCC codes
	 */
	public function getMccCodes()
	{
		$mccCodes = array();
		if (isset($this->approvedMccs['approvedMcc']))
		{
			if (is_array($this->approvedMccs['approvedMcc']))
				$mccCodes = $this->approvedMccs['approvedMcc'];
			else
				$mccCodes[] = $this->approvedMccs['approvedMcc'];
		}
		return $mccCodes;
	}
}