<?php
/* ----------------------------------------------------------------------
   $Id: function.oos_get_zone_name.php,v 1.5 2007/04/05 17:06:55 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
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
 * Smarty {oos_get_zone_name} function plugin
 *
 * Type:     function
 * Name:     oos_get_zone_name
 * Version:  1.0
 * -------------------------------------------------------------
 */

function smarty_function_oos_get_zone_name($params, &$smarty)
{

    $country_id = '';
    $zone_id = '';
    $default_zone = '';

    require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');

    foreach($params as $_key => $_val) {
      $$_key = smarty_function_escape_special_chars($_val);
    }
    $dbconn =& oosDBGetConn();
    $oostable =& oosDBGetTables();

    $zone = $dbconn->Execute("SELECT zone_name FROM " . $oostable['zones'] . " WHERE zone_country_id = '" . intval($country_id) . "' AND zone_id = '" . intval($zone_id) . "'");
    if ($zone->RecordCount()) {
      return $zone->fields['zone_name'];
    } else {
      return $default_zone;
    }

  }

?>
