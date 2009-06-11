<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: product_reviews_info.php,v 1.47 2003/02/13 04:23:23 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if (!$oEvent->installed_plugin('reviews')) {
    $_SESSION['navigation']->remove_current_page();
    MyOOS_CoreApi::redirect(oos_href_link($aModules['main'], $aFilename['main']));
}

if (!isset($_GET['reviews_id'])) {
    MyOOS_CoreApi::redirect(oos_href_link($aModules['reviews'], $aFilename['reviews_reviews']));
}

require 'includes/languages/' . $sLanguage . '/reviews_product_info.php';

// lets retrieve all $_GET keys and values..
$get_parameters = oos_get_all_get_parameters(array('reviews_id'));
$get_parameters = oos_remove_trailing($get_parameters);

$reviewstable  = $oostable['reviews'];
$productstable = $oostable['products'];
$reviews_descriptiontable  = $oostable['reviews_description'];
$products_descriptiontable = $oostable['products_description'];
$sql = "SELECT rd.reviews_text, r.reviews_rating, r.reviews_id, r.products_id,
               r.customers_name, r.date_added, r.last_modified, r.reviews_read,
               p.products_id, pd.products_name, p.products_model, p.products_image
          FROM $reviewstable r,
               $reviews_descriptiontable rd,
               $productstable p,
               $products_descriptiontable pd
          WHERE r.reviews_id = '" . intval($_GET['reviews_id']) . "'
            AND r.reviews_id = rd.reviews_id
            AND rd.reviews_languages_id = '" . intval($nLanguageID) . "'
            AND r.products_id = p.products_id
            AND p.products_status >= '1'
            AND p.products_id = pd.products_id
            AND pd.products_languages_id = '" . intval($nLanguageID) . "'";
$reviews_result = $dbconn->Execute($sql);
if (!$reviews_result->RecordCount()) MyOOS_CoreApi::redirect(oos_href_link($aModules['reviews'], $aFilename['reviews_reviews']));
$reviews = $reviews_result->fields;

$dbconn->Execute("UPDATE " . $oostable['reviews'] . "
                  SET reviews_read = reviews_read+1
                  WHERE reviews_id = '" . $reviews['reviews_id'] . "'");

// links breadcrumb
$oBreadcrumb->add($reviews['products_name'], oos_href_link($aModules['products'], $aFilename['product_info'], 'categories=' . $categories . '&amp;products_id=' . $reviews['products_id']));
$oBreadcrumb->add($aLang['navbar_title'], oos_href_link($aModules['reviews'], $aFilename['product_reviews'], $get_parameters));

$aOption['template_main'] = $sTheme . '/modules/product_reviews_info.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';

$nPageType = OOS_PAGE_TYPE_REVIEWS;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

$oSmarty->assign(
       array(
           'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
           'oos_heading_title' => sprintf($aLang['heading_title'], $reviews['products_name']),
           'oos_heading_image' => 'reviews.gif',

           'popup_window' => 'popup_window.js',

           'reviews' => $reviews
       )
  );

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

