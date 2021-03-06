<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: DBStats.php 1296 2009-07-08 04:19:14Z vipsoft $
 * 
 * @package Piwik_DBStats
 * 
 */

class Piwik_DBStats extends Piwik_Plugin
{
	public function getInformation()
	{
		return array(
			'name' => 'Database statistics',
			'description' => 'This plugin reports the database usage by Piwik tables.',
			'author' => 'Piwik',
			'homepage' => 'http://piwik.org/',
			'version' => '0.1',
		);
	}

	function getListHooksRegistered()
	{
		return array('AdminMenu.add' => 'addMenu');
	}
	
	function addMenu()
	{
		Piwik_AddAdminMenu("Database usage", array('module' => 'DBStats', 'action' => 'index'));		
	}
}
	
