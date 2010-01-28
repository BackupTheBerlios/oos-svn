<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: address_book.php,v 1.55 2003/02/13 01:58:23 hpdl
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

if ( !isset( $_SESSION['customer_id'] ) || !is_numeric( $_SESSION['customer_id'] )) {
    $_SESSION['navigation']->set_snapshot();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['login'], '', 'SSL'));
}

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/account_address_book.php';
require 'includes/functions/function_address.php';

/**
 * Returns Adress
 *
 * @param $customers_id
 * @param $address_id
 * @return string
 */
function oos_address_summary($nCustomersId, $nAddressId) {

    $nCustomersId = intval($nCustomersId);
    $nAddressId = intval($nAddressId);

    $dbconn =& oosDBGetConn();
    $oostable =& oosDBGetTables();

    $address_booktable = $oostable['address_book'];
    $countriestable = $oostable['countries'];
    $sql = "SELECT ab.entry_street_address, ab.entry_suburb, ab.entry_postcode, ab.entry_city,
                   ab.entry_state, ab.entry_country_id, ab.entry_zone_id, c.countries_name, c.address_format_id
            FROM $address_booktable ab,
                 $countriestable c
            WHERE ab.address_book_id = '" . intval($nAddressId) . "'
              AND ab.customers_id = '" . intval($nCustomersId) . "'
              AND ab.entry_country_id = c.countries_id";
    $address = $dbconn->GetRow($sql);

    $street_address = $address['entry_street_address'];
    $suburb = $address['entry_suburb'];
    $postcode = $address['entry_postcode'];
    $city = $address['entry_city'];
    $state = oos_get_zone_code($address['entry_country_id'], $address['entry_zone_id'], $address['entry_state']);
    $country = $address['countries_name'];

    $address_formattable = $oostable['address_format'];
    $address_format_query = "SELECT address_summary
                             FROM $address_formattable
                             WHERE address_format_id = '" . intval($address['address_format_id']) . "'";
    $address_format = $dbconn->GetRow($address_format_query);

    $address_summary = $address_format['address_summary'];
    eval("\$address = \"$address_summary\";");

    return $address;
}


$address_booktable = $oostable['address_book'];
$sql = "SELECT address_book_id, entry_firstname, entry_lastname
        FROM $address_booktable
        WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'
          AND address_book_id > 1
        ORDER BY address_book_id";
$address_book_result = $dbconn->Execute($sql);

$aAddressBook = array();
while ($address_book = $address_book_result->fields)
{
    $aAddressBook[] = array('address_book_id' => $address_book['address_book_id'],
                            'entry_firstname' => $address_book['entry_firstname'],
                            'entry_lastname' => $address_book['entry_lastname'],
                            'address_summary' => oos_address_summary($_SESSION['customer_id'], $address_book['address_book_id']));
    $address_book_result->MoveNext();
}


// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aPages['account'], '', 'SSL'));
$oBreadcrumb->add($aLang['navbar_title_2']);

$aOption['template_main'] = $sTheme . '/modules/address_book.html';
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

          'oos_heading_title'      => $aLang['heading_title'],
          'oos_heading_image'      => 'address_book.gif',

          'oos_address_book_array' => $aAddressBook
      )
);

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

