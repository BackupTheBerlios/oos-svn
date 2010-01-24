<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: wishlist_help.php,v 1  2002/11/09 wib
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}

// split-page-results
MyOOS_CoreApi::requireOnce('classes/class_split_page_results.php');

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/main_wishlist.php';

if (isset($_GET['wlid'])) $wlid =  oos_db_prepare_input($_GET['wlid']);
if (strlen($wlid) < 10) unset($wlid);

if ( empty( $wlid ) || !is_string( $wlid ) ) {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
}

$wishlist_result_raw = "SELECT products_id, customers_wishlist_date_added
                        FROM " . $oostable['customers_wishlist'] . "
                        WHERE customers_wishlist_link_id = '" . oos_db_input($wlid) . "'
                        ORDER BY customers_wishlist_date_added";
$wishlist_split = new splitPageResults($_GET['page'], MAX_DISPLAY_WISHLIST_PRODUCTS, $wishlist_result_raw, $wishlist_numrows);
$wishlist_result = $dbconn->Execute($wishlist_result_raw);

if (!$wishlist_result->RecordCount()) {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main'], '', 'NONSSL'));
}


$sql = "SELECT customers_firstname, customers_lastname
        FROM " . $oostable['customers'] . "
        WHERE customers_wishlist_link_id = '" . oos_db_input($wlid) . "'";
$customer_result = $dbconn->Execute($sql);
if (!$customer_result->RecordCount()) {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main'], '', 'NONSSL'));
}
$customer_info = $customer_result->fields;
$customer = $customer_info['customers_firstname'] . ' ' . $customer_info['customers_lastname'] . ': ';

