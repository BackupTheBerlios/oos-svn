<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: weight.php,v 1.02 2003/02/18 03:30:00 harley_vb 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('MODULE_SHIPPING_WEIGHT_STATUS_TITLE', 'Aktivieren der gew. Versandkosten');
define('MODULE_SHIPPING_WEIGHT_STATUS_DESC', 'M�hten Sie gewichtsabh�gige Versandkosten anbieten?');

define('MODULE_SHIPPING_WEIGHT_HANDLING_TITLE', 'Handling Fee');
define('MODULE_SHIPPING_WEIGHT_HANDLING_DESC', 'Bearbeitungsgebhr fr diese Versandart.');

define('MODULE_SHIPPING_WEIGHT_TAX_CLASS_TITLE', 'Steuersatz');
define('MODULE_SHIPPING_WEIGHT_TAX_CLASS_DESC', 'W�len Sie den MwSt.-Satz fr diese Versandart aus.');

define('MODULE_SHIPPING_WEIGHT_ZONE_TITLE', 'Versand Zone');
define('MODULE_SHIPPING_WEIGHT_ZONE_DESC', 'Wenn Sie eine Zone ausw�len, wird diese Versandart nur in dieser Zone angeboten.');

define('MODULE_SHIPPING_WEIGHT_SORT_ORDER_TITLE', 'Reihenfolge der Anzeige');
define('MODULE_SHIPPING_WEIGHT_SORT_ORDER_DESC', 'Niedrigste wird zuerst angezeigt.');

define('MODULE_SHIPPING_WEIGHT_COST_TITLE', 'Versandkostentabelle');
define('MODULE_SHIPPING_WEIGHT_COST_DESC', 'Versandkosten nach beliebigem Gewicht gestaffelt. z.B.: 31:15,40:28,50:30.5,100:33 bis 31kg->15 EUR, von 31-40kg->28 EUR, von 40-50kg->30.5 EUR und von 50-100kg->33 EUR. Von da an wird der \"Erh�ungsschritt\" benutzt!');

define('MODULE_SHIPPING_WEIGHT_STEP_TITLE', 'Erh�ungsschritt');
define('MODULE_SHIPPING_WEIGHT_STEP_DESC', 'Erh�ungsschritt pro bersteigendes kg in EUR');

define('MODULE_SHIPPING_WEIGHT_MODE_TITLE', 'Table Method');
define('MODULE_SHIPPING_WEIGHT_MODE_DESC', 'Is the shipping table based on total Weight or Total amount of order.');

$aLang['module_shipping_weight_text_title'] = 'Coste Peso-dependiente Del Env�';
$aLang['module_shipping_weight_text_description'] = 'Coste Peso-dependiente Del Env�';
$aLang['module_shipping_weight_text_way'] = 'Coste Del Env�';
$aLang['module_shipping_weight_text_weight'] = 'Peso';
$aLang['module_shipping_weight_text_amount'] = 'Total';
?>
