<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
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

// DO NOT RUN THIS SCRIPT STANDALONE
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


if ($oEvent->installed_plugin('debug')) {

    MyOOS_CoreApi::requireOnce('lib/krumo/class.krumo.php');

    echo '$_SESSION';
    krumo($_SESSION);

    echo '$_GET'; 
    krumo($_GET);

    echo '$_POST';
    krumo($_POST); 

    // print all the included(or required) files 
    krumo::includes();
 
    // print all the included functions 
    krumo::functions();
 
    // print all the declared classes 
    krumo::classes();
 
    // print all the defined constants 
    krumo::defines();     
}

// shopping_cart
if (isset($_SESSION['new_products_id_in_cart'])) {
    unset($_SESSION['new_products_id_in_cart']);
}
if (isset($_SESSION['error_cart_msg'])) {
    unset($_SESSION['error_cart_msg']);
}
  
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
