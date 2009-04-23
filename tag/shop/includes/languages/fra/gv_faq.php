<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: gv_faq.php,v 1.1.2.1 2003/05/15 23:04:32 wilt
   ----------------------------------------------------------------------
   The Exchange Project - Community Made Shopping!
   http://www.theexchangeproject.org

   Gift Voucher System v1.0
   Copyright (c) 2001,2002 Ian C Wilson
   http://www.phesis.org
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

$aLang['navbar_title'] = 'Bons, questions et r�ponses';
$aLang['heading_title'] = 'Bons, questions et r�ponses';

$aLang['text_information'] = '<a name="Top"></a>
  <a href="'.oos_link($aModules['gv'], $aFilename['gv_faq'],'faq_item=1','NONSSL').'">Comment puis-je acheter un bon?</a><br />
  <a href="'.oos_link($aModules['gv'], $aFilename['gv_faq'],'faq_item=2','NONSSL').'">Comment puis-je envoyer un bon?</a><br />
  <a href="'.oos_link($aModules['gv'], $aFilename['gv_faq'],'faq_item=3','NONSSL').'">Comment puis-je faire des achats avec un bon?</a><br />
  <a href="'.oos_link($aModules['gv'], $aFilename['gv_faq'],'faq_item=4','NONSSL').'">Comment puis-je valider un bon?</a><br />
  <a href="'.oos_link($aModules['gv'], $aFilename['gv_faq'],'faq_item=5','NONSSL').'">Comment proc�der en cas de probl�mes?</a><br />
';
switch ($_GET['faq_item']) {
  case '1':
$aLang['sub_heading_title'] = 'Achat de bons';
$aLang['sub_heading_text'] = 'Les bons sont dans notre magasin trait�s comme tout autre article. 
Vous pouvez les payer avec les formes de paiements que nous offrons dans notre boutique. 
Vous retrouvez, une fois que le paiement est effectu�, la valeur du bon dans votre compte de bon qui se trouve au-dessous du panier.
Vous y apercevez �galement un lien conduisant � une page suivante. 
Vous pouvez � partir de celle-ci envoyer les bons � une autre personne par e-mail
.';
  break;
  case '2':
$aLang['sub_heading_title'] = 'Envoyer des bons';
$aLang['sub_heading_text'] = 'Vous devez vous diriger vers la page correspondante afin d\'envoyer un bon. 
Si vous avez des valeurs actives sur votre compte de bon, vous apercevez le lien conduisant � la page en cons�quence (au-dessous du panier c.�.d en haut de chaque page dans la colonne droite). 
Veuillez introduire le nom et l\'adresse e-mail de la personne � laquelle vous d�sirez envoyer le bon. 
Vous pouvez �galement indiquer la valeur que vous tenez envoyer. (Attention! Vous ne devez pas envoyer l\'avoir total sous forme de bon! Vous avez ainsi le choix de distribuer la valeur du bon � plusieurs personnes!) 
Vous pouvez aussi accompagner votre e-mail d\'un petit message. Nous vous prions de v�rifier toutes les donn�es soigneusement. 
Vous avez avant l\'envoi d�finitif du bon encore maintes possibilit�s de modifier vos donn�es.';
  break;
  case '3':
  $aLang['sub_heading_title'] = 'Achat avec un bon';
  $aLang['sub_heading_text'] = 'Si vous avez un solde positif sur votre compte de bon, vous pouvez l\'utiliser pour l\'achat de n\'importe quel article de notre boutique. 
Une interrogation suppl�mentaire appara�tra � la fin du processus de commande. 
Votre bon d\'achat sera utilis� pour cette commande si vous le s�lectionnez explicitement. Nous vous prions de tenir compte du fait qu\'il faudra choisir une forme de paiement pour le cas o� la valeur de la commande d�passe celle du compte de bon. 
Si la valeur active du compte est sup�rieure � votre commande, le solde restera alors enregistr� pour des commandes futures dans notre boutique.';
  break;
  case '4':
  $aLang['sub_heading_title'] = 'Endossement des bons';
  $aLang['sub_heading_text'] = 'Si vous recevez un bon par e-mail, le message sera accompagn� par quelques informations. 
Vous apprenez qui vous l\'a envoy�. Si l\'exp�diteur vous a laiss� un message, vous pouvez �videmment le consulter. 
L\'e-mail contient �galement le code pour votre bon. Nous vous recommandons pour des raisons s�curitaires d\'imprimer le message ou de vous noter le code s�par�ment. 
Vous pouvez endosser le bon de deux mani�res:<br />
  1. Cliquez sur le lien dans le message. 
Vous arrivez alors sur la page des bons de notre boutique. 
Si vous �tes d�j� client, vous pouvez vous y inscrire ou sinon cr�er un nouveau compte client. 
Le code du bon est identifi� par la suite et la somme vous sera accr�dit�e sur votre compte de bon personnel. 
Vous pouvez utiliser le solde pour divers achats dans notre boutique.
  2. Une case particuli�re appara�tra � la fin du processus de commande � la page o� vous choisissez la forme de paiement. 
La case est destin�e pour introduire votre code de bon. Une fois saisi, cliquez sur "encaisser". 
Le code sera identifi� et la somme vous sera accr�dit�e sur votre compte de bon personnel.
Vous pouvez utiliser le solde pour divers achats dans notre boutique.';
  break;
  case '5':
  $aLang['sub_heading_title'] = 'En cas de difficult�s';
  $aLang['sub_heading_text'] = ' Si des difficult�s devraient surgir avec le syst�me des bons, v�rifiez soigneusement toutes les donn�es saisies! 
Nous vous prions de bien vouloir nous contacter par e-mail '. STORE_OWNER_EMAIL_ADDRESS . '. si des probl�mes avec le syst�me de bons devraient persister. 
Veuillez dans le cas �ch�ant nous indiquer le plus d\'informations possibles! Merci beaucoup! ';
  break;
  default:
  $aLang['sub_heading_title'] = '';
  $aLang['sub_heading_text'] = 'Veuillez s�lectionner une des questions mentionn�es ci-dessus';

  }
?>
