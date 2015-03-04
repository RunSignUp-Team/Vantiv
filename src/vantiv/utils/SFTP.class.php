<?php

/* Copyright: Bickel Advisory Services, LLC. */

namespace vantiv\utils;
use \Exception;

/** SFTP Value */
class SFTP
{
	/**
	 * Update batch file contents
	 *
	 * @param string $sftpUsername SFTP username
	 * @param string $sftpHost SFTP host
	 * @param string $fileContents File contents
	 * @param string $remoteFilename Remote filename.  Must end with .asc
	 * @param string $directory Remove directory
	 *
	 * @throws SFTPException
	 */
	public static function uploadBatchFileContents($sftpUsername, $sftpHost, $fileContents, $remoteFilename, $directory = 'inbound')
	{
		// Build SFTP batch script
		$tmpfilename = tempnam('/tmp', 'vsftp-');
		if ($tmpfilename === false || ($fp = fopen($tmpfilename, 'w')) === false)
			throw new SFTPException('Failed to open temp file.');
		
		// Write file
		fwrite($fp, $fileContents);
		fclose($fp);
		
		// Upload the file
		try {
			self::uploadBatchFile($sftpUsername, $sftpHost, $tmpfilename, $remoteFilename, $directory);
		} catch (Exception $e) {
			unlink($tmpfilename);
			throw $e;
		}
		unlink($tmpfilename);
	}
	
	/**
	 * Update batch file
	 *
	 * @param string $sftpUsername SFTP username
	 * @param string $sftpHost SFTP host
	 * @param string $localFilename Filename to upload
	 * @param string $remoteFilename Remote filename.  Must end with .asc
	 * @param string $directory Remove directory
	 *
	 * @throws SFTPException
	 */
	public static function uploadBatchFile($sftpUsername, $sftpHost, $localFilename, $remoteFilename, $directory = 'inbound')
	{
		// Create .prg file
		$remoteFilenamePrg = str_replace('.asc', '.prg', $remoteFilename);
		
		// Build commands
		$cmds = 'cd ' . escapeshellarg($directory) . "\n";
		$cmds .= 'put ' . escapeshellarg($localFilename) . ' ' . escapeshellarg($remoteFilenamePrg) . "\n";
		$cmds .= 'chmod 666 ' . escapeshellarg($remoteFilenamePrg) . "\n";
		$cmds .= 'rename ' . escapeshellarg($remoteFilenamePrg) . ' ' . escapeshellarg($remoteFilename) . "\n";
		
		// Run commands
		self::runSFTPCmds($sftpUsername, $sftpHost, $cmds, $output, $rtn);
		
		// Check return value
		if ($rtn !== 0)
			throw new SFTPException('SFTP transfer failed.', $rtn, implode("\n", $output));
	}
	
	/**
	 * Get file list.  Note: This could be flaky
	 *
	 * @param string $sftpUsername SFTP username
	 * @param string $sftpHost SFTP host
	 * @param string $directory Directory
	 *
	 * @return array Files
	 * @throws SFTPException
	 */
	protected static function getFileList($sftpUsername, $sftpHost, $directory)
	{
		// Build commands
		$cmds = 'cd ' . escapeshellarg($directory) . "\nls";
		
		// Run commands
		self::runSFTPCmds($sftpUsername, $sftpHost, $cmds, $output, $rtn);
		
		// Check return value
		if ($rtn !== 0)
			throw new SFTPException('SFTP file listing failed.', $rtn, implode("\n", $output));
		
		// Find the files
		$files = array();
		foreach ($output as $line)
		{
			// If not a prompt
			if (strpos($line, '>') === false)
				$files[] = $line;
		}
		
		return $files;
	}
	
	/**
	 * Sync outbound directory and remove files from FTP
	 *
	 * @param string $sftpUsername SFTP username
	 * @param string $sftpHost SFTP host
	 * @param string $remoteOutboundDir Remote outbound directory
	 * @param string $localOutboundDir Local outbound directory
	 *
	 * @throws SFTPException
	 */
	public static function syncOutboundDir($sftpUsername, $sftpHost, $remoteOutboundDir, $localOutboundDir)
	{
		// Get files currently in the directory
		$filesBefore = scandir($localOutboundDir);
		
		// Download files
		$cmds = "cd ".escapeshellarg($remoteOutboundDir)."\nlcd ".escapeshellarg($localOutboundDir)."\nmget *";
		self::runSFTPCmds($sftpUsername, $sftpHost, $cmds, $output, $rtn);
		if ($rtn !== 0)
		{
			// See if there are just no files
			$files = self::getFileList($sftpUsername, $sftpHost, $remoteOutboundDir);
			if (!empty($files))
				throw new SFTPException('SFTP Outbound Sync Failed (Download).', $rtn, implode("\n", $output));
		}
		
		// Get new files in the directory
		$filesAfter = scandir($localOutboundDir);
		
		// Remove .prg files
		foreach ($filesAfter as $key=>$filename)
		{
			if (preg_match('/\\.prg$/D', $filename))
			{
				echo $localOutboundDir . DIRECTORY_SEPARATOR . $filename . "\n";
				unlink($localOutboundDir . DIRECTORY_SEPARATOR . $filename);
				unset($filesAfter[$key]);
			}
		}
		
		// Determine files to delete
		$deleteFiles = array_diff($filesAfter, $filesBefore);
		if (!empty($deleteFiles))
		{
			$cmds = "cd ".escapeshellarg($remoteOutboundDir)."\n";
			foreach ($deleteFiles as $file)
				$cmds .= 'rm '.escapeshellarg($file)."\n";
			self::runSFTPCmds($sftpUsername, $sftpHost, $cmds, $output, $rtn);
			if ($rtn !== 0)
				throw new SFTPException('SFTP Outbound Sync Failed (Delete).', $rtn, implode("\n", $output));
		}
	}
	
	/**
	 * Run commands
	 *
	 * @param string $sftpUsername SFTP username
	 * @param string $sftpHost SFTP host
	 * @param string $cmds Commands to run
	 * @param array &$output Output (stdout only)
	 * @param int &$rtn Return code
	 *
	 * @throws SFTPException
	 */
	public static function runSFTPCmds($sftpUsername, $sftpHost, $cmds, &$output, &$rtn)
	{
		// Build SFTP batch script
		$tmpfilename = tempnam('/tmp', 'vsftp-');
		if ($tmpfilename === false || ($fp = fopen($tmpfilename, 'w')) === false)
			throw new SFTPException('Failed to open temp file.');
		
		// Write file
		fwrite($fp, $cmds);
		fclose($fp);
		
		// Execute
		$cmd = 'sftp -o StrictHostKeyChecking=no -b ' . escapeshellarg($tmpfilename) . ' ' . escapeshellarg($sftpUsername.'@'.$sftpHost) . ' 2>/dev/null';
		exec($cmd, $output, $rtn);
		
		// Delete the batch file
		unlink($tmpfilename);
	}
}