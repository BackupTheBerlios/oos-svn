<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: DBStats.php 1628 2009-12-08 16:21:47Z vipsoft $
 * 
 * @category Piwik_Plugins
 * @package Piwik_DBStats
 */

/**
 *
 * @package Piwik_DBStats
 */
class Piwik_DBStats extends Piwik_Plugin
{
	public function getInformation()
	{
		return array(
			'name' => 'Database statistics',
			'description' => 'This plugin reports the MySQL database usage by Piwik tables.',
			'author' => 'Piwik',
			'homepage' => 'http://piwik.org/',
			'version' => Piwik_Version::VERSION,
		);
	}

	function getListHooksRegistered()
	{
		return array('AdminMenu.add' => 'addMenu');
	}
	
	function addMenu()
	{
		Piwik_AddAdminMenu('DBStats_DatabaseUsage', array('module' => 'DBStats', 'action' => 'index'));		
	}
}
