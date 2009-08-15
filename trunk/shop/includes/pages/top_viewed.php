<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

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


require 'includes/languages/' . $sLanguage . '/top_viewed.php';

$oos_pagetitle = $aLang['pagetitle'];
$oos_meta_description = $aLang['meta_description'];
$oos_meta_keywords = $aLang['meta_keywords'];

$aOption['template_main'] = $sTheme . '/products/top_viewed.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['page_navigation'] = $sTheme . '/heading/page_navigation.html';
$aOption['breadcrumb'] = 'default/system/breadcrumb.html';

$nPageType = OOS_PAGE_TYPE_CATALOG;
$contents_cache_id = $sTheme . '|top_viewed|' . $nCurrentPageNumber. '|' . $nGroupID . '|' . $sLanguage;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

if ( (USE_CACHE == '1') && (!SID) ) {
    $oSmarty->caching = 2;
    $oSmarty->cache_lifetime = 6 * 3600;
}

if (!$oSmarty->is_cached($aOption['template_main'], $contents_cache_id)) {


    $productstable  = $oostable['products'];
    $specialsstable = $oostable['specials'];
    $manufacturersstable = $oostable['manufacturers'];
    $products_descriptiontable = $oostable['products_description'];
    $top_viewed_result_raw = "SELECT p.products_id, pd.products_name, p.products_image, p.products_price,
                                       p.products_base_price, p.products_base_unit, p.products_units_id,
                                       p.products_discount_allowed, p.products_tax_class_id, p.products_units_id,
                                       IF(s.status, s.specials_new_products_price, NULL) AS specials_new_products_price,
                                       p.products_date_added, m.manufacturers_name
                                 FROM $productstable p LEFT JOIN
                                      $manufacturersstable m ON p.manufacturers_id = m.manufacturers_id LEFT JOIN
                                      $products_descriptiontable pd ON p.products_id = pd.products_id AND pd.products_languages_id = '" . intval($nLanguageID) . "' LEFT JOIN
                                      $specialsstable s ON p.products_id = s.products_id
                                 WHERE p.products_status >= '1'
                                   AND (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "')
                                 ORDER BY p.products_date_added DESC, pd.products_name";
    $top_viewed_split = new splitPageResults($nCurrentPageNumber, MAX_DISPLAY_PRODUCTS_NEW, $top_viewed_result_raw, $top_viewed_numrows);
    $top_viewed_result = $dbconn->Execute($top_viewed_result_raw);

    $top_viewed_array = array();
    while ($top_viewed = $top_viewed_result->fields)
    {

        $new_product_price = '';
        $new_product_special_price = '';
        $new_max_product_discount = 0;
        $new_special_price = '';
        $new_product_discount_price = '';
        $new_base_product_price = '';
        $new_base_product_special_price = '';

        $new_product_units = UNITS_DELIMITER . $products_units[$top_viewed['products_units_id']];

        $new_product_price = $oCurrencies->display_price($top_viewed['products_price'], oos_get_tax_rate($top_viewed['products_tax_class_id']));
        if (isset($top_viewed['specials_new_products_price'])) {
            $new_special_price = $top_viewed['specials_new_products_price'];
            $new_product_special_price = $oCurrencies->display_price($new_special_price, oos_get_tax_rate($top_viewed['products_tax_class_id']));
        } else {
            $new_max_product_discount = min($top_viewed['products_discount_allowed'],$_SESSION['member']->group['discount']);
            if ($new_max_product_discount != 0) {
                $new_special_price = $top_viewed['products_price']*(100-$new_max_product_discount)/100;
                $new_product_discount_price = $oCurrencies->display_price($new_special_price, oos_get_tax_rate($top_viewed['products_tax_class_id']));
            }
        }

        if ($top_viewed['products_base_price'] != 1) {
            $new_base_product_price = $oCurrencies->display_price($top_viewed['products_price'] * $top_viewed['products_base_price'], oos_get_tax_rate($top_viewed['products_tax_class_id']));

            if ($new_special_price != '') {
                $new_base_product_special_price = $oCurrencies->display_price($new_special_price * $top_viewed['products_base_price'], oos_get_tax_rate($top_viewed['products_tax_class_id']));
            }
        }
        $top_viewed_array[] = array('id' => $top_viewed['products_id'],
                                      'name' => $top_viewed['products_name'],
                                      'image' => $top_viewed['products_image'],
                                      'new_product_price' => $new_product_price,
                                      'new_product_units' => $new_product_units,
                                      'new_product_special_price' => $new_product_special_price,
                                      'new_max_product_discount' => $new_max_product_discount,
                                      'new_special_price' => $new_special_price,
                                      'new_product_discount_price' => $new_product_discount_price,
                                      'new_base_product_price' => $new_base_product_price,
                                      'new_base_product_special_price' => $new_base_product_special_price,
                                      'products_base_price' => $top_viewed['products_base_price'],
                                      'new_products_base_unit' => $top_viewed['products_base_unit'],
                                      'date_added' => $top_viewed['products_date_added'],
                                      'manufacturer' => $top_viewed['manufacturers_name']);
        $top_viewed_result->MoveNext();
    }

    // links breadcrumb
    $oBreadcrumb->add($aLang['header_title_catalog'], oos_href_link($aPages['shop']));
    $oBreadcrumb->add($aLang['navbar_title'], oos_href_link($aPages['top_viewed']), bookmark);

    // assign Smarty variables;
    $oSmarty->assign(
        array(
           'oos_breadcrumb'         => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
           'oos_heading_title'      => $aLang['heading_title'],
           'oos_heading_image'      => 'top_viewed.gif',

           'oos_page_split'         => $top_viewed_split->display_count($top_viewed_numrows, MAX_DISPLAY_PRODUCTS_NEW, $nCurrentPageNumber, $aLang['text_display_number_of_top_viewed']),
           'oos_display_links'      => $top_viewed_split->display_links($top_viewed_numrows, MAX_DISPLAY_PRODUCTS_NEW, MAX_DISPLAY_PAGE_LINKS, $nCurrentPageNumber, oos_get_all_get_parameters(array('nv', 'info'))),
           'oos_page_numrows'       => $top_viewed_numrows,

           'products_image_box'     => SMALL_IMAGE_WIDTH + 10,
           'oos_top_viewed_array'   => $top_viewed_array
        )
    );
}

$oSmarty->assign('oosPageNavigation', $oSmarty->fetch($aOption['page_navigation'], $contents_cache_id));
$oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb'], $contents_cache_id));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading'], $contents_cache_id));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main'], $contents_cache_id));
$oSmarty->caching = false;

// display the template
require 'includes/oos_display.php';

