<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   Newsletter Module
   P&G developmment

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/newsletters_subscription_center.php';

if ( (isset($_POST['action']) && ($_POST['action'] == 'process')) && (isset($_SESSION['formid']) && ($_SESSION['formid'] == $_POST['formid'])) ) {

    $email_address = oos_prepare_input($_POST['email_address']);

    if ( empty( $email_address ) || !is_string( $email_address ) ) {
         MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
    }

    $customerstable = $oostable['customers'];
    $sql = "SELECT customers_firstname, customers_lastname, customers_id
            FROM $customerstable
            WHERE customers_email_address = '" . oos_db_input($email_address) . "'";
    $check_customer_result = $dbconn->Execute($sql);
    if ($check_customer_result->RecordCount()) {
        $check_customer = $check_customer_result->fields;

        $customerstable = $oostable['customers'];
        $dbconn->Execute("UPDATE $customerstable
                      SET customers_newsletter = '0'
                      WHERE customers_id = '" . $check_customer['customers_id'] . "'");
        MyOOS_CoreApi::redirect(oos_href_link($aPages['newsletters_unsubscribe_success']));
    } else {
        $maillisttable = $oostable['maillist'];
        $sql = "SELECT customers_firstname
                FROM $maillisttable
                WHERE customers_email_address = '" . oos_db_input($email_address) . "'";
        $check_mail_customer_result = $dbconn->Execute($sql);
        if ($check_mail_customer_result->RecordCount()) {
           $maillisttable = $oostable['maillist'];
           $dbconn->Execute("UPDATE $maillisttable
                             SET customers_newsletter = '0'
                             WHERE customers_email_address = '" . oos_db_input($email_address) . "'");
           MyOOS_CoreApi::redirect(oos_href_link($aPages['newsletters_unsubscribe_success']));
        }
    }
    MyOOS_CoreApi::redirect(oos_href_link($aPages['subscription_center'], 'email=nonexistent', 'SSL'));
} else {

    $oBreadcrumb->add($aLang['navbar_title']);

    $aOption['template_main'] = $sTheme . '/modules/subscription_center.html';
    $aOption['page_heading'] = $sTheme . '/heading/page_heading.html';

    $nPageType = OOS_PAGE_TYPE_SERVICE;

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
            'oos_heading_image' => 'password_forgotten.gif'
        )
    );

    $oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
    $oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

    // display the template
    require 'includes/oos_display.php';
}
