<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2001 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

error_reporting(E_ALL);

if (function_exists('ini_set')) {
    ini_set('display_errors',1);
    ini_set('magic_quotes_runtime', 0);
    ini_set('session.save_handler', 'files');
}


define('OOS_VALID_MOD', 'yes');

// MyOOS requires PHP 5.2+
version_compare(PHP_VERSION, '5.2', '<') and exit('MyOOS requires PHP 5.2 or newer.');


require(dirname(__FILE__) . '/includes/oos_main.php');


$sPage = oos_var_prep_for_os($sPage);
$sLanguage = oos_var_prep_for_os($_SESSION['language']);
$sTheme = oos_var_prep_for_os($_SESSION['theme']);

if (is_readable('includes/pages/' . $sPage . '.php')) {
    if (isset($_GET['history_back'])){
        $_SESSION['navigation']->remove_last_page();
    } else {
        $_SESSION['navigation']->add_current_page();
    }
    require(dirname(__FILE__) . '/includes/pages/' . $sPage '.php');

} else {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['error404']));
}

require(dirname(__FILE__) . '/includes/oos_nice_exit.php');
