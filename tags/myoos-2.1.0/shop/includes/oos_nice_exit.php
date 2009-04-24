<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: application_bottom.php,v 1.14 2003/02/10 22:30:41 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions

   http://www.oscommerce.com
   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   --------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if ($oEvent->installed_plugin('debug')) {
    echo '<pre>';
/*
    print_r($_SESSION);
    echo '<br />';
    print_r($_GET);
    echo '<br />';
*/
    print_r($_POST);
    echo '</pre>';
}

// shopping_cart
if (isset($_SESSION['new_products_id_in_cart'])) {
    unset($_SESSION['new_products_id_in_cart']);
}
$_SESSION['error_cart_msg'] = '';

// close session (store variables)
oos_session_close();


if (OOS_LOG_SQL == '1') {
    $dbconn->LogSQL(false); // turn off logging
    // output summary of SQL logging results
    $perf = NewPerfMonitor($dbconn);
    echo $perf->SuspiciousSQL();
    echo $perf->ExpensiveSQL();
    echo $perf->InvalidSQL();
}
