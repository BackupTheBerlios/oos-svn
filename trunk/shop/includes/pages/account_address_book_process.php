<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: address_book_process.php,v 1.73 2003/02/13 01:58:23 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
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

if ( !isset( $_SESSION['customer_id'] ) || !is_numeric( $_SESSION['customer_id'] )) {
    $_SESSION['navigation']->set_snapshot();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['login'], '', 'SSL'));
}

if ($_SESSION['navigation']->snapshot['page'] != $aPages['account_address_book']) {
    $_SESSION['navigation']->set_path_as_snapshot(1);
}

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/account_address_book_process.php';


if (isset($_GET['action']) && ($_GET['action'] == 'remove') && !empty($_GET['entry_id']) ) {
    $entry_id = oos_db_prepare_input($_GET['entry_id']);

    if ( empty( $entry_id ) || !is_string( $entry_id ) ) {
        MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
    }

    $address_booktable = $oostable['address_book'];
    $query = "DELETE FROM $address_booktable
              WHERE address_book_id = '" . oos_db_input($entry_id) . "' AND
                    customers_id = '" . intval($_SESSION['customer_id']) . "'";
    $dbconn->Execute($query);

    $address_booktable = $oostable['address_book'];
    $query = "UPDATE $address_booktable
                 SET address_book_id = address_book_id - 1
               WHERE address_book_id > " . oos_db_input($entry_id)  . " AND
                     customers_id = '" . intval($_SESSION['customer_id']) . "'";
    $dbconn->Execute($query);

    MyOOS_CoreApi::redirect(oos_href_link($aPages['account_address_book'], '', 'SSL'));
}


// Post-entry error checking when updating or adding an entry
$process = '0';
if (isset($_POST['action']) && (($_POST['action'] == 'process') || ($_POST['action'] == 'update'))) {
    if ( isset($_SESSION['formid']) && ($_SESSION['formid'] == $_POST['formid']) ) {

        $gender = oos_prepare_input($_POST['gender']);
        $firstname = oos_prepare_input($_POST['firstname']);
        $lastname = oos_prepare_input($_POST['lastname']);
        $company = oos_prepare_input($_POST['company']);
        $street_address = oos_prepare_input($_POST['street_address']);
        $suburb = oos_prepare_input($_POST['suburb']);
        $postcode = oos_prepare_input($_POST['postcode']);
        $city = oos_prepare_input($_POST['city']);
        $state = oos_prepare_input($_POST['state']);
        $entry_id = oos_prepare_input($_POST['entry_id']);
        $suburb = oos_prepare_input($_POST['suburb']);


        $process = '1';
        $error = '0';

        if (ACCOUNT_GENDER == '1') {
            if (($gender == 'm') || ($gender == 'f')) {
                $gender_error = '0';
            } else {
                $gender_error = '1';
                $error = '1';
            }
        }

        if (ACCOUNT_COMPANY == '1') {
            if (strlen($company) < ENTRY_COMPANY_MIN_LENGTH) {
                $company_error = '1';
                $error = '1';
            }
        }

        if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
            $firstname_error = '1';
            $error = '1';
        }

        if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
            $lastname_error = '1';
            $error = '1';
        }

        if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
            $street_address_error = '1';
            $error = '1';
        }

        if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
            $postcode_error = '1';
            $error = '1';
        }

        if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
            $city_error = '1';
            $error = '1';
        }

        if (isset($_POST['country']) && is_numeric($_POST['country']) && ($_POST['country'] >= 1)) {
            $country = (int)$_POST['country'];
            $country_error = '0';
        } else {
            $country = 0;
            $error = true;
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
                            $error = '1';
                            $state_error = '1';
                        }
                    }
                } elseif (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
                    $error = '1';
                    $state_error = '1';
                }
            }
        }

        if ($error == '0') {
          $sql_data_array = array('entry_firstname' => $firstname,
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

          if ($_POST['action'] == 'update') {
              oos_db_perform($oostable['address_book'], $sql_data_array, 'update', "address_book_id = '" . oos_db_input($entry_id) . "' AND customers_id ='" . intval($_SESSION['customer_id']) . "'");
          } else {
              $sql_data_array['customers_id'] = $_SESSION['customer_id'];
              $sql_data_array['address_book_id'] = $entry_id;
              oos_db_perform($oostable['address_book'], $sql_data_array);

              if (count($_SESSION['navigation']->snapshot) > 0) {
                  $origin_href = oos_href_link($_SESSION['navigation']->snapshot['page'], $_SESSION['navigation']->snapshot['get'], $_SESSION['navigation']->snapshot['mode']);
                  $_SESSION['navigation']->clear_snapshot();
                  MyOOS_CoreApi::redirect($origin_href);
              }
          }
      }

      MyOOS_CoreApi::redirect(oos_href_link($aPages['account_address_book'], '', 'SSL'));
   }
}



