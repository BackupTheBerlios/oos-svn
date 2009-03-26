<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


define('OOS_LOG_SQL', 'false');    // OOS Performance Monitor
define('USE_DB_CACHE', 'false');   // OOS SQL-Layer Cache
define('USE_DB_CACHE_LEVEL_HIGH', 'false');  // OOS SQL-Layer Cache HIGH

define('WARN_INSTALL_EXISTENCE', 'true');
define('WARN_CONFIG_WRITEABLE', 'true');

if (strlen(ini_get("safe_mode"))< 1) {
  define('WARN_SESSION_DIRECTORY_NOT_WRITEABLE', 'true');
  define('WARN_SESSION_AUTO_START', 'true');
  define('WARN_DOWNLOAD_DIRECTORY_NOT_READABLE', 'true');
} else {
  define('WARN_SESSION_DIRECTORY_NOT_WRITEABLE', 'false');
  define('WARN_SESSION_AUTO_START', 'false');
  define('WARN_DOWNLOAD_DIRECTORY_NOT_READABLE', 'false');
}

define('TIME_BASED_GREETING', 'true');

define('PRODUCT_LISTING_WITH_QTY', 'true');

define('LIGHTBOX', 'true'); // Lightbox on the products info page
define('SOCIAL_BOOKMARKS', 'true'); // SOCIAL_BOOKMARKS Links on the products info page

define('UNITS_DELIMITER', '&nbsp;/&nbsp;');
define('OOS_XHTML', 'true');

define('STORE_STREET_ADDRESS', '');
define('STORE_CITY', '');
define('STORE_POSTCODE', '');
define('STORE_ISO_639_2', '');

define('OOS_PAGE_TYPE_MAINPAGE',  1);
define('OOS_PAGE_TYPE_CATALOG',   2);
define('OOS_PAGE_TYPE_PRODUCTS',  3);
define('OOS_PAGE_TYPE_NEWS',      4);
define('OOS_PAGE_TYPE_SERVICE',   5);
define('OOS_PAGE_TYPE_CHECKOUT',  6);
// 7 remove
define('OOS_PAGE_TYPE_ACCOUNT',   8);
define('OOS_PAGE_TYPE_REVIEWS',   9);

?>