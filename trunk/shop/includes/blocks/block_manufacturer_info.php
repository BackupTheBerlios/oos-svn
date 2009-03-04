<?php
/* ----------------------------------------------------------------------
   $Id: block_manufacturer_info.php,v 1.35 2007/04/05 17:06:51 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
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

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

  if (!$oEvent->installed_plugin('manufacturers')) return false;

  $manufacturer_info_block = 'false';

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
      $manufacturer_info_block = 'true';

      $oSmarty->assign(
          array(
              'manufacturer' => $manufacturer,
              'block_heading_manufacturer_info' => $block_heading
          )
      );
    }
  }
  $oSmarty->assign('manufacturer_info_block', $manufacturer_info_block);

?>
