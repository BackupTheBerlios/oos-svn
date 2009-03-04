<?php
/* ----------------------------------------------------------------------
   $Id: ot_gv.php,v 1.3 2006/05/08 01:01:25 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: ot_gv.php,v 1.1.2.1 2003/05/15 23:05:02 wilt 
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

define('MODULE_ORDER_TOTAL_GV_STATUS_TITLE', 'Display Total');
define('MODULE_ORDER_TOTAL_GV_STATUS_DESC', 'Do you want to display the Gift Voucher value?');

define('MODULE_ORDER_TOTAL_GV_SORT_ORDER_TITLE', 'Sort Order');
define('MODULE_ORDER_TOTAL_GV_SORT_ORDER_DESC', 'Sort order of display.');

define('MODULE_ORDER_TOTAL_GV_QUEUE_TITLE', 'Queue Purchases');
define('MODULE_ORDER_TOTAL_GV_QUEUE_DESC', 'Do you want to queue purchases of the Gift Voucher?');

define('MODULE_ORDER_TOTAL_GV_INC_SHIPPING_TITLE', 'Include Shipping');
define('MODULE_ORDER_TOTAL_GV_INC_SHIPPING_DESC', 'Include Shipping in calculation');

define('MODULE_ORDER_TOTAL_GV_INC_TAX_TITLE', 'Include Tax');
define('MODULE_ORDER_TOTAL_GV_INC_TAX_DESC', 'Include Tax in calculation.');

define('MODULE_ORDER_TOTAL_GV_CALC_TAX_TITLE', 'Re-calculate Tax');
define('MODULE_ORDER_TOTAL_GV_CALC_TAX_DESC', 'Re-Calculate Tax');

define('MODULE_ORDER_TOTAL_GV_TAX_CLASS_TITLE', 'Tax Class');
define('MODULE_ORDER_TOTAL_GV_TAX_CLASS_DESC', 'Use the following tax class when treating Gift Voucher as Credit Note.');

define('MODULE_ORDER_TOTAL_GV_CREDIT_TAX_TITLE', 'Credit including Tax');
define('MODULE_ORDER_TOTAL_GV_CREDIT_TAX_DESC', 'Add tax to purchased Gift Voucher when crediting to Account');

$aLang['module_order_total_gv_title'] = 'Bon';
$aLang['module_order_total_gv_header'] = 'Bon';
$aLang['module_order_total_gv_description'] = 'Bon';
$aLang['shipping_not_included'] = ' [les frais d\'exp�dition ne sont pas inclus]';
$aLang['tax_not_included'] = ' [La T.V.A. non inclue]';
$aLang['module_order_total_gv_user_prompt'] = 'D�sirez-vous payer avec votre avoir de bons? ->&nbsp;';
$aLang['text_enter_gv_code'] = 'Code du bon;';

?>
