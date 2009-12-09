<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: CorePluginsAdmin.php 1628 2009-12-08 16:21:47Z vipsoft $
 * 
 * @category Piwik_Plugins
 * @package Piwik_CorePluginsAdmin
 */

/**
 *
 * @package Piwik_CorePluginsAdmin
 */
class Piwik_CorePluginsAdmin extends Piwik_Plugin
{
	public function getInformation()
	{
		return array(
			'name' => 'Plugins Management',
			'description' => 'Plugins Administration Interface.',
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
		Piwik_AddAdminMenu('CorePluginsAdmin_MenuPlugins', array('module' => 'CorePluginsAdmin', 'action' => 'index'));		
	}
}
