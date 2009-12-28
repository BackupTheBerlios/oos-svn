<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: pm2checkout.php,v 1.4 2002/11/01 22:19:27 harley_vb
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

define('MODULE_PAYMENT_2CHECKOUT_STATUS_TITLE', 'Enable 2CheckOut Module');
define('MODULE_PAYMENT_2CHECKOUT_STATUS_DESC', 'Do you want to accept 2CheckOut payments?');

define('MODULE_PAYMENT_2CHECKOUT_LOGIN_TITLE', 'Login/Store Number');
define('MODULE_PAYMENT_2CHECKOUT_LOGIN_DESC', 'Login/Store Number used for the 2CheckOut service');

define('MODULE_PAYMENT_2CHECKOUT_TESTMODE_TITLE', 'Transaction Mode');
define('MODULE_PAYMENT_2CHECKOUT_TESTMODE_DESC', 'Transaction mode used for the 2Checkout service');


define('MODULE_PAYMENT_2CHECKOUT_EMAIL_MERCHANT_TITLE', 'Merchant Notifications');
define('MODULE_PAYMENT_2CHECKOUT_EMAIL_MERCHANT_DESC', 'Should 2CheckOut e-mail a receipt to the store owner?');

define('MODULE_PAYMENT_2CHECKOUT_SORT_ORDER_TITLE', 'Sort order of display.');
define('MODULE_PAYMENT_2CHECKOUT_SORT_ORDER_DESC', 'Sort order of display. Lowest is displayed first.');

define('MODULE_PAYMENT_2CHECKOUT_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_2CHECKOUT_ZONE_DESC', 'If a zone is selected, only enable this payment method for that zone.');

define('MODULE_PAYMENT_2CHECKOUT_ORDER_STATUS_ID_TITLE', 'Set Order Status');
define('MODULE_PAYMENT_2CHECKOUT_ORDER_STATUS_ID_DESC', 'Set the status of orders made with this payment module to this value');


$aLang['module_payment_2checkout_text_title'] = '2CheckOut';
$aLang['module_payment_2checkout_text_description'] = 'Kreditkarten Test Info:<br /><br />CC#: 4111111111111111<br />G&uuml;ltig bis: Any';
$aLang['module_payment_2checkout_text_type'] = 'Typ:';
$aLang['module_payment_2checkout_text_credit_card_owner'] = 'Kreditkarteninhaber:';
$aLang['module_payment_2checkout_text_credit_card_owner_first_name'] = 'Kreditkarteninhaber Vorname:';
$aLang['module_payment_2checkout_text_credit_card_owner_last_name'] = 'Kreditkarteninhaber Nachname:';
$aLang['module_payment_2checkout_text_credit_card_number'] = 'Kreditkarten-Nr.:';
$aLang['module_payment_2checkout_text_credit_card_expires'] = 'G&uuml;ltig bis:';
$aLang['module_payment_2checkout_text_credit_card_checknumber'] = 'Karten-Pr&uuml;fnummer:';
$aLang['module_payment_2checkout_text_credit_card_checknumber_location'] = '(Auf der Kartenr&uuml;ckseite im Unterschriftsfeld)';
$aLang['module_payment_2checkout_text_js_cc_number'] = '* Die \'Kreditkarten-Nr.\' muss mindestens aus ' . CC_NUMBER_MIN_LENGTH . ' Zahlen bestehen.\n';
$aLang['module_payment_2checkout_text_error_message'] = 'Bei der &Uuml;berp&uuml;fung Ihrer Kreditkarte ist ein Fehler aufgetreten! Bitte versuchen Sie es nochmal.';
$aLang['module_payment_2checkout_text_error'] = 'Fehler bei der &Uuml;berp&uuml;fung der Kreditkarte!';
?>