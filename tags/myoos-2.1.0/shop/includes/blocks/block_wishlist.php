<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: wishlist.php,v 1.0 2002/05/08 10:00:00 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if (!$oEvent->installed_plugin('wishlist')) return false;
if (!is_numeric(MAX_DISPLAY_WISHLIST_BOX)) return false;

$wishlist_block = '0';

if ($sFile != $aFilename['account_my_wishlist']) {
    if (isset($_SESSION['customer_id'])) {

        $wishlist_block = '1';
        $show_wishlist = '0';

        $productstable = $oostable['products'];
        $products_descriptiontable = $oostable['products_description'];
        $customers_wishlisttable   = $oostable['customers_wishlist'];
        $query = "SELECT p.products_id, p.products_image, p.products_price,
                         p.products_tax_class_id, p.products_units_id,
                         pd.products_id, pd.products_name
                  FROM $productstable AS p,
                       $products_descriptiontable AS pd,
                       $customers_wishlisttable AS wl
                  WHERE wl.customers_id = '" . intval($_SESSION['customer_id']) . "'
                    AND wl.products_id = pd.products_id
                    AND pd.products_languages_id = '" . intval($nLanguageID) . "'
                    AND p.products_id = pd.products_id
                    AND (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "')
                  ORDER BY pd.products_name";
        $wishlist_result = $dbconn->SelectLimit($query, MAX_DISPLAY_WISHLIST_BOX);

        if ($wishlist_result->RecordCount()) {
            $show_wishlist = '1';
            $oSmarty->assign('wishlist_contents', $wishlist_result->GetArray());
        }

        $oSmarty->assign(
            array(
                'show_wishlist' => $show_wishlist,
                'block_heading_customer_wishlist' => $block_heading
            )
        );
    }
}

$oSmarty->assign('wishlist_block', $wishlist_block);

