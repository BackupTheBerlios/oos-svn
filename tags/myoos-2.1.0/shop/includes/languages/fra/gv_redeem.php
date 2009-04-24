<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: gv_redeem.php,v 1.1.2.1 2003/05/15 23:04:32 wilt
   ----------------------------------------------------------------------
   The Exchange Project - Community Made Shopping!
   http://www.theexchangeproject.org

   Gift Voucher System v1.0
   Copyright (c) 2001,2002 Ian C Wilson
   http://www.phesis.org
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

$aLang['navbar_title'] = 'Utiliser le bon';
$aLang['heading_title'] = 'Utiliser le bon';
$aLang['text_information'] = 'Veuillez lire nos CGV pour obtenir d\'informations ultérieures par rapport aux bons <a href="' . oos_link($aModules['gv'], $aFilename['gv_faq']).'">'.GV_FAQ.'.</a>';
$aLang['text_invalid_gv'] = 'Il se peut que le code du bon soit invalide ou déjà utilisé. N\'hésitez pas à nous contactez par notre site de contact <a href="' . oos_link($aModules['main'], $aFilename['contact_us']) . '"> en cas de questions</a>.';
$aLang['text_valid_gv'] = 'Meilleures félicitations; vous avez endossé un bon dans la valeur de CHF %s.';
?>
