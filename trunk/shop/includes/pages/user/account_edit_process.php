<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: account_edit_process.php,v 1.75 2003/02/13 01:58:23 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if (!isset($_SESSION['customer_id'])) {
    $_SESSION['navigation']->set_snapshot(array('mode' => 'SSL', 'modules' => $aModules['user'], 'file' => $aFilename['account_edit']));
    oos_redirect(oos_href_link($aModules['user'], $aFilename['login'], '', 'SSL'));
}

if ( (!isset($_POST['action']) || ($_POST['action'] != 'process'))  || (isset($_SESSION['formid']) && ($_SESSION['formid'] != $_POST['formid'])) ) {
    oos_redirect(oos_href_link($aModules['user'], $aFilename['account_edit'], '', 'SSL'));
}

require 'includes/languages/' . $sLanguage . '/user_account_edit_process.php';
require 'includes/functions/function_validate_vatid.php';



if (ACCOUNT_GENDER == 'true') $gender = oos_prepare_input($_POST['gender']);
$firstname = oos_prepare_input($_POST['firstname']);
$lastname = oos_prepare_input($_POST['lastname']);
if (ACCOUNT_DOB == 'true') $dob = oos_prepare_input($_POST['dob']);
if (ACCOUNT_NUMBER == 'true') $number = oos_prepare_input($_POST['number']);
$email_address = oos_prepare_input($_POST['email_address']);

if (ACCOUNT_COMPANY == 'true') $company = oos_prepare_input($_POST['company']);
if (ACCOUNT_OWNER == 'true') $owner = oos_prepare_input($_POST['owner']);
if (ACCOUNT_VAT_ID == 'true') $vat_id = oos_prepare_input($_POST['vat_id']);

$street_address = oos_prepare_input($_POST['street_address']);
if (ACCOUNT_SUBURB == 'true') $suburb = oos_prepare_input($_POST['suburb']);
$postcode = oos_prepare_input($_POST['postcode']);
$city = oos_prepare_input($_POST['city']);
if (ACCOUNT_STATE == 'true') $state = oos_prepare_input($_POST['state']);
$country = oos_prepare_input($_POST['country']);

$telephone = oos_prepare_input($_POST['telephone']);
$fax = oos_prepare_input($_POST['fax']);

$newsletter = oos_prepare_input($_POST['newsletter']);

$password = oos_prepare_input($_POST['password']);
$confirmation = oos_prepare_input($_POST['confirmation']);



$bError = false; // reset error flag

if (ACCOUNT_GENDER == 'true') {
    if ( ($gender == 'm') || ($gender == 'f') ) {
        $gender_error = false;
    } else {
        $bError = true;
        $gender_error = 'true';
    }
}

if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
    $bError = true;
    $firstname_error = 'true';
}

if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
    $bError = true;
    $lastname_error = 'true';
}

if (ACCOUNT_DOB == 'true') {
    if (checkdate(substr(oos_date_raw($dob), 4, 2), substr(oos_date_raw($dob), 6, 2), substr(oos_date_raw($dob), 0, 4))) {
        $date_of_birth_error = false;
    } else {
        $bError = true;
        $date_of_birth_error = 'true';
    }
}

if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
    $bError = true;
    $email_address_error = 'true';
}

if (!oos_validate_is_email($email_address)) {
    $bError = true;
    $email_address_check_error = 'true';
}

if ((ACCOUNT_VAT_ID == 'true') && (ACCOUNT_COMPANY_VAT_ID_CHECK == 'true') && oos_is_not_null($vat_id)) {
    if (!oos_validate_is_vatid($vat_id)) {
        $bError = true;
        $vatid_check_error = 'true';
    }
}


if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
    $bError = true;
    $street_address_error = 'true';
}

if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
    $bError = true;
    $post_code_error = 'true';
}

if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
    $bError = true;
    $city_error = 'true';
}


if (isset($_POST['country']) && is_numeric($_POST['country']) && ($_POST['country'] >= 1)) {
    $country = intval($_POST['country']);
} else {
    $country = 0;
    $bError = true;
    $country_error = 'true';
}


