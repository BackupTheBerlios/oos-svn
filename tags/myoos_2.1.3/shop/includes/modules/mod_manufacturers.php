<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


if (!$oEvent->installed_plugin('manufacturers')) return false;

if (!defined('MIN_DISPLAY_MANUFACTURER')) {
    define('MIN_DISPLAY_MANUFACTURER', 4);
}
if (!is_numeric(MAX_DISPLAY_MANUFACTURER)) return false;

if (!isset($_GET['manufacturers_id'])) {
    $manufacturerstable = $oostable['manufacturers'];
    $manufacturers_infotable = $oostable['manufacturers_info'];
    $query = "SELECT m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url
              FROM $manufacturerstable m,
                   $manufacturers_infotable mi
              WHERE m.manufacturers_id = mi.manufacturers_id
                AND mi.manufacturers_languages_id = '" .  intval($nLanguageID) . "'
              ORDER BY m.manufacturers_name";
    $manufacturer_result = $dbconn->SelectLimit($query, MAX_DISPLAY_MANUFACTURER);

    $nManufacturer = $manufacturer_result->RecordCount();
    if ($nManufacturer >=  MIN_DISPLAY_MANUFACTURER) {
        $oSmarty->assign('mod_manufacturer_array', $manufacturer_result->GetArray());
    }
}

