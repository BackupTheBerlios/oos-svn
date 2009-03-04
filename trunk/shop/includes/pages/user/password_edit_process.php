<?php
/* ----------------------------------------------------------------------
   $Id: password_edit_process.php,v 1.4 2007/10/27 16:40:16 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

  if (!isset($_SESSION['customer_id'])) {
    $_SESSION['navigation']->set_snapshot(array('mode' => 'SSL', 'modules' => $aModules['user'], 'file' => $aFilename['password_edit']));
    oos_redirect(oos_href_link($aModules['user'], $aFilename['login'], '', 'SSL'));
  }

  if (!isset($_POST['action']) || ($_POST['action'] != 'process')) {
    oos_redirect(oos_href_link($aModules['user'], $aFilename['password_edit'], '', 'SSL'));
  }

  require 'includes/languages/' . $sLanguage . '/user_password_edit_process.php';

  $firstname = oos_db_prepare_input($_POST['firstname']);
  $lastname = oos_db_prepare_input($_POST['lastname']);

  $error = false; // reset error flag

  if (ACCOUNT_GENDER == 'true') {
    if ( ($gender == 'm') || ($gender == 'f') ) {
      $gender_error = false;
    } else {
      $error = true;
      $gender_error = 'true';
    }
  }

  if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
    $error = true;
    $firstname_error = 'true';
  } else {
    $firstname_error = false;
  }

  if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
    $error = true;
    $lastname_error = 'true';
  } else {
    $lastname_error = false;
  }

  if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
    $error = true;
    $email_address_error = 'true';
  } else {
    $email_address_error = false;
  }

  if (!oos_validate_is_email($email_address)) {
    $error = true;
    $email_address_check_error = 'true';
  } else {
    $email_address_check_error = false;
  }


  if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
    $error = true;
    $password_error = 'true';
  } else {
    $password_error = false;
  }

  if ($password != $confirmation) {
    $error = true;
    $password_error = 'true';
  }

  $customerstable = $oostable['customers'];
  $check_email_sql = "SELECT COUNT(*) AS total
                      FROM $customerstable
                      WHERE customers_email_address = '" . oos_db_input($email_address) . "'
                        AND customers_id != '" . intval($_SESSION['customer_id']) . "'";
  $check_email = $dbconn->Execute($check_email_sql);
  if ($check_email->fields['total'] > 0) {
    $error = true;
    $email_address_exists = 'true';
  } else {
    $email_address_exists = false;
  }

  if ($error == true) {
    $_SESSION['navigation']->remove_current_page();

    $processed = true;
    $no_edit = true;
    $show_password = 'true';

    // links breadcrumb
    $oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aModules['user'], $aFilename['account'], '', 'SSL'));
    $oBreadcrumb->add($aLang['navbar_title_2'], oos_href_link($aModules['user'], $aFilename['password_edit'], '', 'SSL'));

    ob_start();
    require 'js/form_check.js.php';
    $javascript = ob_get_contents();
    ob_end_clean();

    $aOption['template_main'] = $sTheme . '/modules/user_password_edit_process.html';
    $aOption['page_heading'] = $sTheme . '/heading/page_heading.html';

    $nPageType = OOS_PAGE_TYPE_ACCOUNT;

    require 'includes/oos_system.php';
    if (!isset($option)) {
      require 'includes/info_message.php';
      require 'includes/oos_blocks.php';
      require 'includes/oos_counter.php';
    }

    // JavaScript
    $oSmarty->assign('oos_js', $javascript);

    $oSmarty->assign(
        array(
            'error'                     => $error,
            'gender_error'              => $gender_error,
            'firstname_error'           => $firstname_error,
            'lastname_error'            => $lastname_error,
            'email_address_error'       => $email_address_error,
            'email_address_check_error' => $email_address_check_error,
            'email_address_exists'      => $email_address_exists,
            'password_error'            => $password_error,

            'gender'            => $gender,
            'firstname'         => $firstname,
            'lastname'          => $lastname,
            'password'          => $password,
            'confirmation'      => $confirmation,

            'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
            'oos_heading_title' => $aLang['heading_title'],
            'oos_heading_image' => 'account.gif',

            'email_address'     => $email_address,
            'show_password'     => $show_password

        )
    );

    $oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
    $oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

    // display the template
    require 'includes/oos_display.php';
  } else {
    $new_encrypted_password = oos_encrypt_password($password);
    $sql_data_array = array('customers_firstname' => $firstname,
                            'customers_lastname' => $lastname,
                            'customers_email_address' => $email_address,
                            'customers_password' => $new_encrypted_password);

    if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;

    oos_db_perform($oostable['customers'], $sql_data_array, 'update', "customers_id = '" . intval($_SESSION['customer_id']) . "'");

    if (oos_is_not_null($_COOKIE['password'])) {
      $cookie_url_array = parse_url((ENABLE_SSL == true ? OOS_HTTPS_SERVER : OOS_HTTP_SERVER) . substr(OOS_SHOP, 0, -1));
      $cookie_path = $cookie_url_array['path'];
      setcookie('email_address', $email_address, time()+ (365 * 24 * 3600), $cookie_path, '', ((getenv('HTTPS') == 'on') ? 1 : 0));
      setcookie('password', $new_encrypted_password, time()+ (365 * 24 * 3600), $cookie_path, '', ((getenv('HTTPS') == 'on') ? 1 : 0));
    }

    $update_info_sql = "UPDATE " . $oostable['customers_info'] . " 
                        SET customers_info_date_account_last_modified = now() 
                        WHERE customers_info_id = '" . intval($_SESSION['customer_id']) . "'";
    $dbconn->Execute($update_info_sql);


    if (SEND_CUSTOMER_EDIT_EMAILS == 'true') {
      $email_owner = $aLang['owner_email_subject'] . "\n" . 
                     $aLang['email_separator'] . "\n" . 
                     $aLang['owner_email_date'] . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n" .
                     $aLang['email_separator'] . "\n";
      if (ACCOUNT_NUMBER == 'true') {
        $email_owner .= $aLang['owner_email_number'] . ' ' . $number . "\n" .
                        $aLang['email_separator'] . "\n\n";
      }

      if (ACCOUNT_GENDER == 'true') {
        if ($gender == 'm') {
          $email_owner .= $aLang['entry_gender'] . ' ' . $aLang['male'] . "\n";
        } else {
          $email_owner .= $aLang['entry_gender'] . ' ' . $aLang['female'] . "\n";
        }
      }

      $email_owner .= $aLang['owner_email_first_name'] . ' ' . $firstname . "\n" .
                      $aLang['owner_email_last_name'] . ' ' . $lastname . "\n\n" .
                      $aLang['email_separator'] . "\n\n" .
                      $aLang['owner_email_contact'] . "\n" .
                      $aLang['owner_email_address'] . ' ' . $email_address . "\n" .
                      $aLang['email_separator'] . "\n\n" .
                      $aLang['owner_email_options'] . "\n";

      oos_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $aLang['owner_email_subject'], nl2br($email_owner), $name, $email_address);
    }

    oos_redirect(oos_href_link($aModules['user'], $aFilename['account'], '', 'SSL'));
  }
?>
