<?php
/* ----------------------------------------------------------------------
   $Id: gv_send.php,v 1.1 2005/10/14 17:32:37 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: gv_send.php,v 1.1.2.1 2003/05/15 23:04:32 wilt
   ----------------------------------------------------------------------
   The Exchange Project - Community Made Shopping!
   http://www.theexchangeproject.org

   Gift Voucher System v1.0
   Copyright (c) 2001,2002 Ian C Wilson
   http://www.phesis.org
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

$aLang['heading_title'] = 'Envoyer un bon';
$aLang['navbar_title'] = 'Envoyer un bon';
$aLang['email_subject'] = 'Bon ' . STORE_NAME;
$aLang['heading_text'] = '<br />Vous pouvez ci-joint facilement faire parvenir un bon d\'achat de chez ' . STORE_NAME . ' à une de vos connaissances.<br /> Veuillez simplement indiquer le nom et l\'adresse e-mail de la personne à laquelle vous souhaitez offrir le bon, spécifiez par la suite la valeur que vous comptez donner, cliquez ensuite sur <b><tt>continuer</tt></b> et top c\'est parti. Vous retrouvez d\'informations ultérieures par rapport aux fonctions des bons dans <a href="' . oos_link($aModules['gv'], $aFilename['gv_faq']).'">FAQ bon\'s</a><br />';
$aLang['entry_name'] = 'Destinataire - Nom:';
$aLang['entry_email'] = 'Destinataire - Adresse e-mail:';
$aLang['entry_message'] = 'Votre message (qui sera envoyée avec le bon):';
$aLang['entry_amount'] = 'Valeur (Somme):';
$aLang['error_entry_amount_check'] = '&nbsp;&nbsp;<span class="errorText">somme invalide</span>';
$aLang['error_entry_email_address_check'] = '&nbsp;&nbsp;<span class="errorText">Adresse e-mail invalide</span>';
$aLang['main_message'] = 'Vous désirez envoyer un bon dans la valeur de %s à %s l\'adresse e-mail.<br /><br />Le texte suivant accompagnera l\'e-mail: <br /><br />Bonjour %s<br /><br /> un bon d\'achat dans la valeur de %s vous a été envoyé par %s.';

$aLang['personal_message'] = '%s parfois avec';
$aLang['text_success'] = 'Félicitation, votre bon a été envoyé avec succès.';

$aLang['email_separator'] = '----------------------------------------------------------------------------------------';
$aLang['email_gv_text_header'] = 'Meilleures félicitations, vous avez reçu un bon dans la valeur de %s';
$aLang['email_gv_text_subject'] = 'Ceci correspond à un bon de valeur de %s';
$aLang['email_gv_from'] = 'Ce bon vous a été envoyé par %s';
$aLang['email_gv_message'] = 'avec le message suivant ';
$aLang['email_gv_send_to'] = 'Bonjour, %s';
$aLang['email_gv_redeem'] = 'Veuillez cliquer sur le lien ci-joint afin d\'utiliser votre bon. Nous vous prions également de noter votre code du bon qui est le %s. En cas de difficultés touchant.';
$aLang['email_gv_link'] = 'Veuillez cliquer pour l\'utilisation ';
$aLang['email_gv_visit'] = ' ou visiter ';
$aLang['email_gv_enter'] = ' et enregistrer le code du bon ';
$aLang['email_gv_fixed_footer'] = 'Vous pouvez, si vous avez des difficultés avez l\'utilisation du bon par le lien automatique, ' . "\n" . 
                                'Également saisir le code du bon quand vous terminez la commande à la caisse.' . "\n\n";
$aLang['email_gv_shop_footer'] = '';
?>
