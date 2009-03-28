<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: languages.php,v 1.14 2003/02/12 20:27:31 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

$languages_block = '0';

$languagestable = $oostable['languages'];
$query = "SELECT name, iso_639_2, iso_639_1
          FROM $languagestable
          WHERE status = '1'
          ORDER BY sort_order";

if (USE_DB_CACHE == '1') {
    $languages_result = $dbconn->CacheExecute(3600, $query);
} else {
    $languages_result = $dbconn->Execute($query);
}

if ($languages_result->RecordCount() >= 2) {
    $languages_block = '1';

    $lang_get_parameters = oos_get_all_get_parameters(array('language', 'currency'));
    $lang_get_parameters = oos_remove_trailing($lang_get_parameters);

    $oSmarty->assign('languages_contents', $languages_result->GetArray());

    $oSmarty->assign(
        array(
            'block_heading_languages' => $block_heading,
            'lang_get_parameters' => $lang_get_parameters
        )
    );
} else {
    $blockstable = $oostable['block'];
    $dbconn->Execute("UPDATE " . $blockstable . "
                      SET block_status = 0
                      WHERE block_file = 'languages'");
}

$oSmarty->assign('languages_block', $languages_block);

?>