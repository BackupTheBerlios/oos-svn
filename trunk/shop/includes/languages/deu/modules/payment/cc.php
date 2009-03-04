<?php
/* ----------------------------------------------------------------------
   $Id: cc.php,v 1.10 2008/11/12 14:56:23 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: cc.php,v 1.11 2003/02/16 01:12:22 harley_vb
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */


define('MODULE_PAYMENT_CC_STATUS_TITLE', 'Kreditkartenmodul aktivieren');
define('MODULE_PAYMENT_CC_STATUS_DESC', 'M&ouml;chten Sie Zahlungen per Kreditkarte akzeptieren?');

define('MODULE_PAYMENT_CC_EMAIL_TITLE', 'Kartensplit eMail Adresse');
define('MODULE_PAYMENT_CC_EMAIL_DESC', 'Wenn eine eMailadresse angegeben worden ist, werden die mittleren Ziffern der Kreditkarten Nummer an diese Adresse gesandt. (Die &auml;usseren Ziffern werden in der Datenbank gespeichert, und die Mittleren darin werden zensiert.');

define('MODULE_PAYMENT_CC_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_CC_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');

define('MODULE_PAYMENT_CC_ZONE_TITLE', 'Zahlungszone');
define('MODULE_PAYMENT_CC_ZONE_DESC', 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');

define('MODULE_PAYMENT_CC_ORDER_STATUS_ID_TITLE', 'Bestellstatus festlegen');
define('MODULE_PAYMENT_CC_ORDER_STATUS_ID_DESC', 'Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen.');

define('CC_VAL_TITLE', 'Karten&uuml;berpr&uuml;fung einschalten');
define('CC_VAL_DESC', 'M&ouml;chten Sie die Kreditkartenangaben &uuml;berpr&uuml;fen und Karten identifizieren?');

define('CC_BLACK_TITLE', 'KK-Blackliste aktivieren');
define('CC_BLACK_DESC', 'M&ouml;chten Sie die KK-Blackliste aktivieren, um dort hinterlegte Kreditkarten abzulehnen?');

define('CC_ENC_TITLE', 'Kreditkarteninfo verschl&uuml;sseln');
define('CC_ENC_DESC', 'M&ouml;chten Sie Kreditkarteninfos verschl&uuml;sseln?');

define('USE_CC_CVV_TITLE', 'CVV Nummer hinterlegen');
define('USE_CC_CVV_DESC', 'M&ouml;chten Sie die CVV Nummer aufnehmen?');

define('USE_CC_ISS_TITLE', 'Vorgangsnummer hinterlegen');
define('USE_CC_ISS_DESC', 'M&ouml;chten Sie die Vorgangsnummer aufnehmen?');

define('USE_CC_START_TITLE', 'Startdatum hinterlegen');
define('USE_CC_START_DESC', 'M&ouml;chten Sie das Startdatums aufnehmen?');

define('CC_CVV_MIN_LENGTH_TITLE', 'L&auml;nge der CVV Nummer');
define('CC_CVV_MIN_LENGTH_DESC', 'L&auml;nge der CVV angeben. Der Standard ist 3 und sollte nicht ge&auml;ndert werden, bis ein neuer Industrie-Standard ausgegeben wurde.');

define('MODULE_PAYMENT_CC_ACCEPT_DINERSCLUB_TITLE', 'DINERS CLUB akzeptieren');
define('MODULE_PAYMENT_CC_ACCEPT_DINERSCLUB_DESC', 'DINERS CLUB akzeptieren');

define('MODULE_PAYMENT_CC_ACCEPT_AMERICANEXPRESS_TITLE', 'AMERICAN EXPRESS akzeptieren');
define('MODULE_PAYMENT_CC_ACCEPT_AMERICANEXPRESS_DESC', 'AMERICAN EXPRESS akzeptieren');

define('MODULE_PAYMENT_CC_ACCEPT_OZBANKCARD_TITLE', 'AUSTRALIAN BANKCARD akzeptieren');
define('MODULE_PAYMENT_CC_ACCEPT_OZBANKCARD_DESC', 'AUSTRALIAN BANKCARD akzeptieren');

define('MODULE_PAYMENT_CC_ACCEPT_DISCOVERNOVUS_TITLE', 'DISCOVER/NOVUS akzeptieren');
define('MODULE_PAYMENT_CC_ACCEPT_DISCOVERNOVUS_DESC', 'DISCOVER/NOVUS akzeptieren');

define('MODULE_PAYMENT_CC_ACCEPT_MASTERCARD_TITLE', 'MASTERCARD akzeptieren');
define('MODULE_PAYMENT_CC_ACCEPT_MASTERCARD_DESC', 'MASTERCARD akzeptieren');

define('MODULE_PAYMENT_CC_ACCEPT_JCB_TITLE', 'JCB akzeptieren');
define('MODULE_PAYMENT_CC_ACCEPT_JCB_DESC', 'JCB akzeptieren');

define('MODULE_PAYMENT_CC_ACCEPT_VISA_TITLE', 'VISA akzeptieren');
define('MODULE_PAYMENT_CC_ACCEPT_VISA_DESC', 'VISA akzeptieren');

$aLang['module_payment_cc_text_title'] = 'Kreditkarte';
$aLang['module_payment_cc_text_description'] = 'Kreditkarten Test Info:<br /><br />CC#: 4111111111111111<br />G&uuml;ltig bis: Any';
$aLang['module_payment_cc_text_credit_card_type'] = 'Typ:';
$aLang['module_payment_cc_text_credit_card_owner'] = 'Kreditkarteninhaber:';
$aLang['module_payment_cc_text_credit_card_number'] = 'Kreditkarten-Nr.:';
$aLang['module_payment_cc_text_credit_card_start'] = 'Kreditkarten-Startdatum:';
$aLang['module_payment_cc_text_credit_card_expires'] = 'G&uuml;ltig bis:';
$aLang['module_payment_cc_text_credit_card_cvv'] = '3-  oder 4-stelliger Sicherheitscode:';
$aLang['module_payment_cc_text_credit_card_issue'] = 'Kreditkarten-Vorgangsnummer:';
$aLang['module_payment_cc_accepted_cards'] = 'Wir akzeptieren folgende Kreditkarten:';


$aLang['module_payment_cc_text_js_cc_owner'] = '* Der \'Name des Inhabers\' muss mindestens aus ' . CC_OWNER_MIN_LENGTH . ' Buchstaben bestehen.\n';
$aLang['module_payment_cc_text_js_cc_number'] = '* Die \'Kreditkarten-Nr.\' muss mindestens aus ' . CC_NUMBER_MIN_LENGTH . ' Zahlen bestehen.\n';
$aLang['module_payment_cc_text_js_cc_cvv'] = '* Der CVV Sicherheitscode ist ein Pflichtfeld und muss ausgef&uuml;llt werden.\n Bestellungen k&ouml;nnen ohne diesen Code nicht ausgef&uuml;hrt werden.\n Der CVV Code besteht aus 3 oder 4 (American Express) Ziffern und ist im Unterschriftsfeld\n auf der R&uuml;ckseite Ihrer Karte gedruckt.\n\n';


$aLang['module_payment_cc_text_error'] = 'Fehler bei der &Uuml;berp&uuml;fung der Kreditkarte!';
$aLang['text_card_not_aczepted'] = 'Die Zahlung mit einer <b>%s</b> Karte ist nicht m&ouml;glich, bitte verwenden Sie eine andere Karte!<br />Folgende Karten werden von uns Akzeptiert: ';

?>

