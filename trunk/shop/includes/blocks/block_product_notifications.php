<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: product_notifications.php,v 1.6 2003/02/12 20:27:32 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if (!$oEvent->installed_plugin('notify')) return false;

$notifications_block = '0';

if (isset($_GET['products_id'])) {
    if (!isset($nProductsId)) $nProductsId = oos_get_product_id($_GET['products_id']);
    $notifications_block = '1';

    if (!isset($block_get_parameters)) {
        $block_get_parameters = oos_get_all_get_parameters(array('action'));
        $block_get_parameters = oos_remove_trailing($block_get_parameters);
        $oSmarty->assign('get_params', $block_get_parameters);
    }

    if (isset($_SESSION['customer_id'])) {
        $products_notificationstable = $oostable['products_notifications'];
        $query = "SELECT COUNT(*) AS total
                  FROM $products_notificationstable
                  WHERE products_id = '" . intval($nProductsId) . "'
                    AND customers_id = '" . intval($_SESSION['customer_id']) . "'";
        $check = $dbconn->Execute($query);
        $notification_exists = (($check->fields['total'] > 0) ? true : false);
    } else {
        $notification_exists = false;
    }

    $products_name = oos_get_products_name($nProductsId);

    $oSmarty->assign(
        array(
            'notification_exists' => $notification_exists,
            'products_name' => $products_name,
            'block_heading_notifications' => $block_heading
        )
    );
}

$oSmarty->assign('notifications_block', $notifications_block);

?>