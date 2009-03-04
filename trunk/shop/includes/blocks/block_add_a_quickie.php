<?php
/* ----------------------------------------------------------------------
   $Id: block_add_a_quickie.php,v 1.15 2007/04/05 17:06:51 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: add_a_quickie.php,v 1.10 2001/12/19 01:37:55 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2001 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

  if (!isset($block_get_parameters)) {
    $block_get_parameters = oos_get_all_get_parameters(array('action'));
    $block_get_parameters = oos_remove_trailing($block_get_parameters);
    $oSmarty->assign('get_params', $block_get_parameters);
  }

  $oSmarty->assign('block_heading_add_product_id', $block_heading);

?>
