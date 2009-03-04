<?php
/* ----------------------------------------------------------------------
   $Id: up_sell_products.php,v 1.21 2008/08/29 16:55:45 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File:  xsell_products.php, v1  2002/09/11
   ----------------------------------------------------------------------
   Cross-Sell

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

  if (isset($_GET['products_id']) && is_numeric(MAX_DISPLAY_XSELL_PRODUCTS)) {
    if (!isset($nProductsId)) $nProductsId = oos_get_product_id($_GET['products_id']);

    $products_up_selltable = $oostable['products_up_sell'];
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $sql = "SELECT DISTINCT p.products_id, p.products_image, pd.products_name
            FROM $products_up_selltable xp,
                 $productstable p,
                 $products_descriptiontable pd
            WHERE xp.products_id = '" . intval($nProductsId) . "'
              AND xp.up_sell_id = p.products_id
              AND p.products_id = pd.products_id
              AND pd.products_languages_id = '" . intval($nLanguageID) . "'
              AND p.products_status >= '1'
              AND (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "')
            ORDER BY xp.products_id ASC";
    $up_sell_products_result = $dbconn->SelectLimit($sql, MAX_DISPLAY_XSELL_PRODUCTS);

    $nUp_sell = $up_sell_products_result->RecordCount();
    if ($nUp_sell >=  MIN_DISPLAY_XSELL_PRODUCTS) {
      $oSmarty->assign('oos_up_sell_products_array', $up_sell_products_result->GetArray());
    }
  }

?>