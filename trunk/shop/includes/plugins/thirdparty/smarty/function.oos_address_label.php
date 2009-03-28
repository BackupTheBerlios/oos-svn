<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: general.php,v 1.212 2003/02/17 07:55:54 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {oos_address_label} function plugin
 *
 * Type:     function
 * Name:     oos_address_label
 * Version:  1.0
 * -------------------------------------------------------------
 */

function smarty_function_oos_address_label($params, &$smarty)
{

    $customers_id = '';
    $address_id = 1;
    $html = true;
    $boln = '';
    $eoln = '<br>';

    require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');
    require_once $smarty->_get_plugin_filepath('function','oos_address_format');

    foreach($params as $_key => $_val) {
      $$_key = smarty_function_escape_special_chars($_val);
    }

    $dbconn =& oosDBGetConn();
    $oostable =& oosDBGetTables();

    $address_result = $dbconn->Execute("SELECT entry_firstname AS firstname, entry_lastname AS lastname, entry_company AS company, entry_street_address AS street_address, entry_suburb AS suburb, entry_city AS city, entry_postcode AS postcode, entry_state AS state, entry_zone_id AS zone_id, entry_country_id AS country_id FROM " . $oostable['address_book'] . " WHERE customers_id = '" . (int)$customers_id . "' AND address_book_id = '" . (int)$address_id . "'");
    $address = $address_result->fields;

    $format_id = oos_get_address_format_id($address['country_id']);


    return smarty_function_oos_address_format(array('address_format_id' => $format_id,
                                                    'address'   => $address,
                                                    'html'      => $html),
                                                  $smarty);


}


