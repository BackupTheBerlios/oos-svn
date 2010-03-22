<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: order_history.php,v 1.4 2003/02/10 22:31:02 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}

if (!is_numeric(MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX)) return false;

$order_history_block = '0';

if (isset($_SESSION['customer_id'])) { // retreive the last x products purchased

    $orderstable = $oostable['orders'];
    $orders_productstable = $oostable['orders_products'];
    $productstable = $oostable['products'];
    $query = "SELECT DISTINCT op.products_id
              FROM $orderstable o,
                   $orders_productstable op,
                   $productstable p
              WHERE o.customers_id = '" . intval($_SESSION['customer_id']) . "'
                AND o.orders_id = op.orders_id
                AND op.products_id = p.products_id
                AND p.products_status >= '1'
                AND (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "')
              GROUP BY products_id
              ORDER BY o.date_purchased DESC";
    $orders_result = $dbconn->SelectLimit($query, MAX_DISPLAY_PRODUCTS_IN_ORDER_HISTORY_BOX);

    if ($orders_result->RecordCount()) {

        $order_history_block = '1';
        $product_ids = '';
        while ($orders = $orders_result->fields)
        {
            $product_ids .= $orders['products_id'] . ',';

            // Move that ADOdb pointer!
            $orders_result->MoveNext();
        }


        $product_ids = substr($product_ids, 0, -1);

        $products_descriptiontable = $oostable['products_description'];
        $products_sql = "SELECT products_id, products_name
                         FROM $products_descriptiontable
                         WHERE products_id IN ($product_ids)
                           AND products_languages_id = '" .  intval($nLanguageID) . "'
                         ORDER BY products_name";
        $oSmarty->assign('order_history', $dbconn->GetAll($products_sql));

        if (!isset($block_get_parameters)) {
            $block_get_parameters = oos_get_all_get_parameters(array('action'));
            $block_get_parameters = oos_remove_trailing($block_get_parameters);
            $oSmarty->assign('get_params', $block_get_parameters);
        }

        $oSmarty->assign('block_heading_customer_orders', $block_heading);

    }

}

$oSmarty->assign('order_history_block', $order_history_block);

