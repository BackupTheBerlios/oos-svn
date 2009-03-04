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

$aLang['navbar_title'] = 'Recherche avancée';
$aLang['heading_title'] = 'Veuillez saisir vos critères de recherche';

$aLang['heading_search_criteria'] = 'Veuillez saisir vos mots-clés';

$aLang['text_search_in_description'] = 'Egalement chercher dans les descriptions';
$aLang['entry_categories'] = 'Catégories:';
$aLang['entry_include_subcategories'] = 'Inclure les sous-catégories';
$aLang['entry_manufacturers'] = 'Producteur:';
$aLang['entry_price_from'] = 'Prix dès:';
$aLang['entry_price_to'] = 'Prix jusqu\'à:';
$aLang['entry_date_from'] = 'ajouté par:';
$aLang['entry_date_to'] = 'ajouté jusqu\'à:';

$aLang['text_search_help_link'] = '<u>Aide pour la recherche avancée</u> [?]';

$aLang['text_all_categories'] = 'Toutes les catégories';
$aLang['text_all_manufacturers'] = 'Tous les producteurs';

$aLang['heading_search_help'] = 'Aide pour la recherche avancée';
$aLang['text_search_help'] = 'La fonction de recherche vous permet une recherche par nom de l\'article, par description du produit, par producteur et par numéro d\'article.<br /><br />Vous avez la possibilité d\'utiliser les opérations comme le "AND" (et) ou bien le "OR" (ou).<br /><br />Vous pouvez par exemple indiquer: <u>Microsoft AND souris</u>.<br /><br />Vous pouvez par ailleurs utiliser des parenthèses afin de enchevêtrer votre recherche, donc p.ex.:<br /><br /><u>Microsoft AND (souris OR clavier OR "Visual Basic")</u>.<br /><br />Vous pouvez grâce à des guillemets regrouper plusieurs termes à un mot de recherche.';
$aLang['text_close_window'] = '<u>fermer la fenêtre</u> [x]';

$aLang['js_at_least_one_input'] = '* Une des cases suivantes doit être saisie:\n    Mots-clefs\n    Date ajoutée par\n    Date ajoutée jusqu\'à\n    prix dès\n    Pris jusqu\'à\n';
$aLang['js_invalid_from_date'] = '* «Date dès» est irrecevable\n';
$aLang['js_invalid_to_date'] = '* «jusqu\'à» est irrecevable\n';
$aLang['js_to_date_less_than_from_date'] = '* La date doit être ultérieure ou égale à jusqu\'à aujourd\'hui\n';
$aLang['js_price_from_must_be_num'] = '* «Prix dès» doit être une chiffre\n';
$aLang['js_price_to_must_be_num'] = '* «Prix dès» doit être une chiffre\n';
$aLang['js_price_to_less_than_price_from'] = '* Le «prix jusqu\'à» doit être supérieur ou égale au «prix dès».\n';
$aLang['js_invalid_keywords'] = '* mot de recherché irrecevable\n';
?>
