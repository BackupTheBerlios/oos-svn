<?php
/* ----------------------------------------------------------------------
   $Id: user_password_forgotten.php,v 1.1 2005/10/14 17:32:38 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
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

$aLang['navbar_title_1'] = 'Connecter';
$aLang['navbar_title_2'] = 'Avez-vous oublié votre mot de passe';
$aLang['heading_title'] = 'Mon mot de passe; qu\'en était-il déjà?';
$aLang['text_no_email_address_found'] = '<font color="#ff0000"><b>ATTENTION:</b></font> L\'adresse e-mail saisie n\'est pas registrée, veuillez s.v.p. essayer encore une fois.';
$aLang['email_password_reminder_subject'] = STORE_NAME . ' - Votre nouveau mot de passe.';
$aLang['email_password_reminder_body'] = 'Nous venons de recevoir de l\'adresse suivante' . oos_server_get_remote() . ' une demande pour le renouvellement du mot de passe.' . "\n\n" . 'Votre nouveau mot de passe pour \'' . STORE_NAME . '\' est dès maintenant:' . "\n\n" . '   %s' . "\n\n";
$aLang['text_password_sent'] = 'Votre nouveau mot de passe vous a été envoyé par e-mail.';
?>
