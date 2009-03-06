<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
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

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

 /**
  * Generate a path to categories
  *
  * @param $current_category_id
  * @return string
  */
  function oos_get_path($current_category_id = '', $parent_id = '', $gparent_id = '') {
    global $aCategoryPath;

    // Get database information
    $dbconn =& oosDBGetConn();
    $oostable =& oosDBGetTables();

    if (oos_is_not_null($current_category_id)) {
      $cp_size = count($aCategoryPath);
      if ($cp_size == 0) {
        $categories_new = $current_category_id;
      } else {
        $categories_new = '';
        if (oos_empty($parent_id) || oos_empty($gparent_id) ) {
          $categoriestable = $oostable['categories'];
          $query = "SELECT c.parent_id, p.parent_id as gparent_id
                      FROM $categoriestable AS c,
                           $categoriestable AS p
                     WHERE c.categories_id = '" . intval($aCategoryPath[($cp_size-1)]) . "'
                       AND p.categories_id = '" . intval($current_category_id) . "'";
          $parent_categories = $dbconn->GetRow($query);

          $gparent_id = $parent_categories['gparent_id'];
          $parent_id = $parent_categories['parent_id'];
        }
        if ($parent_id == $gparent_id) {
          for ($i=0; $i < ($cp_size - 1); $i++) {
            $categories_new .= '_' . $aCategoryPath[$i];
          }
        } else {
          for ($i=0; $i < $cp_size; $i++) {
            $categories_new .= '_' . $aCategoryPath[$i];
          }
        }
        $categories_new .= '_' . $current_category_id;

        if (substr($categories_new, 0, 1) == '_') {
          $categories_new = substr($categories_new, 1);
        }
      }
    } else {
      $categories_new = implode('_', $aCategoryPath);
    }

    return 'categories=' . $categories_new;
  }


 /**
  * Return  time-based greeting
  * Good morning, Good afternoon, Good evening
  *
  * @return string
  */
  function oos_time_based_greeting() {
    global $aLang;

    if(date('G') >= 12 && date('G') <= 18) {
      $time_based_greeting = $aLang['good_afternoon'];
    } elseif (date('a') == 'am') {
      $time_based_greeting = $aLang['good_morning'];
    } else {
      $time_based_greeting = $aLang['good_evening'];
    }
    return $time_based_greeting;
 }


 /**
  * Return the number of products in a category
  *
  * @param $category_id
  * @param $include_inactive
  * @return string
  */
  function oos_total_products_in_category($category_id) {

    $products_count = 0;

    $dbconn =& oosDBGetConn();
    $oostable =& oosDBGetTables();

    $productstable = $oostable['products'];
    $products_to_categoriestable = $oostable['products_to_categories'];
    $products = $dbconn->Execute("SELECT COUNT(*) AS total FROM $productstable p, $products_to_categoriestable p2c WHERE p.products_id = p2c.products_id AND p.products_status >= '1' AND p2c.categories_id = '" . intval($category_id) . "'");

    $products_count += $products->fields['total'];

    return $products_count;
  }


?>
