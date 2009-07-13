<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: create_account_admin_process.php
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

if ( (!isset($_POST['action']) || ($_POST['action'] != 'process'))  || (isset($_SESSION['formid']) && ($_SESSION['formid'] != $_POST['formid'])) ) {
    MyOOS_CoreApi::redirect(oos_href_link($aModules['main'], $aFilename['main']));
}


require 'includes/languages/' . $sLanguage . '/admin_create_account_process.php';
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

$keya = oos_prepare_input($_POST['keya']);
$keyb = oos_prepare_input($_POST['keyb']);

$manual_infotable = $oostable['manual_info'];
$sql = "SELECT man_name, defined
        FROM $manual_infotable
        WHERE man_key = '" . oos_db_input($keya) . "'
          AND man_key2 = '" . oos_db_input($keyb) . "'
          AND status = '1'";
$login_result = $dbconn->Execute($sql);
if (!$login_result->RecordCount()) {
    MyOOS_CoreApi::redirect(oos_href_link($aModules['main'], $aFilename['main']));
}


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


$password = oos_create_random_value(ENTRY_PASSWORD_MIN_LENGTH);


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
    $show_password = false;

    // links breadcrumb
    $oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aModules['admin'], $aFilename['admin_create_account']));
    $oBreadcrumb->add($aLang['navbar_title_2']);

    ob_start();
    require 'js/form_check.js.php';
    $javascript = ob_get_contents();
    ob_end_clean();

    $aOption['template_main'] = $sTheme . '/modules/create_account_admin_process.html';
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
        array(
            'oos_breadcrumb'      => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
            'oos_heading_title'   => $aLang['heading_title'],
            'oos_heading_image'   => 'account.gif',

            'oos_js'              => $javascript,

            'error'               => $bError,
            'gender_error'        => $gender_error,
            'firstname_error'     => $firstname_error,
            'lastname_error'      => $lastname_error,
            'date_of_birth_error' => $date_of_birth_error,
            'email_address_error' => $email_address_error,
            'email_address_check_error' => $email_address_check_error,
            'email_address_exists' => $email_address_exists,
            'vatid_check_error'    => $vatid_check_error,
            'street_address_error' => $street_address_error,
            'post_code_error'      => $post_code_error,
            'city_error'           => $city_error,
            'country_error'        => $country_error,
            'state_error'          => $state_error,
            'state_has_zones'      => $state_has_zones,
            'telephone_error'      => $telephone_error,
            'password_error'       => $password_error,

            'gender'               => $gender,
            'firstname'            => $firstname,
            'lastname'             => $lastname,
            'dob'                  => $dob,
            'number'               => $number,
            'email_address'        => $email_address,
            'company'              => $company,
            'owner'                => $owner,
            'vat_id'               => $vat_id,
            'street_address'       => $street_address,
            'suburb'               => $suburb,
            'postcode'             => $postcode,
            'city'                 => $city,
            'country'              => $country,
            'telephone'            => $telephone,
            'fax'                  => $fax,
            'newsletter'           => $newsletter,
            'password'             => $password,
            'confirmation'         => $confirmation,

            'email_address'        => $email_address,
            'show_password'        => $show_password,

            'verif_key'            => $keya,
            'newkey2'              => $keyb
        )
    );

    if ($state_has_zones == '1') {
        $zones_names = array();
        $zones_values = array();
        $zonestable = $oostable['zones'];
        $zones_result = $dbconn->Execute("SELECT zone_name FROM $zonestable WHERE zone_country_id = '" . oos_db_input($country) . "' ORDER BY zone_name");
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

    $country_name = oos_get_country_name($country);
    $oSmarty->assign('country_name', $country_name);

    if ($newsletter == '1') {
        $news = ENTRY_NEWSLETTER_YES;
    } else {
        $news = ENTRY_NEWSLETTER_NO;
    }
    $oSmarty->assign('news', $news);

    $oSmarty->assign('newsletter_ids', array(0,1));
    $oSmarty->assign('newsletter', array($aLang['entry_newsletter_no'],$aLang['entry_newsletter_yes']));

    $oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
    $oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
    $oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

    // display the template
    require 'includes/oos_display.php';
} else {
    $customer_max_order = DEFAULT_MAX_ORDER;
    $customers_status = DEFAULT_CUSTOMERS_STATUS_ID;

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
                            'customers_login' => 1,
                            'customers_max_order' => $customer_max_order,
                            'customers_password' => oos_encrypt_password($password),
                            'customers_wishlist_link_id' => $wishlist_link_id,
                            'customers_default_address_id' => 1);

    if (ACCOUNT_GENDER == '1') $sql_data_array['customers_gender'] = $gender;
    if (ACCOUNT_NUMBER == '1') $sql_data_array['customers_number'] = $number;
    if (ACCOUNT_DOB == '1') $sql_data_array['customers_dob'] = oos_date_raw($dob);
    if (ACCOUNT_VAT_ID == '1') {
        $sql_data_array['customers_vat_id'] = $vat_id;
        if ((ACCOUNT_COMPANY_VAT_ID_CHECK == '1') && ($vatid_check_error === false)) {
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
    $dbconn->Execute("INSERT INTO " . $customers_infotable . "
                (customers_info_id,
                 customers_info_number_of_logons,
                 customers_info_date_account_created) VALUES ('" . intval($customer_id) . "',
                                                              '0',
                                                              '" . date("Y-m-d H:i:s", time()) . "')");

    $_SESSION['customer_id'] = $customer_id;
    $_SESSION['customer_wishlist_link_id'] = $wishlist_link_id;
    $_SESSION['customer_first_name'] = $firstname;
    $_SESSION['customer_default_address_id'] = 1;
    $_SESSION['customer_country_id'] = $country;
    $_SESSION['customer_zone_id'] = $zone_id;
    $_SESSION['customer_max_order'] = $customer_max_order;
    $_SESSION['man_key'] = $keya;

    if (ACCOUNT_VAT_ID == '1') {
        if ((ACCOUNT_COMPANY_VAT_ID_CHECK == '1') && ($vatid_check_error === false)) {
            $_SESSION['customers_vat_id_status'] = 1;
        } else {
            $_SESSION['customers_vat_id_status'] = 0;
        }
    }

// restore cart contents
    $_SESSION['cart']->restore_contents();

    MyOOS_CoreApi::redirect(oos_href_link($aModules['user'], $aFilename['create_account_success'], '', 'SSL'));
}
