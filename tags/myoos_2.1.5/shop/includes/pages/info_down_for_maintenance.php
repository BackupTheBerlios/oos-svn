<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   WebMakers.com Added: Down for Maintenance No Store
   Written by Linda McGrath osCOMMERCE@WebMakers.com
   http://www.thewebmakerscorner.com
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}

if (!$oEvent->installed_plugin('down_for_maintenance')) {
    $_SESSION['navigation']->remove_current_page();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
}

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/info_down_for_maintenance.php';

$aOption['template_main'] = $sTheme . '/system/info.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';


$nPageType = OOS_PAGE_TYPE_MAINPAGE;
$contents_cache_id = $sTheme . '|down_for_maintenance|' . $sLanguage;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

if ( (USE_CACHE == '1') && (!SID) ) {
    $oSmarty->caching = 2;
    $oSmarty->cache_lifetime = 3 * 3600;
}

if (!$oSmarty->is_cached($aOption['template_main'], $contents_cache_id)) {

    // links breadcrumb
    $oBreadcrumb->add($aLang['navbar_title']);

    $oos_pagetitle = $oBreadcrumb->trail_title(' &raquo; ');
    $oos_pagetitle .= '&raquo;' . OOS_META_TITLE;

    // assign Smarty variables;
    $oSmarty->assign(
        array(
            'pagetitle'         => htmlspecialchars($oos_pagetitle),
            'meta_description'  => htmlspecialchars($oos_meta_description),
            'meta_keywords'     => htmlspecialchars($oos_meta_keywords),
            'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
            'oos_heading_title' => $aLang['heading_title'],
            'oos_heading_image' => 'specials.gif'
        )
    );
}

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading'], $contents_cache_id));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main'], $contents_cache_id));
$oSmarty->caching = false;

// display the template
require 'includes/oos_display.php';
