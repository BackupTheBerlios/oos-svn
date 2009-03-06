<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: paypal.php,v 1.7 2002/04/17 20:31:18 harley_vb
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

define('MODULE_PAYMENT_SAFERPAY_VT_STATUS_TITLE', 'Enable Saferpay Virtual Terminal Module');
define('MODULE_PAYMENT_SAFERPAY_VT_STATUS_DESC', 'Do you want to accept Saferpay Virtual Terminal payments?');

define('MODULE_PAYMENT_SAFERPAY_VT_ACCOUNT_ID_TITLE', 'Account ID');
define('MODULE_PAYMENT_SAFERPAY_VT_ACCOUNT_ID_DESC', 'The account ID of the Saferpay account to use');

define('MODULE_PAYMENT_SAFERPAY_VT_SORT_ORDER_TITLE', 'Sort order of display.');
define('MODULE_PAYMENT_SAFERPAY_VT_SORT_ORDER_DESC', 'Sort order of display. Lowest is displayed first.');

define('MODULE_PAYMENT_SAFERPAY_VT_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_SAFERPAY_VT_ZONE_DESC', 'If a zone is selected, only enable this payment method for that zone.');

define('MODULE_PAYMENT_SAFERPAY_VT_ORDER_STATUS_ID_TITLE', 'Set Order Status');
define('MODULE_PAYMENT_SAFERPAY_VT_ORDER_STATUS_ID_DESC', 'Set the status of orders made with this payment module to this value');

$aLang['module_payment_saferpay_vt_text_title'] = 'Credit Card';
$aLang['module_payment_saferpay_vt_text_description'] = 'Saferpay Virtual Terminal Transactions';
?>