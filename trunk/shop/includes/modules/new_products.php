<?php
/* ----------------------------------------------------------------------
   $Id: new_products.php,v 1.53 2008/08/29 16:55:45 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: new_products.php,v 1.2 2003/01/09 09:40:08 elarifr
   orig: new_products.php,v 1.33 2003/02/12 23:55:58 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

  if (!is_numeric(MAX_DISPLAY_NEW_PRODUCTS)) return false;

  if ( (!isset($new_products_category_id)) || ($new_products_category_id == '0') ) {
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $specialstable = $oostable['specials'];
    $sql = "SELECT p.products_id, pd.products_name, p.products_image, p.products_tax_class_id, p.products_units_id,
                   p.products_price, p.products_base_price, p.products_base_unit, p.products_discount_allowed,
                   substring(pd.products_description, 1, 150) AS products_description,
                   IF(s.status, s.specials_new_products_price, NULL) AS specials_new_products_price
            FROM $productstable p,
                 $products_descriptiontable pd LEFT JOIN
                 $specialstable s ON pd.products_id = s.products_id
            WHERE p.products_status >= '1'
              AND (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "')
              AND p.products_id = pd.products_id
              AND pd.products_languages_id = '" . intval($nLanguageID) . "'
            ORDER BY p.products_date_added DESC";
  } else {
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $specialstable = $oostable['specials'];
    $products_to_categoriestable = $oostable['products_to_categories'];
    $categoriestable = $oostable['categories'];
    $sql = "SELECT DISTINCT p.products_id, pd.products_name, p.products_image, p.products_tax_class_id, p.products_units_id,
                   p.products_price, p.products_base_price, p.products_base_unit, p.products_discount_allowed,
                   substring(pd.products_description, 1, 150) AS products_description,
                   IF(s.status, s.specials_new_products_price, NULL) AS specials_new_products_price
            FROM $productstable p,
                 $products_descriptiontable pd LEFT JOIN
                 $specialstable s ON pd.products_id = s.products_id,
                 $products_to_categoriestable p2c,
                 $categoriestable c
            WHERE p.products_id = p2c.products_id
              AND pd.products_id = p2c.products_id
              AND pd.products_languages_id = '" . intval($nLanguageID) . "'
              AND p2c.categories_id = c.categories_id
              AND c.parent_id = '" . intval($new_products_category_id) . "'
              AND p.products_status >= '1'
            ORDER BY p.products_date_added DESC";
  }
  $new_products_result = $dbconn->SelectLimit($sql, MAX_DISPLAY_NEW_PRODUCTS);
  $new_products_array = array();

  while ($new_products = $new_products_result->fields) {

    $new_product_price = '';
    $new_product_special_price = '';
    $new_max_product_discount = 0;
    $new_product_discount_price = '';
    $new_base_product_price = '';
    $new_base_product_special_price = '';
    $new_special_price = '';

    $new_product_units = UNITS_DELIMITER . $products_units[$new_products['products_units_id']];

    $new_product_price = $oCurrencies->display_price($new_products['products_price'], oos_get_tax_rate($new_products['products_tax_class_id']));
    $new_special_price = $new_products['specials_new_products_price'];

    if (oos_is_not_null($new_special_price)) {
      $new_product_special_price = $oCurrencies->display_price($new_special_price, oos_get_tax_rate($new_products['products_tax_class_id']));
    } else {
      $new_max_product_discount = min($new_products['products_discount_allowed'],$_SESSION['member']->group['discount']);
      if ($new_max_product_discount != 0 ) {
        $new_special_price = $new_products['products_price']*(100-$new_max_product_discount)/100;
        $new_product_discount_price = $oCurrencies->display_price($new_special_price, oos_get_tax_rate($new_products['products_tax_class_id']));
      }
    }

    if ($new_products['products_base_price'] != 1) {
      $new_base_product_price = $oCurrencies->display_price($new_products['products_price'] * $new_products['products_base_price'], oos_get_tax_rate($new_products['products_tax_class_id']));

      if ($new_special_price != '') {
        $new_base_product_special_price = $oCurrencies->display_price($new_special_price * $new_products['products_base_price'], oos_get_tax_rate($new_products['products_tax_class_id']));
      }
    }

    $new_products_array[] = array('products_id' => $new_products['products_id'],
                                  'products_image' => $new_products['products_image'],
                                  'products_name' => $new_products['products_name'],
                                  'products_description' => oos_remove_tags($new_products['products_description']),
                                  'products_base_price' => $new_products['products_base_price'],
                                  'products_base_unit' => $new_products['products_base_unit'],
                                  'new_product_units' => $new_product_units,
                                  'new_product_price' => $new_product_price,
                                  'new_product_special_price' => $new_product_special_price,
                                  'new_max_product_discount' => $new_max_product_discount,
                                  'new_product_discount_price' => $new_product_discount_price,
                                  'new_base_product_price' => $new_base_product_price,
                                  'new_base_product_special_price' => $new_base_product_special_price,
                                  'new_special_price' => $new_special_price);

    // Move that ADOdb pointer!
    $new_products_result->MoveNext();
  }

  // Close result set
  $new_products_result->Close();

  // assign Smarty variables;
  $oSmarty->assign(
      array(
          'block_heading_new_products' => sprintf($aLang['table_heading_new_products'], strftime('%B')),
          'new_products_array' => $new_products_array
      )
  );

?>