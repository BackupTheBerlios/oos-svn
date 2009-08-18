<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: account_edit.php,v 1.62 2003/02/13 01:58:23 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}

if ( !isset( $_SESSION['customer_id'] ) || !is_numeric( $_SESSION['customer_id'] )) {
    $_SESSION['navigation']->set_snapshot();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['login'], '', 'SSL'));
}

require 'includes/languages/' . $sLanguage . '/user_account_edit.php';

$customerstable = $oostable['customers'];
$address_bookstable = $oostable['address_book'];
$sql = "SELECT c.customers_gender, c.customers_firstname, c.customers_lastname,
               c.customers_dob, c.customers_number, c.customers_email_address,
               c.customers_vat_id, c.customers_vat_id_status, c.customers_telephone, c.customers_fax, c.customers_newsletter,
               a.entry_company, a.entry_owner, a.entry_street_address, a.entry_suburb,
               a.entry_postcode, a.entry_city, a.entry_zone_id, a.entry_state, a.entry_country_id
        FROM $customerstable c,
             $address_bookstable a
        WHERE c.customers_id = '" . intval($_SESSION['customer_id']) . "'
          AND a.customers_id = c.customers_id
          AND a.address_book_id = '" . intval($_SESSION['customer_default_address_id']) . "'";
$account = $dbconn->GetRow($sql);

$email_address = $account['customers_email_address'];
$number = $account['customers_number'];

$no_edit = true;
$show_password = true;

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aPages['account'], '', 'SSL'));
$oBreadcrumb->add($aLang['navbar_title_2'], oos_href_link($aPages['account_edit'], '', 'SSL'), bookmark);

ob_start();
require 'js/form_check.js.php';
$javascript = ob_get_contents();
ob_end_clean();

$aOption['template_main'] = $sTheme . '/modules/user_account_edit.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['breadcrumb'] = 'default/system/breadcrumb.html';

$nPageType = OOS_PAGE_TYPE_ACCOUNT;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

// assign Smarty variables;
$oSmarty->assign(
      array(
          'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
          'oos_heading_title' => $aLang['heading_title'],
          'oos_heading_image' => 'account.gif',

          'account'           => $account,
          'email_address'     => $email_address,
          'show_password'     => $show_password

      )
);

// JavaScript
$oSmarty->assign('oos_js', $javascript);

$oSmarty->assign('newsletter_ids', array(0,1));
$oSmarty->assign('newsletter', array($aLang['entry_newsletter_no'],$aLang['entry_newsletter_yes']));

$oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

