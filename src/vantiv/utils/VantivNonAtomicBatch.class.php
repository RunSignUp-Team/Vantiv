<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\utils;
use \vantiv\objs\VantivObj;
use \vantiv\objs\VantivError;

/** Vantiv Non-atomic batch */
class VantivNonAtomicBatch
{
	/** Requests */
	public $requests = array();
	
	/**
	 * Add a request
	 * 
	 * @param string $url URL
   * @param string $httpMethod HTTP method (ie. 'GET', 'POST', 'PUT', 'DELETE')
   * @param string $rawData Raw data to post
   * @param array $addlHeaders Additional headers to send
   * @param string $classname Class name for response
	 */
	public function addRequest($url, $httpMethod, $post, $addlHeaders, $classname)
	{
		$this->requests[] = new VantivNonAtomicBatchSingleRequest($url, $httpMethod, $post, $addlHeaders, $classname);
	}
}