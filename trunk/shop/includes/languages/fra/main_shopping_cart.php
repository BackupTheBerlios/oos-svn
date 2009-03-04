<?php
/* ----------------------------------------------------------------------
   $Id: main_shopping_cart.php,v 1.1 2005/10/14 17:32:37 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: shopping_cart.php,v 1.15 2002/04/17 15:57:07 harley_vb
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

$aLang['navbar_title'] = 'Panier';
$aLang['heading_title'] = 'Votre panier contient:';
$aLang['table_heading_remove'] = 'Annuler';
$aLang['table_heading_quantity'] = 'Quantit�';
$aLang['table_heading_model'] = 'Num�ro d\�article';
$aLang['table_heading_products'] = 'Article';
$aLang['table_heading_total'] = 'Somme';
$aLang['text_cart_empty'] = 'Nous n\�avez pas encore d\�articles dans votre panier.';
$aLang['SUB_TITLE_SUB_TOTAL'] = 'Sous-total:';
$aLang['SUB_TITLE_TOTAL'] = 'Somme:';

$aLang['out_of_stock_cant_checkout'] = 'Les articles marqu�s par' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' ne sont malheureusement plus en stock dans la quantit� demand�e.<br />Nous vous prions de r�duire la quantit� de commande pour les articles marqu�s. Merci beaucoup';
$aLang['out_of_stock_can_checkout'] = 'Les articles marqu�s par ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' ne sont malheureusement plus en stock dans la quantit� souhait�e.<br />La quantit� demand�e sera livr�e d�s que possible. Nous effectuons, si vous le d�sirez, d�j� une livraison partielle.';
?>
