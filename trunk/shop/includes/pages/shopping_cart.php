<?php
/* ----------------------------------------------------------------------
 $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: shopping_cart.php,v 1.71 2003/02/14 05:51:28 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); 
    header("Location: /");
    header("Connection: close");
    exit;
}

$_SESSION['navigation']->remove_current_page();

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/main_shopping_cart.php';

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title']);

$aOption['template_main'] = $sTheme . '/system/shopping_cart.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';

$nPageType = OOS_PAGE_TYPE_CATALOG;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}


$hidden_field = '';
$shopping_cart_detail = '';
$any_out_of_stock = 0;

if ($_SESSION['cart']->count_contents() > 0) {

    $products = $_SESSION['cart']->get_products();
    $nCountProducts = count($products);
    for ($i=0, $n=$nCountProducts; $i<$n; $i++) {

        // Push all attributes information in an array
        if (isset($products[$i]['attributes']) && is_array($products[$i]['attributes'])) {
            while (list($option, $value) = each($products[$i]['attributes'])) {

                $products_id = oos_get_product_id($products[$i]['id']);

                $products_optionstable = $oostable['products_options'];
                $products_options_valuestable = $oostable['products_options_values'];
                $products_attributestable = $oostable['products_attributes'];

                if ($value == PRODUCTS_OPTIONS_VALUE_TEXT_ID) {
                    $sql = "SELECT popt.products_options_name,
                                   pa.options_values_price, pa.price_prefix
                            FROM $products_optionstable popt,
                                 $products_attributestable pa
                            WHERE pa.products_id = '" . intval($products_id) . "'
                              AND pa.options_id = popt.products_options_id
                              AND pa.options_id = '" . oos_db_input($option) . "'
                              AND popt.products_options_languages_id = '" . intval($nLanguageID) . "'";
                } else {
                    $sql = "SELECT popt.products_options_name,
                                   poval.products_options_values_name,
                                   pa.options_values_price, pa.price_prefix
                            FROM $products_optionstable popt,
                                 $products_options_valuestable poval,
                                 $products_attributestable pa
                            WHERE pa.products_id = '" . intval($products_id) . "'
                              AND pa.options_id = '" . oos_db_input($option) . "'
                              AND pa.options_id = popt.products_options_id
                              AND pa.options_values_id = '" . oos_db_input($value) . "'
                              AND pa.options_values_id = poval.products_options_values_id
                              AND popt.products_options_languages_id = '" . intval($nLanguageID) . "'
                              AND poval.products_options_values_languages_id = '" .  intval($nLanguageID) . "'";
                }

                $attributes_values = $dbconn->GetRow($sql);

                if ($value == PRODUCTS_OPTIONS_VALUE_TEXT_ID) {
                    $hidden_field .=  oos_draw_hidden_field('id[' . $products[$i]['id'] . '][' . TEXT_PREFIX . $option . ']',$products[$i]['attributes_values'][$option]);
                    $attr_value = $products[$i]['attributes_values'][$option];
                } else {
                    $hidden_field .= oos_draw_hidden_field('id[' . $products[$i]['id'] . '][' . $option . ']', $value);
                    $attr_value = $attributes_values['products_options_values_name'];
                }

                $attr_price = $attributes_values['options_values_price'];

                if ($_SESSION['member']->group['discount'] != 0) {
                    $max_product_discount = min($products[$i]['discount_allowed'], $_SESSION['member']->group['discount']);
                    if ( ($max_product_discount > 0) && ($products[$i]['spezial'] == '0') ) {
                        $attr_price = $attr_price*(100-$max_product_discount)/100;
                    }
                }

                $products[$i][$option]['products_options_name'] = $attributes_values['products_options_name'];
                $products[$i][$option]['options_values_id'] = $value;
                $products[$i][$option]['products_options_values_name'] = $attr_value;
                $products[$i][$option]['options_values_price'] = $attr_price;
                $products[$i][$option]['price_prefix'] = $attributes_values['price_prefix'];
            }
        }
    }

    require 'includes/modules/order_details.php';
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
          'oos_heading_title' => $aLang['heading_title'],
          'oos_heading_image' => 'cart.gif',

          'hidden_field'         => $hidden_field,
          'shopping_cart_detail' => $shopping_cart_detail,
          'oos_cart_total'       => $oCurrencies->format($_SESSION['cart']->show_total()),
          'any_out_of_stock'     => $any_out_of_stock
       )
);

$back = count($_SESSION['navigation']->path)-1;
if (isset($_SESSION['navigation']->path[$back])) {
    $back_link = oos_href_link($_SESSION['navigation']->path[$back]['page'], $_SESSION['navigation']->path[$back]['get'], $_SESSION['navigation']->path[$back]['mode']);
    $oSmarty->assign('back_link', $back_link);
}

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

