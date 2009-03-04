<?php
/* ----------------------------------------------------------------------
   $Id: moneyorder.php,v 1.3 2006/05/08 01:01:25 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: moneyorder.php,v 1.8 2003/02/16 01:12:22 harley_vb
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

define('MODULE_PAYMENT_MONEYORDER_STATUS_TITLE', 'Enable Check/Money Order Module');
define('MODULE_PAYMENT_MONEYORDER_STATUS_DESC', 'Do you want to accept Check/Money Order payments?');

define('MODULE_PAYMENT_MONEYORDER_PAYTO_TITLE', 'Make Payable to:');
define('MODULE_PAYMENT_MONEYORDER_PAYTO_DESC', 'Who should payments be made payable to?');

define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_TITLE', 'Sort order of display.');
define('MODULE_PAYMENT_MONEYORDER_SORT_ORDER_DESC', 'Sort order of display. Lowest is displayed first.');

define('MODULE_PAYMENT_MONEYORDER_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_MONEYORDER_ZONE_DESC', 'If a zone is selected, only enable this payment method for that zone.');

define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_TITLE', 'Set Order Status');
define('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID_DESC', 'Set the status of orders made with this payment module to this value');

$aLang['module_payment_moneyorder_text_title'] = 'Scheck/Vorkasse';
$aLang['module_payment_moneyorder_text_description'] = 'Zahlbar an:&nbsp;' . MODULE_PAYMENT_MONEYORDER_PAYTO . '<br />Adressat:<br /><br />' . nl2br(STORE_NAME_ADDRESS) . '<br /><br />' . 'Ihre Bestellung wird versandt, sobald wir das Geld erhalten haben!';
$aLang['module_payment_moneyorder_text_email_footer'] = "Zahlbar an: ". MODULE_PAYMENT_MONEYORDER_PAYTO . "\n\nAdressat:\n" . STORE_NAME_ADDRESS . "\n\n" . 'Ihre Bestellung wird versandt, sobald wir das Geld erhalten haben!';
?>