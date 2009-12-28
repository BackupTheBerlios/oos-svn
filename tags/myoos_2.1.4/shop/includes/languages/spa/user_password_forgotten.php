<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: password_forgotten.php,v 1.6 2002/11/12 00:45:21 dgw_ 
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


$aLang['navbar_title_1'] = 'Entrar';
$aLang['navbar_title_2'] = 'Constrase� Olvidada';
$aLang['heading_title'] = 'He olvidado mi Contrase�!';
$aLang['sub_title'] = 'Step 1:';
$aLang['text_info'] = 'Enter the e-mail address associated with your ' . STORE_NAME . ' account, then click Continue.<br>';
$aLang['text_new_account_info'] = 'Has your e-mail address changed? If you\'ve forgotten your password and no longer use the e-mail address associated with your ' . STORE_NAME . ' account, you may choose from the following:';
$aLang['text_create_new_account'] = 'Create a new ' . STORE_NAME . 'account';

$aLang['text_no_email_address_found'] = '<font color="#ff0000"><b>NOTA:</b></font> Ese E-Mail no figura en nuestros datos, intentelo de nuevo.';
$aLang['email_password_reminder_subject'] = STORE_NAME . ' - Nueva Contrase�';
$aLang['email_password_reminder_body'] = 'Ha solicitado una Nueva Contrase� desde ' . oos_server_get_remote() . '.' . "\n\n" . 'Su nueva contrase� para \'' . STORE_NAME . '\' es:' . "\n\n" . '   %s' . "\n\n";
$aLang['text_password_sent'] = 'Se Ha Enviado Una Nueva Contrase� A Tu Email';
?>
