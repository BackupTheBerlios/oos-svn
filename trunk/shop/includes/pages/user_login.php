<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: login.php,v 1.75 2003/02/13 03:01:49 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce

   Max Order - 2003/04/27 JOHNSON - Copyright (c) 2003 Matti Ressler - mattifinn@optusnet.com.au
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
require 'includes/languages/' . $sLanguage . '/user_login.php';


if ( (isset($_POST['action']) && ($_POST['action'] == 'process')) && (isset($_SESSION['formid']) && ($_SESSION['formid'] == $_POST['formid'])) ) {

    $email_address = oos_prepare_input($_POST['email_address']);
    $password = oos_prepare_input($_POST['password']);

    if ( empty( $email_address ) || !is_string( $email_address ) ) {
         MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
    }

    // Check if email exists
    $customerstable = $oostable['customers'];
    $sql = "SELECT customers_id, customers_gender, customers_firstname, customers_lastname,
                   customers_password, customers_wishlist_link_id, customers_language,
                   customers_vat_id_status, customers_email_address, customers_default_address_id,
                   customers_max_order
            FROM $customerstable
            WHERE customers_login = '1'
              AND customers_email_address = '" . oos_db_input($email_address) . "'";
    $check_customer_result = $dbconn->Execute($sql);

    if (!$check_customer_result->RecordCount()) {
        $_GET['login'] = 'fail';
    } else {
        $check_customer = $check_customer_result->fields;

        // Check that password is good
        if (!oos_validate_password($password, $check_customer['customers_password'])) {
            $_GET['login'] = 'fail';
        } else {
            $address_booktable = $oostable['address_book'];
            $sql = "SELECT entry_country_id, entry_zone_id
                    FROM $address_booktable
                    WHERE customers_id = '" . $check_customer['customers_id'] . "'
                      AND address_book_id = '1'";
            $check_country = $dbconn->GetRow($sql);

            if ($check_customer['customers_language'] == '') {
                $customerstable = $oostable['customers'];
                $dbconn->Execute("UPDATE $customerstable
                                  SET customers_language = '" . oos_db_input($sLanguage) . "'
                                  WHERE customers_id = '" . intval($check_customer['customers_id']) . "'");
            }


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

            if (isset($_SESSION['tax_excl']) && ($_SESSION['tax_excl'] == 1)) {
               $_SESSION['tax_excl'] = 0;
            }

            $_SESSION['member']->restore_group();

            $cookie_url_array = parse_url((ENABLE_SSL == true ? OOS_HTTPS_SERVER : OOS_HTTP_SERVER) . substr(OOS_SHOP, 0, -1));
            $cookie_path = $cookie_url_array['path'];

            if ((!$oEvent->installed_plugin('autologon')) || ($_POST['remember_me'] == '')) {
                setcookie("email_address", "", time() - 3600, $cookie_path);   // Delete email_address cookie
                setcookie("password", "", time() - 3600, $cookie_path);	 // Delete password cookie
            } else {
               setcookie('email_address', $email_address, time()+ (365 * 24 * 3600), $cookie_path, '', ((getenv('HTTPS') == 'on') ? 1 : 0));
               setcookie('password', $check_customer['customers_password'], time()+ (365 * 24 * 3600), $cookie_path, '', ((getenv('HTTPS') == 'on') ? 1 : 0));
            }

            $customers_infotable = $oostable['customers_info'];
            $dbconn->Execute("UPDATE $customers_infotable
                              SET customers_info_date_of_last_logon = '" . date("Y-m-d H:i:s", time()) . "',
                                  customers_info_number_of_logons = customers_info_number_of_logons+1
                              WHERE customers_info_id = '" . intval($_SESSION['customer_id']) . "'");

            // restore cart contents
            $_SESSION['cart']->restore_contents();

            if (count($_SESSION['navigation']->snapshot) > 0) {
                $origin_href = oos_href_link($_SESSION['navigation']->snapshot['page'], $_SESSION['navigation']->snapshot['get'], $_SESSION['navigation']->snapshot['mode']);
                $_SESSION['navigation']->clear_snapshot();
                $_SESSION['navigation']->remove_last_page();
                MyOOS_CoreApi::redirect($origin_href);
            } else {
                MyOOS_CoreApi::redirect(oos_href_link($aPages['account'], '', 'SSL'));
            }
        }
    }
}

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title']);

$info_message = '';
if (isset($_GET['login']) && ($_GET['login'] == 'fail')) {
    $info_message = $aLang['text_login_error'];
} elseif ($_SESSION['cart']->count_contents()) {
    $info_message = $aLang['text_visitors_cart'];
}

$aOption['template_main'] = $sTheme . '/modules/user_login.html';
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
          'oos_heading_image' => 'login.gif',

          'popup_window' => 'popup_window.js',
          'info_message' => $info_message
      )
);

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

