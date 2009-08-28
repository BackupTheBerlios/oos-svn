<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: product_notifications.php,v 1.7 2003/02/14 05:51:27 hpdl
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

if (!$oEvent->installed_plugin('notify')) {
    $_SESSION['navigation']->remove_current_page();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
}

if ( !isset( $_SESSION['customer_id'] ) || !is_numeric( $_SESSION['customer_id'] )) {
    $_SESSION['navigation']->set_snapshot();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['login'], '', 'SSL'));
}

require 'includes/languages/' . $sLanguage . '/user_product_notifications.php';

if (isset($_GET['action']) && ($_GET['action'] == 'update_notifications')) {
    (array)$products = $_POST['products'];
    $aRemove = array();
    for ($i=0, $n=count($products); $i<$n; $i++) {
        if (is_numeric($products[$i])) {
            $aRemove[] = $products[$i];
        }
    }

    if (oos_is_not_null($aRemove)) {
        $products_notificationstable = $oostable['products_notifications'];
        $dbconn->Execute("DELETE FROM $products_notificationstable
                          WHERE customers_id = '" . intval($_SESSION['customer_id']) . "' AND
                                products_id IN (" . implode(',', $aRemove) . ")");
    }

    MyOOS_CoreApi::redirect(oos_href_link($aPages['product_notifications'], '', 'SSL'));

} elseif (isset($_GET['action']) && ($_GET['action'] == 'global_notify')) {
    if (isset($_POST['global']) && ($_POST['global'] == 'enable')) {
        $customers_infotable = $oostable['customers_info'];
        $dbconn->Execute("UPDATE $customers_infotable
                          SET global_product_notifications = '1'
                          WHERE customers_info_id = '" . intval($_SESSION['customer_id']) . "'");
    } else {
        $customers_infotable   = $oostable['customers_info'];
        $sql = "SELECT COUNT(*) AS total
                FROM $customers_infotable
                WHERE customers_info_id = '" . intval($_SESSION['customer_id']) . "'
                  AND global_product_notifications = '1'";
        $check_result = $dbconn->Execute($sql);

        if ($check_result->fields['total'] > 0) {
            $customers_infotable = $oostable['customers_info'];
            $dbconn->Execute("UPDATE $customers_infotable
                              SET global_product_notifications = '0'
                              WHERE customers_info_id = '" . intval($_SESSION['customer_id']) . "'");
        }
    }

    MyOOS_CoreApi::redirect(oos_href_link($aPages['product_notifications'], '', 'SSL'));
}

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aPages['account'], '', 'SSL'));
$oBreadcrumb->add($aLang['navbar_title_2'], oos_href_link($aPages['product_notifications'], '', 'SSL'), bookmark);

$aOption['template_main'] = $sTheme . '/modules/user_product_notifications.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['breadcrumb'] = 'default/system/breadcrumb.html';

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
          'oos_heading_image' => 'account.gif'
      )
);

$customers_infotable = $oostable['customers_info'];
$sql = "SELECT global_product_notifications
        FROM $customers_infotable
        WHERE customers_info_id = '" . intval($_SESSION['customer_id']) . "'";
$global_status_result = $dbconn->Execute($sql);
$global_status = $global_status_result->fields;
$oSmarty->assign('global_status', $global_status);

$products_descriptionstable  = $oostable['products_description'];
$products_notificationstable = $oostable['products_notifications'];
$sql = "SELECT pd.products_id, pd.products_name
        FROM $products_descriptionstable pd,
             $products_notificationstable pn
        WHERE pn.customers_id = '" . intval($_SESSION['customer_id']) . "'
          AND pn.products_id = pd.products_id
          AND pd.products_languages_id = '" . intval($nLanguageID) . "'
        ORDER BY pd.products_name";
$oSmarty->assign('products_array', $dbconn->GetAll($sql));

$oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

