<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}

if (!defined('OOS_BASE_PRICE')) {
    define('OOS_BASE_PRICE', '0');
}

$_SESSION['navigation']->remove_current_page();

if (isset($_GET['products_id'])) {
    if (!isset($nProductsId)) $nProductsId = oos_get_product_id($_GET['products_id']);
}

$aOption['popup_print'] = $sTheme . '/products/popup_print.html';

//smarty
require 'includes/classes/class_template.php';
$oSmarty = new Template;

$oSmarty->caching = true;

$popup_cache_id = $sTheme . '|products|' . $nGroupID . '|print|' . $nProductsId . '|' . $sLanguage;

if (!$oSmarty->is_cached($aOption['popup_print'], $popup_cache_id )) {
    require 'includes/languages/' . $sLanguage . '/products_info.php';

    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $product_info_sql = "SELECT p.products_id, pd.products_name, pd.products_description, pd.products_url,
                                pd.products_description_meta, pd.products_keywords_meta, p.products_model,
                                p.products_quantity, p.products_image, p.products_subimage1, p.products_subimage2,
                                p.products_subimage3, p.products_subimage4, p.products_subimage5, p.products_subimage6,
                                p.products_discount_allowed, p.products_price, p.products_base_price, p.products_base_unit,
                                p.products_quantity_order_min, p.products_quantity_order_units,
                                p.products_discount1, p.products_discount2, p.products_discount3, p.products_discount4,
                                p.products_discount1_qty, p.products_discount2_qty, p.products_discount3_qty,
                                p.products_discount4_qty, p.products_tax_class_id, p.products_units_id, p.products_date_added,
                                p.products_date_available, p.manufacturers_id, p.products_price_list
                          FROM $productstable p,
                             $products_descriptiontable pd
                          WHERE p.products_status >= '1'
                            AND (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "')
                            AND p.products_id = '" . intval($nProductsId) . "'
                            AND pd.products_id = p.products_id
                            AND pd.products_languages_id = '" . intval($nLanguageID) . "'";
    $product_info_result = $dbconn->Execute($product_info_sql);

    if (!$product_info_result->RecordCount()) {
        // product not found
        $aLang['text_information'] = $aLang['text_product_not_found'];

        $oSmarty->assign(
            array(
                'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
                'oos_heading_title' => $aLang['text_product_not_found'],
                'oos_heading_image' => 'specials.gif'
            )
        );
    } else {

        $product_info = $product_info_result->fields;

        $info_product_price = '';
        $info_product_special_price = '';
        $info_product_discount = 0;
        $info_product_discount_price = '';
        $info_base_product_price = '';
        $info_base_product_special_price = '';
        $info_product_price_list = 0;
        $info_special_price = '';
        $info_product_special_price = '';

        if ($_SESSION['member']->group['show_price'] == 1 ) {
            $info_product_price = $oCurrencies->display_price($product_info['products_price'], oos_get_tax_rate($product_info['products_tax_class_id']));

            if ($info_special_price = oos_get_products_special_price($product_info['products_id'])) {
                $info_product_special_price = $oCurrencies->display_price($info_special_price, oos_get_tax_rate($product_info['products_tax_class_id']));
            } else {
                $info_product_discount = min($product_info['products_discount_allowed'], $_SESSION['member']->group['discount']);

                if ($info_product_discount != 0 ) {
                    $info_product_special_price = $product_info['products_price']*(100-$info_product_discount)/100;
                    $info_product_discount_price = $oCurrencies->display_price($info_product_special_price, oos_get_tax_rate($product_info['products_tax_class_id']));
                }

            }

            if ($product_info['products_base_price'] != 1) {
                $info_base_product_price = $oCurrencies->display_price($product_info['products_price'] * $product_info['products_base_price'], oos_get_tax_rate($product_info['products_tax_class_id']));

                if ($info_product_special_price != '') {
                    $info_base_product_special_price = $oCurrencies->display_price($info_product_special_price * $product_info['products_base_price'], oos_get_tax_rate($product_info['products_tax_class_id']));
                }
            }
        }


        if (OOS_BASE_PRICE == '0') {
            $info_product_price_list = $oCurrencies->display_price($product_info['products_price_list'], oos_get_tax_rate($product_info['products_tax_class_id']));
            $oSmarty->assign('info_product_price_list', $info_product_price_list);
        }

        // assign Smarty variables;
        $oSmarty->assign_by_ref("oEvent", $oEvent);

        $oSmarty->assign('product_info', $product_info);
        $oSmarty->assign('oosDate', date('Y-m-d H:i:s'));
        $oSmarty->assign('oos_base', (($request_type == 'SSL') ? OOS_HTTPS_SERVER : OOS_HTTP_SERVER) . OOS_SHOP);

        $oSmarty->assign(
              array(
                  'request_type'                    => $request_type,

                  'theme_set'                       => $sTheme,
                  'theme_image'                     => 'themes/' . $sTheme . '/images',
                  'theme_css'                       => 'themes/' . $sTheme,

                  'lang'                            => $aLang,

                  'info_product_price'              => $info_product_price,
                  'info_special_price'              => $info_special_price,
                  'info_product_special_price'      => $info_product_special_price,
                  'info_max_product_discount'       => $info_product_discount,
                  'info_product_discount_price'     => $info_product_discount_price,
                  'info_base_product_price'         => $info_base_product_price,
                  'info_base_product_special_price' => $info_base_product_special_price
              )
        );
    }
}

// display the template
$oSmarty->display($aOption['popup_print'], $popup_cache_id);

