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
$aLang['table_heading_quantity'] = 'Quantité';
$aLang['table_heading_model'] = 'Numéro d\’article';
$aLang['table_heading_products'] = 'Article';
$aLang['table_heading_total'] = 'Somme';
$aLang['text_cart_empty'] = 'Nous n\’avez pas encore d\’articles dans votre panier.';
$aLang['SUB_TITLE_SUB_TOTAL'] = 'Sous-total:';
$aLang['SUB_TITLE_TOTAL'] = 'Somme:';

$aLang['out_of_stock_cant_checkout'] = 'Les articles marqués par' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' ne sont malheureusement plus en stock dans la quantité demandée.<br />Nous vous prions de réduire la quantité de commande pour les articles marqués. Merci beaucoup';
$aLang['out_of_stock_can_checkout'] = 'Les articles marqués par ' . STOCK_MARK_PRODUCT_OUT_OF_STOCK . ' ne sont malheureusement plus en stock dans la quantité souhaitée.<br />La quantité demandée sera livrée dès que possible. Nous effectuons, si vous le désirez, déjà une livraison partielle.';
?>
