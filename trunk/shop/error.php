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

define('MYOOS_DOCUMENT_ROOT', dirname(__FILE__)=='/'?'':dirname(__FILE__));

if (!defined('MYOOS_INCLUDE_PATH'))
{
  define('MYOOS_INCLUDE_PATH', MYOOS_DOCUMENT_ROOT);
}


require_once MYOOS_INCLUDE_PATH . '/includes/oos_main.php';

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
$sTheme = oos_var_prep_for_os($_SESSION['theme']);

require_once MYOOS_INCLUDE_PATH . '/includes/pages/' . oos_var_prep_for_os($aPages['error404']) . '.php';

require_once MYOOS_INCLUDE_PATH . '/includes/oos_nice_exit.php';
