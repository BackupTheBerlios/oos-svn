<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/


   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: general.php,v 1.212 2003/02/17 07:55:54 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     oos_address_format
 * Version:  1.0
 * Date:
 * Purpose:
 *
 *
 * Install:  Drop into the plugin directory
 * Author:
 * -------------------------------------------------------------
 */

function smarty_function_oos_address_format($params, &$smarty)
{

   MyOOS_CoreApi::requireOnce('lib/smarty/libs/plugins/shared.escape_special_chars.php');

   $address_format_id = '';
   $address = '';
   $html = '';
   $boln = '';
   $eoln = '<br />';

   foreach($params as $_key => $_val) {
     $$_key = smarty_function_escape_special_chars($_val);
   }

   $dbconn =& oosDBGetConn();
   $oostable =& oosDBGetTables();

   $address_formattable = $oostable['address_format'];
   $query = "SELECT address_format AS format
             FROM $address_formattable
             WHERE address_format_id = '" . intval($address_format_id) . "'";
   $address_format = $dbconn->GetRow($query);

   $company = addslashes($address['company']);
   $firstname = addslashes($address['firstname']);
   $lastname = addslashes($address['lastname']);
   $street = addslashes($address['street_address']);
   $suburb = addslashes($address['suburb']);
   $city = addslashes($address['city']);
   $state = addslashes($address['state']);
   $country_id = $address['country_id'];
   $zone_id = $address['zone_id'];
   $postcode = addslashes($address['postcode']);
   $zip = $postcode;
   $country = oos_get_country_name($country_id);
   $state = oos_get_zone_code($country_id, $zone_id, $state);

   if ($html) {
     // HTML Mode
     $HR = '<hr>';
     $hr = '<hr>';
     if ( ($boln == '') && ($eoln == "\n") ) { // Values not specified, use rational defaults
       $CR = '<br />';
       $cr = '<br />';
       $eoln = $cr;
     } else { // Use values supplied
       $CR = $eoln . $boln;
       $cr = $CR;
     }
   } else {
     // Text Mode
     $CR = $eoln;
     $cr = $CR;
     $HR = '----------------------------------------';
     $hr = '----------------------------------------';
   }

   $statecomma = '';
   $streets = $street;
   if ($suburb != '') $streets = $street . $cr . $suburb;
   if ($firstname == '') $firstname = addslashes($address['name']);
   if ($country == '') $country = addslashes($address['country']);
   if ($state != '') $statecomma = $state . ', ';

   $fmt = $address_format['format'];
   eval("\$address = \"$fmt\";");
   $address = stripslashes($address);

   if ( (ACCOUNT_COMPANY == '1') && (oos_is_not_null($company)) ) {
     $address = $company . $cr . $address;
   }

   print $boln . $address . $eoln;
}

