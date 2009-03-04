<?php
/* ----------------------------------------------------------------------
   $Id: search_advanced.php,v 1.1 2005/10/14 17:32:37 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: advanced_search.php,v 1.18 2003/02/16 00:42:02 harley_vb
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

$aLang['navbar_title'] = 'Recherche avanc�e';
$aLang['heading_title'] = 'Veuillez saisir vos crit�res de recherche';

$aLang['heading_search_criteria'] = 'Veuillez saisir vos mots-cl�s';

$aLang['text_search_in_description'] = 'Egalement chercher dans les descriptions';
$aLang['entry_categories'] = 'Cat�gories:';
$aLang['entry_include_subcategories'] = 'Inclure les sous-cat�gories';
$aLang['entry_manufacturers'] = 'Producteur:';
$aLang['entry_price_from'] = 'Prix d�s:';
$aLang['entry_price_to'] = 'Prix jusqu\'�:';
$aLang['entry_date_from'] = 'ajout� par:';
$aLang['entry_date_to'] = 'ajout� jusqu\'�:';

$aLang['text_search_help_link'] = '<u>Aide pour la recherche avanc�e</u> [?]';

$aLang['text_all_categories'] = 'Toutes les cat�gories';
$aLang['text_all_manufacturers'] = 'Tous les producteurs';

$aLang['heading_search_help'] = 'Aide pour la recherche avanc�e';
$aLang['text_search_help'] = 'La fonction de recherche vous permet une recherche par nom de l\'article, par description du produit, par producteur et par num�ro d\'article.<br /><br />Vous avez la possibilit� d\'utiliser les op�rations comme le "AND" (et) ou bien le "OR" (ou).<br /><br />Vous pouvez par exemple indiquer: <u>Microsoft AND souris</u>.<br /><br />Vous pouvez par ailleurs utiliser des parenth�ses afin de enchev�trer votre recherche, donc p.ex.:<br /><br /><u>Microsoft AND (souris OR clavier OR "Visual Basic")</u>.<br /><br />Vous pouvez gr�ce � des guillemets regrouper plusieurs termes � un mot de recherche.';
$aLang['text_close_window'] = '<u>fermer la fen�tre</u> [x]';

$aLang['js_at_least_one_input'] = '* Une des cases suivantes doit �tre saisie:\n    Mots-clefs\n    Date ajout�e par\n    Date ajout�e jusqu\'�\n    prix d�s\n    Pris jusqu\'�\n';
$aLang['js_invalid_from_date'] = '* �Date d�s� est irrecevable\n';
$aLang['js_invalid_to_date'] = '* �jusqu\'� est irrecevable\n';
$aLang['js_to_date_less_than_from_date'] = '* La date doit �tre ult�rieure ou �gale � jusqu\'� aujourd\'hui\n';
$aLang['js_price_from_must_be_num'] = '* �Prix d�s� doit �tre une chiffre\n';
$aLang['js_price_to_must_be_num'] = '* �Prix d�s� doit �tre une chiffre\n';
$aLang['js_price_to_less_than_price_from'] = '* Le �prix jusqu\'� doit �tre sup�rieur ou �gale au �prix d�s�.\n';
$aLang['js_invalid_keywords'] = '* mot de recherch� irrecevable\n';
?>
