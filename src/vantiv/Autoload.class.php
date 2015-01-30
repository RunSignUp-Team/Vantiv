<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv;

/** Vantiv Autoload */
class Autoload
{
	/** Vantiv dir */
	private static $vantivDir = null;
	
	/** Set up auto-load */
	public static function setupAutoload()
	{
		self::$vantivDir = realpath(__DIR__);
		spl_autoload_register(array(__CLASS__, 'autoload'), true, true);
	}
	
	/**
	 * Auto-load class
	 * @param string $class Class name
	 */
	public static function autoload($class)
	{
		$path = explode('\\', $class);
		$namespace = array_shift($path);
		if ($namespace == 'vantiv')
		{
			$filename = self::$vantivDir . DIRECTORY_SEPARATOR . implode(DIRECTORY_SEPARATOR, $path) . '.class.php';
			require_once($filename);
		}
	}
}

// Set up auto-load
Autoload::setupAutoload();