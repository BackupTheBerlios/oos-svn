<?php
 /* ----------------------------------------------------------------------
   $Id: function.oos_price.php 120 2009-03-28 08:37:06Z r23 $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/


   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: general.php,v 1.212 2003/02/17 07:55:54 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     oos_price
 * Version:  1.0
 * Date:
 * Purpose:
 *
 *
 * Install:  Drop into the plugin directory
 * Author:
 * -------------------------------------------------------------
 */

function smarty_function_oos_price($params, &$smarty)
{

   global $oCurrencies;

   require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');

   $price = '';
   $tax = '';
   $qty = '';


   foreach($params as $_key => $_val) {
     $$_key = smarty_function_escape_special_chars($_val);
   }

   print $oCurrencies->display_price($price, $tax, $qty);

}
