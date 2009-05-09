<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: shipping.php,v 1.21 2003/02/13 04:23:23 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

$aOption['template_main'] = $sTheme . '/modules/information.html';
$aOption['page_heading'] = $sTheme . '/heading/print_page.html';;

$nPageType = OOS_PAGE_TYPE_MAINPAGE;

$nInformationsID = isset($_GET[information_id]) ? $_GET[information_id]+0 : 1;
$sGroup = trim($_SESSION['member']->group['text']);
$contents_cache_id = $sTheme . '|info|' . $sGroup . '|information|' . $nInformationsID . '|' . $sLanguage;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

if ( (USE_CACHE == '1') && (!SID) ) {
    $oSmarty->caching = 2;
    $oSmarty->cache_lifetime = 24 * 3600;
}

if (!$oSmarty->is_cached($aOption['template_main'], $contents_cache_id)) {
    $informationtable = $oostable['information'];
    $information_descriptiontable = $oostable['information_description'];
    $sql = "SELECT i.information_id, i.information_image, id.information_name,
                   id.information_description, id.information_heading_title,
                   id.information_url
            FROM $informationtable i,
               $information_descriptiontable id
            WHERE i.information_id = '" . intval($nInformationsID) . "'
              AND id.information_id = i.information_id
              AND id.information_languages_id = '" .  intval($nLanguageID) . "'";
    $information = $dbconn->GetRow($sql);

    // links breadcrumb
    $oBreadcrumb->add($information['information_heading_title'], oos_href_link($aModules['info'], $aFilename['information'], 'information_id=' . intval($nInformationsID)));

    // assign Smarty variables;
    $oSmarty->assign(
        array(
            'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
            'oos_heading_title' => $information['information_heading_title'],
            'oos_heading_image' => $information['information_image'],

            'informations'       => $information,
            'get_params'         => 'information_id=' . intval($nInformationsID)
        )
    );

}
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading'], $contents_cache_id));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main'], $contents_cache_id));
$oSmarty->caching = false;

// display the template
require 'includes/oos_display.php';

