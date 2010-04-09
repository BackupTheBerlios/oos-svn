<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: info_autologon.php,v 1.01 2002/10/08 12:00:00
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 osCommerce
   Copyright (c) 2002 HMCservices
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); 
    header("Location: /");
    header("Connection: close");
    exit;
}

$_SESSION['navigation']->remove_current_page();

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/main_info_autologon.php';

$aOption['info_autologon'] = $sTheme . '/system/info_autologon.html';

//smarty
require 'includes/classes/class_template.php';
$oSmarty =& new Template;

$oSmarty->caching = true;
$info_autologon_id = $sTheme . '|info_autologon|' . $sLanguage;

if (!$oSmarty->is_cached($aOption['info_autologon'], $info_autologon_id )) {

    // assign Smarty variables;
    $oSmarty->assign('oos_base', (($request_type == 'SSL') ? OOS_HTTPS_SERVER : OOS_HTTP_SERVER) . OOS_SHOP);
    $oSmarty->assign('lang', $aLang);
    $oSmarty->assign('theme_image', 'themes/' . $sTheme . '/images');
    $oSmarty->assign('theme_css', 'themes/' . $sTheme);
}

// display the template
$oSmarty->display($aOption['info_autologon'], $info_autologon_id);

