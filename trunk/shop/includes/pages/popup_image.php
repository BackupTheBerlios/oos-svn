<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2006 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   Images_resize Vs 1.3 for OSC http://www.oscommerce.com

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce

   based on osCommerce 2.2MS1

   check http://www.in-solution.org for updates and other free addons

   Copyright 2003 Henri Schmidhuber
   mailto: info@in-solution.de    http://www.in-solution.de

   popup_image.php,v 1.13 2002/08/24 11:08:39 project3000
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

$aOption['popup_image'] = $sTheme . '/products/popup_image.html';

//smarty
require 'includes/classes/class_template.php';
$oSmarty =& new Template;

$oSmarty->caching = 2;
$oSmarty->cache_lifetime = 30 * 24 * 3600;

$image = (isset($_GET['image']) && is_numeric($_GET['image']) ? $_GET['image'] : 0);
$pID = intval($_GET['pID']);

$popup_cache_id = $sTheme . '|popup_image|' . $pID . '|' . $image . '|' . $sLanguage . '|' . intval($nGroupID);

if (!$oSmarty->is_cached($aOption['popup_image'], $popup_cache_id )) {
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $sql = "SELECT pd.products_name, p.products_image, p.products_subimage1, p.products_subimage2,
                   p.products_subimage3, p.products_subimage4, p.products_subimage5, p.products_subimage6
            FROM $productstable p LEFT JOIN
                 $products_descriptiontable pd ON p.products_id = pd.products_id
            WHERE p.products_status >= '1'
              AND (p.products_access = '0' OR p.products_access = '" . intval($nGroupID) . "')
              AND p.products_id = '" . intval($_GET['pID']) . "'
              AND pd.products_languages_id = '" . intval($nLanguageID) . "'";
    $products_info = $dbconn->GetRow($sql);

    if (isset($_GET['image']) && is_numeric($_GET['image'])) {
        switch ($_GET['image']) {
            case '0':
                if (is_readable(OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_image'])) {
                    $picture = OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_image'];
                } else {
                    $picture = OOS_IMAGES . $products_info['products_image'];
                }
                break;

            case '1':
                if (is_readable(OOS_ABSOLUTE_PATH . OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_subimage1'])) {
                    $picture = OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_subimage1'];
                } else {
                    $picture = OOS_IMAGES . $products_info['products_subimage1'];
                }
                break;

            case '2':
                if (is_readable(OOS_ABSOLUTE_PATH . OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_subimage2'])) {
                    $picture = OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_subimage2'];
                } else {
                    $picture = OOS_IMAGES . $products_info['products_subimage2'];
                }
                break;

            case '3':
                if (is_readable(OOS_ABSOLUTE_PATH . OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_subimage3'])) {
                    $picture = OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_subimage3'];
                } else {
                    $picture = OOS_IMAGES . $products_info['products_subimage3'];
                }
                break;

            case '4':
                if (is_readable(OOS_ABSOLUTE_PATH . OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_subimage4'])) {
                    $picture = OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_subimage4'];
                } else {
                    $picture = OOS_IMAGES . $products_info['products_subimage4'];
                }
                break;

            case '5':
                if (is_readable(OOS_ABSOLUTE_PATH . OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_subimage5'])) {
                    $picture = OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_subimage5'];
                } else {
                    $picture = OOS_IMAGES . $products_info['products_subimage5'];
                }
                break;

            case '6':
                if (is_readable(OOS_ABSOLUTE_PATH . OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_subimage6'])) {
                    $picture = OOS_IMAGES . OOS_POPUP_IMAGES . $products_info['products_subimage6'];
                } else {
                    $picture = OOS_IMAGES . $products_info['products_subimage6'];
                }
                break;
       }
    }

    $size = @GetImageSize($picture);

    // assign Smarty variables;
    $oSmarty->assign('oos_base', (($request_type == 'SSL') ? OOS_HTTPS_SERVER : OOS_HTTP_SERVER) . OOS_SHOP);
    $oSmarty->assign('products_name', $products_info['products_name']);
    $oSmarty->assign('picture', $picture);
    $oSmarty->assign('size', $size);

}

// display the template
$oSmarty->display($aOption['popup_image'], $popup_cache_id);
