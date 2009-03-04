<?php
/* ----------------------------------------------------------------------
   $Id: block_tell_a_friend.php,v 1.24 2007/04/05 17:06:51 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: tell_a_friend.php,v 1.15 2003/02/10 22:31:08 hpdl 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

  $tell_a_friend_block = 'false';
  if ($sFile != $aFilename['tell_a_friend']) {
    if (isset($_GET['products_id'])) {
      if (!isset($nProductsId)) $nProductsId = oos_get_product_id($_GET['products_id']);
      $tell_products_id = intval($nProductsId);
      $tell_a_friend_block = 'true';
      $oSmarty->assign(
          array(
              'tell_products_id' => $tell_products_id,
              'block_heading_tell_a_friend' => $block_heading
          )
      );
    }
  }
  $oSmarty->assign('tell_a_friend_block', $tell_a_friend_block);

?>
