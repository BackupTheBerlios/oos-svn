<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

  require_once 'HTML/QuickForm.php';
  require_once 'HTML/QuickForm/Renderer/Array.php';

  require 'includes/languages/' . $sLanguage . '/main_contact_us.php';


  // links breadcrumb
  $oBreadcrumb->add($aLang['navbar_title'], oos_href_link($aModules['main'], $aFilename['contact_us']));

  // $aOption['template_main'] = $sTheme . '/system/contact_us.html';
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
          'oos_heading_image' => 'contact_us.gif',

          'error'             => $error
      )
  );

  $oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
  $oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
  $oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

  // display the template
  require 'includes/oos_display.php';

