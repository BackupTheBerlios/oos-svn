<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
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
/* ----------------------------------------------------------------------
   If you made a translation, please send to
      lang@oos-shop.de
   the translated file.
   ---------------------------------------------------------------------- */

if (isset($_GET['origin']) && ($_GET['origin'] == $aPages['checkout_payment'])) {
  $aLang['navbar_title'] = 'Commander';
  $aLang['heading_title'] = 'Passer une commande en ligne est tr�s facile.';
} else {
  $aLang['navbar_title'] = 'Inscrire';
  $aLang['heading_title'] = 'Inscrivez-vous';
}

$aLang['heading_new_customer'] = 'Nouveau client';
$aLang['text_new_customer'] = 'Je suis un nouveau client.';
$aLang['text_new_customer_introduction'] = 'Vous pouvez gr�ce � votre inscription chez ' . STORE_NAME . ' commander plus rapidement. Vous connaissez � tout moment le statut de votre commande et avez toujours un aper�u actuel touchant vos commandes pr�c�dentes.';

$aLang['heading_returning_customer'] = 'D�j� client';
$aLang['text_returning_customer'] = 'Je suis d�j� client.';

$aLang['entry_remember_me'] = 'Automatique de connection<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:win_autologon(\'' . oos_link($aPages['info_autologon']) . '\');"><b><u>D\'abord lire ici!</u></b></a>';
$aLang['text_password_forgotten'] = 'Avez-vous oubli� votre mot de passe? Cliquez alors <u>ici</u>';

$aLang['text_login_error'] = '<font color="#ff0000"><b>ERREUR:</b></font> Concordance entre l\' \'adresse e-mail\' indiqu�e et/ou le \'mot de passe\' n\'est pas donn�e.';
$aLang['text_visitors_cart'] = '<font color="#ff0000"><b>ATTENTION:</b></font> Vos donn�es de visiteur seront automatiquement li�es � votre compte client. <a href="javascript:session_win(\'' . oos_link($aPages['info_shopping_cart']) . '\');">[Plus d\'informations]</a>';