if (ACCOUNT_STATE == 'true') {
    if ($entry_country_error) {
        $state_error = 'true';
    } else {
        $zone_id = 0;
        $state_error = 'false';

        $zonestable = $oostable['zones'];
        $country_check_sql = "SELECT COUNT(*) AS total
                              FROM $zonestable
                              WHERE zone_country_id = '" . intval($country) . "'";
        $country_check = $dbconn->Execute($country_check_sql);

        $entry_state_has_zones = ($country_check->fields['total'] > 0);

        if ($entry_state_has_zones === true) {
            $state_has_zones = 'true';

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
                    $state_error = 'true';
                }
            }
        } elseif (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
            $bError = true;
            $state_error = 'true';
        }
    }
}

if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
    $bError = true;
    $telephone_error = 'true';
} else {
    $telephone_error = false;
}

if (strlen($password) < ENTRY_PASSWORD_MIN_LENGTH) {
    $bError = true;
    $password_error = 'true';
} else {
    $password_error = false;
}

if ($password != $confirmation) {
    $bError = true;
    $password_error = 'true';
}

$customerstable = $oostable['customers'];
$check_email_sql = "SELECT COUNT(*) AS total
                    FROM $customerstable
                    WHERE customers_email_address = '" . oos_db_input($email_address) . "'
                      AND customers_id != '" . intval($_SESSION['customer_id']) . "'";
$check_email = $dbconn->Execute($check_email_sql);

if ($check_email->fields['total'] > 0) {
    $bError = true;
    $email_address_exists = 'true';
} else {
    $email_address_exists = false;
}

