<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}

$xsell_block = '0';

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
              AND (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "')
              AND pd.products_languages_id = '" . intval($nLanguageID) . "'
              AND p.products_status >= '1'
            ORDER BY xp.products_id ASC";
    $xsell_products_result = $dbconn->SelectLimit($sql, MAX_DISPLAY_XSELL_PRODUCTS);

    if ($xsell_products_result->RecordCount()) {
        $xsell_block = '1';
        $oSmarty->assign('block_xsell_products', $xsell_products_result->GetArray());
    }
}

$oSmarty->assign('block_heading_xsell', $block_heading);

$oSmarty->assign('xsell_block', $xsell_block);

