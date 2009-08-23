<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}

if (!$oEvent->installed_plugin('gallery')) {
    $_SESSION['navigation']->remove_current_page();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
}

require 'includes/languages/' . $sLanguage . '/info_gallery.php';

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title'], oos_href_link($aPages['info_gallery']), bookmark);

$aOption['template_main'] = $sTheme .  '/system/gallery.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['breadcrumb'] = 'default/system/breadcrumb.html';

$nPageType = OOS_PAGE_TYPE_MAINPAGE;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

// assign Smarty variables;
$oSmarty->assign(
      array(
          'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
          'oos_heading_title' => $aLang['heading_title'],
          'oos_heading_image' => 'contact_us.gif'
      )
);

$oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