$aWishlist = array();
while ($wishlist = $wishlist_result->fields)
{
    $wl_products_id = oos_get_product_id($wishlist['products_id']);
    $sql = "SELECT p.products_id, pd.products_name, pd.products_description, p.products_model,
                   p.products_image, p.products_price, p.products_base_price, p.products_base_unit,
                   p.products_discount_allowed, p.products_tax_class_id, p.products_units_id
            FROM " . $oostable['products'] . " p,
                 " . $oostable['products_description'] . " pd
            WHERE p.products_id = '" . intval($wl_products_id) . "'
              AND pd.products_id = p.products_id
              AND pd.products_languages_id = '" .  intval($nLanguageID) . "'";
    $wishlist_product = $dbconn->GetRow($sql);

    $wishlist_product_price = '';
    $wishlist_product_special_price = '';
    $wishlist_product_discount = 0;
    $wishlist_product_discount_price = '';
    $wishlist_base_product_price = '';
    $wishlist_base_product_special_price = '';
    $wishlist_special_price = '';

    $wishlist_product_price = $oCurrencies->display_price($wishlist_product['products_price'], oos_get_tax_rate($wishlist_product['products_tax_class_id']));

    if ($wishlist_special_price = oos_get_products_special_price($wl_products_id)) {
        $wishlist_product_special_price = $oCurrencies->display_price($wishlist_special_price, oos_get_tax_rate($wishlist_product['products_tax_class_id']));
    } else {
        $wishlist_product_discount = min($wishlist_product['products_discount_allowed'], $_SESSION['member']->group['discount']);

        if ($wishlist_product_discount != 0 ) {
            $wishlist_special_price = $wishlist_product['products_price']*(100-$wishlist_product_discount)/100;
            $wishlist_product_discount_price = $oCurrencies->display_price($wishlist_special_price, oos_get_tax_rate($wishlist_product['products_tax_class_id']));
        }
    }

    if ($wishlist_product['products_base_price'] != 1) {
        $wishlist_base_product_price = $oCurrencies->display_price($wishlist_product['products_price'] * $wishlist_product['products_base_price'], oos_get_tax_rate($wishlist_product['products_tax_class_id']));

        if ($wishlist_special_price != '') {
            $wishlist_base_product_special_price = $oCurrencies->display_price($wishlist_special_price * $wishlist_product['products_base_price'], oos_get_tax_rate($wishlist_product['products_tax_class_id']));
        }
    }

    $sql = "SELECT products_options_id, products_options_value_id
            FROM " . $oostable['customers_wishlist_attributes'] . "
            WHERE customers_wishlist_link_id = '" . oos_db_input($wlid) . "'
              AND products_id = '" . $wishlist['products_id'] . "'";
    $attributes_result = $dbconn->Execute($sql);
    $attributes_print = '';
    while ($attributes = $attributes_result->fields)
    {
        $attributes_print .= oos_draw_hidden_field('id[' . $attributes['products_options_id'] . ']', $attributes['products_options_value_id']);
        $attributes_print .= '                   <tr>';
        $sql = "SELECT popt.products_options_name,
                       poval.products_options_values_name,
                       pa.options_values_price, pa.price_prefix
                FROM " . $oostable['products_options'] . " popt,
                     " . $oostable['products_options_values'] . " poval,
                     " . $oostable['products_attributes'] . " pa
                WHERE pa.products_id = '" . intval($wl_products_id) . "'
                  AND pa.options_id = '" . $attributes['products_options_id'] . "'
                  AND pa.options_id = popt.products_options_id
                  AND pa.options_values_id = '" . $attributes['products_options_value_id'] . "'
                  AND pa.options_values_id = poval.products_options_values_id
                  AND popt.products_options_languages_id = '" .  intval($nLanguageID) . "'
                  AND poval.products_options_values_languages_id = '" .  intval($nLanguageID) . "'";
        $option = $dbconn->Execute($sql);
        $option_values = $option->fields;

        $attributes_print .= '<td><br /><small><i> - ' . $option_values['products_options_name'] . ' ' . $option_values['products_options_values_name'] . '</i></small></td>';

        if ($option_values['options_values_price'] != 0) {
            $attributes_print .= '<td align="right"><small><i>' . $option_values['price_prefix'] . $oCurrencies->display_price($option_values['options_values_price'], oos_get_tax_rate($wishlist_product['products_tax_class_id'])) . '</i></small></td>';
        } else {
            $attributes_print .= '<td><small><i>&nbsp;</i></small></td>';
        }
        $attributes_print .= '                   </tr>';
        $attributes_result->MoveNext();
    }
    $aWishlist[] = array('products_id' => $wishlist_product['products_id'],
                         'wl_products_id' => $wl_products_id,
                         'products_image' => $wishlist_product['products_image'],
                         'products_name' => $wishlist_product['products_name'],
                         'product_price' => $wishlist_product_price,
                         'product_special_price' => $wishlist_product_special_price,
                         'max_product_discount' => $wishlist_product_discount,
                         'product_discount_price' => $wishlist_product_discount_price,
                         'base_product_price' => $wishlist_base_product_price,
                         'base_product_special_price' => $wishlist_base_product_special_price,
                         'products_base_price' => $wishlist_product['products_base_price'],
                         'products_base_unit' => $wishlist_product['products_base_unit'],
                         'attributes_print' => $attributes_print);
    $wishlist_result->MoveNext();
}

// links breadcrumb
$oBreadcrumb->add($customer. $aLang['navbar_title']);

$aOption['template_main'] = $sTheme . '/modules/wishlist.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['page_navigation'] = $sTheme . '/heading/page_navigation.html';

$nPageType = OOS_PAGE_TYPE_CATALOG;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

$oos_pagetitle = $oBreadcrumb->trail_title(' &raquo; ');
$oos_pagetitle .= '&raquo;' . OOS_META_TITLE;

// assign Smarty variables;
$oSmarty->assign(
      array(
          'pagetitle'         => htmlspecialchars($oos_pagetitle),
          'meta_description'  => htmlspecialchars($oos_meta_description),
          'meta_keywords'     => htmlspecialchars($oos_meta_keywords),
          'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
          'oos_heading_title' => $customer . $aLang['heading_title'],
          'oos_heading_image' => 'wishlist.gif',

          'oos_page_split'    => $wishlist_split->display_count($wishlist_numrows, MAX_DISPLAY_WISHLIST_PRODUCTS, $_GET['page'], $aLang['text_display_number_of_wishlist']),
          'oos_display_links' => $wishlist_split->display_links($wishlist_numrows, MAX_DISPLAY_WISHLIST_PRODUCTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], oos_get_all_get_parameters(array('page', 'info'))),
          'oos_page_numrows'  => $wishlist_numrows,

          'wishlist_array'    => $aWishlist
      )
);

$oSmarty->assign('oosPageNavigation', $oSmarty->fetch($aOption['page_navigation']));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';
