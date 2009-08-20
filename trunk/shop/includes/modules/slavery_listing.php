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


// define our listing functions
include 'includes/functions/function_listing.php';


$listing_numrows_sql = $listing_sql;
$listing_split = new splitPageResults($nCurrentPageNumber, MAX_DISPLAY_SEARCH_RESULTS, $listing_sql, $listing_numrows);


$listing_numrows = $dbconn->Execute($listing_numrows_sql);
$listing_numrows = $listing_numrows->RecordCount();

if ($listing_numrows > 0) {

/*
    $cur_row = count($list_box_contents) - 1;

    $nArrayCountColumnList = count($column_list);
    for ($col=0, $n=$nArrayCountColumnList; $col<$n; $col++) {
      switch ($column_list[$col]) {
        case 'PRODUCT_LIST_MODEL':
          $lc_text = $aLang['table_heading_model'];
          break;

        case 'PRODUCT_LIST_NAME':
          $lc_text = $aLang['table_heading_products'];
          break;

        case 'PRODUCT_LIST_MANUFACTURER':
          $lc_text = $aLang['table_heading_manufacturer'];
          break;

        case 'PRODUCT_LIST_PRICE':
            $lc_text = $aLang['table_heading_price'];
          break;

        case 'PRODUCT_LIST_QUANTITY':
          $lc_text = $aLang['table_heading_quantity'];
          break;

        case 'PRODUCT_LIST_WEIGHT':
          $lc_text = $aLang['table_heading_weight'];
          break;

        case 'PRODUCT_LIST_IMAGE':
          $lc_text = $aLang['table_heading_image'];
          break;

        case 'PRODUCT_SLAVE_BUY_NOW':
            $lc_text = $aLang['table_heading_buy_now'];
          break;
      }

      if ( ($column_list[$col] != 'PRODUCT_SLAVE_BUY_NOW') && ($column_list[$col] != 'PRODUCT_LIST_IMAGE') ) {
          $lc_text = oos_create_sort_heading($_GET['sort'], $col+1, $lc_text);
      }
*/
}



