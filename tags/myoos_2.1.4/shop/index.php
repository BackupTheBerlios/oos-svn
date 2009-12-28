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

if(file_exists('bootstrap.php'))
{
	require_once 'bootstrap.php';
}

error_reporting(E_ALL & ~E_STRICT);

if (function_exists('ini_set'))
{
  ini_set('magic_quotes_runtime', 0);
}


define('OOS_VALID_MOD', 'yes');

// MyOOS requires PHP 5.2+
version_compare(PHP_VERSION, '5.2', '<') and exit('MyOOS requires PHP 5.2 or newer.');

define('MYOOS_DOCUMENT_ROOT', dirname(__FILE__)=='/'?'':dirname(__FILE__));

if (!defined('MYOOS_INCLUDE_PATH'))
{
  define('MYOOS_INCLUDE_PATH', MYOOS_DOCUMENT_ROOT);
}
if(!defined('MYOOS_USER_PATH'))
{
  define('MYOOS_USER_PATH', MYOOS_DOCUMENT_ROOT);
}

if (!defined('MYOOS_SESSION_NAME'))
{
  define('MYOOS_SESSION_NAME', 'MYOOS_SESSID');
}



@ini_set('session.name', MYOOS_SESSION_NAME);
if(ini_get('session.save_handler') == 'user')
{
    @ini_set('session.save_handler', 'files');
    @ini_set('session.save_path', '');
}
if(ini_get('session.save_handler') == 'files')
{
	$sessionPath = ini_get('session.save_path');
	if(preg_match('/^[0-9]+;(.*)/', $sessionPath, $matches))
	{
		$sessionPath = $matches[1];
	}
	if(ini_get('safe_mode') || ini_get('open_basedir') || empty($sessionPath) || !@is_writable($sessionPath))
	{
		$sessionPath = MYOOS_USER_PATH . '/tmp/sessions';
		@ini_set('session.save_path', $sessionPath);
		if(!is_dir($sessionPath))
		{
			@mkdir($sessionPath, 0755, true);
			if(!is_dir($sessionPath))
			{
				die("Error: Unable to mkdir $sessionPath");
			}
		}
		elseif(!@is_writable($sessionPath))
		{
			die("Error: $sessionPath is not writable");
		}
	}
}



require_once MYOOS_INCLUDE_PATH . '/includes/oos_main.php';


$sPage = oos_var_prep_for_os($sPage);
$sLanguage = oos_var_prep_for_os($_SESSION['language']);
$sTheme = oos_var_prep_for_os($_SESSION['theme']);

if (is_readable('includes/pages/' . $sPage . '.php')) {
    if (isset($_GET['history_back'])){
        $_SESSION['navigation']->remove_last_page();
    } else {
        $_SESSION['navigation']->add_current_page();
    }
    require_once MYOOS_INCLUDE_PATH . '/includes/pages/' . $sPage . '.php';

} else {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['error404']));
}

require_once MYOOS_INCLUDE_PATH . '/includes/oos_nice_exit.php';
