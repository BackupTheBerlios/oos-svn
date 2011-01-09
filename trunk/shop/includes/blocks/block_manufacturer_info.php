<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: manufacturer_info.php,v 1.10 2003/02/12 20:27:31 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


if (!$oEvent->installed_plugin('manufacturers')) return false;

$manufacturer_info_block = '0';

if (isset($_GET['products_id'])) {
    if (!isset($nProductsId)) $nProductsId = oos_get_product_id($_GET['products_id']);

    $manufacturerstable = $oostable['manufacturers'];
    $manufacturers_infotable = $oostable['manufacturers_info'];
    $productstable = $oostable['products'];
    $query = "SELECT m.manufacturers_id, m.manufacturers_name, m.manufacturers_image, mi.manufacturers_url
              FROM $manufacturerstable m LEFT JOIN
                   $manufacturers_infotable mi
                ON (m.manufacturers_id = mi.manufacturers_id
               AND mi.manufacturers_languages_id = '" . intval($nLanguageID) . "'),
                   $productstable p
              WHERE p.products_id = '" . intval($nProductsId) . "'
                AND p.manufacturers_id = m.manufacturers_id";
    $manufacturer_result = $dbconn->Execute($query);

    if ($manufacturer_result->RecordCount()) {

        $manufacturer = $manufacturer_result->fields;
        $manufacturer_info_block = '1';

        $oSmarty->assign(
            array(
                'manufacturer' => $manufacturer,
                'block_heading_manufacturer_info' => $block_heading
            )
        );
    }
}

$oSmarty->assign('manufacturer_info_block', $manufacturer_info_block);

