<?php
/* ----------------------------------------------------------------------
   $Id$

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

define('ADMIN_PASSWORD_SUBJECT', STORE_NAME . ' - Votre nouveau mot de passe.');
define('ADMIN_EMAIL_TEXT', 'Par l\'adresse ' . oosServerGetVar('REMOTE_ADDR') . 'Nous avons reçu une demande pour un renouvellement de mot de passe.' . "\n\n" . 'Votre nouveau mot de passe pour \'' . STORE_NAME . '\' est dès maintenant:' . "\n\n" . '   %s' . "\n\n");

deine('HEADING_PASSWORD_FORGOTTEN', 'Oublié le mot de passe');
define('TEXT_PASSWORD_INFO', 'Entrez votre prénom et votre adresse e-mail et cliquez sur envoyer le mot de passe. <br />Vous allez recevoir prochainement un nouveau mot de passe. Utilisez ce mot de passe pour vous inscrire à votre compte.');
?>
