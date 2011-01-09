<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: create_account_admin.php
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

// DO NOT RUN THIS SCRIPT STANDALONE
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

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


if (isset($_POST['verif_key'])) {
    $verif_key = oos_prepare_input($_POST['verif_key']);
}

require 'includes/modules/key_generate.php';

if ( empty( $verif_key ) || !is_string( $verif_key ) ) {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
}

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/admin_create_account.php';

$manual_infotable = $oostable['manual_info'];
$login_result = $dbconn->Execute("SELECT man_key2, man_key3, status FROM $manual_infotable WHERE man_key = '" . oos_db_input($verif_key) . "' AND status = 1 ");

if (!$login_result->RecordCount()) {
    $manual_infotable = $oostable['manual_info'];
    $dbconn->Execute("UPDATE $manual_infotable SET man_key = '', man_key2 = '' WHERE man_info_id = '1' ");
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
}

if (!isset($_GET['action']) && ($_GET['action'] != 'login_admin')) {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
} else {
    $login_result_values = $login_result->fields;

    if (($login_result_values['man_key2'] = $newkey2) && ($login_result_values['status'] !=0))  {

        // links breadcrumb
        $oBreadcrumb->add($aLang['navbar_title']);

        ob_start();
        require 'js/form_check.js.php';
        $javascript = ob_get_contents();
        ob_end_clean();

        if (isset($_GET['email_address'])) {
            $email_address = oos_db_prepare_input($_GET['email_address']);
        }
        $account['entry_country_id'] = STORE_COUNTRY;

        $aOption['template_main'] = $sTheme . '/modules/create_account_admin.html';
        $aOption['page_heading'] = $sTheme . '/heading/page_heading.html';

        $nPageType = OOS_PAGE_TYPE_SERVICE;
        $read = '0';

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
                'oos_heading_image' => 'account.gif',

                'oos_js'            => $javascript,
                'read'              => $read,

                'account'           => $account,
                'email_address'     => $email_address,
                'show_password'     => $show_password,
                'snapshot'          => $snapshot,
                'verif_key'         => $verif_key,
                'newkey2'           => $newkey2
            )
        );

        $oSmarty->assign('newsletter_ids', array(0,1));
        $oSmarty->assign('newsletter', array($aLang['entry_newsletter_no'],$aLang['entry_newsletter_yes']));

        $oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
        $oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

        // display the template
        require 'includes/oos_display.php';
    }
}
