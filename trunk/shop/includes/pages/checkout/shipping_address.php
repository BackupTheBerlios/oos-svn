<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: checkout_shipping_address.php,v 1.8 2003/02/13 04:23:22 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

require 'includes/languages/' . $sLanguage . '/checkout_shipping_address.php';
require 'includes/functions/function_address.php';

// if the customer is not logged on, redirect them to the login page
if (!isset($_SESSION['customer_id'])) {
    $_SESSION['navigation']->set_snapshot();
    MyOOS_CoreApi::redirect(oos_href_link($aModules['user'], $aFilename['login'], '', 'SSL'));
}

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() < 1) {
    MyOOS_CoreApi::redirect(oos_href_link($aModules['main'], $aFilename['main_shopping_cart']));
}

// if the order contains only virtual products, forward the customer to the billing page as
// a shipping address is not needed
if ($oOrder->content_type == 'virtual') {
    $_SESSION['shipping'] = false;
    $_SESSION['sendto'] = false;
    MyOOS_CoreApi::redirect(oos_href_link($aModules['checkout'], $aFilename['checkout_payment'], '', 'SSL'));
}

$bError = false;
$process = '0';

if ( (isset($_POST['action']) && ($_POST['action'] == 'submit')) && (isset($_SESSION['formid']) && ($_SESSION['formid'] == $_POST['formid'])) ) {
// process a new shipping address
    if (oos_is_not_null($_POST['firstname']) && oos_is_not_null($_POST['lastname']) && oos_is_not_null($_POST['street_address'])) {

        if (ACCOUNT_GENDER == '1') $gender = oos_prepare_input($_POST['gender']);
        $firstname = oos_db_prepare_input($_POST['firstname']);
        $lastname = oos_db_prepare_input($_POST['lastname']);
        if (ACCOUNT_COMPANY == '1') $company = oos_prepare_input($_POST['company']);
        $street_address = oos_prepare_input($_POST['street_address']);
        if (ACCOUNT_SUBURB == '1') $suburb = oos_prepare_input($_POST['suburb']);
        $postcode = oos_prepare_input($_POST['postcode']);
        $city = oos_prepare_input($_POST['city']);
        if (ACCOUNT_STATE == '1') $state = oos_prepare_input($_POST['state']);
        $country = oos_prepare_input($_POST['country']);

        $process = '1';

        if (ACCOUNT_GENDER == '1') {
            if (($gender == 'm') || ($gender == 'f')) {
                $gender_error = '0';
            } else {
                $gender_error = '1';
                $bError = true;
            }
        }

        if (ACCOUNT_COMPANY == '1') {
            if (strlen($company) < ENTRY_COMPANY_MIN_LENGTH) {
                $company_error = '1';
                $bError = true;
            }
        }

        if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
            $firstname_error = '1';
            $bError = true;
        }

        if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
            $lastname_error = '1';
            $bError = true;
        }

        if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
            $street_address_error = '1';
            $bError = true;
        }

        if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
            $postcode_error = '1';
            $bError = true;
        }

        if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
            $city_error = '1';
            $bError = true;
        }

        if (strlen($country) < 1) {
            $country_error = '1';
            $bError = true;
        }

        if (ACCOUNT_STATE == '1') {
            if ($country_error == '1') {
                $state_error = '1';
            } else {
                $zone_id = 0;
                $state_error = '0';
                $zonestable = $oostable['zones'];
                $sql = "SELECT COUNT(*) as total
                        FROM $zonestable
                        WHERE zone_country_id = '" . oos_db_input($country) . "'";
                $check_result = $dbconn->Execute($sql);
                $check_value = $check_result->fields;
                $state_has_zones = '0';
                if ($check_value['total'] > 0) {
                    $state_has_zones = '1';
                    $zonestable = $oostable['zones'];
                    $sql = "SELECT zone_id
                            FROM $zonestable
                            WHERE zone_country_id = '" . oos_db_input($country) . "'
                              AND zone_name = '" . oos_db_input($state) . "'";
                    $zone_result = $dbconn->Execute($sql);
                    if ($zone_result->RecordCount() == 1) {
                        $zone_values = $zone_result->fields;
                        $zone_id = $zone_values['zone_id'];
                    } else {
                        $bError = true;
                        $state_error = '1';
                    }
                } else {
                    if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
                        $bError = true;
                        $state_error = '1';
                    }
                }
            }
        }

        if ($bError === false) {
            $address_booktable = $oostable['address_book'];
            $sql = "SELECT max(address_book_id) AS address_book_id
                    FROM $address_booktable
                    WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'";
            $next_id_result = $dbconn->Execute($sql);
            if ($next_id_result->RecordCount()) {
                $next_id = $next_id_result->fields;
                $entry_id = $next_id['address_book_id']+1;
            } else {
                $entry_id = 1;
            }

            $sql_data_array = array('customers_id' => $_SESSION['customer_id'],
                                    'address_book_id' => $entry_id,
                                    'entry_firstname' => $firstname,
                                    'entry_lastname' => $lastname,
                                    'entry_street_address' => $street_address,
                                    'entry_postcode' => $postcode,
                                    'entry_city' => $city,
                                    'entry_country_id' => $country);

            if (ACCOUNT_GENDER == '1') $sql_data_array['entry_gender'] = $gender;
            if (ACCOUNT_COMPANY == '1') $sql_data_array['entry_company'] = $company;
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

            $_SESSION['sendto'] = $entry_id;

            if (isset($_SESSION['shipping'])) unset($_SESSION['shipping']);

            MyOOS_CoreApi::redirect(oos_href_link($aModules['checkout'], $aFilename['checkout_shipping'], '', 'SSL'));
        }
