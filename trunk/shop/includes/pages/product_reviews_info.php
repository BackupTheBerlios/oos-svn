<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
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

// DO NOT RUN THIS SCRIPT STANDALONE
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


if (!$oEvent->installed_plugin('reviews')) {
    $_SESSION['navigation']->remove_current_page();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']), 301);
}

if (!isset($_GET['reviews_id'])) {
    $_SESSION['navigation']->remove_current_page();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['reviews']), 301);
}

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/reviews_product_info.php';

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
if (!$reviews_result->RecordCount()){
    $_SESSION['navigation']->remove_current_page();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
}
$reviews = $reviews_result->fields;

$dbconn->Execute("UPDATE " . $oostable['reviews'] . "
                  SET reviews_read = reviews_read+1
                  WHERE reviews_id = '" . $reviews['reviews_id'] . "'");

// links breadcrumb
$oBreadcrumb->add($reviews['products_name'], oos_href_link($aPages['product_info'], 'categories=' . $categories . '&amp;products_id=' . $reviews['products_id']));
$oBreadcrumb->add($aLang['navbar_title']);

$aOption['template_main'] = $sTheme . '/modules/product_reviews_info.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';

$nPageType = OOS_PAGE_TYPE_REVIEWS;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

$oos_pagetitle = sprintf($aLang['heading_title'], $reviews['products_name'];
$oos_pagetitle .= '&raquo;' . OOS_META_TITLE;

// assign Smarty variables;
$oSmarty->assign(
      array(
           'pagetitle'         => htmlspecialchars($oos_pagetitle),
           'meta_description'  => htmlspecialchars($oos_meta_description),
           'meta_keywords'     => htmlspecialchars($oos_meta_keywords),
           'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
           'oos_heading_image' => 'reviews.gif',

           'popup_window' => 'popup_window.js',

           'reviews' => $reviews
       )
  );

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

