<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: UsersManager.php 1665 2009-12-11 21:25:57Z vipsoft $
 * 
 * @category Piwik_Plugins
 * @package Piwik_UsersManager
 */

/**
 * 
 * @package Piwik_UsersManager
 */
class Piwik_UsersManager extends Piwik_Plugin
{		
	public function getInformation()
	{
		$info = array(
			'name' => 'Users Management',
			'description' => 'Users Management in Piwik: add a new User, edit an existing one, update the permissions. All the actions are also available through the API.',
			'author' => 'Piwik',
			'author_homepage' => 'http://piwik.org/',
			'version' => Piwik_Version::VERSION,
		);
		
		return $info;
	}
	
	function getListHooksRegistered()
	{
		return array('AdminMenu.add' => 'addMenu');
	}
	
	function addMenu()
	{
		Piwik_AddAdminMenu('UsersManager_MenuUsers', array('module' => 'UsersManager', 'action' => 'index'));		
	}
}

