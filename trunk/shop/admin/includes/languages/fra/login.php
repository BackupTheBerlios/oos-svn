<?php
/* ----------------------------------------------------------------------
   $Id: login.php,v 1.1 2005/10/14 15:04:01 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: login.php,v 1.11 2002/06/03 13:19:42 hpdl 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('HEADING_RETURNING_ADMIN', 'Anmeldebereich:');

define('TEXT_RETURNING_ADMIN', 'Nur f&uuml;r Mitarbeiter!');
define('ENTRY_EMAIL_ADDRESS', 'E-Mail-Adresse:');
define('ENTRY_PASSWORD', 'Passwort:');
define('ENTRY_FIRSTNAME', 'Vorname:');
define('IMAGE_BUTTON_LOGIN', '‹bertragen');

define('SECURITYCODE', 'Sicherheitscode:');
define('TEXT_PASSWORD_FORGOTTEN', 'Passwort vergessen?');

define('TEXT_WELCOME', ' Willkommen bei OOS <br />OOS [OSIS Online Shop]!</p><p>Use a valid eMail and password to gain access to the administration console.');

define('TEXT_LOGIN_ERROR', '<font color="#ff0000"><b>ERROR:</b></font> Falscher Benutzername oder Passwort!');
define('TEXT_FORGOTTEN_ERROR', '<font color="#ff0000"><b>FEHLER:</b></font> Vorname und Passwort sind nicht hinterlegt!');
define('TEXT_FORGOTTEN_FAIL', 'Sie haben es mehr als 3x versucht. Aus Sicherheitsgr&uuml;nden kontaktieren Sie bitte Ihren Administrator um ein neues Passwort zu erhalten.');
define('TEXT_FORGOTTEN_SUCCESS', 'Das neue Passwort wurde an Ihre E-Mail-Adresse gesendet. &uuml;berpr&uuml;fen Sie Ihren E-Mail-Eingang und klicken Sie zur&uuml;ck um sich anzumelden.');

define('ADMIN_EMAIL_SUBJECT', 'Neues Passwort'); 
define('ADMIN_EMAIL_TEXT', 'Hi %s,' . "\n\n" . 'Sie k&ouml;nnen den redaktionellen Bereich mit folgenden Passwort betreten. Nach erfolgtem Login, &auml;ndern Sie bitte aus Sicherheitsgr&uuml;nden Ihr Passwort!' . "\n\n" . 'Website : %s' . "\n" . 'Benutzername: %s' . "\n" . 'Passwort: %s' . "\n\n" . 'Danke!' . "\n" . '%s' . "\n\n" . 'Dies ist eine automatisierte Antwortmail. Bitte beantworten Sie diese nicht!'); 
?>
