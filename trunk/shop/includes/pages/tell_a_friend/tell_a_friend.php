<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: tell_a_friend.php,v 1.36 2003/02/17 07:55:10 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if (isset($_SESSION['customer_id'])) {
    $customerstable = $oostable['customers'];
    $sql = "SELECT customers_firstname, customers_lastname, customers_email_address
            FROM $customerstable
            WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'";
    $account = $dbconn->Execute($sql);
    $account_values = $account->fields;
} elseif (ALLOW_GUEST_TO_TELL_A_FRIEND == '0') {
    $_SESSION['navigation']->set_snapshot();
    MyOOS_CoreApi::redirect(oos_href_link($aModules['user'], $aFilename['login'], '', 'SSL'));
}

require 'includes/languages/' . $sLanguage . '/tell_a_friend_tell_a_friend.php';

$action = '';
if (isset($_GET['action']) && ($_GET['action'] == 'process')) {
    $action = 'process';
}

$valid_product = false;
if (isset($_GET['products_id'])) {
    if (!isset($nProductsId)) $nProductsId = oos_get_product_id($_GET['products_id']);
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $sql = "SELECT pd.products_name
            FROM $productstable p,
                 $products_descriptiontable pd
            WHERE p.products_status >= '1'
              AND p.products_id = '" . intval($nProductsId) . "'
              AND p.products_id = pd.products_id
              AND pd.products_languages_id = '" . intval($nLanguageID) . "'";
    $product_info_result = $dbconn->Execute($sql);
    $valid_product = ($product_info_result->RecordCount() > 0);
}

if ($valid_product != false) {
    $product_info = $product_info_result->fields;
    $error = '0';
    $friendemail_error = '0';

    $friendname = oos_prepare_input($_POST['friendname']);
    $friendemail = oos_prepare_input($_POST['friendemail']);
    $yourname = oos_prepare_input($_POST['yourname']);
    $from = oos_prepare_input($_POST['from']);
    $yourmessage = oos_prepare_input($_POST['yourmessage']);


    if (isset($_GET['action']) && ($_GET['action'] == 'process') && !oos_validate_is_email(trim($friendemail))) {
        $friendemail_error = '1';
        $error = '1';
    }

    if (isset($_GET['action']) && ($_GET['action'] == 'process') && empty($friendname)) {
        $friendname_error = '1';
        $error = '1';
    }

    if (isset($_SESSION['customer_id'])) {
        $from_name = $account_values['customers_firstname'] . ' ' . $account_values['customers_lastname'];
        $from_email_address = $account_values['customers_email_address'];
    } else {
        $from_name = $yourname;
        $from_email_address = $from;
    }

    if (!isset($_SESSION['customer_id'])) {
        if (isset($_GET['action']) && ($_GET['action'] == 'process') && !oos_validate_is_email(trim($from_email_address))) {
            $fromemail_error = '1';
            $error = '1';
        }
    }

    if (isset($_GET['action']) && ($_GET['action'] == 'process') && empty($from_name)) {
        $fromname_error = '1';
        $error = '1';
    }

    if (isset($_GET['action']) && ($_GET['action'] == 'process') && ($error == '0') && (isset($_SESSION['formid']) && ($_SESSION['formid'] == $_POST['formid'])) ) {

        $email_subject = sprintf($aLang['text_email_subject'], $from_name, STORE_NAME);
        $email_body = sprintf($aLang['text_email_intro'], $friendname, $from_name, $products_name, STORE_NAME) . "\n\n";

        if (!empty($_POST['yourmessage'])) {
            $email_body .= oos_prepare_input($_POST['yourname']) . "\n\n";
        }

        $email_body .= sprintf($aLang['text_email_link'], oos_href_link($aModules['products'], $aFilename['product_info'], 'products_id=' . $_GET['products_id'])) . "\n\n" .
        sprintf($aLang['text_email_signature'], STORE_NAME . "\n" . OOS_HTTP_SERVER . OOS_SHOP . "\n");

        oos_mail($friendname, $friendemail, $email_subject, stripslashes($email_body), '', $from_email_address);
    } else {
        if (isset($_SESSION['customer_id'])) {
            $your_name_prompt = $account_values['customers_firstname'] . ' ' . $account_values['customers_lastname'];
            $your_email_address_prompt = $account_values['customers_email_address'];
        } else {
            $your_name_prompt = oos_draw_input_field('yourname', (($fromname_error == '1') ? $yourname : $_GET['yourname']));
            if ($fromname_error == '1') $your_name_prompt .= '&nbsp;<span class="errorText">' . $aLang['text_required'] . '</span>';
            $your_email_address_prompt = oos_draw_input_field('from', (($fromemail_error == '1') ? $from : $_GET['from']));
            if ($fromemail_error == '1') $your_email_address_prompt .= $aLang['entry_email_address_check_error'];
        }
    }
}

if (isset($_GET['send_to'])) {
   if (oos_validate_is_email(trim($_GET['send_to']))) {
       $friendemail = oos_var_prep_for_os($_GET['send_to']);
   }
}

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title'], oos_href_link($aModules['tell_a_friend'], $aFilename['tell_a_friend'], 'send_to=' . $friendemail . '&amp;products_id=' . $_GET['products_id']));

$aOption['template_main'] = $sTheme . '/modules/tell_a_friend.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['breadcrumb'] = 'default/system/breadcrumb.html';

$nPageType = OOS_PAGE_TYPE_PRODUCTS;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

// assign Smarty variables;
$oSmarty->assign(
      array(
          'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
          'oos_heading_title' => sprintf($aLang['heading_title'], $product_info['products_name']),
          'oos_heading_image' => 'specials.gif',

          'valid_product'             => $valid_product,
          'product_info'              => $product_info,
          'action'                    => $action,
          'your_name_prompt'          => $your_name_prompt,
          'your_email_address_prompt' => $your_email_address_prompt,
          'friendname'                => $friendname,
          'friendemail'               => $friendemail,
          'yourmessage'               => $yourmessage,
          'oos_friendemail'           => sprintf($aLang['text_email_successful_sent'], stripslashes($products_name), $friendemail),

          'error'             => $error,
          'friendemail_error' => $friendemail_error,
          'friendname_error'  => $friendname_error,
          'fromemail_error'   => $fromemail_error,
          'fromname_error'    => $fromname_error
      )
);

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