// process the selected shipping destination
    } elseif (isset($_POST['address'])) {

        $reset_shipping = false;
        if (isset($_SESSION['sendto'])) {
            if ($_SESSION['sendto'] != $_POST['address']) {
                if (isset($_SESSION['shipping'])) {
                    $reset_shipping = true;
                }
            }
        }
        $_SESSION['sendto'] = $_POST['address'];

        $address_booktable = $oostable['address_book'];
        $sql = "SELECT COUNT(*) AS total
                FROM $address_booktable
                WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'
                  AND address_book_id = '" . intval($_SESSION['sendto']) . "'";
        $check_address_result = $dbconn->Execute($sql);
        $check_address = $check_address_result->fields;

        if ($check_address['total'] == '1') {
            if ($reset_shipping == true) unset($_SESSION['shipping']);
            MyOOS_CoreApi::redirect(oos_href_link($aModules['checkout'], $aFilename['checkout_shipping'], '', 'SSL'));
        } else {
            unset($_SESSION['sendto']);
        }
    } else {
        $_SESSION['sendto'] = $_SESSION['customer_default_address_id'];

        MyOOS_CoreApi::redirect(oos_href_link($aModules['checkout'], $aFilename['checkout_shipping'], '', 'SSL'));
    }
}

if ($process == '0') {
    $address_booktable = $oostable['address_book'];
    $sql = "SELECT COUNT(*) AS total
            FROM $address_booktable
            WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'
              AND address_book_id != '" . intval($_SESSION['sendto']) . "'";
    $addresses_count_result = $dbconn->Execute($sql);
    $addresses_count = $addresses_count_result->fields['total'];

    if ($addresses_count > 0) {
        $radio_buttons = 0;
        $address_booktable = $oostable['address_book'];
        $sql = "SELECT address_book_id, entry_firstname AS firstname, entry_lastname AS lastname,
                       entry_company AS company, entry_street_address AS street_address,
                       entry_suburb AS suburb, entry_city AS city, entry_postcode AS postcode,
                       entry_state AS state, entry_zone_id AS zone_id, entry_country_id AS country_id
                FROM $address_booktable
                WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'";
        $addresses_result = $dbconn->Execute($sql);
        $addresses_array = array();
        while ($addresses = $addresses_result->fields)
        {
            $format_id = oos_get_address_format_id($address['country_id']);
            $addresses_array[] = array('format_id' => $format_id,
                                       'radio_buttons' => $radio_buttons,
                                       'firstname' => $addresses['firstname'],
                                       'lastname' => $addresses['lastname'],
                                       'address_book_id' => $addresses['address_book_id'],
                                       'address' => oos_address_format($format_id, $addresses, true, ' ', ', '));
            $radio_buttons++;
            // Move that ADOdb pointer!
            $addresses_result->MoveNext();
        }

    }
}

// if no shipping destination address was selected, use their own address as default
if (!isset($_SESSION['sendto'])) {
    $_SESSION['sendto'] = $_SESSION['customer_default_address_id'];
}

if (!isset($process)) $process = '0';

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aModules['checkout'], $aFilename['checkout_shipping'], '', 'SSL'));
$oBreadcrumb->add($aLang['navbar_title_2'], oos_href_link($aModules['checkout'], $aFilename['checkout_shipping_address'], '', 'SSL'));

ob_start();
require 'js/checkout_shipping_address.js.php';
$javascript = ob_get_contents();
ob_end_clean();

$aOption['template_main'] = $sTheme . '/modules/shipping_address.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';

$nPageType = OOS_PAGE_TYPE_CHECKOUT;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

// assign Smarty variables;
$oSmarty->assign(
      array(
          'oos_breadcrumb' => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
          'oos_heading_title' => $aLang['heading_title'],
          'oos_heading_image' => 'delivery.gif',

          'process' => $process,
          'addresses_count' => $addresses_count,

          'gender' => $gender,
          'firstname' => $firstname,
          'lastname' => $lastname,
          'company' => $company,
          'street_address' => $street_address,
          'suburb' => $suburb,
          'postcode' => $postcode,
          'city' => $city,
          'country' => $country,

          'gender_error' => $gender_error,
          'firstname_error' => $firstname_error,
          'lastname_error' => $lastname_error,
          'street_address_error' => $street_address_error,
          'post_code_error' => $post_code_error,
          'city_error' => $city_error,
          'state_error' => $state_error,
          'state_has_zones' => $state_has_zones,
          'country_error' => $country_error
      )
);

// JavaScript
$oSmarty->assign('oos_js', $javascript);

if ($process == '0') {
    $oSmarty->assign('addresses_array', $addresses_array);
}


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

$state = oos_get_zone_name($country, $zone_id, $state);
$oSmarty->assign('state', $state);

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';
