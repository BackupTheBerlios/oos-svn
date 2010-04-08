<?php
/* ----------------------------------------------------------------------
   $Id: cron_googlesitemap.php 511 2009-12-28 00:03:48Z r23 $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Google XML Sitemap Feed Cron Script

   Bobby Easland
   Copyright 2005, Bobby Easland
   http://www.oscommerce-freelancers.com/
   ----------------------------------------------------------------------
   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// define('YAHOOKEY', '');
define('OOS_VALID_MOD', 'yes');


define('MYOOS_DOCUMENT_ROOT', dirname(__FILE__)=='/'?'':dirname(__FILE__));

if (!defined('MYOOS_INCLUDE_PATH'))
{
    define('MYOOS_INCLUDE_PATH', MYOOS_DOCUMENT_ROOT);
}
if(!defined('MYOOS_USER_PATH'))
{
    define('MYOOS_USER_PATH', MYOOS_DOCUMENT_ROOT);
}



require_once MYOOS_INCLUDE_PATH . '/includes/oos_main.php';

//Settings - changes made here
define('GOOGLE_SITEMAP_COMPRESS', '0'); // Option to compress the files

define('GOOGLE_SITEMAP_PROD_CHANGE_FREQ', 'weekly'); // Option for change frequency of products
define('GOOGLE_SITEMAP_CAT_CHANGE_FREQ', 'weekly'); // Option for change frequency of categories


//prevent script from running more than once a day
$configurationtable = $oostable['configuration'];
$sql = "SELECT configuration_value FROM $configurationtable WHERE configuration_key = 'CRON_GOOGLE_RUN'";
$prevent_result = $dbconn->Execute($sql);

if ($prevent_result->RecordCount() > 0) {
    $prevent = $prevent_result->fields;
    if ($prevent['configuration_value'] == date("Ymd")) {
     #   die('Halt! Already executed - should not execute more than once a day.');
    } 
}


require_once MYOOS_INCLUDE_PATH . '/includes/classes/class_googlesitemap.php';

$oSitemap = new GoogleSitemap;

$submit = true;
echo '<pre>';

if ($oSitemap->GenerateProductSitemap()){
    echo 'Generated Google Product Sitemap Successfully' . "\n\n";
} else {
    $submit = false;
    echo 'ERROR: Google Product Sitemap Generation FAILED!' . "\n\n";
}

if ($oSitemap->GenerateCategorySitemap()){
    echo 'Generated Google Category Sitemap Successfully' . "\n\n";
} else {
    $submit = false;
    echo 'ERROR: Google Category Sitemap Generation FAILED!' . "\n\n";
}

if ($oSitemap->GenerateSitemapIndex()){
    echo 'Generated Google Sitemap Index Successfully' . "\n\n";
} else {
    $submit = false;
    echo 'ERROR: Google Sitemap Index Generation FAILED!' . "\n\n";
}

if ($submit){

    if ($prevent_result->RecordCount() > 0) {
        $configurationtable = $oostable['configuration'];
        $dbconn->Execute("UPDATE $configurationtable SET configuration_value = '" . date("Ymd") . "' WHERE configuration_key = 'CRON_GOOGLE_RUN'");
    } else {
        $configurationtable = $oostable['configuration'];
        $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id) VALUES ('CRON_GOOGLE_RUN', '" . date("Ymd") . "', '6')");
    }

    echo 'CONGRATULATIONS! All files generated successfully.' . "\n\n";

    echo 'Here is your sitemap index: ' .$oSitemap->base_url . 'sitemapindex.xml' . "\n";
    echo 'Here is your product sitemap: ' . $oSitemap->base_url . 'sitemapproducts.xml' . "\n";
    echo 'Here is your category sitemap: ' . $oSitemap->base_url . 'sitemapcategories.xml' . "\n";

    $pingUrl = $oSitemap->base_url . 'sitemapindex.xml';

    //Ping Google
    $sPingUrl = "http://www.google.com/webmasters/sitemaps/ping?sitemap=" . urlencode($pingUrl);
    $pingres = MyOOS_Utilities::RemoteOpen($sPingUrl);
									  
    if ($pingres == NULL || $pingres === false) {
         trigger_error("Failed to ping Google: " . htmlspecialchars(strip_tags($pingres)),E_USER_NOTICE);
    }
				
    //Ping Ask.com
    $sPingUrl = "http://submissions.ask.com/ping?sitemap=" . urlencode($pingUrl);
    $pingres = MyOOS_Utilities::RemoteOpen($sPingUrl);
    if ($pingres == NULL || $pingres === false || strpos($pingres,"successfully received and added")===false) { //Ask.com returns 200 OK even if there was an error, so we need to check the content.
        trigger_error("Failed to ping Ask.com: " . htmlspecialchars(strip_tags($pingres)),E_USER_NOTICE);
    }

    //Ping YAHOO
    if (!oos_empty(YAHOOKEY)) {
        $sPingUrl = "http://search.yahooapis.com/SiteExplorerService/V1/updateNotification?appid=" . YAHOOKEY . "&url=" . urlencode($pingUrl);
        $pingres = MyOOS_Utilities::RemoteOpen($sPingUrl);
        if ($pingres==NULL || $pingres===false || strpos(strtolower($pingres),"success")===false) {
            trigger_error("Failed to ping YAHOO: " . htmlspecialchars(strip_tags($pingres)),E_USER_NOTICE);
        }
	  }
	  
    //Ping Bing
    $sPingUrl = "http://www.bing.com/webmaster/ping.aspx?siteMap=" . urlencode($pingUrl);
    $pingres = MyOOS_Utilities::RemoteOpen($sPingUrl);
    if ($pingres==NULL || $pingres===false || strpos($pingres,"Thanks for submitting your sitemap")===false) {
        trigger_error("Failed to ping Bing: " . htmlspecialchars(strip_tags($pingres)),E_USER_NOTICE);
    }
	
} else {
    print_r($oSitemap->debug);
}
echo '</pre>';
require_once MYOOS_INCLUDE_PATH . '/includes/oos_nice_exit.php';

