<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
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

$aLang['navbar_title'] = 'Kreditlimit';
$aLang['heading_title'] = 'Kreditlimit';

$aLang['text_information'] = 'Sie sind '. $oCurrencies->format ($_SESSION['cart']->show_total() - (+$_SESSION['customer_max_order'])) .' &uuml;ber Ihrem ' . $oCurrencies->format($_SESSION['customer_max_order']) . ' Kreditlimit. <br />Bitte kontaktieren Sie unser Verkaufsteam, um Ihre Bestellung zu best&auml;tigen!';


