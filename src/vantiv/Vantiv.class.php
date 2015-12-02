<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv;
require_once(realpath(__DIR__) . DIRECTORY_SEPARATOR . 'Autoload.class.php');
use \vantiv\utils\VantivException;
use \vantiv\utils\VantivResponse;
use \vantiv\utils\VantivNonAtomicBatch;

/** Vantiv */
class Vantiv
{
	/** API username */
	protected $apiUsername = null;

	/** API password */
	protected $apiPswd = null;
	
	/** Proxy */
	protected $proxy = null;
	
	/** Proxy username and password */
	protected $proxyUserPswd = null;
	
	/** Connect timeout */
	protected $connectTimeout = 20;
	
	/** Timeout */
	protected $timeout = 45;
	
	/**
   * Constructor
   *
   * @param string $apiUsername API username
   * @param string $$apiPswd API password
   * @param string $proxy Optional proxy to use
   * @param string $proxyUserPswd Optional proxy user and password
	 */
	public function __construct($apiUsername, $apiPswd, $proxy = null, $proxyUserPswd = null)
	{
		$this->apiUsername = $apiUsername;
		$this->apiPswd = $apiPswd;
		$this->proxy = $proxy;
		$this->proxyUserPswd = $proxyUserPswd;
	}
	
	/**
	 * Get API username
	 *
	 * @return string API username
	 */
	public function getApiUsername() {
		return $this->apiUsername;
	}
	
	/**
	 * Get API password
	 *
	 * @return string API password
	 */
	public function getApiPassword() {
		return $this->apiPswd;
	}
	
