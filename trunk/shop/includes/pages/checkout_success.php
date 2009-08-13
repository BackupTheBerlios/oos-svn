<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: checkout_success.php,v 1.6.2.1 2003/05/03 23:41:23 wilt
   orig: checkout_success.php,v 1.48 2003/02/17 11:51:16 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

// if the customer is not logged on, redirect them to the shopping cart page
if (!isset($_SESSION['customer_id'])) {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main_shopping_cart']));
}

require 'includes/languages/' . $sLanguage . '/checkout_success.php';

if (isset($_GET['action']) && ($_GET['action'] == 'update')) {
    $notify = $_POST['notify'];
    if (!is_array($notify)) $notify = array($notify);

    for ($i=0, $n=count($notify); $i<$n; $i++) {
        $products_notificationstable = $oostable['products_notifications'];
        $sql = "SELECT COUNT(*) AS total
                FROM $products_notificationstable
                WHERE products_id = '" . intval($notify[$i]) . "'
                  AND customers_id = '" . intval($_SESSION['customer_id']) . "'";
        $check = $dbconn->Execute($sql);
        if ($check->fields['total'] < 1) {
            $products_notificationstable = $oostable['products_notifications'];
            $sql = "INSERT INTO $products_notificationstable
                    (products_id,
                     customers_id,
                     date_added) VALUES (" . $dbconn->qstr($notify[$i]) . ','
                                           . $dbconn->qstr($_SESSION['customer_id']) . ','
                                           . $dbconn->DBTimeStamp($today) . ")";
            $result = $dbconn->Execute($sql);
        }
    }
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
}

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title_1']);
$oBreadcrumb->add($aLang['navbar_title_2']);

$customers_infotable = $oostable['customers_info'];
$sql = "SELECT global_product_notifications
        FROM $customers_infotable
        WHERE customers_info_id = '" . intval($_SESSION['customer_id']) . "'";
$global_result = $dbconn->Execute($sql);
$global = $global_result->fields;

if ($global['global_product_notifications'] != '1') {
    $orderstable = $oostable['orders'];
    $sql = "SELECT orders_id
            FROM $orderstable
            WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'
            ORDER BY date_purchased desc LIMIT 1";
    $orders_result = $dbconn->Execute($sql);
    $orders = $orders_result->fields;

    $products_array = array();
    $orders_productstable = $oostable['orders_products'];
    $sql = "SELECT products_id, products_name
            FROM $orders_productstable
            WHERE orders_id = '" . intval($orders['orders_id']) . "'
            ORDER BY products_name";
    $products_result = $dbconn->Execute($sql);
    while ($products = $products_result->fields)
    {
        $products_array[] = array('id' => $products['products_id'],
                                'text' => $products['products_name']);
        $products_result->MoveNext();
    }
}


$aOption['template_main'] = $sTheme . '/modules/checkout_success.html';
$aOption['page_heading'] = $sTheme . '/modules/checkout_success_page_heading.html';
$aOption['breadcrumb'] = 'default/system/breadcrumb.html';

$nPageType = OOS_PAGE_TYPE_CHECKOUT;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}


//ICW ADDED FOR ORDER_TOTAL CREDIT SYSTEM - Start Addition
$coupon_gv_customertable = $oostable['coupon_gv_customer'];
$sql = "SELECT amount
        FROM $coupon_gv_customertable
        WHERE customer_id = '" . intval($_SESSION['customer_id']) . "'";
$gv_amount = $dbconn->GetOne($sql);
$oSmarty->assign('gv_amount', $gv_amount);


$products_notify = '';
if ($global['global_product_notifications'] != '1') {
    $products_notify .= $aLang['text_notify_products'] . '<br /><p class="productsNotifications">';

    $products_displayed = array();
    for ($i=0, $n=count($products_array); $i<$n; $i++) {
        if (!in_array($products_array[$i]['id'], $products_displayed)) {
            $products_notify .= oos_draw_checkbox_field('notify[]', $products_array[$i]['id']) . ' ' . $products_array[$i]['text'] . '<br />';
            $products_displayed[] = $products_array[$i]['id'];
        }
    }
    $products_notify .= '</p>';
} else {
    $products_notify .= $aLang['text_see_orders'] . '<br /><br />' . $aLang['text_contact_store_owner'];
}

// assign Smarty variables;
$oSmarty->assign(
      array(
          'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
          'oos_heading_title' => $aLang['heading_title'],

          'products_notify' => $products_notify,
          'oos_heading_image' => 'man_on_board.gif'
      )
);

$oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

