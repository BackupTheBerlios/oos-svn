<?php
/* ----------------------------------------------------------------------
   $Id: orders_status.php,v 1.3 2006/01/24 17:52:41 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: orders_status.php,v 1.5 2002/01/29 14:43:00 hpdl 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */


define('HEADING_TITLE', 'Stan zam�ie�);

define('TABLE_HEADING_ORDERS_STATUS', 'Stan zam�ie�);
define('TABLE_HEADING_ACTION', 'Dziaanie');

define('TEXT_INFO_EDIT_INTRO', 'Wprowad potrzebne zmiany');
define('TEXT_INFO_ORDERS_STATUS_NAME', 'Stan zam�ienia:');
define('TEXT_INFO_INSERT_INTRO', 'Wprowad nowy stan zam�ienia i jego potrzebne dane');
define('TEXT_INFO_DELETE_INTRO', 'Czy na pewno chcesz usun�ten stan zam�ienia?');
define('TEXT_INFO_HEADING_NEW_ORDERS_STATUS', 'Nowy stan zam�ienia');
define('TEXT_INFO_HEADING_EDIT_ORDERS_STATUS', 'Edytuj stan zam�ienia');
define('TEXT_INFO_HEADING_DELETE_ORDERS_STATUS', 'Usu�stan zam�ienia');

define('ERROR_REMOVE_DEFAULT_ORDER_STATUS', 'Bad: Domylny stan zam�ienia nie moe by�usuni�y. Ustaw inny status jako domylny i spr�uj ponownie.');
define('ERROR_STATUS_USED_IN_ORDERS', 'Bad: Ten stan zam�ienia jest obecnie uywany w zam�ieniach.');
define('ERROR_STATUS_USED_IN_HISTORY', 'Bad: Ten stan zam�ienia jest obecnie uywany w historii zam�ie�');
?>
