<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: logoff.php,v 1.1.2.2 2003/05/13 23:20:53 wilt Exp $
   orig: logoff.php,v 1.12 2003/02/13 03:01:51 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/user_logoff.php';

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title']);

$cookie_url_array = parse_url((ENABLE_SSL == true ? OOS_HTTPS_SERVER : OOS_HTTP_SERVER) . substr(OOS_SHOP, 0, -1));
$cookie_path = $cookie_url_array['path'];
setcookie("email_address", "", time() - 3600, $cookie_path);
setcookie("password", "", time() - 3600, $cookie_path);

unset($_SESSION['customer_id']);
unset($_SESSION['customer_wishlist_link_id']);
unset($_SESSION['customer_default_address_id']);
unset($_SESSION['customer_gender']);
unset($_SESSION['customer_first_name']);
unset($_SESSION['customer_lastname']);
unset($_SESSION['customer_country_id']);
unset($_SESSION['customer_zone_id']);
unset($_SESSION['comments']);
unset($_SESSION['customer_max_order']);
unset($_SESSION['gv_id']);
unset($_SESSION['cc_id']);
unset($_SESSION['man_key']);

unset($_SESSION['sendto']);
unset($_SESSION['billto']);
unset($_SESSION['shipping']);
unset($_SESSION['payment']);
unset($_SESSION['comments']);

if (ACCOUNT_VAT_ID == '1') {
    $_SESSION['customers_vat_id_status'] = 0;
}
unset( $_SESSION['tax_excl']);

$_SESSION['cart']->reset();
$_SESSION['member']->default_member();

$aOption['template_main'] = $sTheme . '/system/success.html';
$aOption['page_heading'] = $sTheme . '/heading/success_page_heading.html';

$nPageType = OOS_PAGE_TYPE_MAINPAGE;

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
          'oos_heading_title' => $aLang['heading_title'],
          'oos_heading_image' => 'man_on_board.gif'
      )
);

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

