<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: login_admin.php
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ----------------------------------------------------------------------
   P&G Shipping Module Version 0.1 12/03/2002
   osCommerce Shipping Management Module
   Copyright (c) 2002  - Oliver Baelde
   http://www.francecontacts.com
   dev@francecontacts.com
   - eCommerce Solutions development and integration -

   osCommerce, Open Source E-Commerce Solutions
   Copyright (c) 2002 osCommerce
   http://www.oscommerce.com

   IMPORTANT NOTE:
   This script is not part of the official osCommerce distribution
   but an add-on contributed to the osCommerce community. Please
   read the README and  INSTALL documents that are provided
   with this file for further information and installation notes.

   LICENSE:
   This program is free software; you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation; either version 2 of the License, or
   (at your option) any later version.
   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.
   You should have received a copy of the GNU General Public License
   along with this program; if not, write to the Free Software
   Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

   All contributions are gladly accepted though Paypal.
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

require 'includes/languages/' . $sLanguage . '/admin_login.php';

$_SESSION['navigation']->remove_current_page();

if (isset($_SESSION['customer_id'])) {
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

    $_SESSION['cart']->reset();

    $_SESSION['member']->default_member();
}

if (isset($_POST)) {
    $email_address = oos_prepare_input($_POST['email_address']);
    $verif_key = oos_prepare_input($_POST['verif_key']);
}


if ( (isset($_POST['action']) && ($_POST['action'] == 'login_process')) && (isset($_SESSION['formid']) && ($_SESSION['formid'] == $_POST['formid'])) ) {
    $email_addressb = oos_prepare_input($_POST['email_addressa']);
    $keya = oos_prepare_input($_POST['keya']);
    $keyb = oos_prepare_input($_POST['keyb']);

    if ( empty( $keya ) || !is_string( $keya ) ) {
        MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
    }
    if ( empty( $keyb ) || !is_string( $keyb ) ) {
        MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
    }

    $manual_infotable = $oostable['manual_info'];
    $sql = "SELECT man_name, defined
            FROM $manual_infotable
            WHERE man_key = '" . oos_db_input($keya) . "'
              AND man_key2 = '" . oos_db_input($keyb) . "'
              AND status = '1'";
    $login_result = $dbconn->Execute($sql);

    if (!$login_result->RecordCount()) {
        $manual_infotable = $oostable['manual_info'];
        $dbconn->Execute("UPDATE $manual_infotable
                          SET man_key = '',
                              man_key2 = '',
                          WHERE man_info_id = '1'");
        MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
    }

    // Check if email exists
    $customerstable = $oostable['customers'];
    $sql = "SELECT customers_id, customers_gender, customers_firstname, customers_lastname,
                   customers_password, customers_wishlist_link_id, customers_vat_id_status,
                   customers_email_address, customers_default_address_id, customers_max_order
            FROM $customerstable
            WHERE customers_login = '1'
              AND customers_email_address = '" . oos_db_input($email_addressb) . "'";
    $check_customer_result = $dbconn->Execute($sql);

    if (!$check_customer_result->RecordCount()) {
        $_GET['login'] = 'fail';
        $dbconn->Execute("UPDATE " . $oostable['manual_info'] . "
                          SET man_key2  = ''
                          WHERE where man_info_id = '1'");
    } else {
        $check_customer = $check_customer_result->fields;
        $login_result_values = $login_result->fields;

        // Check that status is 1 and
        $address_booktable = $oostable['address_book'];
        $sql = "SELECT entry_country_id, entry_zone_id
                FROM $address_booktable
                WHERE customers_id = '" . $check_customer['customers_id'] . "'
                  AND address_book_id = '1'";
        $check_country = $dbconn->GetRow($sql);

        $_SESSION['customer_wishlist_link_id'] = $check_customer['customers_wishlist_link_id'];
        $_SESSION['customer_id'] = $check_customer['customers_id'];
        $_SESSION['customer_default_address_id'] = $check_customer['customers_default_address_id'];
        if (ACCOUNT_GENDER == '1') $_SESSION['customer_gender'] = $check_customer['customers_gender'];
        $_SESSION['customer_first_name'] = $check_customer['customers_firstname'];
        $_SESSION['customer_lastname'] = $check_customer['customers_lastname'];
        $_SESSION['customer_max_order'] = $check_customer['customers_max_order'];
        $_SESSION['customer_country_id'] = $check_country['entry_country_id'];
        $_SESSION['customer_zone_id'] = $check_country['entry_zone_id'];
        if (ACCOUNT_VAT_ID == '1') $_SESSION['customers_vat_id_status'] = $check_customer['customers_vat_id_status'];

        $_SESSION['man_key'] = $keya;
        $_SESSION['member']->restore_group();

// restore cart contents
        $_SESSION['cart']->restore_contents();
        MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));

    }
}

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title'], oos_href_link($aPages['login'], '', 'SSL'), bookmark);

$info_message = '';
if (isset($_GET['login']) && ($_GET['login'] == 'fail')) {
    $info_message = $aLang['text_login_error'];
} if ($_GET['login'] == 'fail2') {
    $info_message = $aLang['text_login_error2'];
} elseif ($_SESSION['cart']->count_contents()) {
    $info_message = $aLang['text_visitors_cart'];
}

$aOption['template_main'] = $sTheme . '/modules/login_admin.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['breadcrumb'] = 'default/system/breadcrumb.html';

$nPageType = OOS_PAGE_TYPE_SERVICE;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}


// assign Smarty variables;
$oSmarty->assign(
      array('oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
            'oos_heading_title' => $aLang['heading_title'],
            'oos_heading_image' => 'login.gif',

            'info_message'      => $info_message
      )
);


// JavaScript
$oSmarty->assign('popup_window', 'popup_window.js');

if (isset($_GET['action']) && ($_GET['action'] == 'login_admin')) {
    require 'includes/modules/key_generate.php';

    $manual_infotable = $oostable['manual_info'];
    $login_query = "SELECT man_key2, man_key3, status FROM $manual_infotable WHERE man_key = '" . oos_db_input($verif_key) . "' AND status = '1'";
    $login_result_values = $dbconn->GetRow($login_query);

    $oSmarty->assign(
        array('newkey2'             => $newkey2,
              'email_address'       => $email_address,
              'verif_key'           => $verif_key,
              'login_result_values' => $login_result_values
       )
    );
}

$oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';
