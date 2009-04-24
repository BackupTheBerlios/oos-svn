<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: create_account_process.php,v 1.1.2.4 2003/05/02 22:23:01 wilt
   orig: create_account_process.php,v 1.85 2003/02/13 04:23:23 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if ( (!isset($_POST['action']) || ($_POST['action'] != 'process'))  || (isset($_SESSION['formid']) && ($_SESSION['formid'] != $_POST['formid'])) ) {
    MyOOS_CoreApi::redirect(oos_href_link($aModules['user'], $aFilename['create_account']));
}

MyOOS_CoreApi::requireOnce('functions/function_coupon.php');

require 'includes/languages/' . $sLanguage . '/user_create_account_process.php';
require 'includes/functions/function_validate_vatid.php';

if (ACCOUNT_GENDER == '1') $gender = oos_prepare_input($_POST['gender']);
$firstname = oos_db_prepare_input($_POST['firstname']);
$lastname = oos_db_prepare_input($_POST['lastname']);

if (ACCOUNT_DOB == '1') $dob = oos_prepare_input($_POST['dob']);
if (ACCOUNT_NUMBER == '1') $number = oos_prepare_input($_POST['number']);
$email_address = oos_prepare_input($_POST['email_address']);

if (ACCOUNT_COMPANY == '1') $company = oos_prepare_input($_POST['company']);
if (ACCOUNT_OWNER == '1') $owner = oos_prepare_input($_POST['owner']);
if (ACCOUNT_VAT_ID == '1') $vat_id = oos_prepare_input($_POST['vat_id']);

$street_address = oos_prepare_input($_POST['street_address']);
if (ACCOUNT_SUBURB == '1') $suburb = oos_prepare_input($_POST['suburb']);
$postcode = oos_prepare_input($_POST['postcode']);
$city = oos_prepare_input($_POST['city']);
if (ACCOUNT_STATE == '1') $state = oos_prepare_input($_POST['state']);
$country = oos_prepare_input($_POST['country']);

$telephone = oos_prepare_input($_POST['telephone']);
$fax = oos_prepare_input($_POST['fax']);

$newsletter = oos_prepare_input($_POST['newsletter']);

$password = oos_prepare_input($_POST['password']);
$confirmation = oos_prepare_input($_POST['confirmation']);


$bError = false; // reset error flag

if (ACCOUNT_GENDER == '1') {
    if (($gender == 'm') || ($gender == 'f')) {
        $gender_error = false;
    } else {
        $bError = true;
        $gender_error = '1';
    }
}

if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
    $bError = true;
    $firstname_error = '1';
}

if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
    $bError = true;
    $lastname_error = '1';
}

if (ACCOUNT_DOB == '1') {
    if (checkdate(substr(oos_date_raw($dob), 4, 2), substr(oos_date_raw($dob), 6, 2), substr(oos_date_raw($dob), 0, 4))) {
      $date_of_birth_error = false;
    } else {
      $bError = true;
      $date_of_birth_error = '1';
    }
}

if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
    $bError = true;
    $email_address_error = '1';
}

if (!oos_validate_is_email($email_address)) {
    $bError = true;
    $email_address_check_error = '1';
}

if ((ACCOUNT_VAT_ID == '1') && (ACCOUNT_COMPANY_VAT_ID_CHECK == '1') && oos_is_not_null($vat_id)) {
    if (!oos_validate_is_vatid($vat_id)) {
        $bError = true;
        $vatid_check_error = '1';
    }
}

if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
    $bError = true;
    $street_address_error = '1';
}

if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
    $bError = true;
    $post_code_error = '1';
}

if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
    $bError = true;
    $city_error = '1';
}


if (isset($_POST['country']) && is_numeric($_POST['country']) && ($_POST['country'] >= 1)) {
    $country = intval($_POST['country']);
} else {
    $country = 0;
    $bError = true;
    $country_error = '1';
}

