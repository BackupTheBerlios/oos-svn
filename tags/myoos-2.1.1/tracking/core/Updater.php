<?php
require_once "Option.php";

class Piwik_Updater
{
	const INDEX_CURRENT_VERSION = 0;
	const INDEX_NEW_VERSION = 1;
	
	public $pathUpdateFileCore;
	public $pathUpdateFilePlugins;

	private $componentsToCheck = array();
	
	public function __construct()
	{
		$this->pathUpdateFileCore = PIWIK_INCLUDE_PATH . '/core/Updates/';
		$this->pathUpdateFilePlugins = PIWIK_INCLUDE_PATH . '/plugins/%s/Updates/';
	}

	/**
	 * @param string $name
	 * @param string $version
	 * @return void
	 */
	public function addComponentToCheck($name, $version)
	{
		$this->componentsToCheck[$name] = $version;
	}
	
	/**
	 * @param string $name
	 * @param string $version
	 * @return void
	 */
	public function recordComponentSuccessfullyUpdated($name, $version)
	{
		try {
			Piwik_SetOption('version_'.$name, $version, $autoload = 1);
		} catch(Exception $e) {
			// case when the option table is not yet created (before 0.2.10)
		}
	}
	
	/**
	 * Returns a list of components (core | plugin) that need to run through the upgrade process.
	 *
	 * @return array( componentName => array( updateFile1, [...]), [...])
	 */
	public function getComponentsWithUpdateFile()
	{
		$this->componentsWithNewVersion = $this->loadComponentsWithNewVersion();
		$this->componentsWithUpdateFile = $this->loadComponentsWithUpdateFile();
		return $this->componentsWithUpdateFile;
	}

	/**
	 * @param string $name
	 * @return array of warning strings if applicable
	 */
	public function update($name)
	{
		$warningMessages = array();
		foreach($this->componentsWithUpdateFile[$name] as $file)
		{
			try {
				require_once $file;
			} catch( UpdateErrorException $e) {
				throw $e;
			} catch( Exception $e) {
				$warningMessages[] = $e->getMessage();
			}
		}
		
		// to debug, create core/Updates/X.php, update the core/Version.php, throw an Exception in the try, and comment the following line
		$this->recordComponentSuccessfullyUpdated($name, $this->componentsWithNewVersion[$name][self::INDEX_NEW_VERSION]);
		return $warningMessages;
	}
	
	/**
	 * @return array array( componentName => array( file1, [...]), [...])
	 */
	private function loadComponentsWithUpdateFile()
	{
		$componentsWithUpdateFile = array();
		foreach($this->componentsWithNewVersion as $name => $versions)
		{
			$currentVersion = $versions[self::INDEX_CURRENT_VERSION];
			$newVersion = $versions[self::INDEX_NEW_VERSION];
			
			if($name == 'core')
			{
				$pathToUpdates = $this->pathUpdateFileCore . '*';
			}
			else
			{
				$pathToUpdates = sprintf($this->pathUpdateFilePlugins, $name) . '*';
			}
			
			$files = glob( $pathToUpdates );
			if($files === false)
			{
				continue;
			}
			foreach( $files as $file)
			{
				$fileVersion = basename($file, '.php');
				if(version_compare($currentVersion, $fileVersion) == -1)
				{
					$componentsWithUpdateFile[$name][] = $file;
				}
			}
			
			if(isset($componentsWithUpdateFile[$name]))
			{
				// order the update files by version asc
				usort($componentsWithUpdateFile[$name], "version_compare");
			}
			else
			{
				// there are no update file => nothing to do, update to the new version is successful
				$this->recordComponentSuccessfullyUpdated($name, $newVersion);
			}
		}
		return $componentsWithUpdateFile;
	}
	
	/**
	 * @return array array( componentName => array( oldVersion, newVersion), [...])
	 */
	private function loadComponentsWithNewVersion()
	{
		$componentsToUpdate = array();
		
		// we make sure core updates are processed before any plugin updates
		if(isset($this->componentsToCheck['core']))
		{
			$coreVersions = $this->componentsToCheck['core'];
			unset($this->componentsToCheck['core']);
			$this->componentsToCheck = array_merge( array('core' => $coreVersions), $this->componentsToCheck);
		}
		
		foreach($this->componentsToCheck as $name => $version)
		{
			try {
				$currentVersion = Piwik_GetOption('version_'.$name);
			} catch( Exception $e) {
				// case when the option table is not yet created (before 0.2.10)
				$currentVersion = false;
			}
			if($currentVersion === false)
			{
				if($name === 'core')
				{
					$currentVersion = '0.2.9';
				}
				else
				{
					$currentVersion = '0.0.1';
				}
				$this->recordComponentSuccessfullyUpdated($name, $currentVersion);
			}

			$versionCompare = version_compare($currentVersion, $version);
			if($versionCompare == -1)
			{
				$componentsToUpdate[$name] = array(
								self::INDEX_CURRENT_VERSION => $currentVersion, 
								self::INDEX_NEW_VERSION => $version
							);
			}
			else if($versionCompare == 1) 
			{
				// the version in the DB is newest.. we choose to ignore (for the time being)
			}
		}
		return $componentsToUpdate;
	}
}

class UpdateErrorException extends Exception {}
