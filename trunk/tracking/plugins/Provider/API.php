<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: API.php 1049 2009-04-06 22:12:25Z matt $
 * 
 * @package Piwik_Provider
 */
require_once "Provider/functions.php";

/**
 * 
 * @package Piwik_Provider
 */
class Piwik_Provider_API 
{
	static private $instance = null;
	
	static public function getInstance()
	{
		if (self::$instance == null)
		{            
			$c = __CLASS__;
			self::$instance = new $c();
		}
		return self::$instance;
	}

	public function getProvider( $idSite, $period, $date )
	{
		Piwik::checkUserHasViewAccess( $idSite );
		$archive = Piwik_Archive::build($idSite, $period, $date );
		$dataTable = $archive->getDataTable('Provider_hostnameExt');
		$dataTable->filter('Sort', array(Piwik_Archive::INDEX_NB_VISITS));
		$dataTable->queuefilter('ColumnCallbackAddMetadata', array('label', 'url', 'Piwik_getHostnameUrl'));
		$dataTable->queuefilter('ColumnCallbackReplace', array('label', 'Piwik_getHostnameName'));
		$dataTable->queuefilter('ReplaceColumnNames');
		return $dataTable;
	}
}
