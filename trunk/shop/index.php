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


define('OOS_VALID_MOD', 'yes');
require(dirname(__FILE__) . '/includes/oos_main.php');


$sMp = oos_var_prep_for_os($sMp);
$sFile = oos_var_prep_for_os($sFile);
$sLanguage = oos_var_prep_for_os($_SESSION['language']);
$sTheme = oos_var_prep_for_os($_SESSION['theme']);

if (is_readable('includes/pages/' . $sMp . '/' . $sFile . '.php')) {
    if (isset($_GET['history_back'])){
        $_SESSION['navigation']->remove_last_page();
    } else {
        $_SESSION['navigation']->add_current_page();
    }
    require(dirname(__FILE__) . '/includes/pages/' . $sMp . '/' . $sFile . '.php');

} else {
    oos_redirect(oos_href_link($aModules['error'], $aFilename['error404']));
}

require(dirname(__FILE__) . '/includes/oos_nice_exit.php');
