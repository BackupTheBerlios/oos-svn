<?php
/* ----------------------------------------------------------------------
   $Id: ot_loworderfee.php,v 1.3 2006/05/08 01:01:25 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: ot_loworderfee.php,v 1.2 2002/04/17 12:01:46 harley_vb
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/* ----------------------------------------------------------------------
   If you made a translation, please send to 
      lang@oos-shop.de 
   the translated file. 
   ---------------------------------------------------------------------- */

define('MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS_TITLE', 'Display Low Order Fee');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_STATUS_DESC', 'Do you want to display the low order fee?');

define('MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER_TITLE', 'Sort Order');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_SORT_ORDER_DESC', 'Sort order of display.');

define('MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE_TITLE', 'Allow Low Order Fee');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_LOW_ORDER_FEE_DESC', 'Do you want to allow low order fees?');

define('MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER_TITLE', 'Order Fee For Orders Under');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_ORDER_UNDER_DESC', 'Add the low order fee to orders under this amount.');

define('MODULE_ORDER_TOTAL_LOWORDERFEE_FEE_TITLE', 'Order Fee');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_FEE_DESC', 'Low order fee.');

define('MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION_TITLE', 'Attach Low Order Fee On Orders Made');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_DESTINATION_DESC', 'Attach low order fee for orders sent to the set destination.');

define('MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS_TITLE', 'Tax Class');
define('MODULE_ORDER_TOTAL_LOWORDERFEE_TAX_CLASS_DESC', 'Use the following tax class on the low order fee.');


$aLang['module_order_total_loworderfee_title'] = 'Surtaxe commande minimale';
$aLang['module_order_total_loworderfee_description'] = 'Surtaxe lors d\�une inf�riorit� de la commande minimale';
?>
