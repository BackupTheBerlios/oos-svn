<?php
/* ----------------------------------------------------------------------
   $Id: specials.php 312 2009-07-21 14:59:24Z r23 $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: specials.php,v 1.46 2003/02/13 04:23:23 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if (!$oEvent->installed_plugin('spezials')) {
    $_SESSION['navigation']->remove_current_page();
    MyOOS_CoreApi::redirect(oos_href_link($aModules['main'], $aFilename['main'], 'history_back=true'));
}

// split-page-results
MyOOS_CoreApi::requireOnce('classes/class_split_page_results.php');

require 'includes/languages/' . $sLanguage . '/products_specials.php';

$aOption['template_main'] = $sTheme . '/products/specials.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['page_navigation'] = $sTheme . '/heading/page_navigation.html';
$aOption['breadcrumb'] = 'default/system/breadcrumb.html';

$nPageType = OOS_PAGE_TYPE_CATALOG;
$sGroup = trim($_SESSION['member']->group['text']);
$nPage = isset($_GET[page]) ? $_GET[page]+0 : 1;
$contents_cache_id = $sTheme . '|info|' . $sGroup . '|spezials|' . $nPage . '|' . $sLanguage;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

if ( (USE_CACHE == '1') && (!SID) ) {
    $oSmarty->caching = 2;
    $oSmarty->cache_lifetime = 12 * 3600;
}

if (!$oSmarty->is_cached($aOption['template_main'], $contents_cache_id)) {
    $productstable = $oostable['products'];
    $specialstable = $oostable['specials'];
    $products_descriptiontable = $oostable['products_description'];
    $specials_result_raw = "SELECT p.products_id, pd.products_name, p.products_image, p.products_price,
                                   p.products_base_price, p.products_base_unit, p.products_tax_class_id,
                                   p.products_units_id, p.products_image, s.specials_new_products_price,
                                   substring(pd.products_description, 1, 150) AS products_description
                            FROM $productstable p,
                                 $products_descriptiontable pd,
                                 $specialstable s
                           WHERE p.products_status >= '1'
                             AND (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "')
                             AND s.products_id = p.products_id
                             AND p.products_id = pd.products_id
                             AND pd.products_languages_id = '" . intval($nLanguageID) . "'
                             AND s.status = '1'
                           ORDER BY s.specials_date_added DESC";
    $specials_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SPECIAL_PRODUCTS, $specials_result_raw, $specials_numrows);
    $specials_result = $dbconn->Execute($specials_result_raw);

    $aSpecials = array();
    while ($specials = $specials_result->fields)
    {

        $specials_base_product_price = '';
        $specials_base_product_special_price = '';

        $specials_product_price = $oCurrencies->display_price($specials['products_price'], oos_get_tax_rate($specials['products_tax_class_id']));
        $specials_product_special_price = $oCurrencies->display_price($specials['specials_new_products_price'], oos_get_tax_rate($specials['products_tax_class_id']));

        if ($specials['products_base_price'] != 1) {
            $specials_base_product_price = $oCurrencies->display_price($specials['products_price'] * $specials['products_base_price'], oos_get_tax_rate($specials['products_tax_class_id']));
            $specials_base_product_special_price = $oCurrencies->display_price($specials['specials_new_products_price'] * $specials['products_base_price'], oos_get_tax_rate($specials['products_tax_class_id']));
        }

        $aSpecials[] = array(
                           'products_id'                => $specials['products_id'],
                           'products_image'             => $specials['products_image'],
                           'products_name'              => $specials['products_name'],
                           'products_description'       => $specials['products_description'],
                           'products_base_unit'         => $specials['products_base_unit'],
                           'products_base_price'        => $specials['products_base_price'],
                           'products_price'             => $specials_product_price,
                           'products_special_price'     => $specials_product_special_price,
                           'base_product_price'         => $specials_base_product_price,
                           'base_product_special_price' => $specials_base_product_special_price
                       );
        $specials_result->MoveNext();
    }

    // links breadcrumb
    $oBreadcrumb->add($aLang['navbar_title'], oos_href_link($aModules['products'], $aFilename['specials']), bookmark);

    // assign Smarty variables;
    $oSmarty->assign(
        array(
            'oos_breadcrumb'     => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
            'oos_heading_title'  => $aLang['heading_title'],
            'oos_heading_image'  => 'specials.gif',

            'oos_page_split'     => $specials_split->display_count($specials_numrows, MAX_DISPLAY_SPECIAL_PRODUCTS, $_GET['page'], $aLang['text_display_number_of_specials']),
            'oos_display_links'  => $specials_split->display_links($specials_numrows, MAX_DISPLAY_SPECIAL_PRODUCTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], oos_get_all_get_parameters(array('page', 'info'))),
            'oos_page_numrows'   => $specials_numrows,

            'oos_specials_array' => $aSpecials
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


