<?php
/* ----------------------------------------------------------------------
   $Id: user_password_forgotten.php,v 1.5 2007/10/22 22:22:15 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
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


$aLang['navbar_title_1'] = 'Aanmelden';
$aLang['navbar_title_2'] = 'Wachtwoord vergeten';
$aLang['heading_title'] = 'Wat was ook alweer mijn wachtwoord?';
$aLang['text_no_email_address_found'] = '<font color="#ff0000"><b>ATTENTIE:</b></font> Het ingevoerde emailadres is niet geregistreerd. probeer het a.u.b. nog een keer.';
$aLang['sub_title'] = 'Step 1:';
$aLang['text_info'] = 'Enter the e-mail address associated with your ' . STORE_NAME . ' account, then click Continue.<br>';
$aLang['text_new_account_info'] = 'Has your e-mail address changed? If you\'ve forgotten your password and no longer use the e-mail address associated with your ' . STORE_NAME . ' account, you may choose from the following:';
$aLang['text_create_new_account'] = 'Create a new ' . STORE_NAME . 'account';

$aLang['email_password_reminder_subject'] = STORE_NAME . ' - Uw nieuwe wachtwoord.';
$aLang['email_password_reminder_body'] = 'Via het adres ' . oos_server_get_remote() . ' hebben wij een verzoek voor wachtwoordvenieuwing.' . "\n\n" . 'Uw nieuwe wachtwoord voor \'' . STORE_NAME . '\' is vanaf heden:' . "\n\n" . '   %s' . "\n\n";
$aLang['text_password_sent'] = 'Een nieuw wachtwoord is per email verstuurd.';
?>
