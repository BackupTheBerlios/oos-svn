<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: account_history_info.php,v 1.94 2003/02/14 20:28:46 dgw_
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

if (!isset($_SESSION['customer_id'])) {
  $_SESSION['navigation']->set_snapshot();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['login'], '', 'SSL'));
}


if (!isset($_GET['order_id'])) {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['account_history'], '', 'SSL'));
}

require 'includes/languages/' . $sLanguage . '/account_history_info.php';
require 'includes/functions/function_address.php';

$orderstable = $oostable['orders'];
$sql = "SELECT customers_id
        FROM $orderstable
        WHERE orders_id = '" . intval($_GET['order_id']) . "'";
$customer_number = $dbconn->GetOne($sql);


if ($customer_number != $_SESSION['customer_id']) {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['account_history'], '', 'SSL'));
}

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aPages['account'], '', 'SSL'));
$oBreadcrumb->add($aLang['navbar_title_2'], oos_href_link($aPages['account_history'], '', 'SSL'));
$oBreadcrumb->add($aLang['navbar_title_3'], oos_href_link($aPages['account_history_info'], 'order_id=' . intval($_GET['order_id']), 'SSL'), bookmark);

require 'includes/classes/class_order.php';
$oOrder = new order($_GET['order_id']);

$aOption['template_main'] = $sTheme . '/modules/account_history_info.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['breadcrumb'] = 'default/system/breadcrumb.html';

if (DOWNLOAD_ENABLED == '1') {
  $aOption['download'] = $sTheme . '/modules/download.html';
}

$nPageType = OOS_PAGE_TYPE_ACCOUNT;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

$oos_pagetitle = $oBreadcrumb->trail_title(' &raquo; ');
$oos_pagetitle .= '&raquo;' . OOS_META_TITLE;

// assign Smarty variables;
$oSmarty->assign(
      array(
          'pagetitle'         => htmlspecialchars($oos_pagetitle),
          'meta_description'  => htmlspecialchars($oos_meta_description),
          'meta_keywords'     => htmlspecialchars($oos_meta_keywords),
          'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
          'oos_heading_title' => $aLang['heading_title'],
          'oos_heading_image' => 'history.gif'
      )
);


$oSmarty->assign('order', $oOrder);
$oSmarty->assign('currencies', $oCurrencies);

$orders_statustable = $oostable['orders_status'];
$orders_status_historytable = $oostable['orders_status_history'];
$sql = "SELECT os.orders_status_name, osh.date_added, osh.comments
          FROM $orders_statustable os,
             $orders_status_historytable osh
          WHERE osh.orders_id = '" . intval($_GET['order_id']) . "'
            AND osh.orders_status_id = os.orders_status_id
            AND os.orders_languages_id = '" . intval($nLanguageID) . "'
          ORDER BY osh.date_added";
$oSmarty->assign('statuses_array', $dbconn->GetAll($sql));

if (DOWNLOAD_ENABLED == '1') {
    require 'includes/modules/downloads.php';
    $oSmarty->assign('download', $oSmarty->fetch($aOption['download']));
}

$oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

