<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/
   
   
   Copyright (c) 2003 - 2006 by the OOS Development Team.
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

$aLang['navbar_title'] = 'Maximum order';
$aLang['heading_title'] = 'Maximum order';

$aLang['text_information'] = 'You are '. $oCurrencies->format ($_SESSION['cart']->show_total() - (+$_SESSION['customer_max_order'])) .' above your ' . $oCurrencies->format($_SESSION['customer_max_order']) . ' Credit Limit. <br />Please contact our Sales Team to confirm your order.';
?>