if (ACCOUNT_STATE == '1') {
    if ($entry_country_error) {
        $state_error = '1';
    } else {
        $zone_id = 0;
        $state_error = '0';

        $zonestable = $oostable['zones'];
        $country_check_sql = "SELECT COUNT(*) AS total
                              FROM $zonestable
                              WHERE zone_country_id = '" . intval($country) . "'";
        $country_check = $dbconn->Execute($country_check_sql);

        $entry_state_has_zones = ($country_check->fields['total'] > 0);

        if ($entry_state_has_zones === true) {
            $state_has_zones = '1';

            $zonestable = $oostable['zones'];
            $match_zone_sql = "SELECT zone_id
                               FROM $zonestable
                               WHERE zone_country_id = '" . intval($country) . "'
                                 AND zone_name = '" . oos_db_input($state) . "'";
            $match_zone_result = $dbconn->Execute($match_zone_sql);

            if ($match_zone_result->RecordCount() == 1) {
                $match_zone = $match_zone_result->fields;
                $zone_id = $match_zone['zone_id'];
            } else {
                $zonestable = $oostable['zones'];
                $match_zone_sql2 = "SELECT zone_id
                                    FROM $zonestable
                                    WHERE zone_country_id = '" . intval($country) . "'
                                      AND zone_code = '" . oos_db_input($state) . "'";
                $match_zone_result = $dbconn->Execute($match_zone_sql2);
                if ($match_zone_result->RecordCount() == 1) {
                    $match_zone = $match_zone_result->fields;
                    $zone_id = $match_zone['zone_id'];
                } else {
                    $bError = true;
                    $state_error = '1';
                }
            }
        } elseif (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
            $bError = true;
            $state_error = '1';
        }
    }
}


if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
    $bError = true;
    $telephone_error = '1';
}

if (CUSTOMER_NOT_LOGIN == '0') {
    if (MAKE_PASSWORD == '1') {
        $password = oos_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);
    } else {
        $passlen = strlen($password);
        if ($passlen < ENTRY_PASSWORD_MIN_LENGTH) {
            $bError = true;
            $password_error = '1';
        }

        if ($password != $confirmation) {
            $bError = true;
            $password_error = '1';
        }
    }
}

$customerstable = $oostable['customers'];
$check_email_sql = "SELECT customers_email_address
                    FROM $customerstable
                    WHERE customers_email_address = '" . oos_db_input($email_address) . "'";
$check_email = $dbconn->Execute($check_email_sql);

if ($check_email->RecordCount()) {
    $bError = true;
    $email_address_exists = '1';
}

