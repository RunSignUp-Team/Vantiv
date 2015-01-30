<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\objs;

/** Vantiv Error */
class VantivError extends VantivObj
{
	/**
	 * Get errors
	 *
	 * @return array Errors
	 */
	public function getErrors()
	{
		$rtn = array();
		if (isset($this->errors) && isset($this->errors['error']))
		{
			if (is_array($this->errors['error']))
				$rtn = $this->errors['error'];
			else
				$rtn[] = $this->errors['error'];
		}
		
		return $rtn;
	}
}