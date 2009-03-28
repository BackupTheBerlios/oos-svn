<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: account_history.php,v 1.58 2003/02/13 01:58:23 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if (!isset($_SESSION['customer_id'])) {
    $_SESSION['navigation']->set_snapshot();
    oos_redirect(oos_href_link($aModules['user'], $aFilename['login'], '', 'SSL'));
}

require 'includes/languages/' . $sLanguage . '/account_history.php';

$orderstable = $oostable['orders'];
$orders_totaltable = $oostable['orders_total'];
$orders_statustable = $oostable['orders_status'];
$history_result_raw = "SELECT o.orders_id, o.date_purchased, o.delivery_name, ot.text AS order_total,
                              s.orders_status_name
                       FROM $orderstable o LEFT JOIN
                            $orders_totaltable ot
                         ON (o.orders_id = ot.orders_id) LEFT JOIN
                            $orders_statustable s
                         ON (o.orders_status = s.orders_status_id
                        AND s.orders_languages_id = '" .  intval($nLanguageID) . "')
                      WHERE o.customers_id = '" . intval($_SESSION['customer_id']) . "'
                        AND ot.class = 'ot_total'
                      ORDER BY orders_id DESC";
$history_split = new splitPageResults($_GET['page'], MAX_DISPLAY_ORDER_HISTORY, $history_result_raw, $history_numrows);
$history_result = $dbconn->Execute($history_result_raw);

$aHistory = array();
if ($history_result->RecordCount()) {
    while ($history = $history_result->fields) {
        $orders_productstable = $oostable['orders_products'];
        $sql = "SELECT COUNT(*) AS total
                FROM $orders_productstable
                WHERE orders_id = '" . intval($history['orders_id']) . "'";
        $products = $dbconn->Execute($sql);
        $aHistory[] = array('orders_id' => $history['orders_id'],
                            'orders_status_name' => $history['orders_status_name'],
                            'date_purchased' => $history['date_purchased'],
                            'delivery_name' =>$history['delivery_name'],
                            'products_total' => $products->fields['total'],
                            'order_total' => strip_tags($history['order_total']));
        // Move that ADOdb pointer!
       $history_result->MoveNext();
    }

    // Close result set
    $history_result->Close();
}

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aModules['user'], $aFilename['account'], '', 'SSL'));
$oBreadcrumb->add($aLang['navbar_title_2'], oos_href_link($aModules['account'], $aFilename['account_history'], '', 'SSL'));

$aOption['template_main'] = $sTheme . '/modules/account_history.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';

$nPageType = OOS_PAGE_TYPE_ACCOUNT;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
    require 'includes/oos_counter.php';
}

// assign Smarty variables;
$oSmarty->assign(
      array(
          'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
          'oos_heading_title' => $aLang['heading_title'],
          'oos_heading_image' => 'history.gif',

          'oos_page_split'    => $history_split->display_count($history_numrows, MAX_DISPLAY_ORDER_HISTORY, $_GET['page'], $aLang['text_display_number_of_orders']),
          'oos_display_links' => $history_split->display_links($history_numrows, MAX_DISPLAY_ORDER_HISTORY, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], oos_get_all_get_parameters(array('page', 'info'))),
          'oos_page_numrows'  => $history_numrows,

          'oos_history_array' => $aHistory
      )
);

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

