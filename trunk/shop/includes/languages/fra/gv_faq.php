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

$aLang['navbar_title'] = 'Bons, questions et réponses';
$aLang['heading_title'] = 'Bons, questions et réponses';

$aLang['text_information'] = '<a name="Top"></a>
  <a href="'.oos_link($aModules['gv'], $aFilename['gv_faq'],'faq_item=1','NONSSL').'">Comment puis-je acheter un bon?</a><br />
  <a href="'.oos_link($aModules['gv'], $aFilename['gv_faq'],'faq_item=2','NONSSL').'">Comment puis-je envoyer un bon?</a><br />
  <a href="'.oos_link($aModules['gv'], $aFilename['gv_faq'],'faq_item=3','NONSSL').'">Comment puis-je faire des achats avec un bon?</a><br />
  <a href="'.oos_link($aModules['gv'], $aFilename['gv_faq'],'faq_item=4','NONSSL').'">Comment puis-je valider un bon?</a><br />
  <a href="'.oos_link($aModules['gv'], $aFilename['gv_faq'],'faq_item=5','NONSSL').'">Comment procéder en cas de problèmes?</a><br />
';
switch ($_GET['faq_item']) {
  case '1':
$aLang['sub_heading_title'] = 'Achat de bons';
$aLang['sub_heading_text'] = 'Les bons sont dans notre magasin traités comme tout autre article. 
Vous pouvez les payer avec les formes de paiements que nous offrons dans notre boutique. 
Vous retrouvez, une fois que le paiement est effectué, la valeur du bon dans votre compte de bon qui se trouve au-dessous du panier.
Vous y apercevez également un lien conduisant à une page suivante. 
Vous pouvez à partir de celle-ci envoyer les bons à une autre personne par e-mail
.';
  break;
  case '2':
$aLang['sub_heading_title'] = 'Envoyer des bons';
$aLang['sub_heading_text'] = 'Vous devez vous diriger vers la page correspondante afin d\'envoyer un bon. 
Si vous avez des valeurs actives sur votre compte de bon, vous apercevez le lien conduisant à la page en conséquence (au-dessous du panier c.à.d en haut de chaque page dans la colonne droite). 
Veuillez introduire le nom et l\'adresse e-mail de la personne à laquelle vous désirez envoyer le bon. 
Vous pouvez également indiquer la valeur que vous tenez envoyer. (Attention! Vous ne devez pas envoyer l\'avoir total sous forme de bon! Vous avez ainsi le choix de distribuer la valeur du bon à plusieurs personnes!) 
Vous pouvez aussi accompagner votre e-mail d\'un petit message. Nous vous prions de vérifier toutes les données soigneusement. 
Vous avez avant l\'envoi définitif du bon encore maintes possibilités de modifier vos données.';
  break;
  case '3':
  $aLang['sub_heading_title'] = 'Achat avec un bon';
  $aLang['sub_heading_text'] = 'Si vous avez un solde positif sur votre compte de bon, vous pouvez l\'utiliser pour l\'achat de n\'importe quel article de notre boutique. 
Une interrogation supplémentaire apparaîtra à la fin du processus de commande. 
Votre bon d\'achat sera utilisé pour cette commande si vous le sélectionnez explicitement. Nous vous prions de tenir compte du fait qu\'il faudra choisir une forme de paiement pour le cas où la valeur de la commande dépasse celle du compte de bon. 
Si la valeur active du compte est supérieure à votre commande, le solde restera alors enregistré pour des commandes futures dans notre boutique.';
  break;
  case '4':
  $aLang['sub_heading_title'] = 'Endossement des bons';
  $aLang['sub_heading_text'] = 'Si vous recevez un bon par e-mail, le message sera accompagné par quelques informations. 
Vous apprenez qui vous l\'a envoyé. Si l\'expéditeur vous a laissé un message, vous pouvez évidemment le consulter. 
L\'e-mail contient également le code pour votre bon. Nous vous recommandons pour des raisons sécuritaires d\'imprimer le message ou de vous noter le code séparément. 
Vous pouvez endosser le bon de deux manières:<br />
  1. Cliquez sur le lien dans le message. 
Vous arrivez alors sur la page des bons de notre boutique. 
Si vous êtes déjà client, vous pouvez vous y inscrire ou sinon créer un nouveau compte client. 
Le code du bon est identifié par la suite et la somme vous sera accréditée sur votre compte de bon personnel. 
Vous pouvez utiliser le solde pour divers achats dans notre boutique.
  2. Une case particulière apparaîtra à la fin du processus de commande à la page où vous choisissez la forme de paiement. 
La case est destinée pour introduire votre code de bon. Une fois saisi, cliquez sur "encaisser". 
Le code sera identifié et la somme vous sera accréditée sur votre compte de bon personnel.
Vous pouvez utiliser le solde pour divers achats dans notre boutique.';
  break;
  case '5':
  $aLang['sub_heading_title'] = 'En cas de difficultés';
  $aLang['sub_heading_text'] = ' Si des difficultés devraient surgir avec le système des bons, vérifiez soigneusement toutes les données saisies! 
Nous vous prions de bien vouloir nous contacter par e-mail '. STORE_OWNER_EMAIL_ADDRESS . '. si des problèmes avec le système de bons devraient persister. 
Veuillez dans le cas échéant nous indiquer le plus d\'informations possibles! Merci beaucoup! ';
  break;
  default:
  $aLang['sub_heading_title'] = '';
  $aLang['sub_heading_text'] = 'Veuillez sélectionner une des questions mentionnées ci-dessus';

  }
?>
