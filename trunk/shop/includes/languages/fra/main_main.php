<?php
/* ----------------------------------------------------------------------
   $Id: main_main.php,v 1.1 2005/10/14 17:32:37 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: default.php,v 1.22 2003/02/16 00:42:03 harley_vb
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// Willkommenstext mit zuf�llig ausgew�hltem Zitat erg�nzen
$_zufall=rand(1,13);
switch($_zufall) {
	case 1: $aLang['text_main'] = '<span class="zitat">&quot;Les passions sont les vents qui enflent les voiles du navire; elles le submergent quelquefois, mais sans elles il ne pourrait voguer.&quot;</span><br><span class="zitat_autor">Voltaire</span>'; break;
	case 2: $aLang['text_main'] = '<span class="zitat">&quot;Nous plaisons plus souvent dans le commerce de la vie par nos d�fauts que par nos qualit�s.&quot;</span><br><span class="zitat_autor">La Rochefoucauld</span>'; break;
	case 3: $aLang['text_main'] = '<span class="zitat">&quot;La vie ressemble � un conte ; ce qui importe, ce n\'est pas sa longueur, mais sa valeur.&quot;</span><br><span class="zitat_autor">S�n�que</span>'; break;
	case 4: $aLang['text_main'] = '<span class="zitat">&quot;Les grandes pens�es viennent du coeur, et les grandes affections viennent de la raison.&quot;</span><br><span class="zitat_autor">Louis de Bonald</span>'; break;
	case 5: $aLang['text_main'] = '<span class="zitat">&quot;On jouit moins de tout ce qu\'on obtient que de ce qu\'on esp�re.&quot;</span><br><span class="zitat_autor">J.-J. Rousseau</span>'; break;
	case 6: $aLang['text_main'] = '<span class="zitat">&quot;Il y a du plaisir � rencontrer les yeux de celui � qui l\'on vient de donner.&quot;</span><br><span class="zitat_autor">La Bruy�re</span>'; break;
	case 7: $aLang['text_main'] = '<span class="zitat">&quot;On parle toujours mal quand on a rien � dire.&quot;</span><br><span class="zitat_autor">Voltaire</span>'; break;
	case 8: $aLang['text_main'] = '<span class="zitat">&quot;Le hasard gouverne un peu plus de la moiti� de nos actions, et nous dirigeons le reste.&quot;</span><br><span class="zitat_autor">Machiavel</span>'; break;
	case 9: $aLang['text_main'] = '<span class="zitat">&quot;L\'�ducation d�veloppe les facult�s, mais ne les cr�e pas.&quot;</span><br><span class="zitat_autor">Voltaire</span>'; break;
	case 10: $aLang['text_main'] = '<span class="zitat">&quot;On jouit moins de tout ce qu\'on obtient que de ce qu\'on esp�re.&quot;</span><br><span class="zitat_autor">J.-J. Rousseau</span>'; break;
	case 11: $aLang['text_main'] = '<span class="zitat">&quot;Si l\'homme r�alisait la moiti� de ses d�sirs, il doublerait ses peines.&quot;</span><br><span class="zitat_autor">Benjamin Franklin</span>'; break;
	case 12: $aLang['text_main'] = '<span class="zitat">&quot;Ce n\'est pas parce que les choses sont difficiles que nous n\'osons pas, c\'est parce que nous n\'osons pas qu\'elles sont difficiles.&quot;</span><br><span class="zitat_autor">S�n�que</span>'; break;
	case 13: $aLang['text_main'] = '<span class="zitat">&quot;Il y a du plaisir � rencontrer les yeux de celui � qui l\'on vient de donner.&quot;</span><br><span class="zitat_autor">La Bruy�re</span>'; break;

}

//$aLang['text_main'] = '';
$aLang['table_heading_new_products'] = 'Nouveaux articles dans %s';
$aLang['table_heading_upcoming_products'] = 'Quoi est d�s quand disponible';
$aLang['table_heading_date_expected'] = 'Date';
$aLang['table_heading_featured_products'] = 'Specials';
$aLang['table_heading_featured_products_category'] = 'Top-offres dans %s';
$aLang['heading_title'] = 'Notre offre';
$aLang['text_news_postedby'] = 'R�dig� par';
$aLang['text_news_reads'] = 'Lu une fois';
$aLang['text_news_comments'] = 'Commentaire';
$aLang['text_news_score'] = '�valuation moyenne:';
$aLang['text_news_printer'] = 'Version imprimable';
$aLang['text_news_on'] = 'le';
$aLang['text_news_readmore'] = 'plus...';
?>
