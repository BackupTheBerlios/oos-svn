<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: currencies.php,v 1.16 2003/02/12 20:27:31 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if (isset($oCurrencies) && is_object($oCurrencies)) {

    reset($oCurrencies->currencies);
    $aCurrencies = array();

    foreach ($oCurrencies->currencies as $sKey => $value) {
        $aCurrencies[] = array('id' => $sKey, 'text' => $value['title']);
    }

    $hidden_get_variables = '';
    foreach ($_GET as $sKey => $value) {
        if ( ($sKey != 'currency') && ($sKey != oos_session_name()) && ($sKey != 'x') && ($sKey != 'y') ) {
            $hidden_get_variables .= oos_draw_hidden_field($sKey, $value);
        }
    }

    $oos_pull_down_menu = oos_draw_pull_down_menu('currency', $aCurrencies, $_SESSION['currency'], 'onchange="this.form.submit();" style="width: 100%"') . $hidden_get_variables . oos_hide_session_id();

    $oSmarty->assign(
        array(
            'oos_pull_down_menu' => $oos_pull_down_menu,
            'block_heading_currencies' => $block_heading
        )
    );
}

