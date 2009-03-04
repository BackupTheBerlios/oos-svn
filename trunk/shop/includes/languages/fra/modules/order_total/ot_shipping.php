<?php
/* ----------------------------------------------------------------------
   $Id: ot_shipping.php,v 1.3 2006/05/08 01:01:25 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: ot_shipping.php,v 1.4 2003/02/16 01:18:31 harley_vb
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

define('MODULE_ORDER_TOTAL_SHIPPING_STATUS_TITLE', 'Display Shipping');
define('MODULE_ORDER_TOTAL_SHIPPING_STATUS_DESC', 'Do you want to display the order shipping cost?');

define('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER_TITLE', 'Sort Order');
define('MODULE_ORDER_TOTAL_SHIPPING_SORT_ORDER_DESC', 'Sort order of display.');

define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_TITLE', 'Allow Free Shipping');
define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_DESC', 'Do you want to allow free shipping?');

define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_TITLE', 'Free Shipping For Orders Over');
define('MODULE_ORDER_TOTAL_SHIPPING_FREE_SHIPPING_OVER_DESC', 'Provide free shipping for orders over the set amount.');

define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_TITLE', 'Provide Free Shipping For Orders Made');
define('MODULE_ORDER_TOTAL_SHIPPING_DESTINATION_DESC', 'Provide free shipping for orders sent to the set destination.');


$aLang['module_order_total_shipping_title'] = 'Frais d\'exp�dition';
$aLang['module_order_total_shipping_description'] = 'Frais d\�exp�dition par commande';

$aLang['free_shipping_title'] = 'Port pay�';
$aLang['free_shipping_description'] = 'Port pay� lors d\�une valeur de commande s\��l�vant � %s';
?>
