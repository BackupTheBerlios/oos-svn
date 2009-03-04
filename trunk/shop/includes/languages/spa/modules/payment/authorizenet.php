<?php
/* ----------------------------------------------------------------------
   $Id: authorizenet.php,v 1.8 2006/01/24 17:54:38 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:
  
   File: authorizenet.php,v 1.13 2003/01/10 13:08:35 dgw_ 
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
$aLang['module_payment_authorizenet_text_description'] = 'Tarjeta de Credito para Pruebas:<br /><br />Numero: 4111111111111111<br />Caducidad: Cualquiera';
$aLang['module_payment_authorizenet_text_type'] = 'Tipo de Tarjeta:';
$aLang['module_payment_authorizenet_text_credit_card_owner'] = 'Titular de la Tarjeta:';
$aLang['module_payment_authorizenet_text_credit_card_number'] = 'Numero de la Tarjeta:';
$aLang['module_payment_authorizenet_text_credit_card_expires'] = 'Fecha de Caducidad:';
$aLang['module_payment_authorizenet_text_js_cc_owner'] = '* El nombre del titular de la tarjeta de credito debe de tener al menos ' . CC_OWNER_MIN_LENGTH . ' caracteres.\n';
$aLang['module_payment_authorizenet_text_js_cc_number'] = '* El numero de la tarjeta de credito debe de tener al menos ' . CC_NUMBER_MIN_LENGTH . ' numeros.\n';
$aLang['module_payment_authorizenet_text_error_message'] = 'Ha ocurrido un error procesando su tarjeta de credito. Por favor, intentelo de nuevo.';
$aLang['module_payment_authorizenet_text_declined_message'] = 'Su tarjeta ha sido denegada. Pruebe con otra tarjeta o consulte con su banco.';
$aLang['module_payment_authorizenet_text_error'] = 'Error en Tarjeta de Credito!';
?>
