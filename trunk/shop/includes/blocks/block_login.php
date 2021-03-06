<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


if ($oEvent->installed_plugin('down_for_maintenance')) return false;

$login_block = '0';
if ( ($sPage != $aPages['login']) && ($sPage != $aPages['create_account'])) {
    if ( !isset( $_SESSION['customer_id'] ) || !is_numeric( $_SESSION['customer_id'] )) {
        $login_block = '1';
        $oSmarty->assign('block_login_heading', $block_heading);
    }
}

$oSmarty->assign('login_block', $login_block);

