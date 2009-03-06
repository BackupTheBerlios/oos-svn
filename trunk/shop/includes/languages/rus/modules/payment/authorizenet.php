<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: authorizenet.php,v 1.13 2003/01/03 17:25:43 thomasamoulton 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('MODULE_PAYMENT_AUTHORIZENET_STATUS_TITLE', 'Enable Authorize.net Module');
define('MODULE_PAYMENT_AUTHORIZENET_STATUS_DESC', 'Do you want to accept Authorize.net payments?');

define('MODULE_PAYMENT_AUTHORIZENET_LOGIN_TITLE', 'Login Username');
define('MODULE_PAYMENT_AUTHORIZENET_LOGIN_DESC', 'The login username used for the Authorize.net service');

define('MODULE_PAYMENT_AUTHORIZENET_TXNKEY_TITLE', 'Transaction Key');
define('MODULE_PAYMENT_AUTHORIZENET_TXNKEY_DESC', 'Transaction Key used for encrypting TP data');

define('MODULE_PAYMENT_AUTHORIZENET_TESTMODE_TITLE', 'Transaction Mode');
define('MODULE_PAYMENT_AUTHORIZENET_TESTMODE_DESC', 'Transaction mode used for processing orders');

define('MODULE_PAYMENT_AUTHORIZENET_METHOD_TITLE', 'Transaction Method');
define('MODULE_PAYMENT_AUTHORIZENET_METHOD_DESC', 'Transaction method used for processing orders');

define('MODULE_PAYMENT_AUTHORIZENET_EMAIL_CUSTOMER_TITLE', 'Customer Notifications');
define('MODULE_PAYMENT_AUTHORIZENET_EMAIL_CUSTOMER_DESC', 'Should Authorize.Net e-mail a receipt to the customer?');

define('MODULE_PAYMENT_AUTHORIZENET_SORT_ORDER_TITLE', 'Sort order of display.');
define('MODULE_PAYMENT_AUTHORIZENET_SORT_ORDER_DESC', 'Sort order of display. Lowest is displayed first.');

define('MODULE_PAYMENT_AUTHORIZENET_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_AUTHORIZENET_ZONE_DESC', 'If a zone is selected, only enable this payment method for that zone.');

define('MODULE_PAYMENT_AUTHORIZENET_ORDER_STATUS_ID_TITLE', 'Set Order Status');
define('MODULE_PAYMENT_AUTHORIZENET_ORDER_STATUS_ID_DESC', 'Set the status of orders made with this payment module to this value');


$aLang['module_payment_authorizenet_text_title'] = 'Authorize.net';
$aLang['module_payment_authorizenet_text_description'] = 'Credit Card Test Info:<br /><br />CC#: 4111111111111111<br />Expiry: Any';
$aLang['module_payment_authorizenet_text_type'] = 'Type:';
$aLang['module_payment_authorizenet_text_credit_card_owner'] = 'Credit Card Owner:';
$aLang['module_payment_authorizenet_text_credit_card_number'] = 'Credit Card Number:';
$aLang['module_payment_authorizenet_text_credit_card_expires'] = 'Credit Card Expiry Date:';
$aLang['module_payment_authorizenet_text_js_cc_owner'] = '* The owner\'s name of the credit card must be at least ' . CC_OWNER_MIN_LENGTH . ' characters.\n';
$aLang['module_payment_authorizenet_text_js_cc_number'] = '* The credit card number must be at least ' . CC_NUMBER_MIN_LENGTH . ' characters.\n';
$aLang['module_payment_authorizenet_text_error_message'] = 'There has been an error processing your credit card. Please try again.';
$aLang['module_payment_authorizenet_text_declined_message'] = 'Your credit card was declined. Please try another card or contact your bank for more info.';
$aLang['module_payment_authorizenet_text_error'] = 'Credit Card Error!';
?>
