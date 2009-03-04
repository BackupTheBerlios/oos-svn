<?php
/* ----------------------------------------------------------------------
   $Id: user_login.php,v 1.1 2005/10/14 17:32:37 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: login.php,v 1.12 2002/06/17 23:10:03 harley_vb
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

if (isset($_GET['origin']) && ($_GET['origin'] == $aFilename['checkout_payment'])) {
  $aLang['navbar_title'] = 'Commander';
  $aLang['heading_title'] = 'Passer une commande en ligne est très facile.';
} else {
  $aLang['navbar_title'] = 'Inscrire';
  $aLang['heading_title'] = 'Inscrivez-vous';
}

$aLang['heading_new_customer'] = 'Nouveau client';
$aLang['text_new_customer'] = 'Je suis un nouveau client.';
$aLang['text_new_customer_introduction'] = 'Vous pouvez grâce à votre inscription chez ' . STORE_NAME . ' commander plus rapidement. Vous connaissez à tout moment le statut de votre commande et avez toujours un aperçu actuel touchant vos commandes précédentes.';

$aLang['heading_returning_customer'] = 'Déjà client';
$aLang['text_returning_customer'] = 'Je suis déjà client.';

$aLang['entry_remember_me'] = 'Automatique de connection<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:win_autologon(\'' . oos_link($aModules['main'], $aFilename['info_autologon']) . '\');"><b><u>D\'abord lire ici!</u></b></a>';
$aLang['text_password_forgotten'] = 'Avez-vous oublié votre mot de passe? Cliquez alors <u>ici</u>';

$aLang['text_login_error'] = '<font color="#ff0000"><b>ERREUR:</b></font> Concordance entre l\' \'adresse e-mail\' indiquée et/ou le \'mot de passe\' n\'est pas donnée.';
$aLang['text_visitors_cart'] = '<font color="#ff0000"><b>ATTENTION:</b></font> Vos données de visiteur seront automatiquement liées à votre compte client. <a href="javascript:session_win(\'' . oos_link($aModules['main'], $aFilename['info_shopping_cart']) . '\');">[Plus d\'informations]</a>';
?>
