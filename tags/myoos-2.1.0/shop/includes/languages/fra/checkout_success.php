<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: checkout_success.php,v 1.17 2003/02/16 00:42:03 harley_vb
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

$aLang['navbar_title_1'] = 'Caisse';
$aLang['navbar_title_2'] = 'Succ�s';

$aLang['heading_title'] = 'Merci beaucoup!';

$aLang['text_success'] = 'Nous accusons r�ception de votre commande. Elle est d�j� en traitement. La livraison devrait s\'effectuer dans les prochains 2 � 5 jours ouvrables.';
$aLang['text_notify_products'] = 'Je tiens � �tre tenu inform� des actualit�s touchant les articles suivants:';
$aLang['text_see_orders'] = 'Vous pouvez � tout moment examiner votre / vos commande(s) � la page <a href="' . oos_link($aModules['user'], $aFilename['account'], '', 'SSL') . '"><u>\'et y visualiser \'</a></u> votre compte <a href="' . oos_link($aModules['account'], $aFilename['account_history'], '', 'SSL') . '"><u>\'et votre\'</u></a> aper�u de commande.';
$aLang['text_contact_store_owner'] = 'N\'h�sitez pas � <a href="' . oos_link($aModules['main'], $aFilename['contact_us']) . '"><u>nous contacter pour toute question ult�rieure</u></a>.';
$aLang['text_thanks_for_shopping'] = 'Nous vous remercions de votre achat en ligne!';

$aLang['table_heading_download_date'] = 'T�l�chargement possible jusqu\'au:';
$aLang['table_heading_download_count'] = 'Nombre maximal de t�l�chargements';
$aLang['heading_download'] = 'T�l�charger l\'article:';
$aLang['footer_download'] = 'Sachez que vous pouvez �galement t�l�charger vos articles ult�rieurement sous \'%s\' ';
?>
