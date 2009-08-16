<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: order_history.php,v 1.4 2003/02/10 22:31:02 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if (!isset($_SESSION['customer_id'])) {
    $_SESSION['navigation']->set_snapshot();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['login'], '', 'SSL'));
}

// split-page-results
if (isset($_GET['nv'])) {
    $nCurrentPageNumber = filter_input(INPUT_GET, 'nv', FILTER_VALIDATE_INT);
} elseif (isset($_POST['nv'])) {
    $nCurrentPageNumber = filter_input(INPUT_POST, 'nv', FILTER_VALIDATE_INT);
} else {
    $nCurrentPageNumber = 1;
}

if (empty($nCurrentPageNumber) || !is_numeric($nCurrentPageNumber)) $nCurrentPageNumber = 1;

MyOOS_CoreApi::requireOnce('classes/class_split_page_results.php');

require 'includes/languages/' . $sLanguage . '/account_order_history.php';

$aOption['template_main'] = $sTheme . '/modules/account_order_history.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['page_navigation'] = $sTheme . '/heading/page_navigation.html';
$aOption['breadcrumb'] = 'default/system/breadcrumb.html';

$nPageType = OOS_PAGE_TYPE_CATALOG;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

$orderstable = $oostable['orders'];
$orders_productstable = $oostable['orders_products'];
$productstable = $oostable['products'];
$query = "SELECT DISTINCT op.products_id
            FROM $orderstable o,
               $orders_productstable op,
               $productstable p
            WHERE o.customers_id = '" . intval($_SESSION['customer_id']) . "'
              AND o.orders_id = op.orders_id
              AND op.products_id = p.products_id
              AND p.products_status >= '1'
            GROUP BY products_id
            ORDER BY o.date_purchased DESC";
$orders_result =$dbconn->Execute($query);
if ($orders_result->RecordCount()) {

    $product_ids = '';
    while ($orders = $orders_result->fields)
    {
        $product_ids .= $orders['products_id'] . ',';

       // Move that ADOdb pointer!
       $orders_result->MoveNext();
    }


    $product_ids = substr($product_ids, 0, -1);

    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $manufacturerstable = $oostable['manufacturers'];
    $historytable = $oostable['specials'];
    $order_history_raw = "SELECT pd.products_name, p.products_id, p.products_quantity, p.products_image,
                                 p.products_price, p.products_base_price, p.products_base_unit,
                                 p.products_discount_allowed, p.products_tax_class_id, p.products_sort_order,
                                 IF(s.status, s.specials_new_products_price, NULL) AS specials_new_products_price,
                                 IF(s.status, s.specials_new_products_price, p.products_price) AS final_price
                          FROM $products_descriptiontable pd,
                             $productstable p LEFT JOIN
                             $manufacturerstable m ON p.manufacturers_id = m.manufacturers_id LEFT JOIN
                             $historytable s ON p.products_id = s.products_id
                          WHERE p.products_status >= '1'
                            AND p.products_id = pd.products_id
                            AND pd.products_id IN ($product_ids)
                            AND pd.products_languages_id = '" .  intval($nLanguageID) . "'";

    $order_history_split = new splitPageResults($nCurrentPageNumber, MAX_DISPLAY_PRODUCTS_NEW, $order_history_raw, $order_history_numrows);
    $order_history_result = $dbconn->Execute($order_history_raw);

    $order_history_array = array();
    while ($order_history = $order_history_result->fields)
    {

        $new_product_price = '';
        $new_product_special_price = '';
        $new_max_product_discount = 0;
        $new_special_price = '';
        $new_product_discount_price = '';
        $new_base_product_price = '';
        $new_base_product_special_price = '';

        $new_product_price = $oCurrencies->display_price($order_history['products_price'], oos_get_tax_rate($order_history['products_tax_class_id']));
        if (isset($order_history['specials_new_products_price'])) {
            $new_special_price = $order_history['specials_new_products_price'];
            $new_product_special_price = $oCurrencies->display_price($new_special_price, oos_get_tax_rate($order_history['products_tax_class_id']));
        } else {
            $new_max_product_discount = min($order_history['products_discount_allowed'],$_SESSION['member']->group['discount']);
            if ($new_max_product_discount != 0) {
                $new_special_price = $order_history['products_price']*(100-$new_max_product_discount)/100;
                $new_product_discount_price = $oCurrencies->display_price($new_special_price, oos_get_tax_rate($order_history['products_tax_class_id']));
            }
        }

        if ($order_history['products_base_price'] != 1) {
            $new_base_product_price = $oCurrencies->display_price($order_history['products_price'] * $order_history['products_base_price'], oos_get_tax_rate($order_history['products_tax_class_id']));

            if ($new_special_price != '') {
                $new_base_product_special_price = $oCurrencies->display_price($new_special_price * $order_history['products_base_price'], oos_get_tax_rate($order_history['products_tax_class_id']));
            }
        }
        $order_history_array[] = array('id' => $order_history['products_id'],
                                       'name' => $order_history['products_name'],
                                       'image' => $order_history['products_image'],
                                       'new_product_price' => $new_product_price,
                                       'new_product_special_price' => $new_product_special_price,
                                       'new_max_product_discount' => $new_max_product_discount,
                                       'new_special_price' => $new_special_price,
                                       'new_product_discount_price' => $new_product_discount_price,
                                       'new_base_product_price' => $new_base_product_price,
                                       'new_base_product_special_price' => $new_base_product_special_price,
                                       'products_base_price' => $order_history['products_base_price'],
                                       'new_products_base_unit' => $order_history['products_base_unit'],
                                       'date_added' => $order_history['products_date_added'],
                                       'manufacturer' => $order_history['manufacturers_name']);
       $order_history_result->MoveNext();
    }

    // assign Smarty variables;
    $oSmarty->assign(
        array(
           'oos_page_split'          => $order_history_split->display_count($order_history_numrows, MAX_DISPLAY_SEARCH_RESULTS, $nCurrentPageNumber, $aLang['text_display_number_of_products']),
           'oos_display_links'       => $order_history_split->display_links($order_history_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $nCurrentPageNumber, oos_get_all_get_parameters(array('nv', 'info'))),
           'oos_page_numrows'        => $order_history_numrows,

           'products_image_box'      => SMALL_IMAGE_WIDTH + 10,
           'oos_order_history_array' => $order_history_array
       )
    );
}

// links breadcrumb
$oBreadcrumb->add($aLang['header_title_catalog'], oos_href_link($aPages['shop']));
$oBreadcrumb->add($aLang['navbar_title'], oos_href_link($aPages['account_order_history']), bookmark);


// assign Smarty variables;
$oSmarty->assign(
      array(
         'oos_breadcrumb'         => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
         'oos_heading_title'      => $aLang['heading_title'],
         'oos_heading_image'      => 'products_new.gif'
     )
);

$oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
$oSmarty->assign('oosPageNavigation', $oSmarty->fetch($aOption['page_navigation']));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