if ($listing_numrows > 0) {

    // todo remove oos_get_all_get_parameters
    // 'nv='. $nCurrentPageNumber
    if (!isset($all_get_listing)) $all_get_listing = oos_get_all_get_parameters(array('action'));

    $listing_result = $dbconn->Execute($listing_sql);
    while ($listing = $listing_result->fields)
    {

        // $sProductListLink
        if (isset($_GET['manufacturers_id'])) {
            $sProductListLink = oos_href_link($aPages['product_info'], 'manufacturers_id=' . $_GET['manufacturers_id'] . '&amp;products_id=' . $listing['products_id']);
        } else {
            if ($oEvent->installed_plugin('sefu')) {
               $sProductListLink =  oos_href_link($aPages['product_info'], 'products_id=' . $listing['products_id']);
            } else {
               $sProductListLink =  oos_href_link($aPages['product_info'], ($categories ? 'categories=' . $categories . '&amp;' : '') . 'products_id=' . $listing['products_id']);
            }
        }


        // $sProductListUVP
        if ($listing['products_price_list'] > 0) {
           $sProductListUVP = $oCurrencies->display_price($listing['products_price_list'], oos_get_tax_rate($listing['products_tax_class_id']));
        }


        // $sProductListPrice
        $sUnits = UNITS_DELIMITER . $products_units[$listing['products_units_id']];
        $pl_product_price = $oCurrencies->display_price($listing['products_price'], oos_get_tax_rate($listing['products_tax_class_id']));

        unset($pl_price_discount);
        unset($pl_special_price);
        unset($pl_max_product_discount);
        unset($pl_base_product_price);
        unset($pl_base_product_special_price);

        if ( $listing['products_discount4'] > 0 ) {
            $pl_price_discount = $oCurrencies->display_price($listing['products_discount4'], oos_get_tax_rate($listing['products_tax_class_id']));
        } elseif ( $listing['products_discount3'] > 0 ) {
            $pl_price_discount = $oCurrencies->display_price($listing['products_discount3'], oos_get_tax_rate($listing['products_tax_class_id']));
        } elseif ( $listing['products_discount2'] > 0 ) {
            $pl_price_discount = $oCurrencies->display_price($listing['products_discount2'], oos_get_tax_rate($listing['products_tax_class_id']));
        } elseif ( $listing['products_discount1'] > 0 ) {
            $pl_price_discount = $oCurrencies->display_price($listing['products_discount1'], oos_get_tax_rate($listing['products_tax_class_id']));
        }

        if (!empty($listing['specials_new_products_price'])) {
            $pl_special_price = $listing['specials_new_products_price'];
            $pl_product_special_price = $oCurrencies->display_price($pl_special_price, oos_get_tax_rate($listing['products_tax_class_id']));
        } else {
            $pl_max_product_discount =  min($listing['products_discount_allowed'],$_SESSION['member']->group['discount']);

            if ($pl_max_product_discount != 0 ) {
                $pl_special_price = $listing['products_price']*(100-$pl_max_product_discount)/100;
                $pl_product_special_price = $oCurrencies->display_price($pl_special_price, oos_get_tax_rate($listing['products_tax_class_id']));
            }
        }


        if ($listing['products_base_price'] != 1) {
            $pl_base_product_price = $oCurrencies->display_price($listing['products_price'] * $listing['products_base_price'], oos_get_tax_rate($listing['products_tax_class_id']));

            if ($pl_special_price != '') {
                $pl_base_product_special_price = $oCurrencies->display_price($pl_special_price * $listing['products_base_price'], oos_get_tax_rate($listing['products_tax_class_id']));
            }
        }

        if (!empty($listing['specials_new_products_price'])) {
            $sProductListPrice = '&nbsp;<s>' . $pl_product_price . $sUnits . '</s><br />';
            if ($listing['products_base_price'] != 1)  $lc_text .= '<s><span class="base_price">' . $listing['products_base_unit'] . ' = ' . $pl_base_product_price . '</span></s><br />';

            $sProductListPrice .= '&nbsp;<span class="special_price">' . $pl_product_special_price . $sUnits . '</span>';
            if ($listing['products_base_price'] != 1)  $lc_text .= '<br /><span class="special_base_price">' . $listing['products_base_unit'] . ' = ' . $pl_base_product_special_price . '</span></s><br />';
        } else {
            if ($pl_max_product_discount != 0 ) {
                $sProductListPrice = '&nbsp;<s>' . $pl_product_price . $sUnits . '</s>&nbsp;-' . number_format($pl_max_product_discount, 2) . '%<br />';
                $sProductListPrice .= '&nbsp;<span class="discount_price">' . $pl_product_special_price . $sUnits . '</span>';
                if ($listing['products_base_price'] != 1)  $lc_text .= '<br /><span class="special_base_price">' . $listing['products_base_unit'] . ' = ' . $pl_base_product_special_price . '</span></s><br />';

             } else {
                if (isset($pl_price_discount)) {
                    $sProductListPrice = $aLang['price_from'] . '&nbsp;' . $pl_price_discount . $sUnits . '<br />';
                } else {
                    $sProductListPrice = '&nbsp;' . $pl_product_price . $sUnits . '<br />';
                    if ($listing['products_base_price'] != 1)  $lc_text .= '<span class="base_price">' . $listing['products_base_unit'] . ' = ' . $pl_base_product_price . '</span><br />';
                }
            }
        }
        $sProductListPrice .= '&nbsp;<span class="pangv">' . $sPAngV . '</span><br />';


        // sProductListBuyNow:
        if ($_SESSION['member']->group['show_price'] == 1) {

            if (DECIMAL_CART_QUANTITY == '1') {
                $order_min = number_format($listing['products_quantity_order_min'], 2);
            } else {
                $order_min = number_format($listing['products_quantity_order_min']);
            }

            if (PRODUCT_LISTING_WITH_QTY == '1') {
                if (!isset($nProductsId)) $nProductsId = oos_get_product_id($_GET['products_id']);
                $sProductListBuyNow = '<form name="buy_slave" action="' . OOS_HTTP_SERVER . OOS_SHOP . 'index.php" method="post">';
                $sProductListBuyNow .='<input type="hidden" name="action" value="buy_slave">';
                $sProductListBuyNow .='<input type="hidden" name="slave_id" value="' . $listing['products_id'] .'">';
                $sProductListBuyNow .='<input type="hidden" name="page" value="' . $sPage .'">';
                $sProductListBuyNow .='<input type="hidden" name="formid" value="' . $sFormid .'">';
                $sProductListBuyNow .='<input type="hidden" name="categories" value="' . $categories .'">';
                $sProductListBuyNow .='<input type="hidden" name="products_id" value="' . $nProductsId .'">';
                $sProductListBuyNow .=oos_hide_session_id();

// todo remove oos_get_all_as_hidden_field
$sProductListBuyNow .=oos_get_all_as_hidden_field(array('action'));
                 $sProductListBuyNow .='<input type="hidden" name="nv" value="' . $nCurrentPageNumber .'">';

                 $sProductListBuyNow .=$aLang['products_order_qty_text'];
                 $sProductListBuyNow .=' <input type="text" name="cart_quantity" value="' . $order_min . '" size="3" /><br />';
                 $sProductListBuyNow .=oos_image_submit('buy_now.gif', $aLang['text_buy'] . $listing['products_name'] . $aLang['text_now']);
                 $sProductListBuyNow .='</form>';
               } else {
                 $lc_text = '<a href="' . oos_href_link($sPage, $all_get_listing . 'action=buy_slave&amp;slave_id=' . $listing['products_id'] . '&amp;cart_quantity=' . $order_min ) . '" title="' . $listing['products_name'] . '">' . oos_image_button('buy_now.gif', $aLang['text_buy'] . $listing['products_name'] . $aLang['text_now']) . '</a>&nbsp;';
        }

        $aProductListing[] = array(
                                'products_id' => $listing['products_id'],
                                'products_model' => $listing['products_model'],
                                'products_image' => $listing['products_image'],
                                'products_name' => $listing['products_name'],
                                'manufacturers_id' => $listing['manufacturers_id'],
                                'manufacturers_name' => $listing['manufacturers_name'],
                                'products_quantity' => $listing['products_quantity'],
                                'products_weight' => $listing['products_weight'],
                                'product_list_sort_order' => $listing['products_sort_order'],
                                'product_list_link' => $sProductListLink,
                                'products_description' => oos_remove_tags($listing['products_description']),
                                'product_list_uvp' => $sProductListUVP,
                                'product_list_price' =>  $sProductListPrice,
                                'product_list_buy_now' => $sProductListBuyNow
                              );

        // Move that ADOdb pointer!
        $listing_result->MoveNext();
    }



    $oSmarty->assign(array('oos_page_split' => $listing_split->display_count($listing_numrows, MAX_DISPLAY_SEARCH_RESULTS, $nCurrentPageNumber, $aLang['text_display_number_of_products']),
                           'oos_display_links' => $listing_split->display_links($listing_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $nCurrentPageNumber, oos_get_all_get_parameters(array('nv', 'info'))),
                           'oos_page_numrows' => $listing_numrows));

    $oSmarty->assign('list_box_contents', $aProductListing);
}