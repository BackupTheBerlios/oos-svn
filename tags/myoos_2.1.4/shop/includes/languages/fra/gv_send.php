<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
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
/* ----------------------------------------------------------------------
   If you made a translation, please send to
      lang@oos-shop.de
   the translated file.
   ---------------------------------------------------------------------- */

$aLang['heading_title'] = 'Envoyer un bon';
$aLang['navbar_title'] = 'Envoyer un bon';
$aLang['email_subject'] = 'Bon ' . STORE_NAME;
$aLang['heading_text'] = '<br />Vous pouvez ci-joint facilement faire parvenir un bon d\'achat de chez ' . STORE_NAME . ' � une de vos connaissances.<br /> Veuillez simplement indiquer le nom et l\'adresse e-mail de la personne � laquelle vous souhaitez offrir le bon, sp�cifiez par la suite la valeur que vous comptez donner, cliquez ensuite sur <b><tt>continuer</tt></b> et top c\'est parti. Vous retrouvez d\'informations ult�rieures par rapport aux fonctions des bons dans <a href="' . oos_link($aPages['gv_faq']).'">FAQ bon\'s</a><br />';
$aLang['entry_name'] = 'Destinataire - Nom:';
$aLang['entry_email'] = 'Destinataire - Adresse e-mail:';
$aLang['entry_message'] = 'Votre message (qui sera envoy�e avec le bon):';
$aLang['entry_amount'] = 'Valeur (Somme):';
$aLang['error_entry_amount_check'] = '&nbsp;&nbsp;<span class="errorText">somme invalide</span>';
$aLang['error_entry_email_address_check'] = '&nbsp;&nbsp;<span class="errorText">Adresse e-mail invalide</span>';
$aLang['main_message'] = 'Vous d�sirez envoyer un bon dans la valeur de %s � %s l\'adresse e-mail.<br /><br />Le texte suivant accompagnera l\'e-mail: <br /><br />Bonjour %s<br /><br /> un bon d\'achat dans la valeur de %s vous a �t� envoy� par %s.';

$aLang['personal_message'] = '%s parfois avec';
$aLang['text_success'] = 'F�licitation, votre bon a �t� envoy� avec succ�s.';

$aLang['email_separator'] = '----------------------------------------------------------------------------------------';
$aLang['email_gv_text_header'] = 'Meilleures f�licitations, vous avez re�u un bon dans la valeur de %s';
$aLang['email_gv_text_subject'] = 'Ceci correspond � un bon de valeur de %s';
$aLang['email_gv_from'] = 'Ce bon vous a �t� envoy� par %s';
$aLang['email_gv_message'] = 'avec le message suivant ';
$aLang['email_gv_send_to'] = 'Bonjour, %s';
$aLang['email_gv_redeem'] = 'Veuillez cliquer sur le lien ci-joint afin d\'utiliser votre bon. Nous vous prions �galement de noter votre code du bon qui est le %s. En cas de difficult�s touchant.';
$aLang['email_gv_link'] = 'Veuillez cliquer pour l\'utilisation ';
$aLang['email_gv_visit'] = ' ou visiter ';
$aLang['email_gv_enter'] = ' et enregistrer le code du bon ';
$aLang['email_gv_fixed_footer'] = 'Vous pouvez, si vous avez des difficult�s avez l\'utilisation du bon par le lien automatique, ' . "\n" . 
                                '�galement saisir le code du bon quand vous terminez la commande � la caisse.' . "\n\n";
$aLang['email_gv_shop_footer'] = '';

