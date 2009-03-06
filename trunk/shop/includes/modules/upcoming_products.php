<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: upcoming_products.php,v 1.23 2003/02/12 23:55:58 hpdl 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

  if (!is_numeric(MAX_DISPLAY_UPCOMING_PRODUCTS)) return false;

  switch (OOS_DB_TYPE)
    {
      case 'postgres':
        $productstable = $oostable['products'];
        $products_descriptiontable = $oostable['products_description'];
        $sql = "SELECT p.products_id, pd.products_name, products_date_available AS date_expected
                FROM $productstable p,
                     $products_descriptiontable pd
                WHERE products_date_available >= CURRENT_DATE AND
                      p.products_id = pd.products_id AND
                      p.products_status >= '1' AND
                      (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "') AND
                      pd.products_languages_id = '" . intval($nLanguageID) . "'
                ORDER BY
                      " . EXPECTED_PRODUCTS_FIELD . "
                      " . EXPECTED_PRODUCTS_SORT;
        break;

      case 'mysqli':
      case 'mysql':
      default:
        $productstable = $oostable['products'];
        $products_descriptiontable = $oostable['products_description'];
        $sql = "SELECT p.products_id, pd.products_name, products_date_available AS date_expected
                FROM $productstable p,
                     $products_descriptiontable pd
                WHERE to_days(products_date_available) >= to_days(now()) AND
                      p.products_id = pd.products_id AND
                      p.products_status >= '1' AND
                      (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "') AND
                      pd.products_languages_id = '" . intval($nLanguageID) . "'
                ORDER BY
                      " . EXPECTED_PRODUCTS_FIELD . "
                      " . EXPECTED_PRODUCTS_SORT;
        break;
    }

  $expected_result = $dbconn->SelectLimit($sql, MAX_DISPLAY_UPCOMING_PRODUCTS);
  if ($expected_result->RecordCount() > 0) {
    $oSmarty->assign('expected_array', $expected_result->GetArray());
  }

?>