	/**
	 * Set up curl handle
	 *
	 * @param string $ch Curl handle
	 * @param string $url URL
	 * @param string $httpMethod HTTP method (ie. 'GET', 'POST', 'PUT', 'DELETE')
   * @param mixed $rawData Raw data to post
   * @param array $addlHeaders Additional headers to send
   *
   * @return Curl handle
   * @throws VantivException
	 */
	protected function setupCurlHandle($url, $httpMethod, &$post, &$addlHeaders)
	{
		if (($ch = curl_init()) === false)
			throw new VantivException();
		
		// Set up curl options
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		
		// Timeouts
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connectTimeout);
		curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout);
		
		// Set up proxy
		if ($this->proxy !== null)
		{
			curl_setopt($ch, CURLOPT_PROXY, $this->proxy);
			curl_setopt($ch, CURLOPT_PROXYUSERPWD, $this->proxyUserPswd);
		}
		
		// Determine HTTP method
		if ($httpMethod == 'GET')
			curl_setopt($ch, CURLOPT_HTTPGET, 1);
		else if ($httpMethod == 'POST')
			curl_setopt($ch, CURLOPT_POST, 1);
		else
			curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $httpMethod);
		
		// Add post data
		if ($post !== null)
		{
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
		}
		
		// Add headers
		if (!empty($addlHeaders))
			curl_setopt($ch, CURLOPT_HTTPHEADER, $addlHeaders);
		
		return $ch;
	}
	
	/**
   * Make a request
   *
   * @param string $url URL
   * @param string $httpMethod HTTP method (ie. 'GET', 'POST', 'PUT', 'DELETE')
   * @param string $rawData Raw data to post
   * @param array $addlHeaders Additional headers to send
   * @param string $classname Class name for response
   *
   * @return VantivResponse Response
   * @throws VantivException
	 */
	public function makeRequest($url, $httpMethod, $post, $addlHeaders, $classname)
	{
		$resp = null;
		
		// Set up curl
		$ch = $this->setupCurlHandle($url, $httpMethod, $post, $addlHeaders);
		
		// Make request
		if (($resp = curl_exec($ch)) === false)
			throw new VantivException(curl_error($ch), curl_errno($ch));
		
		// Get curl response code
		$curlInfo = curl_getinfo($ch);
		$statusCode = $curlInfo['http_code'];
		
		return new VantivResponse($resp, $statusCode, $classname);
	}
	
	/**
   * Make a request
   *
   * @param string $url URL
   * @param string $httpMethod HTTP method (ie. 'GET', 'POST', 'PUT', 'DELETE')
   * @param string $rawData Raw data to post
   * @param array $addlHeaders Additional headers to send
   * @param string $classname Class name for response
   *
   * @return VantivResponse Response
   * @throws VantivException
	 */
	public function makeBasicAuthRequest($url, $httpMethod, $post, $addlHeaders, $classname)
	{
		$resp = null;
		
		// Set up curl
		$ch = $this->setupCurlHandle($url, $httpMethod, $post, $addlHeaders);
		
		// Set authentication
		curl_setopt($ch, CURLOPT_USERPWD, $this->apiUsername . ':' . $this->apiPswd);
		
		// Make request
		if (($resp = curl_exec($ch)) === false)
			throw new VantivException(curl_error($ch), curl_errno($ch));
		
		// Get curl response code
		$curlInfo = curl_getinfo($ch);
		$statusCode = $curlInfo['http_code'];
		
		return new VantivResponse($resp, $statusCode, $classname);
	}
	
	/**
	 * Start non-atomic batch
	 *
	 * @return VantivNonAtomicBatch
	 */
	public function startNonAtomicBatch() {
		return new VantivNonAtomicBatch();
	}
	
	/**
   * Execute non-atomic batch
   *
   * @param VantivNonAtomicBatch $batch Batch
   *
   * @return array Array of VantivResponse or VantivException responses
   * @throws VantivException
	 */
	public function executeNonAtomicBatch(VantivNonAtomicBatch $batch)
	{
		// Multi curl init
		if (!($mh = curl_multi_init()))
			throw new VantivException(curl_error($ch), curl_errno($ch));
		$chs = array();
		
		// Process each request
		$rtn = array();
		$chToIdxHash = array();
		foreach ($batch->requests as $idx=>$req)
		{
			$resp = null;
			
			// Set up curl
			$ch = $this->setupCurlHandle($req->url, $req->httpMethod, $req->post, $req->addlHeaders);
			
			// Add to multi curl
			$chs[] = $ch;
			curl_multi_add_handle($mh, $ch);
			$chToIdxHash[(int)$ch] = $idx;
			$rtn[] = new VantivException();	// Default to exception
		}
		
		
		// Execute (Read/write data)
		$active = null;
		do {
			$mrc = curl_multi_exec($mh, $active);
		} while ($mrc == CURLM_CALL_MULTI_PERFORM);
		
		// Loop while active
		while ($active && $mrc == CURLM_OK)
		{
			if (curl_multi_select($mh) === -1)
				usleep(250);// Short sleep
			
			// Read/write data from handles
			do {
				$mrc = curl_multi_exec($mh, $active);
			} while ($mrc == CURLM_CALL_MULTI_PERFORM);
			
			// Process data
			while (($data = curl_multi_info_read($mh)))
			{
				$idx = $chToIdxHash[(int)$data['handle']];
				$req = $batch->requests[$idx];
				
				// Check for error
				if ($data['result'] !== CURLM_OK)
					$rtn[$idx] = new VantivException(curl_error($data['handle']), curl_errno($data['handle']));
				else
				{
					// Get curl response code
					$curlInfo = curl_getinfo($data['handle']);
					$statusCode = $curlInfo['http_code'];
					
					// Get response
					$resp = curl_multi_getcontent($data['handle']);
					if (!$resp)
					{
						// Add exception to response
						$rtn[$idx] = new VantivException(curl_error($data['handle']) . "\nStatus Code: " . $statusCode, curl_errno($data['handle']));
					}
					else
					{
						// Build response
						try
						{
							$rtn[$idx] = new VantivResponse($resp, $statusCode, $req->classname);
						} catch (VantivException $e) {
							$rtn[$idx] = $e;
						}
					}
				}
			}
		}
		unset($tmp);
		
		// Close handles
		foreach ($chs as $ch)
		{
			curl_multi_remove_handle($mh, $ch);
			curl_close($ch);
		}
		curl_multi_close($mh);
		
		return $rtn;
	}
	
	/**
	 * Determine credit card type
	 *
	 * @param string $cardNum Card number
	 *
	 * @return string Credit card type
	 */
	public static function getCreditCardType($cardNum)
	{
		$rtn = '';
		
		$len = strlen($cardNum);
		$c1 = (int)$cardNum[0];
		$c2 = (int)substr($cardNum, 0, 2);
		$c4 = (int)substr($cardNum, 0, 4);
		$c6 = (int)substr($cardNum, 0, 6);
		$c8 = (int)substr($cardNum, 0, 8);
		
		// Mastercard
		if (($c2 >= 51 && $c2 <= 55) && ($len === 16 || $len === 19))
			$rtn ='MC';
		// Visa
		else if ($c1 === 4 && ($len === 16 || $len === 19))
			$rtn = 'VI';
		// American express
		else if (($c2 === 34 || $c2 === 37) && $len === 15)
			$rtn = 'AX';
		// Diner's club
		else if ($c2 === 36 && $len === 14)
			$rtn = 'DI';	// Intentionally Discover
		else if (($c2 === 54 || $c2 === 55) && $len === 16)
			$rtn = 'MC';	// Intentionally Mastercard
		// Discover
		else if ((
			($c8 >= 30000000 && $c8 <= 30599999) ||
			($c8 >= 30950000 && $c8 <= 30959999) ||
			($c8 >= 35280000 && $c8 <= 35899999) ||
			$c2 === 36 ||
			$c2 === 38 ||
			$c2 === 39 ||
			$c2 === 64 ||
			$c2 === 65 ||
			$c4 === 6011 ||
			($c8 >= 62212600 && $c8 <= 62699999) ||
			($c8 >= 62400000 && $c8 <= 62699999) ||
			($c8 >= 62820000 && $c8 <= 62889999)
		) && ($len === 14 || $len === 16))
			$rtn ='DI';
		// JCB
		else if ($c2 === 35 && $len == 16)	// Note: This must be after Discover
			$rtn = 'JC';
		
		return $rtn;
	}
}