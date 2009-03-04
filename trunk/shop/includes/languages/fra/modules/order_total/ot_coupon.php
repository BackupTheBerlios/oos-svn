<?php
/* ----------------------------------------------------------------------
   $Id: ot_coupon.php,v 1.3 2006/05/08 01:01:25 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: ot_coupon.php,v 1.1.2.2 2003/05/15 23:05:02 wilt
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

define('MODULE_ORDER_TOTAL_COUPON_STATUS_TITLE', 'Display Total');
define('MODULE_ORDER_TOTAL_COUPON_STATUS_DESC', 'Do you want to display the Discount Coupon value?');

define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_TITLE', 'Sort Order');
define('MODULE_ORDER_TOTAL_COUPON_SORT_ORDER_DESC', 'Sort order of display.');

define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_TITLE', 'Include Shipping');
define('MODULE_ORDER_TOTAL_COUPON_INC_SHIPPING_DESC', 'Include Shipping in calculation');

define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_TITLE', 'Include Tax');
define('MODULE_ORDER_TOTAL_COUPON_INC_TAX_DESC', 'Include Tax in calculation.');

define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_TITLE', 'Re-calculate Tax');
define('MODULE_ORDER_TOTAL_COUPON_CALC_TAX_DESC', 'Re-Calculate Tax');

define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_TITLE', 'Tax Class');
define('MODULE_ORDER_TOTAL_COUPON_TAX_CLASS_DESC', 'Use the following tax class when treating Discount Coupon as Credit Note.');

$aLang['module_order_total_coupon_title'] = 'Rabais coupons';
$aLang['module_order_total_coupon_header'] = 'Bons cadeaux / Rabais coupon';
$aLang['module_order_total_coupon_description'] = 'Rabais coupon';
$aLang['shipping_not_included'] = ' [Expédition non comprise]';
$aLang['tax_not_included'] = ' [Taxe non incluse]';
$aLang['module_order_total_coupon_user_prompt'] = '';
$aLang['error_no_invalid_redeem_coupon'] = 'Code du coupon invalide';
$aLang['error_invalid_startdate_coupon'] = 'Ce coupon n\’est pas encore disponible';
$aLang['error_invalid_finisdate_coupon'] = 'Ce coupon est expiré';
$aLang['error_invalid_uses_coupon'] = 'Ce coupon peut uniquement être utilisé';  
$aLang['times'] = ' fois.';
$aLang['error_invalid_uses_user_coupon'] = 'Vous avez utilisé le coupon le nombre maximum de fois possible par client.'; 
$aLang['redeemed_coupon'] = 'Un coupon dans la valeur de';
$aLang['redeemed_min_order'] = 'Pour des commandes de';
$aLang['redeemed_restrictions'] = ' [Les restrictions articles-catégories s\’appliquent]';
$aLang['text_enter_coupon_code'] = 'Code du bon;';
?>
