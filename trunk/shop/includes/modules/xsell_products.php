<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
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

if (!is_numeric(MAX_DISPLAY_XSELL_PRODUCTS)) return false;

if (isset($_GET['products_id'])) {
    if (!isset($nProductsId)) $nProductsId = oos_get_product_id($_GET['products_id']);

    $productstable = $oostable['products'];
    $products_xselltable = $oostable['products_xsell'];
    $products_descriptiontable = $oostable['products_description'];
    $sql = "SELECT DISTINCT p.products_id, p.products_image, pd.products_name,
                  substring(pd.products_description, 1, 150) AS products_description
            FROM $products_xselltable xp,
                 $productstable p,
                 $products_descriptiontable pd
            WHERE xp.products_id = '" . intval($nProductsId) . "'
              AND xp.xsell_id = p.products_id
              AND p.products_id = pd.products_id
              AND pd.products_languages_id = '" . intval($nLanguageID) . "'
              AND p.products_status >= '1'
              AND (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "')
            ORDER BY xp.products_id ASC";
    $xsell_products_result = $dbconn->SelectLimit($sql, MAX_DISPLAY_XSELL_PRODUCTS);

    $nXsellProducts = $xsell_products_result->RecordCount();
    if ($nXsellProducts >=  MIN_DISPLAY_XSELL_PRODUCTS) {
        $oSmarty->assign('oos_xsell_products_array', $xsell_products_result->GetArray());
    }
}

