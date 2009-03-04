<?php
/* ----------------------------------------------------------------------
   $Id: cc.php,v 1.3 2007/06/14 16:15:58 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/


   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: cc.php,v 1.10 2002/11/01 05:14:11 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('MODULE_PAYMENT_CC_STATUS_TITLE', 'Enable Credit Card Module');
define('MODULE_PAYMENT_CC_STATUS_DESC', 'Do you want to accept credit card payments?');

define('MODULE_PAYMENT_CC_EMAIL_TITLE', 'Split Credit Card E-Mail Address');
define('MODULE_PAYMENT_CC_EMAIL_DESC', 'If an e-mail address is entered, the middle digits of the credit card number will be sent to the e-mail address (the outside digits are stored in the database with the middle digits censored)');

define('MODULE_PAYMENT_CC_SORT_ORDER_TITLE', 'Sort order of display.');
define('MODULE_PAYMENT_CC_SORT_ORDER_DESC', 'Sort order of display. Lowest is displayed first.');

define('MODULE_PAYMENT_CC_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_CC_ZONE_DESC', 'If a zone is selected, only enable this payment method for that zone.');

define('MODULE_PAYMENT_CC_ORDER_STATUS_ID_TITLE', 'Set Order Status');
define('MODULE_PAYMENT_CC_ORDER_STATUS_ID_DESC', 'Set the status of orders made with this payment module to this value');

define('CC_VAL_TITLE', 'Enable CC Validation');
define('CC_VAL_DESC', 'Do you want to enable CC validation and identify cards?');

define('CC_BLACK_TITLE', 'Enable CC Blacklist Check');
define('CC_BLACK_DESC', 'Do you want to enable CC blacklist check?');

define('CC_ENC_TITLE', 'Encrypt CC Info');
define('CC_ENC_DESC', 'Do you want to encypt cc info?');

define('USE_CC_CVV_TITLE', 'Collect CVV Number');
define('USE_CC_CVV_DESC', 'Do you want to collect CVV Number?');

define('USE_CC_ISS_TITLE', 'Collect Issue Number');
define('USE_CC_ISS_DESC', 'Do you want to collect Issue Number?');

define('USE_CC_START_TITLE', 'Collect Start Date');
define('USE_CC_START_DESC', 'Do you want to collect the Start Date?');

define('CC_CVV_MIN_LENGTH_TITLE', 'CVV Number Length');
define('CC_CVV_MIN_LENGTH_DESC', 'Define CVV length. The default is 3 and should not be changed unless the industry standard changes.');

define('MODULE_PAYMENT_CC_ACCEPT_DINERSCLUB_TITLE', 'Accept DINERS CLUB cards');
define('MODULE_PAYMENT_CC_ACCEPT_DINERSCLUB_DESC', 'Accept DINERS CLUB cards');

define('MODULE_PAYMENT_CC_ACCEPT_AMERICANEXPRESS_TITLE', 'Accept AMERICAN EXPRESS cards');
define('MODULE_PAYMENT_CC_ACCEPT_AMERICANEXPRESS_DESC', 'Accept AMERICAN EXPRESS cards');

define('MODULE_PAYMENT_CC_ACCEPT_OZBANKCARD_TITLE', 'Accept AUSTRALIAN BANKCARD cards');
define('MODULE_PAYMENT_CC_ACCEPT_OZBANKCARD_DESC', 'Accept AUSTRALIAN BANKCARD cards');

define('MODULE_PAYMENT_CC_ACCEPT_DISCOVERNOVUS_TITLE', 'Accept DISCOVER/NOVUS cards');
define('MODULE_PAYMENT_CC_ACCEPT_DISCOVERNOVUS_DESC', 'Accept DISCOVER/NOVUS cards');

define('MODULE_PAYMENT_CC_ACCEPT_MASTERCARD_TITLE', 'Accept MASTERCARD cards');
define('MODULE_PAYMENT_CC_ACCEPT_MASTERCARD_DESC', 'Accept MASTERCARD cards');

define('MODULE_PAYMENT_CC_ACCEPT_JCB_TITLE', 'Accept JCB cards');
define('MODULE_PAYMENT_CC_ACCEPT_JCB_DESC', 'Accept JCB cards');

define('MODULE_PAYMENT_CC_ACCEPT_VISA_TITLE', 'Accept VISA cards');
define('MODULE_PAYMENT_CC_ACCEPT_VISA_DESC', 'Accept VISA cards');

$aLang['module_payment_cc_text_title'] = 'Credit Card';
$aLang['module_payment_cc_text_description'] = 'Credit Card Test Info:<br /><br />CC#: 4111111111111111<br />Expiry: Any';
$aLang['module_payment_cc_text_credit_card_type'] = 'Credit Card Type:';
$aLang['module_payment_cc_text_credit_card_owner'] = 'Credit Card Owner:';
$aLang['module_payment_cc_text_credit_card_number'] = 'Credit Card Number:';
$aLang['module_payment_cc_text_credit_card_start'] = 'Credit Card Start Date:';
$aLang['module_payment_cc_text_credit_card_expires'] = 'Credit Card Expiry Date:';
$aLang['module_payment_cc_text_credit_card_cvv'] = '3 or 4 Digit Security Code:';
$aLang['module_payment_cc_text_credit_card_issue'] = 'Credit Card Issue Number:';
$aLang['module_payment_cc_accepted_cards'] = 'We accept following cards:';

$aLang['module_payment_cc_text_js_cc_owner'] = '* The owner\'s name of the credit card must be at least ' . CC_OWNER_MIN_LENGTH . ' characters.\n';
$aLang['module_payment_cc_text_js_cc_number'] = '* The credit card number must be at least ' . CC_NUMBER_MIN_LENGTH . ' characters.\n';
$aLang['module_payment_cc_text_js_cc_cvv'] = '* The CVV number is a required field and must be included.\n Orders cannot be submitted without it.\n The CVV number is the final 3 or 4 (American Express) digits printed on the signature strip on the reverse of your card.\n\n';

$aLang['module_payment_cc_text_error'] = 'Credit Card Error!';

$aLang['text_card_not_aczepted'] = 'Sorry, we do not accept <b>%s</b> cards, please use another card type!<br />We accept following credit cards: ';


?>