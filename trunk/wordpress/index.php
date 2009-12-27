<?php

/**
 * Project:     MyOOS: Open Source E-Commerce 
 * File:        index.php
 * Based on:    WordPress
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 *
 *
 * 
 * @link http://www.oos-shop.de
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version $Id$
 * 
 * @package Blog
 */


if(file_exists('bootstrap.php'))
{
	require_once 'bootstrap.php';
}

if (function_exists('ini_set'))
{
  ini_set('magic_quotes_runtime', 0);
}


define('MOOS_VALID_MOD', 'yes');

// MyOOS requires PHP 5.2+
version_compare(PHP_VERSION, '5.2', '<') and exit('MyOOS requires PHP 5.2 or newer.');

define('WP_DOCUMENT_ROOT', dirname(__FILE__)=='/'?'':dirname(__FILE__));

$root_path = WP_DOCUMENT_ROOT;
$root_path = str_replace("\\","/", $root_path); // "
$root_path = str_replace("/wordpress", "", $root_path);
// mainly for developers
if (is_readable( $root_path . '/shop/index.php')) {
  define('MYOOS_DOCUMENT_ROOT',  $root_path . '/shop');
} else {
  define('MYOOS_DOCUMENT_ROOT',  $root_path);
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

/**
 * Front to the WordPress application. This file doesn't do anything, but loads
 * wp-blog-header.php which does and tells WordPress to load the theme.
 *
 * @package WordPress
 */

/**
 * Tells WordPress to load the WordPress theme and output it.
 *
 * @var bool
 */
define('WP_USE_THEMES', true);

/** Loads the WordPress Environment and Template */
require('./wp-blog-header.php');
