<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: table.php,v 1.6 2003/02/16 00:52:41 harley_vb
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

define('MODULE_SHIPPING_TABLE_STATUS_TITLE', 'Enable Table Method');
define('MODULE_SHIPPING_TABLE_STATUS_DESC', 'Do you want to offer table rate shipping?');

define('MODULE_SHIPPING_TABLE_COST_TITLE', 'Shipping Table');
define('MODULE_SHIPPING_TABLE_COST_DESC', 'The shipping cost is based on the total cost or weight of items. Example: 25:8.50,50:5.50,etc.. Up to 25 charge 8.50, from there to 50 charge 5.50, etc');

define('MODULE_SHIPPING_TABLE_MODE_TITLE', 'Table Method');
define('MODULE_SHIPPING_TABLE_MODE_DESC', 'The shipping cost is based on the order total or the total weight of the items ordered.');

define('MODULE_SHIPPING_TABLE_HANDLING_TITLE', 'Handling Fee');
define('MODULE_SHIPPING_TABLE_HANDLING_DESC', 'Handling fee for this shipping method.');

define('MODULE_SHIPPING_TABLE_TAX_CLASS_TITLE', 'Tax Class');
define('MODULE_SHIPPING_TABLE_TAX_CLASS_DESC', 'Use the following tax class on the shipping fee.');

define('MODULE_SHIPPING_TABLE_ZONE_TITLE', 'Shipping Zone');
define('MODULE_SHIPPING_TABLE_ZONE_DESC', 'If a zone is selected, only enable this shipping method for that zone.');

define('MODULE_SHIPPING_TABLE_SORT_ORDER_TITLE', 'Sort Order');
define('MODULE_SHIPPING_TABLE_SORT_ORDER_DESC', 'Sort order of display.');

$aLang['module_shipping_table_text_title'] = 'Tabellarische Versandkosten';
$aLang['module_shipping_table_text_description'] = 'Tabellarische Versandkosten';
$aLang['module_shipping_table_text_way'] = '';
$aLang['module_shipping_table_text_weight'] = 'Gewicht';
$aLang['module_shipping_table_text_amount'] = 'Menge';
?>