if (isset($_GET['action']) && ($_GET['action'] == 'modify') && !empty($_GET['entry_id'])) {
    $address_booktable = $oostable['address_book'];
    $sql = "SELECT entry_gender, entry_company, entry_firstname, entry_lastname,
                   entry_street_address, entry_suburb, entry_postcode, entry_city,
                   entry_state, entry_zone_id, entry_country_id
            FROM $address_booktable
            WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'
              AND address_book_id = '" . intval($_GET['entry_id']) . "'";
    $entry = $dbconn->GetRow($sql);
} else {
    $entry = array('entry_country_id' => STORE_COUNTRY);
}

if (!isset($process)) {
    $process = '0';
}

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aPages['account'], '', 'SSL'));
$oBreadcrumb->add($aLang['navbar_title_2']);

if ( (isset($_GET['action']) && ($_GET['action'] == 'modify')) || (isset($_POST['action']) && ($_POST['action'] == 'update') && !empty($_POST['entry_id'])) ) {
    $oBreadcrumb->add($aLang['navbar_title_modify_entry'], oos_href_link($aPages['account_address_book_process'], 'action=modify&amp;entry_id=' . ((isset($_GET['entry_id'])) ? intval($_GET['entry_id']) : intval($_POST['entry_id'])), 'SSL'), bookmark);
} else {
    $oBreadcrumb->add($aLang['navbar_title_add_entry'], oos_href_link($aPages['account_address_book_process'], '', 'SSL'), bookmark);
}

if (count($_SESSION['navigation']->snapshot) > 0) {
    $back_link = oos_href_link($_SESSION['navigation']->snapshot['page'], $_SESSION['navigation']->snapshot['get'], $_SESSION['navigation']->snapshot['mode']);
} else {
    $back_link = oos_href_link($aPages['account_address_book'], '', 'SSL');
}

if (isset($_GET['entry_id'])) {
    $entry_id = (int)$_GET['entry_id'];
}

ob_start();
require 'js/address_book_process.js.php';
$javascript = ob_get_contents();
ob_end_clean();

$aOption['template_main'] = $sTheme . '/modules/address_book_process.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';

$nPageType = OOS_PAGE_TYPE_ACCOUNT;

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

          'back_link'      => $back_link,
          'entry_id'       => $entry_id,
          'process'        => $process,

          'oos_js'         => $javascript
      )
);

if (isset($_GET['action']) && $_GET['action'] == 'modify') {
    $oSmarty->assign(
        array(
            'oos_heading_title' => $aLang['heading_title_modify_entry'],
            'oos_heading_image' => 'address_book.gif'
        )
    );
} else {
    $oSmarty->assign(
        array(
            'oos_heading_title' => $aLang['heading_title_add_entry'],
            'oos_heading_image' => 'address_book.gif'
        )
    );
}

$oSmarty->assign(
      array(
          'gender'         => $gender,
          'firstname'      => $firstname,
          'lastname'       => $lastname,
          'company'        => $company,
          'street_address' => $street_address,
          'suburb'         => $suburb,
          'postcode'       => $postcode,
          'city'           => $city,
          'country'        => $country
      )
);

$oSmarty->assign(
      array(
          'error'                => $error,
          'gender_error'         => $gender_error,
          'firstname_error'      => $firstname_error,
          'lastname_error'       => $lastname_error,
          'street_address_error' => $street_address_error,
          'post_code_error'      => $post_code_error,
          'city_error'           => $city_error,
          'country_error'        => $country_error,
          'state_error'          => $state_error,
          'state_has_zones'      => $state_has_zones
      )
);

if ($state_has_zones == '1') {
     $aZonesNames = array();
     $aZonesValues = array();
     $zonestable = $oostable['zones'];
     $zones_query = "SELECT zone_name FROM $zonestable
                     WHERE zone_country_id = '" . intval($country) . "'
                     ORDER BY zone_name";
     $zones_result =& $dbconn->Execute($zones_query);
     while ($zones = $zones_result->fields) {
         $aZonesNames[] =  $zones['zone_name'];
         $aZonesValues[] = $zones['zone_name'];
         $zones_result->MoveNext();
     }
     $oSmarty->assign('zones_names', $aZonesNames);
     $oSmarty->assign('zones_values', $aZonesValues);
} else {
     $state = oos_get_zone_name($country, $zone_id, $state);
     $oSmarty->assign('state', $state);
     $oSmarty->assign('zone_id', $zone_id);
}

$country_name = oos_get_country_name($country);
$oSmarty->assign('country_name', $country_name);

$oSmarty->assign('entry', $entry);

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

