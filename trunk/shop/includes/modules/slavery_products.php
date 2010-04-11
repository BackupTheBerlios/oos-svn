<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: product_listing.php,v 1.2 2003/01/09 09:40:08 elarifr
   orig: product_listing.php,v 1.41 2003/02/12 23:55:58 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


if (!isset($nProductsId)) $nProductsId = oos_get_product_id($_GET['products_id']);
$nNV = isset($_GET['nv']) ? $_GET['nv']+0 : 1;
$sSort = oos_var_prep_for_os($_GET['sort']);

// $contents_cache_id = $sTheme . '|shop|slavery_products|' . intval($nProductsId) . '|' . $nNV . '|' .  $nGroupID . '|' . $sLanguage;
// if (!$oSmarty->is_cached($aOption['template_main'], $contents_cache_id)) { }


// create column list
$aDefineList = array('PRODUCT_LIST_MODEL' => SLAVE_LIST_MODEL,
                     'PRODUCT_LIST_MANUFACTURER' => SLAVE_LIST_MANUFACTURER,
                     'PRODUCT_LIST_UVP' => PRODUCT_LIST_UVP,
                     'PRODUCT_LIST_PRICE' => SLAVE_LIST_PRICE,
                     'PRODUCT_LIST_QUANTITY' => SLAVE_LIST_QUANTITY,
                     'PRODUCT_LIST_WEIGHT' => SLAVE_LIST_WEIGHT,
                     'PRODUCT_LIST_IMAGE' => SLAVE_LIST_IMAGE,
                     'PRODUCT_SLAVE_BUY_NOW' => SLAVE_LIST_BUY_NOW);
asort($aDefineList);

$column_list = array();
foreach ($aDefineList as $column => $value) {
   if ($value) $column_list[] = $column;
}


$productstable = $oostable['products'];
$products_to_mastertable = $oostable['products_to_master'];
$products_descriptiontable = $oostable['products_description'];
$manufacturerstable = $oostable['manufacturers'];
$specialstable = $oostable['specials'];
$listing_sql = "SELECT p.products_id, p.products_model, p.products_image, p.products_quantity, p.products_weight, p.products_sort_order, p.manufacturers_id, pd.products_name,
                       p.products_price, p.products_price_list, p.products_base_price, p.products_base_unit,
                       p.products_discount_allowed, p.products_discount1, p.products_discount2,
                       p.products_discount3, p.products_discount4, p.products_discount1_qty,
                       p.products_discount2_qty, p.products_discount3_qty, p.products_discount4_qty,
                       p.products_tax_class_id, p.products_units_id, p.products_quantity_order_min,
                       IF(s.status, s.specials_new_products_price, NULL) AS specials_new_products_price,
                       IF(s.status, s.specials_new_products_price, p.products_price) AS final_price,
                       pm.master_id, pm.slave_id
                FROM $productstable p LEFT JOIN
                     $manufacturerstable m ON p.manufacturers_id = m.manufacturers_id LEFT JOIN
                     $specialstable s ON p.products_id = s.products_id,
                     $products_to_mastertable pm,
                     $products_descriptiontable pd
                WHERE p.products_status >= '1'
                  AND (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "')
                  AND pd.products_id = p.products_id
                  AND pd.products_languages_id = '" . intval($nLanguageID) . "'
                  AND p.products_id = pm.slave_id
                  AND pm.master_id = '" . intval($nProductsId) . "'";


 if ( (!isset($_GET['sort'])) || (!preg_match('/^[1-8][ad]$/', $_GET['sort'])) || (substr($_GET['sort'], 0, 1) > count($column_list)) ) {
    $col = 0;
    $_GET['sort'] = $col+1 . 'a';
    $listing_sql .= " ORDER BY pd.products_name";
} else {
    $sort_col = substr($_GET['sort'], 0 , 1);
    $sort_order = substr($_GET['sort'], 1);
    $listing_sql .= ' ORDER BY ';

    switch ($column_list[$sort_col-1]) {
      case 'PRODUCT_LIST_MODEL':
        $listing_sql .= "p.products_model " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;

      case 'PRODUCT_LIST_MANUFACTURER':
        $listing_sql .= "m.manufacturers_name " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;

      case 'PRODUCT_LIST_QUANTITY':
        $listing_sql .= "p.products_quantity " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;

      case 'PRODUCT_LIST_IMAGE':
        $listing_sql .= "pd.products_name";
        break;

      case 'PRODUCT_LIST_WEIGHT':
        $listing_sql .= "p.products_weight " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;

      case 'PRODUCT_LIST_PRICE':
        $listing_sql .= "final_price " . ($sort_order == 'd' ? 'desc' : '') . ", pd.products_name";
        break;

      default:
        $listing_sql .= "pd.products_name";
        break;

    }
}

$aOption['slavery_products'] = $sTheme . '/products/slavery_product_listing.html';
$aOption['slavery_page_navigation'] = $sTheme . '/heading/page_navigation.html';

include 'includes/modules/slavery_listing.php';

$oSmarty->assign('define_list', $aDefineList);
$oSmarty->assign('slavery_products', $oSmarty->fetch($aOption['slavery_products']));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));

