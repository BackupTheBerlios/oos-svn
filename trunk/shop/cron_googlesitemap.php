<?php
/* ----------------------------------------------------------------------
   $Id: cron_googlesitemap.php,v 1.10 2007/11/03 12:41:35 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
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

  define('OOS_VALID_MOD', 'yes');
  require_once(dirname(__FILE__) . '/includes/oos_main.php');

  //Settings - changes made here
  define('GOOGLE_SITEMAP_COMPRESS', 'false'); // Option to compress the files

  define('GOOGLE_SITEMAP_PROD_CHANGE_FREQ', 'weekly'); // Option for change frequency of products
  define('GOOGLE_SITEMAP_CAT_CHANGE_FREQ', 'weekly'); // Option for change frequency of categories


  //prevent script from running more than once a day
  $configurationtable = $oostable['configuration'];
  $sql = "SELECT configuration_value FROM $configurationtable WHERE configuration_key = 'CRON_GOOGLE_RUN'";
  $prevent_result = $dbconn->Execute($sql);
  if ($prevent_result->RecordCount() > 0) {
    $prevent = $prevent_result->fields;
    if ($prevent['configuration_value'] == date("Ymd")) {
      die('Halt! Already executed - should not execute more than once a day.');
    } else {
      $configurationtable = $oostable['configuration'];
      $dbconn->Execute("UPDATE $configurationtable SET configuration_value = '" . date("Ymd") . "' WHERE configuration_key = 'CRON_GOOGLE_RUN'");
    }
  } else {
    $configurationtable = $oostable['configuration'];
    $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id) VALUES ('CRON_GOOGLE_RUN', '" . date("Ymd") . "', '6')");
  }


  require_once(dirname(__FILE__) . '/includes/classes/class_googlesitemap.php');
  $oGoogle = new GoogleSitemap;

  $submit = true;
  echo '<pre>';

  if ($oGoogle->GenerateProductSitemap()){
    echo 'Generated Google Product Sitemap Successfully' . "\n\n";
  } else {
    $submit = false;
    echo 'ERROR: Google Product Sitemap Generation FAILED!' . "\n\n";
  }

  if ($oGoogle->GenerateCategorySitemap()){
    echo 'Generated Google Category Sitemap Successfully' . "\n\n";
  } else {
    $submit = false;
    echo 'ERROR: Google Category Sitemap Generation FAILED!' . "\n\n";
  }

  if ($oGoogle->GenerateSitemapIndex()){
    echo 'Generated Google Sitemap Index Successfully' . "\n\n";
  } else {
    $submit = false;
    echo 'ERROR: Google Sitemap Index Generation FAILED!' . "\n\n";
  }

  if ($submit){
    echo 'CONGRATULATIONS! All files generated successfully.' . "\n\n";
    echo 'If you have not already submitted the sitemap index to Google click the link below.' . "\n";
    echo 'Before you do I HIGHLY recommend that you view the XML files to make sure the data is correct.' . "\n\n";
    echo $oGoogle->GenerateSubmitURL() . "\n\n";

    echo 'Here is your sitemap index: ' .$oGoogle->base_url . 'sitemapindex.xml' . "\n";
    echo 'Here is your product sitemap: ' . $oGoogle->base_url . 'sitemapproducts.xml' . "\n";
    echo 'Here is your category sitemap: ' . $oGoogle->base_url . 'sitemapcategories.xml' . "\n";
  } else {
    print_r($oGoogle->debug);
  }

  echo '</pre>';

  require_once(dirname(__FILE__) . '/includes/oos_nice_exit.php');
?>
