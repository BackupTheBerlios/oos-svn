<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


define('OOS_LOG_SQL', '0');    // OOS Performance Monitor
define('USE_DB_CACHE', '0');   // OOS SQL-Layer Cache
define('USE_DB_CACHE_LEVEL_HIGH', '0');  // OOS SQL-Layer Cache HIGH

define('WARN_INSTALL_EXISTENCE', '1');
define('WARN_CONFIG_WRITEABLE', '1');

define('WARN_SESSION_DIRECTORY_NOT_WRITEABLE', '1');
define('WARN_SESSION_AUTO_START', '1');
define('WARN_DOWNLOAD_DIRECTORY_NOT_READABLE', '1');

define('TIME_BASED_GREETING', '0');

define('PRODUCT_LISTING_WITH_QTY', '1');

define('LIGHTBOX', '1'); // Lightbox on the products info page

define('UNITS_DELIMITER', '&nbsp;/&nbsp;');
define('OOS_XHTML', '1');



define('OOS_PAGE_TYPE_MAINPAGE',  1);
define('OOS_PAGE_TYPE_CATALOG',   2);
define('OOS_PAGE_TYPE_PRODUCTS',  3);
define('OOS_PAGE_TYPE_NEWS',      4);
define('OOS_PAGE_TYPE_SERVICE',   5);
define('OOS_PAGE_TYPE_CHECKOUT',  6);
// 7 remove
define('OOS_PAGE_TYPE_ACCOUNT',   8);
define('OOS_PAGE_TYPE_REVIEWS',   9);


