<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: info_shopping_cart.php,v 1.19 2003/02/13 03:01:48 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}

$_SESSION['navigation']->remove_current_page();

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/main_info_shopping_cart.php';

$aOption['info_shopping_cart'] = $sTheme . '/system/info_shopping_cart.html';

//smarty
require 'includes/classes/class_template.php';
$oSmarty =& new Template;

$oSmarty->caching = true;
$info_shopping_cart_id = $sTheme . '|info_shopping_cart|' . $sLanguage;

if (!$oSmarty->is_cached($aOption['info_shopping_cart'], $info_shopping_cart_id )) {

    // assign Smarty variables;
    $oSmarty->assign('oos_base', (($request_type == 'SSL') ? OOS_HTTPS_SERVER : OOS_HTTP_SERVER) . OOS_SHOP);
    $oSmarty->assign('lang', $aLang);
    $oSmarty->assign('theme_image', 'themes/' . $sTheme . '/images');
    $oSmarty->assign('theme_css', 'themes/' . $sTheme);
}

// display the template
$oSmarty->display($aOption['info_shopping_cart'], $info_shopping_cart_id);

