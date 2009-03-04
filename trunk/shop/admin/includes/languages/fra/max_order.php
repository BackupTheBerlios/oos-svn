<?php
/* ----------------------------------------------------------------------
   $Id: max_order.php,v 1.1 2005/10/14 15:04:01 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2005 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: max_order.php v1.00 2003/04/27 JOHNSON   
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2001 - 2003 osCommerce
  
   Max Order - 2003/04/27 JOHNSON - Copyright (c) 2003 Matti Ressler - mattifinn@optusnet.com.au
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('NAVBAR_TITLE', 'Montant maximal de la commande');
define('HEADING_TITLE', 'Montant maximal de la commande');
define('TEXT_INFORMATION', 'Vous êtes'. $currencies->format ($cart->show_total() - (+$customer_max_order)) .'au-dessus de' . $currencies->format($customer_max_order) . ' montant maximal de la commande. <br />Contactez notre équipe de vente pour que votre commande soit accepté.');
?>
