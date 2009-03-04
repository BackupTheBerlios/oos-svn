<?php
/* ----------------------------------------------------------------------
   $Id: paypal.php,v 1.2 2006/05/08 01:01:25 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: saferpaygw.php 1308 2005-10-15 14:22:18Z af $

   Copyright (c) 2006 Alexander Federau
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/* ----------------------------------------------------------------------
   If you made a translation, please send to 
      lang@oos-shop.de 
   the translated file. 
   ---------------------------------------------------------------------- */


  define('YES', 'ja');
  define('NO', 'nein');

  define('MODULE_PAYMENT_SAFERPAYGW_TEXT_DESCRIPTION', '<b>Saferpay Testkonto</b><br /><br />ACCOUNTID: 99867-94913159<br />Normale Testkarte: 9451123100000004<br />G&uuml;ltig bis: 12/10, CVC 123<br /><br />Testkarte f&uuml;r 3D-Secure: 9451123100000111<br />G&uuml;ltig bis: 12/10, CVC 123<br /><br /><b>Login f&uuml;r das Backoffice<br />auf www.saferpay.com:</b><br />Benutzername: e99867001<br />Passwort: Xajc3Kna<br /><hr>');
  define('SAFERPAYGW_ERROR_HEADING', 'Ein Fehler bei Verbindung zum Saferpay Gateway.');
  define('SAFERPAYGW_ERROR_MESSAGE', 'Bitte kontrollieren Sie die Daten Ihrer Kreditkarte!');
  define('TEXT_SAFERPAYGW_CONFIRMATION_ERROR', 'There has been an error to confirm your payment');
  define('TEXT_SAFERPAYGW_CAPTURING_ERROR', 'There has been an error capturing your credit card');
  define('TEXT_SAFERPAYGW_SETUP_ERROR', 'There has been an error creating the request! Please check your settings!');
  
  define('MODULE_PAYMENT_SAFERPAYGW_STATUS_TITLE', 'Saferpay Modul aktivieren');
  define('MODULE_PAYMENT_SAFERPAYGW_STATUS_DESC', 'M&ouml;chten Sie Zahlungen per Saferpay akzeptieren?');
  define('MODULE_PAYMENT_SAFERPAYGW_ALLOWED_TITLE', 'Erlaubte Zonen');
  define('MODULE_PAYMENT_SAFERPAYGW_ALLOWED_DESC', 'Geben Sie <b>einzeln</b> die Zonen an, welche f&uuml;r dieses Modul erlaubt sein sollen. (z.B. AT,DE (wenn leer, werden alle Zonen erlaubt))');
  define('MODULE_PAYMENT_SAFERPAYGW_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
  define('MODULE_PAYMENT_SAFERPAYGW_SORT_ORDER_DESC', 'Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
  define('MODULE_PAYMENT_SAFERPAYGW_ZONE_TITLE', '<hr><br />Zahlungszone');
  define('MODULE_PAYMENT_SAFERPAYGW_ZONE_DESC', 'Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');
  define('MODULE_PAYMENT_SAFERPAYGW_ORDER_STATUS_ID_TITLE', 'Bestellstatus festlegen');
  define('MODULE_PAYMENT_SAFERPAYGW_ORDER_STATUS_ID_DESC', 'Mit Saferpay bezahlte Bestellungen, auf diesen Status setzen');
  define('MODULE_PAYMENT_SAFERPAYGW_CURRENCY_TITLE', 'Transaktionsw&auml;hrung');
  define('MODULE_PAYMENT_SAFERPAYGW_CURRENCY_DESC', 'W&auml;hrung f&uuml;r die Zahlungsanfragen');

  define('MODULE_PAYMENT_SAFERPAYGW_LOGIN_TITLE', 'Saferpay-Loginname');
  define('MODULE_PAYMENT_SAFERPAYGW_LOGIN_DESC' , 'Loginname, welches f&uuml;r Saferpay verwendet wird');
  define('MODULE_PAYMENT_SAFERPAYGW_PASSWORD_TITLE', 'Saferpay-Passwort');
  define('MODULE_PAYMENT_SAFERPAYGW_PASSWORD_DESC', 'Passwort welches f&uuml;r Saferpay verwendet wird');
  define('MODULE_PAYMENT_SAFERPAYGW_ACCOUNT_ID_TITLE' , 'Saferpay-Konto');
  define('MODULE_PAYMENT_SAFERPAYGW_ACCOUNT_ID_DESC' , 'ACCOUNTID des Saferpay Terminals');
  define('MODULE_PAYMENT_SAFERPAYGW_PAYINIT_URL_TITLE' , 'PayInit URL');
  define('MODULE_PAYMENT_SAFERPAYGW_PAYINIT_URL_DESC' , 'URL f&uuml;r die Initialisierung der Zahlung');
  define('MODULE_PAYMENT_SAFERPAYGW_CONFIRM_URL_TITLE' , 'PayConfirm URL');
  define('MODULE_PAYMENT_SAFERPAYGW_CONFIRM_URL_DESC' , 'URL f&uuml;r die Best&auml;tigung der Zahlung');
  define('MODULE_PAYMENT_SAFERPAYGW_COMPLETE_URL_TITLE' , 'PayComplete URL');
  define('MODULE_PAYMENT_SAFERPAYGW_COMPLETE_URL_DESC' , 'URL f&uuml;r das Abschlie&#64258;en der Zahlung');

  define('MODULE_PAYMENT_SAFERPAYGW_CCCVC_TITLE' , 'CVC Eingabe');
  define('MODULE_PAYMENT_SAFERPAYGW_CCCVC_DESC' , 'Abfrage der Kartenpr&uuml;fnummer');
  define('MODULE_PAYMENT_SAFERPAYGW_CCNAME_TITLE' , 'Karteninhaber');
  define('MODULE_PAYMENT_SAFERPAYGW_CCNAME_DESC' , 'Abfrage des Karteninhabernamens');

  define('MODULE_PAYMENT_SAFERPAYGW_COMPLETE_TITLE', 'Transaktion verbuchen');
  define('MODULE_PAYMENT_SAFERPAYGW_COMPLETE_DESC', 'Sofortige Verbuchung der Saferpay Transaktion');
  define('MODULE_PAYMENT_SAFERPAYGW_MENUCOLOR_TITLE', '<hr size=1>Styling-Attribute zur farblichen Anpassung des Saferpay VT (optional)&nbsp;<a href="images/saferpaygw_styling.jpg" target=_blank><img src="images/icons/graphics/unknown.jpg" width="15" border="0" alt="Hilfe"></a><br><br>MENUCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_MENUCOLOR_DESC', 'Farbe inaktiver Reiter.');
  define('MODULE_PAYMENT_SAFERPAYGW_MENUFONTCOLOR_TITLE', 'MENUFONTCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_MENUFONTCOLOR_DESC', 'Schriftfarbe des Men&uuml;s.');
  define('MODULE_PAYMENT_SAFERPAYGW_BODYFONTCOLOR_TITLE', 'BODYFONTCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_BODYFONTCOLOR_DESC', 'Schriftfarbe des Eingabebereichs.');
  define('MODULE_PAYMENT_SAFERPAYGW_BODYCOLOR_TITLE', 'BODYCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_BODYCOLOR_DESC', 'Hintergrundfarbe des Saferpay VT.');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADFONTCOLOR_TITLE', 'HEADFONTCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADFONTCOLOR_DESC', 'Schriftfarbe der Reiter.');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADCOLOR_TITLE', 'HEADCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADCOLOR_DESC', 'Hintergrundfarbe des oberen Bereichs.');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADLINECOLOR_TITLE', 'HEADLINECOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_HEADLINECOLOR_DESC', 'Farbe der Trennlinie oben links.');
  define('MODULE_PAYMENT_SAFERPAYGW_LINKCOLOR_TITLE', 'LINKCOLOR');
  define('MODULE_PAYMENT_SAFERPAYGW_LINKCOLOR_DESC', 'Schriftfarbe der Links.');

$aLang['module_payment_saferpaygw_text_title'] = 'Carte Visa / Mastercard';
$aLang['module_payment_saferpaygw_text_description'] =  '<b>Compte test saferpay</b><br /><br />ACCOUNTID: 99867-94913159<br />Carte test normale: 9451123100000004<br />Valable jusqu\’à: 12/10, CVC 123<br /><br />Carte test pour 3D-Secure: 9451123100000111<br />Valable jusqu\’à: 12/10, CVC 123<br /><br /><b>login pour le département de facturation<br />sur www.saferpay.com:</b><br />Benutzername: e99867001<br />Mot de passe: Xajc3Kna<br /><hr>';

?>
