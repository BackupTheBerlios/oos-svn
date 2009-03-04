<?php
/* ----------------------------------------------------------------------
   $Id: user_password_forgotten.php,v 1.3 2007/10/22 22:22:15 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: password_forgotten.php,v 1.6 2002/11/19 01:48:08 dgw_ 
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

$aLang['navbar_title_1'] = 'Login';
$aLang['navbar_title_2'] = 'Password Forgotten';
$aLang['heading_title'] = 'I\'ve Forgotten My Password!';
$aLang['text_no_email_address_found'] = '<font color="#ff0000"><b>NOTE:</b></font> The E-Mail Address was not found in our records, please try again.';
$aLang['sub_title'] = 'Step 1:';
$aLang['text_info'] = 'Enter the e-mail address associated with your ' . STORE_NAME . ' account, then click Continue.<br>';
$aLang['text_new_account_info'] = 'Has your e-mail address changed? If you\'ve forgotten your password and no longer use the e-mail address associated with your ' . STORE_NAME . ' account, you may choose from the following:';
$aLang['text_create_new_account'] = 'Create a new ' . STORE_NAME . 'account';

$aLang['email_password_reminder_subject'] = STORE_NAME . ' - New Password';
$aLang['email_password_reminder_body'] = 'A new password was requested from ' . oos_server_get_remote() . '.' . "\n\n" . 'Your new password to \'' . STORE_NAME . '\' is:' . "\n\n" . '   %s' . "\n\n";
$aLang['text_password_sent'] = 'A New Password Has Been Sent To Your Email Address';
?>
