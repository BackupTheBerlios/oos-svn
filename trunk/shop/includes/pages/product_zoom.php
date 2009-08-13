<?php
/* ----------------------------------------------------------------------
   $Id: zoom.php 121 2009-03-28 08:49:02Z r23 $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

$_SESSION['navigation']->remove_current_page();

if (!isset($nProductsId)) $nProductsId = oos_get_product_id($_GET['products_id']);

$productstable = $oostable['products'];
$products_descriptiontable = $oostable['products_description'];
$query = "SELECT pd.products_name, p.products_zoomify
          FROM $productstable p LEFT JOIN
               $products_descriptiontable pd
            ON p.products_id = pd.products_id
         WHERE p.products_id = '" . intval($nProductsId) . "'
           AND (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "')
           AND pd.products_languages_id = '" . intval($nLanguageID) . "'";
$products_info = $dbconn->GetRow($query);

$aOption['popup_zoom'] = 'default/products/popup_zoom.html';

//smarty
require 'includes/classes/class_template.php';
$oSmarty =& new Template;


/*
  zoomifyImagePath: image folder URL
  zoomifyX: initial view X, -1 to 1, 0 centers image in display (centered = default)
  zoomifyY: initial view Y, -1 to 1, 0 centers image in display (centered = default)
  zoomifyZoom: 1 to 100, -1 to fit to display area (-1 = default)
  zoomifyMinZoom: 1 to 100, -1 to fit to display area (-1 = default)
  zoomifyMaxZoom: 1 to 100, -1 to fit to display area (100 = default)
  zoomifyNavWindow: 1 to show, 0 to hide (1 = default)
  zoomfiyNavX: X pixel position of NavWindow on stage (0 = default)
  zoomfiyNavY: Y pixel position of NavWindow on stage (0 = default)
  zoomifyToolbar: 1 to show, 0 to hide (1 = default)
  zoomifySlider: 1 to show, 0 to hide (1 = default)
  zoomifyClickZoom: 1 enables click-jump to next zoom level, 0 disables (0 = default)
  zoomifyZoomSpeed: 1 to magnify quickly, 10 to magnify slowly (5 = default)
  zoomifyFadeInSpeed: transition in milliseconds, 0 disables fade-in effect (0 = default)
*/

$sZoomify  = 'zoomifyImagePath=' . OOS_HTTP_SERVER . OOS_SHOP .
              OOS_IMAGES . 'zoomify/' . $products_info['products_zoomify'] .
             '&zoomifyZoom=80&zoomifyMinZoom=10&zoomifyMaxZoom=100';

// assign Smarty variables;
$oSmarty->assign('lang', $aLang);
$oSmarty->assign('theme_css', 'themes/' . $sTheme);
$oSmarty->assign('oos_base', (($request_type == 'SSL') ? OOS_HTTPS_SERVER : OOS_HTTP_SERVER) . OOS_SHOP);
$oSmarty->assign('products_name', $products_info['products_name']);
$oSmarty->assign('zoomify', $sZoomify);

// display the template
$oSmarty->display($aOption['popup_zoom']);

