<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: banktransfer.php,v 1.9 2003/02/18 19:22:15 dogu 
   ----------------------------------------------------------------------

   OSC German Banktransfer
   (http://www.oscommerce.com/community/contributions,826)

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2001 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/* ----------------------------------------------------------------------
   If you made a translation, please send to 
      lang@oos-shop.de 
   the translated file. 
   ---------------------------------------------------------------------- */

define('MODULE_PAYMENT_BANKTRANSFER_STATUS_TITLE', 'Allow Banktranfer Payments');
define('MODULE_PAYMENT_BANKTRANSFER_STATUS_DESC', 'Do you want to accept banktransfer payments?');

define('MODULE_PAYMENT_BANKTRANSFER_ZONE_TITLE', 'Payment Zone');
define('MODULE_PAYMENT_BANKTRANSFER_ZONE_DESC', 'If a zone is selected, only enable this payment method for that zone.');

define('MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER_TITLE', 'Sort order of display.');
define('MODULE_PAYMENT_BANKTRANSFER_SORT_ORDER_DESC', 'Sort order of display. Lowest is displayed first.');
 
define('MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID_TITLE', 'Set Order Status');
define('MODULE_PAYMENT_BANKTRANSFER_ORDER_STATUS_ID_DESC', 'Set the status of orders made with this payment module to this value');

define('MODULE_PAYMENT_BANKTRANSFER_FAX_CONFIRMATION_TITLE', 'Allow Fax Confirmation');
define('MODULE_PAYMENT_BANKTRANSFER_FAX_CONFIRMATION_DESC', 'Do you want to allow fax confirmation?');

define('MODULE_PAYMENT_BANKTRANSFER_URL_NOTE_TITLE', 'Fax- File');
define('MODULE_PAYMENT_BANKTRANSFER_URL_NOTE_DESC', 'The fax-confirmation file. It must located in catalog-dir');


$aLang['module_payment_banktransfer_text_title'] = 'Lastschriftverfahren';
$aLang['module_payment_banktransfer_text_description'] = 'Lastschriftverfahren';
$aLang['module_payment_banktransfer_text_bank'] = 'Bankeinzug';
$aLang['module_payment_banktransfer_text_email_footer'] = 'Hinweis: Sie können sich unser Faxformular unter ' . OOS_HTTP_SERVER . OOS_SHOP . MODULE_PAYMENT_BANKTRANSFER_URL_NOTE . ' herunterladen und es ausgefüllt an uns zurücksenden.';
$aLang['module_payment_banktransfer_text_bank_info'] = 'Bitte beachten Sie, dass das Lastschriftverfahren <b>nur</b> von einem <b>deutschen Girokonto</b> aus möglich ist';
$aLang['module_payment_banktransfer_text_bank_owner'] = 'Kontoinhaber:';
$aLang['module_payment_banktransfer_text_bank_number'] = 'Kontonummer:';
$aLang['module_payment_banktransfer_text_bank_blz'] = 'BLZ:';
$aLang['module_payment_banktransfer_text_bank_name'] = 'Bank:';
$aLang['module_payment_banktransfer_text_bank_fax'] = 'Einzugsermächtigung wird per Fax bestätigt';

$aLang['module_payment_banktransfer_text_bank_error'] = '<font color="#FF0000">FEHLER: </font>';
$aLang['module_payment_banktransfer_text_bank_error_1'] = 'Kontonummer und BLZ stimmen nicht überein!<br />Bitte überprüfen Sie Ihre Angaben nochmals.';
$aLang['module_payment_banktransfer_text_bank_error_2'] = 'Für diese Kontonummer ist kein Prüfziffernverfahren definiert!';
$aLang['module_payment_banktransfer_text_bank_error_3'] = 'Kontonummer nicht prüfbar!';
$aLang['module_payment_banktransfer_text_bank_error_4'] = 'Kontonummer nicht prüfbar!<br />Bitte überprüfen Sie Ihre Angaben nochmals.';
$aLang['module_payment_banktransfer_text_bank_error_5'] = 'Bankleitzahl nicht gefunden!<br />Bitte überprüfen Sie Ihre Angaben nochmals.';
$aLang['module_payment_banktransfer_text_bank_error_8'] = 'Fehler bei der Bankleitzahl oder keine Bankleitzahl angegeben!';
$aLang['module_payment_banktransfer_text_bank_error_9'] = 'Keine Kontonummer angegeben!';

$aLang['module_payment_banktransfer_text_note'] = 'Hinweis:';
$aLang['module_payment_banktransfer_text_note2'] = 'Wenn Sie aus Sicherheitsbedenken keine Bankdaten über das Internet<br />übertragen wollen, können Sie sich unser ';
$aLang['module_payment_banktransfer_text_note3'] = 'Faxformular';
$aLang['module_payment_banktransfer_text_note4'] = ' herunterladen und uns ausgefüllt zusenden.';

$aLang['js_bank_blz'] = 'Bitte geben Sie die BLZ Ihrer Bank ein!\n';
$aLang['js_bank_name'] = 'Bitte geben Sie den Namen Ihrer Bank ein!\n';
$aLang['js_bank_number'] = 'Bitte geben Sie Ihre Kontonummer ein!\n';
$aLang['js_bank_owner'] = 'Bitte geben Sie den Namen des Kontobesitzers ein!\n';
?>