<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: checkout_payment.php,v 1.6.2.1 2003/05/03 23:41:23 wilt
   orig: checkout_payment.php,v 1.109 2003/02/14 20:28:47 dgw_
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

require 'includes/languages/' . $sLanguage . '/checkout_payment.php';
require 'includes/functions/function_address.php';

// if the customer is not logged on, redirect them to the login page
if (!isset($_SESSION['customer_id'])) {
    $_SESSION['navigation']->set_snapshot();
    MyOOS_CoreApi::redirect(oos_href_link($aModules['user'], $aFilename['login'], '', 'SSL'));
}

if (oos_empty($_SESSION['member']->group['payment'])) {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
}

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() < 1) {
    MyOOS_CoreApi::redirect(oos_href_link($aModules['main'], $aFilename['main_shopping_cart']));
}

// if no shipping method has been selected, redirect the customer to the shipping method selection page
if (!isset($_SESSION['shipping'])) {
    MyOOS_CoreApi::redirect(oos_href_link($aModules['checkout'], $aFilename['checkout_shipping'], '', 'SSL'));
}


// avoid hack attempts during the checkout procedure by checking the internal cartID
if (isset($_SESSION['cart']->cartID) && isset($_SESSION['cartID'])) {
    if ($_SESSION['cart']->cartID != $_SESSION['cartID']) {
        MyOOS_CoreApi::redirect(oos_href_link($aModules['checkout'], $aFilename['checkout_shipping'], '', 'SSL'));
    }
}

// Stock Check
if ( (STOCK_CHECK == '1') && (STOCK_ALLOW_CHECKOUT != '1') ) {
    $products = $_SESSION['cart']->get_products();
    $any_out_of_stock = 0;
    for ($i=0, $n=count($products); $i<$n; $i++) {
        if (oos_check_stock($products[$i]['id'], $products[$i]['quantity'])) {
            $any_out_of_stock = 1;
        }
    }
    if ($any_out_of_stock == 1) {
        MyOOS_CoreApi::redirect(oos_href_link($aModules['main'], $aFilename['main_shopping_cart']));
    }
}

// if no billing destination address was selected, use the customers own address as default
if (!isset($_SESSION['billto'])) {
    $_SESSION['billto'] = $_SESSION['customer_default_address_id'];
} else {
// verify the selected billing address
    $address_booktable = $oostable['address_book'];
    $sql = "SELECT COUNT(*) AS total
            FROM $address_booktable
            WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'
              AND address_book_id = '" . intval($_SESSION['billto']) . "'";
    $check_address_result = $dbconn->Execute($sql);
    $check_address = $check_address_result->fields;

    if ($check_address['total'] != '1') {
        $_SESSION['billto'] = $_SESSION['customer_default_address_id'];
        if (isset($_SESSION['payment'])) unset($_SESSION['payment']);
    }
}

require 'includes/classes/class_order.php';
$oOrder = new order;

require 'includes/classes/class_order_total.php';
$oOrderTotalModules = new order_total;


$total_weight = $_SESSION['cart']->show_weight();
$total_count = $_SESSION['cart']->count_contents();
$total_count = $_SESSION['cart']->count_contents_virtual();

// load all enabled payment modules
require 'includes/classes/class_payment.php';
$oPaymentModules = new payment;
$selection = $oPaymentModules->selection();
$credit_selection = $oOrderTotalModules->credit_selection();

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aModules['checkout'], $aFilename['checkout_shipping'], '', 'SSL'));
$oBreadcrumb->add($aLang['navbar_title_2'], oos_href_link($aModules['checkout'], $aFilename['checkout_payment'], '', 'SSL'));

if (ENABLE_SSL == '1') {
    $condition_link = OOS_HTTPS_SERVER;
} else {
    $condition_link = OOS_HTTP_SERVER;
}
$condition_link .= OOS_SHOP . OOS_MEDIA . $sLanguage . '/' . $aFilename['conditions_download'];

ob_start();
require 'js/checkout_payment.js.php';
print $oPaymentModules->javascript_validation();
$javascript = ob_get_contents();
ob_end_clean();

$aOption['template_main'] = $sTheme . '/modules/checkout_payment.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['breadcrumb'] = 'default/system/breadcrumb.html';

$nPageType = OOS_PAGE_TYPE_CHECKOUT;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

// assign Smarty variables;
$oSmarty->assign(
      array(
          'oos_breadcrumb' => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
          'oos_heading_title' => $aLang['heading_title'],
          'oos_heading_image' => 'payment.gif'
      )
);

if (isset($_GET['payment_error']) && is_object(${$_GET['payment_error']}) && ($error = ${$_GET['payment_error']}->get_error())) {
    $oSmarty->assign(
        array(
            'oos_payment_error' => '1',
            'error' => $error
        )
    );
}

$oSmarty->assign('condition_link', $condition_link);
$oSmarty->assign(
      array(
          'selection' => $selection,
          'credit_selection' => $credit_selection
      )
);


$campaignstable = $oostable['campaigns'];
$sql = "SELECT campaigns_id FROM $campaignstable WHERE campaigns_languages_id = '" . intval($_SESSION['language_id']) . "'";
$campaigns_result = $dbconn->Execute($sql);
if ($campaigns_result->RecordCount()) {
    $oSmarty->assign('campaigns', '1');

    if (isset($_SESSION['campaigns_id']) && is_numeric($_SESSION['campaigns_id'])) {
        $oSmarty->assign('campaigns_id', $_SESSION['campaigns_id']);
    } else {
        $oSmarty->assign('campaigns_id', DEFAULT_CAMPAIGNS_ID);
    }

    $campaignstable = $oostable['campaigns'];
    $campaigns_sql = "SELECT campaigns_id, campaigns_name
                      FROM $campaignstable
                      WHERE campaigns_languages_id = '" . intval($_SESSION['language_id']) . "'
                      ORDER BY campaigns_id";
    $oSmarty->assign('campaigns_radios', $dbconn->getAssoc($campaigns_sql));
}

// JavaScript
$oSmarty->assign('oos_js', $javascript);

$oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

