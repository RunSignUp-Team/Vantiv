<?php

/** Copyright: RunSignUp, Inc. */

namespace vantiv\utils;
use \vantiv\objs\VantivObj;
use \vantiv\objs\VantivError;

/** Vantiv Non-atomic batch */
class VantivNonAtomicBatchSingleRequest
{
	/** URL */
	public $url = null;
	
	/** HTTP method (ie. 'GET', 'POST', 'PUT', 'DELETE') */
	public $httpMethod = null;
	
	/** Raw data to post */
	public $rawData = null;
	
	/** Additional headers to send */
	public $addlHeaders = null;
	
	/** Class name for response */
	public $classname = null;
	
	/**
	 * Constructor
	 * 
	 * @param string $url URL
   * @param string $httpMethod HTTP method (ie. 'GET', 'POST', 'PUT', 'DELETE')
   * @param string $rawData Raw data to post
   * @param array $addlHeaders Additional headers to send
   * @param string $classname Class name for response
	 */
	public function __construct($url, $httpMethod, $post, $addlHeaders, $classname)
	{
		$this->url = $url;
		$this->httpMethod = $httpMethod;
		$this->post = $post;
		$this->addlHeaders = $addlHeaders;
		$this->classname = $classname;
	}
}