<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: password_forgotten.php,v 1.48 2003/02/13 03:10:55 hpdl
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

require 'includes/languages/' . $sLanguage . '/user_password_forgotten.php';

if ( (isset($_POST['action']) && ($_POST['action'] == 'process')) && (isset($_SESSION['formid']) && ($_SESSION['formid'] == $_POST['formid'])) ) {

    $email_address = oos_prepare_input($_POST['email_address']);

    if ( empty( $email_address ) || !is_string( $email_address ) ) {
         MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
    }

    $customerstable = $oostable['customers'];
    $check_customer_sql = "SELECT customers_firstname, customers_lastname, customers_password, customers_id
                           FROM $customerstable
                           WHERE customers_email_address = '" . oos_db_input($email_address) . "'";
    $check_customer_result = $dbconn->Execute($check_customer_sql);

    if ($check_customer_result->RecordCount()) {
        $check_customer = $check_customer_result->fields;

        // Crypted password mods - create a new password, update the database and mail it to them
        $newpass = oos_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
        $crypted_password = oos_encrypt_password($newpass);

        $customerstable = $oostable['customers'];
        $dbconn->Execute("UPDATE $customerstable
                          SET customers_password = '" . oos_db_input($crypted_password) . "'
                          WHERE customers_id = '" . $check_customer['customers_id'] . "'");

        oos_mail($check_customer['customers_firstname'] . " " . $check_customer['customers_lastname'], $email_address, $aLang['email_password_reminder_subject'], nl2br(sprintf($aLang['email_password_reminder_body'], $newpass)), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

        $_SESSION['info_message'] = $aLang['text_password_sent'];
        MyOOS_CoreApi::redirect(oos_href_link($aPages['login'], '', 'SSL', true, false));
    } else {
        MyOOS_CoreApi::redirect(oos_href_link($aPages['password_forgotten'], 'email=nonexistent', 'SSL'));
    }
} else {

    // links breadcrumb
    $oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aPages['login'], '', 'SSL'));
    $oBreadcrumb->add($aLang['navbar_title_2'], oos_href_link($aPages['password_forgotten'], '', 'SSL'), bookmark);

    $aOption['template_main'] = $sTheme . '/modules/user_password_forgotten.html';
    $aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
    $aOption['breadcrumb'] = 'default/system/breadcrumb.html';

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

    $oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
    $oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
    $oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

    // display the template
    require 'includes/oos_display.php';
}

