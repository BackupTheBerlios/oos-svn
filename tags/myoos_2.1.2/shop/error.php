<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('OOS_VALID_MOD', 'yes');
require(dirname(__FILE__) . '/includes/oos_main.php');

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
$sTheme = oos_var_prep_for_os($_SESSION['theme']);

require(dirname(__FILE__) . '/includes/pages/' . oos_var_prep_for_os($aPages['error404']) . '.php');

require(dirname(__FILE__) . '/includes/oos_nice_exit.php');
