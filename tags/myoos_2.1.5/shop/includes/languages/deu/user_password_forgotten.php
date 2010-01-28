<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: password_forgotten.php,v 1.8 2003/02/16 00:42:03 harley_vb
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

$aLang['navbar_title_1'] = 'Anmelden';
$aLang['navbar_title_2'] = 'Passwort vergessen';
$aLang['heading_title'] = 'Wie war noch mal mein Passwort?';
$aLang['sub_title'] = 'Schritt 1:';
$aLang['text_info'] = 'Geben Sie die zu Ihrem ' . STORE_NAME . '-Konto geh&ouml;rende E-Mail-Adresse ein. Klicken Sie dann auf "Weiter".<br/>Wir senden Ihnen per E-Mail Ihr neues Passwort zu.';
$aLang['text_new_account_info'] = 'Hat sich Ihre E-Mail-Adresse ge&auml;ndert? Falls Sie Ihr Passwort vergessen haben und auch die E-Mail-Adresse zu Ihrem Kundenkonto nicht mehr aktuell ist, legen Sie am besten ein neues Kundenkonto an.';
$aLang['text_create_new_account'] = 'Neues Konto bei ' . STORE_NAME . ' anlegen';

$aLang['text_no_email_address_found'] = '<font color="#ff0000"><b>ACHTUNG:</b></font> Die eingegebene eMail-Adresse ist nicht registriert. Bitte versuchen Sie es noch einmal.';
$aLang['email_password_reminder_subject'] = STORE_NAME . ' - Ihr neues Passwort.';
$aLang['email_password_reminder_body'] = 'Über die Adresse ' . oos_server_get_remote() . ' haben wir eine Anfrage zur Passworterneuerung erhalten.' . "\n\n" . 'Ihr neues Passwort für \'' . STORE_NAME . '\' lautet ab sofort:' . "\n\n" . '   %s' . "\n\n";
$aLang['text_password_sent'] = 'Ein neues Passwort wurde per eMail verschickt.';