if ($bError == true) {
    $_SESSION['navigation']->remove_current_page();

    $processed = true;
    $no_edit = true;
    $show_password = 'true';

    // links breadcrumb
    $oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aModules['user'], $aFilename['account'], '', 'SSL'));
    $oBreadcrumb->add($aLang['navbar_title_2'], oos_href_link($aModules['user'], $aFilename['account_edit'], '', 'SSL'));

    ob_start();
    require 'js/form_check.js.php';
    $javascript = ob_get_contents();
    ob_end_clean();

    $aOption['template_main'] = $sTheme . '/modules/user_account_edit_process.html';
    $aOption['page_heading'] = $sTheme . '/heading/page_heading.html';

    $nPageType = OOS_PAGE_TYPE_ACCOUNT;

    require 'includes/oos_system.php';
    if (!isset($option)) {
        require 'includes/info_message.php';
        require 'includes/oos_blocks.php';
        require 'includes/oos_counter.php';
    }

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
    if ($state_has_zones == 'true') {
        $zones_names = array();
        $zones_values = array();

        $zonestable = $oostable['zones'];
        $zones_query = "SELECT zone_name FROM $zonestable WHERE zone_country_id = '" . intval($country) . "' ORDER BY zone_name";
        $zones_result =& $dbconn->Execute($zones_query);
        while ($zones = $zones_result->fields) {
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

    $country_name = oos_get_country_name($country);
    $oSmarty->assign('country_name', $country_name);
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

    require 'includes/oos_display.php';
} else {
    $new_encrypted_password = oos_encrypt_password($password);
    $sql_data_array = array('customers_firstname' => $firstname,
                            'customers_lastname' => $lastname,
                            'customers_email_address' => $email_address,
                            'customers_telephone' => $telephone,
                            'customers_fax' => $fax,
                            'customers_newsletter' => $newsletter,
                            'customers_password' => $new_encrypted_password);

    if (ACCOUNT_GENDER == 'true') $sql_data_array['customers_gender'] = $gender;
    if (ACCOUNT_DOB == 'true') $sql_data_array['customers_dob'] = oos_date_raw($dob);
    if (ACCOUNT_VAT_ID == 'true') {
        $sql_data_array['customers_vat_id'] = $vat_id;
        if ((ACCOUNT_COMPANY_VAT_ID_CHECK == 'true') && ($vatid_check_error === false) && ($country != STORE_COUNTRY)) {
            $sql_data_array['customers_vat_id_status'] = 1;
        } else {
            $sql_data_array['customers_vat_id_status'] = 0;
        }
    }

    oos_db_perform($oostable['customers'], $sql_data_array, 'update', "customers_id = '" . intval($_SESSION['customer_id']) . "'");

    if (oos_is_not_null($_COOKIE['password'])) {
        $cookie_url_array = parse_url((ENABLE_SSL == true ? OOS_HTTPS_SERVER : OOS_HTTP_SERVER) . substr(OOS_SHOP, 0, -1));
        $cookie_path = $cookie_url_array['path'];
        setcookie('email_address', $email_address, time()+ (365 * 24 * 3600), $cookie_path, '', ((getenv('HTTPS') == 'on') ? 1 : 0));
        setcookie('password', $new_encrypted_password, time()+ (365 * 24 * 3600), $cookie_path, '', ((getenv('HTTPS') == 'on') ? 1 : 0));
    }

    $sql_data_array = array('entry_street_address' => $street_address,
                            'entry_firstname' => $firstname,
                            'entry_lastname' => $lastname,
                            'entry_postcode' => $postcode,
                            'entry_city' => $city,
                            'entry_country_id' => $country);

    if (ACCOUNT_GENDER == 'true') $sql_data_array['entry_gender'] = $gender;
    if (ACCOUNT_COMPANY == 'true') $sql_data_array['entry_company'] = $company;
    if (ACCOUNT_OWNER == 'true') $sql_data_array['entry_owner'] = $owner;
    if (ACCOUNT_SUBURB == 'true') $sql_data_array['entry_suburb'] = $suburb;

    if (ACCOUNT_STATE == 'true') {
        if ($zone_id > 0) {
            $sql_data_array['entry_zone_id'] = $zone_id;
            $sql_data_array['entry_state'] = '';
        } else {
            $sql_data_array['entry_zone_id'] = '0';
            $sql_data_array['entry_state'] = $state;
        }
    }

    oos_db_perform($oostable['address_book'], $sql_data_array, 'update', "customers_id = '" . intval($_SESSION['customer_id']) . "' AND address_book_id = '" . intval($_SESSION['customer_default_address_id']) . "'");

    $update_info_sql = "UPDATE " . $oostable['customers_info'] . "
                        SET customers_info_date_account_last_modified = now()
                        WHERE customers_info_id = '" . intval($_SESSION['customer_id']) . "'";
    $dbconn->Execute($update_info_sql);

    //session
    $_SESSION['customer_country_id'] = $country;
    $_SESSION['customer_zone_id'] = $zone_id;

    if (ACCOUNT_VAT_ID == 'true') {
        if ((ACCOUNT_COMPANY_VAT_ID_CHECK == 'true') && ($vatid_check_error === false)) {
            $_SESSION['customers_vat_id_status'] = 1;
        } else {
            $_SESSION['customers_vat_id_status'] = 0;
        }
    }


    if (SEND_CUSTOMER_EDIT_EMAILS == 'true') {
        $email_owner = $aLang['owner_email_subject'] . "\n" .
                       $aLang['email_separator'] . "\n" .
                       $aLang['owner_email_date'] . ' ' . strftime(DATE_FORMAT_LONG) . "\n\n" .
                       $aLang['email_separator'] . "\n";
        if (ACCOUNT_NUMBER == 'true') {
            $email_owner .= $aLang['owner_email_number'] . ' ' . $number . "\n" .
                            $aLang['email_separator'] . "\n\n";
        }
        if (ACCOUNT_COMPANY == 'true') {
            $email_owner .= $aLang['owner_email_company_info'] . "\n" .
                            $aLang['owner_email_company'] . ' ' . $company . "\n";
            if (ACCOUNT_OWNER == 'true') {
                $email_owner .= $aLang['owner_email_owner'] . ' ' . $owner . "\n";
            }
            if (ACCOUNT_VAT_ID == 'true') {
                $email_owner .= $aLang['entry_vat_id'] . ' ' . $vat_id . "\n";
            }
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

    oos_redirect(oos_href_link($aModules['user'], $aFilename['account'], '', 'SSL'));
}

?>