<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
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

// DO NOT RUN THIS SCRIPT STANDALONE
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

// if the customer is not logged on, redirect them to the shopping cart page
if ( !isset( $_SESSION['customer_id'] ) || !is_numeric( $_SESSION['customer_id'] )) {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['shopping_cart']), '301');
}

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/checkout_success.php';

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title_1']);
$oBreadcrumb->add($aLang['navbar_title_2']);

$aOption['template_main'] = $sTheme . '/modules/checkout_success.html';
$aOption['page_heading'] = $sTheme . '/modules/checkout_success_page_heading.html';

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

$oos_pagetitle = $oBreadcrumb->trail_title(' &raquo; ');
$oos_pagetitle .= '&raquo;' . OOS_META_TITLE;

// assign Smarty variables;
$oSmarty->assign(
      array(
          'pagetitle'         => htmlspecialchars($oos_pagetitle),
          'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
          'oos_heading_title' => $aLang['heading_title'],
          'oos_heading_image' => 'man_on_board.gif'
      )
);

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

