<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: ipayment.php,v 1.6 2002/11/01 22:19:27 harley_vb
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

define('MODULE_PAYMENT_IPAYMENT_STATUS_TITLE', 'Enable iPayment Module');
define('MODULE_PAYMENT_IPAYMENT_STATUS_DESC', 'Do you want to accept iPayment payments?');

define('MODULE_PAYMENT_IPAYMENT_ID_TITLE', 'Account Number');
define('MODULE_PAYMENT_IPAYMENT_ID_DESC', 'The account number used for the iPayment service');

define('MODULE_PAYMENT_IPAYMENT_USER_ID_TITLE', 'User ID');
define('MODULE_PAYMENT_IPAYMENT_USER_ID_DESC', 'The user ID for the iPayment service');

define('MODULE_PAYMENT_IPAYMENT_PASSWORD_TITLE', 'User Password');
define('MODULE_PAYMENT_IPAYMENT_PASSWORD_DESC', 'The user password for the iPayment service');

define('MODULE_PAYMENT_IPAYMENT_CURRENCY_TITLE', 'Transaction Currency');
define('MODULE_PAYMENT_IPAYMENT_CURRENCY_DESC', 'The currency to use for credit card transactions');

define('MODULE_PAYMENT_IPAYMENT_SORT_ORDER_TITLE', 'Sort order of display.');
define('MODULE_PAYMENT_IPAYMENT_SORT_ORDER_DESC', 'Sort order of display. Lowest is displayed first.');

define('MODULE_PAYMENT_IPAYMENT_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_IPAYMENT_ZONE_DESC', 'If a zone is selected, only enable this payment method for that zone.');

define('MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID_TITLE', 'Set Order Status');
define('MODULE_PAYMENT_IPAYMENT_ORDER_STATUS_ID_DESC', 'Set the status of orders made with this payment module to this value');


$aLang['module_payment_ipayment_text_title'] = 'iPayment';
$aLang['module_payment_ipayment_text_description'] = 'Kreditkarten Test Info:<br /><br />CC#: 4111111111111111<br />G&uuml;ltig bis: Any';
$aLang['ipayment_error_heading'] = 'Folgender Fehler wurde von iPayment w&auml;hrend des Prozesses gemeldet:';
$aLang['ipayment_error_message'] = 'Bitte kontrollieren Sie die Daten Ihrer Kreditkarte!';
$aLang['module_payment_ipayment_text_credit_card_owner'] = 'Kreditkarteninhaber';
$aLang['module_payment_ipayment_text_credit_card_number'] = 'Kreditkarten-Nr.:';
$aLang['module_payment_ipayment_text_credit_card_expires'] = 'G&uuml;ltig bis:';
$aLang['module_payment_ipayment_text_credit_card_checknumber'] = 'Karten-Pr&uuml;fnummer';
$aLang['module_payment_ipayment_text_credit_card_checknumber_location'] = '(Auf der Kartenr&uuml;ckseite im Unterschriftsfeld)';

$aLang['module_payment_ipayment_text_js_cc_owner'] = '* Der Name des Kreditkarteninhabers mss mindestens aus  ' . CC_OWNER_MIN_LENGTH . ' Zeichen bestehen.\n';
$aLang['module_payment_ipayment_text_js_cc_number'] = '* Die \'Kreditkarten-Nr.\' muss mindestens aus ' . CC_NUMBER_MIN_LENGTH . ' Zahlen bestehen.\n';
?>