if ($bError == true) {
    $_SESSION['navigation']->remove_current_page();

    $processed = true;
    if ((CUSTOMER_NOT_LOGIN == '1') or (MAKE_PASSWORD == '1')) {
        $show_password = false;
    } else {
        $show_password = '1';
    }

    // links breadcrumb
    $oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aModules['user'], $aFilename['create_account']));
    $oBreadcrumb->add($aLang['navbar_title_2']);

    ob_start();
    require 'js/form_check.js.php';
    $javascript = ob_get_contents();
    ob_end_clean();

    $aOption['template_main'] = $sTheme . '/modules/user_create_account_process.html';
    $aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
    $nPageType = OOS_PAGE_TYPE_ACCOUNT;

    require 'includes/oos_system.php';
    if (!isset($option)) {
        require 'includes/info_message.php';
        require 'includes/oos_blocks.php';
        require 'includes/oos_counter.php';
    }

    // assign Smarty variables;
    $oSmarty->assign('oos_js', $javascript);

    // assign Smarty variables;
    $oSmarty->assign(
        array(
            'gender_error'              => $gender_error,
            'firstname_error'           => $firstname_error,
            'lastname_error'            => $lastname_error,
            'date_of_birth_error'       => $date_of_birth_error,
            'email_address_error'       => $email_address_error,
            'email_address_check_error' => $email_address_check_error,
            'email_address_exists'      => $email_address_exists,
            'vatid_check_error'         => $vatid_check_error,
            'street_address_error'      => $street_address_error,
            'post_code_error'           => $post_code_error,
            'city_error'                => $city_error,
            'country_error'             => $country_error,
            'state_error'               => $state_error,
            'state_has_zones'           => $state_has_zones,
            'telephone_error'           => $telephone_error,
            'password_error'            => $password_error
         )
    );
    $oSmarty->assign(
        array(
            'gender'         => $gender,
            'firstname'      => $firstname,
            'lastname'       => $lastname,
            'dob'            => $dob,
            'number'         => $number,
            'email_address'  => $email_address,
            'company'        => $company,
            'owner'          => $owner,
            'vat_id'         => $vat_id,
            'street_address' => $street_address,
            'suburb'         => $suburb,
            'postcode'       => $postcode,
            'city'           => $city,
            'country'        => $country,
            'telephone'      => $telephone,
            'fax'            => $fax,
            'newsletter'     => $newsletter,
            'password'       => $password,
            'confirmation'   => $confirmation
        )
    );


    if ($state_has_zones == '1') {
        $zones_names = array();
        $zones_values = array();

        $zonestable = $oostable['zones'];
        $zones_result = $dbconn->Execute("SELECT zone_name FROM $zonestable WHERE zone_country_id = '" . intval($country) . "' ORDER BY zone_name");
        while ($zones = $zones_result->fields)
        {
            $zones_names[] =  $zones['zone_name'];
            $zones_values[] = $zones['zone_name'];
            $zones_result->MoveNext();
        }
        $oSmarty->assign('zones_names', $zones_names);
        $oSmarty->assign('zones_values', $zones_values);
    } else {
        $state = oos_get_zone_name($country, $zone_id, $state);
        $oSmarty->assign('state', $state);
        $oSmarty->assign('zone_id', $zone_id);
    }

    if (isset($_POST['country']) && is_numeric($_POST['country']) && ($_POST['country'] >= 1)) {
        $country_name = oos_get_country_name($country);
        $oSmarty->assign('country_name', $country_name);
    }

    if ($newsletter == '1') {
        $news = $aLang['entry_newsletter_yes'];
    } else {
        $news = $aLang['entry_newsletter_no'];
    }
    $oSmarty->assign('news', $news);

    $oSmarty->assign(
        array(
            'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
            'oos_heading_title' => $aLang['heading_title'],
            'oos_heading_image' => 'account.gif',

            'email_address'     => $email_address,
            'show_password'     => $show_password

        )
    );

    $oSmarty->assign('newsletter_ids', array(0,1));
    $oSmarty->assign('newsletter', array($aLang['entry_newsletter_no'],$aLang['entry_newsletter_yes']));

    $oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
    $oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

    // display the template
    require 'includes/oos_display.php';
} else {
    $customer_max_order = DEFAULT_MAX_ORDER;
    $customers_status = DEFAULT_CUSTOMERS_STATUS_ID;

    if (CUSTOMER_NOT_LOGIN == '1') {
        $customers_login = '0';
    } else {
        $customers_login = '1';
    }

    $time = mktime();
    $wishlist_link_id = '';
    for ($x=3;$x<10;$x++) {
        $wishlist_link_id .= substr($time,$x,1) . oos_create_random_value(1, $type = 'chars');
    }
    $sql_data_array = array('customers_firstname' => $firstname,
                            'customers_lastname' => $lastname,
                            'customers_email_address' => $email_address,
                            'customers_telephone' => $telephone,
                            'customers_fax' => $fax,
                            'customers_newsletter' => $newsletter,
                            'customers_status' => $customers_status,
                            'customers_login' => $customers_login,
                            'customers_language' => $sLanguage,
                            'customers_max_order' => $customer_max_order,
                            'customers_password' => oos_encrypt_password($password),
                            'customers_wishlist_link_id' => $wishlist_link_id,
                            'customers_default_address_id' => 1);

    if (ACCOUNT_GENDER == '1') $sql_data_array['customers_gender'] = $gender;
    if (ACCOUNT_NUMBER == '1') $sql_data_array['customers_number'] = $number;
    if (ACCOUNT_DOB == '1') $sql_data_array['customers_dob'] = oos_date_raw($dob);
    if (ACCOUNT_VAT_ID == '1') {
        $sql_data_array['customers_vat_id'] = $vat_id;
        if ((ACCOUNT_COMPANY_VAT_ID_CHECK == '1') && ($vatid_check_error === false) && ($country != STORE_COUNTRY)) {
            $sql_data_array['customers_vat_id_status'] = 1;
        } else {
            $sql_data_array['customers_vat_id_status'] = 0;
        }
    }
    oos_db_perform($oostable['customers'], $sql_data_array);

    $customer_id = $dbconn->Insert_ID();

    $sql_data_array = array('customers_id' => $customer_id,
                            'address_book_id' => 1,
                            'entry_firstname' => $firstname,
                            'entry_lastname' => $lastname,
                            'entry_street_address' => $street_address,
                            'entry_postcode' => $postcode,
                            'entry_city' => $city,
                            'entry_country_id' => $country);

    if (ACCOUNT_GENDER == '1') $sql_data_array['entry_gender'] = $gender;
    if (ACCOUNT_COMPANY == '1') $sql_data_array['entry_company'] = $company;
    if (ACCOUNT_OWNER == '1') $sql_data_array['entry_owner'] = $owner;
    if (ACCOUNT_SUBURB == '1') $sql_data_array['entry_suburb'] = $suburb;
    if (ACCOUNT_STATE == '1') {
        if ($zone_id > 0) {
            $sql_data_array['entry_zone_id'] = $zone_id;
            $sql_data_array['entry_state'] = '';
        } else {
            $sql_data_array['entry_zone_id'] = '0';
            $sql_data_array['entry_state'] = $state;
        }
    }

    oos_db_perform($oostable['address_book'], $sql_data_array);

    $customers_infotable = $oostable['customers_info'];
    $dbconn->Execute("INSERT INTO $customers_infotable
                (customers_info_id,
                 customers_info_number_of_logons,
                 customers_info_date_account_created) VALUES ('" . intval($customer_id) . "',
                                                              '0',
                                                              '" . date("Y-m-d H:i:s", time()) . "')");

    $maillisttable = $oostable['maillist'];
    $sql = "SELECT customers_firstname
            FROM $maillisttable
            WHERE customers_email_address = '" . oos_db_input($email_address) . "'";
    $check_mail_customer_result = $dbconn->Execute($sql);
    if ($check_mail_customer_result->RecordCount()) {
        $dbconn->Execute("UPDATE " . $oostable['maillist'] . "
                          SET customers_newsletter = '0'
                          WHERE customers_email_address = '" . oos_db_input($email_address) . "'");
    }

    if (CUSTOMER_NOT_LOGIN != '1') {
        $_SESSION['customer_id'] = $customer_id;
        if (ACCOUNT_GENDER == '1') $_SESSION['customer_gender'] = $gender;
        $_SESSION['customer_first_name'] = $firstname;
        $_SESSION['customer_lastname'] = $lastname;
        $_SESSION['customer_default_address_id'] = 1;
        $_SESSION['customer_country_id'] = $country;
        $_SESSION['customer_zone_id'] = $zone_id;
        $_SESSION['customer_wishlist_link_id'] = $wishlist_link_id;
        $_SESSION['customer_max_order'] = $customer_max_order;

        if (ACCOUNT_VAT_ID == '1') {
            if ((ACCOUNT_COMPANY_VAT_ID_CHECK == '1') && ($vatid_check_error === false)) {
                $_SESSION['customers_vat_id_status'] = 1;
            } else {
                $_SESSION['customers_vat_id_status'] = 0;
            }
        }

        // restore cart contents
        $_SESSION['cart']->restore_contents();

        $_SESSION['member']->restore_group();
    }

    // build the message content
    $name = $firstname . " " . $lastname;

    if (ACCOUNT_GENDER == '1') {
        if ($gender == 'm') {
            $email_text = $aLang['email_greet_mr'];
        } else {
            $email_text = $aLang['email_greet_ms'];
        }
    } else {
        $email_text = $aLang['email_greet_none'];
    }

    $email_text .= $aLang['email_welcome'];
    if (MODULE_ORDER_TOTAL_GV_STATUS == '1') {
        if (NEW_SIGNUP_GIFT_VOUCHER_AMOUNT > 0) {
            $coupon_code = oos_create_coupon_code();
            $couponstable = $oostable['coupons'];
            $insert_result = $dbconn->Execute("INSERT INTO $couponstable
                                              (coupon_code,
                                               coupon_type,
                                               coupon_amount,
                                               date_created) VALUES ('" . oos_db_input($coupon_code) . "',
                                                                     'G',
                                                                     '" . NEW_SIGNUP_GIFT_VOUCHER_AMOUNT . "',
                                                                     '" . date("Y-m-d H:i:s", time()) . "')");
            $insert_id = $dbconn->Insert_ID();
            $coupon_email_tracktable = $oostable['coupon_email_track'];
            $insert_result = $dbconn->Execute("INSERT INTO $coupon_email_tracktable
                                              (coupon_id,
                                               customer_id_sent,
                                               sent_firstname,
                                               emailed_to,
                                              date_sent) VALUES ('" . oos_db_input($insert_id) ."',
                                                                 '0',
                                                                 'Admin',
                                                                 '" . $email_address . "',
                                                                 '" . date("Y-m-d H:i:s", time()) . "' )");

            $email_text .= sprintf($aLang['email_gv_incentive_header'], $oCurrencies->format(NEW_SIGNUP_GIFT_VOUCHER_AMOUNT)) . "\n\n" .
                           sprintf($aLang['email_gv_redeem'], $coupon_code) . "\n\n" .
                           $aLang['email_gv_link'] . oos_href_link($aModules['gv'], $aFilename['gv_redeem'], 'gv_no=' . $coupon_code, 'NONSSL', false, false) .
                           "\n\n";
        }
        if (NEW_SIGNUP_DISCOUNT_COUPON != '') {
            $coupon_id = NEW_SIGNUP_DISCOUNT_COUPON;
            $couponstable = $oostable['coupons'];
            $sql = "SELECT *
                    FROM $couponstable
                    WHERE coupon_id = '" . oos_db_input($coupon_id) . "'";
            $coupon_result = $dbconn->Execute($sql);

            $coupons_descriptiontable = $oostable['coupons_description'];
            $sql = "SELECT *
                    FROM " . $coupons_descriptiontable . "
                    WHERE coupon_id = '" . oos_db_input($coupon_id) . "'
                      AND coupon_languages_id = '" .  intval($nLanguageID) . "'";
            $coupon_desc_result = $dbconn->Execute($sql);
            $coupon = $coupon_result->fields;
            $coupon_desc = $coupon_desc_result->fields;
            $coupon_email_tracktable = $oostable['coupon_email_track'];
            $insert_result = $dbconn->Execute("INSERT INTO $coupon_email_tracktable
                                               (coupon_id,
                                                customer_id_sent,
                                                sent_firstname,
                                                emailed_to,
                                                date_sent) VALUES ('" . oos_db_input($coupon_id) ."',
                                                                   '0',
                                                                   'Admin',
                                                                   '" . oos_db_input($email_address) . "',
                                                                   '" . date("Y-m-d H:i:s", time()) . "' )");

            $email_text .= $aLang['email_coupon_incentive_header'] .  "\n\n" .
                           $coupon_desc['coupon_description'] .
                           sprintf($aLang['email_coupon_redeem'], $coupon['coupon_code']) . "\n\n" .
                           "\n\n";
        }
    }

    if (MAKE_PASSWORD == '1') {
        $email_text .= sprintf($aLang['email_password'], $password) . "\n\n";
    }
    $email_text .= $aLang['email_text'] . $aLang['email_contact'] . $aLang['email_warning'] . $aLang['email_disclaimer'];

    oos_mail($name, $email_address, $aLang['email_subject'], nl2br($email_text), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);

    if (SEND_CUSTOMER_EDIT_EMAILS == '1') {
        $email_owner = $aLang['owner_email_subject'] . "\n" .
                       $aLang['email_separator'] . "\n" .
                       $aLang['owner_email_date'] . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n" .
                       $aLang['email_separator'] . "\n";

        if (ACCOUNT_NUMBER == '1') {
            $email_owner .= $aLang['owner_email_number'] . ' ' . $number . "\n" .
                            $aLang['email_separator'] . "\n\n";
        }
        if (ACCOUNT_COMPANY == '1') {
            $email_owner .= $aLang['owner_email_company_info'] . "\n" .
                            $aLang['owner_email_company'] . ' ' . $company . "\n";
            if (ACCOUNT_OWNER == '1') {
                $email_owner .= $aLang['owner_email_owner'] . ' ' . $owner . "\n";
            }
            if (ACCOUNT_VAT_ID == '1') {
                $email_owner .= $aLang['entry_vat_id'] . ' ' . $vat_id . "\n";
            }
        }
        if (ACCOUNT_GENDER == '1') {
            if ($gender == 'm') {
                $email_owner .= $aLang['entry_gender'] . ' ' . $aLang['male'] . "\n";
            } else {
                $email_owner .= $aLang['entry_gender'] . ' ' . $aLang['female'] . "\n";
            }
        }

        $email_owner .= $aLang['owner_email_first_name'] . ' ' . $firstname . "\n" .
                        $aLang['owner_email_last_name'] . ' ' . $lastname . "\n\n" .
                        $aLang['owner_email_street'] . ' ' . $street_address . "\n" .
                        $aLang['owner_email_post_code'] . ' ' . $postcode . "\n" .
                        $aLang['owner_email_city'] . ' ' . $city . "\n" .
                        $aLang['email_separator'] . "\n\n" .
                        $aLang['owner_email_contact'] . "\n" .
                        $aLang['owner_email_telephone_number'] . ' ' . $telephone . "\n" .
                        $aLang['owner_email_fax_number'] . ' ' . $fax . "\n" .
                        $aLang['owner_email_address'] . ' ' . $email_address . "\n" .
                        $aLang['email_separator'] . "\n\n" .
                        $aLang['owner_email_options'] . "\n";
        if ($newsletter == '1') {
            $email_owner .= $aLang['owner_email_newsletter'] . $aLang['entry_newsletter_yes'] . "\n";
        } else {
            $email_owner .= $aLang['owner_email_newsletter'] . $aLang['entry_newsletter_no'] . "\n";
        }
        oos_mail(STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS, $aLang['owner_email_subject'], nl2br($email_owner), $name, $email_address);
    }

    MyOOS_CoreApi::redirect(oos_href_link($aModules['user'], $aFilename['create_account_success'], '', 'SSL'));
}
