<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: reviews.php,v 1.47 2003/02/13 04:23:23 hpdl
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
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
}


/**
 * Get the number of times a word/character is present in a string
 *
 * @param $sStr
 * @param $sNeedle
 * @return number
 */
function oosWordCount($sStr, $sNeedle = ' ') {
    $aTemp = explode($sNeedle, $sStr);

    return count($aTemp);
}


if (!defined('MAX_DISPLAY_NEW_REVIEWS')) {
    define('MAX_DISPLAY_NEW_REVIEWS', 5);
}

// split-page-results
if (isset($_GET['nv'])) {
    $nCurrentPageNumber = filter_input(INPUT_GET, 'nv', FILTER_VALIDATE_INT);
} elseif (isset($_POST['nv'])) {
    $nCurrentPageNumber = filter_input(INPUT_POST, 'nv', FILTER_VALIDATE_INT);
} else {
    $nCurrentPageNumber = 1;
}

if (empty($nCurrentPageNumber) || !is_numeric($nCurrentPageNumber)) $nCurrentPageNumber = 1;

MyOOS_CoreApi::requireOnce('classes/class_split_page_results.php');

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/reviews_reviews.php';

$aOption['template_main'] = $sTheme . '/modules/reviews.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['page_navigation'] = $sTheme . '/heading/page_navigation.html';

$nPageType = OOS_PAGE_TYPE_CATALOG;

$sGroup = trim($_SESSION['member']->group['text']);
$contents_cache_id = $sTheme . '|products|reviews|' . $nCurrentPageNumber . '|' . $sGroup . '|' . $sLanguage;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

if ( (USE_CACHE == '1') && (!SID) ) {
    $oSmarty->caching = 2;
    $oSmarty->cache_lifetime = 2 * 24 * 3600;
}

if (!$oSmarty->is_cached($aOption['template_main'], $contents_cache_id)) {
    $reviewstable  = $oostable['reviews'];
    $productstable = $oostable['products'];
    $reviews_descriptiontable  = $oostable['reviews_description'];
    $products_descriptiontable = $oostable['products_description'];
    $reviews_result_raw = "SELECT r.reviews_id, rd.reviews_text, r.reviews_rating, r.date_added, p.products_id,
                                  pd.products_name, p.products_image, r.customers_name
                           FROM $reviewstable r,$reviews_descriptiontable rd,
                                $productstable p, $products_descriptiontable pd
                           WHERE p.products_status >= '1'
                             AND p.products_id = r.products_id
                             AND r.reviews_id = rd.reviews_id
                             AND p.products_id = pd.products_id
                             AND pd.products_languages_id = '" . intval($nLanguageID) . "'
                             AND rd.reviews_languages_id = '" . intval($nLanguageID) . "'
                           ORDER BY r.reviews_id DESC";
    $reviews_split = new splitPageResults($nCurrentPageNumber, MAX_DISPLAY_NEW_REVIEWS, $reviews_result_raw, $reviews_numrows);
    $reviews_result = $dbconn->Execute($reviews_result_raw);

    $aReviews = array();
    while ($reviews = $reviews_result->fields)
    {
        $aReviews[] = array('id' => $reviews['reviews_id'],
                            'products_id' => $reviews['products_id'],
                            'reviews_id' => $reviews['reviews_id'],
                            'products_name' => $reviews['products_name'],
                            'products_image' => $reviews['products_image'],
                            'authors_name' => $reviews['customers_name'],
                            'review' => htmlspecialchars(substr($reviews['reviews_text'], 0, 250)) . '..',
                            'rating' => $reviews['reviews_rating'],
                            'word_count' => oosWordCount($reviews['reviews_text'], ' '),
                            'date_added' => oos_date_long($reviews['date_added']));
        $reviews_result->MoveNext();
    }

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
              'oos_heading_image' => 'specials.gif',

              'oos_page_split'    => $reviews_split->display_count($reviews_numrows, MAX_DISPLAY_NEW_REVIEWS, $nCurrentPageNumber, $aLang['text_display_number_of_reviews']),
              'oos_display_links' => $reviews_split->display_links($reviews_numrows, MAX_DISPLAY_NEW_REVIEWS, MAX_DISPLAY_PAGE_LINKS, $nCurrentPageNumber, oos_get_all_get_parameters(array('nv', 'info'))),
              'oos_page_numrows'  => $reviews_numrows,

              'oos_reviews_array' => $aReviews
          )
    );
}
$oSmarty->assign('oosPageNavigation', $oSmarty->fetch($aOption['page_navigation'], $contents_cache_id));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading'], $contents_cache_id));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main'], $contents_cache_id));
$oSmarty->caching = false;

// display the template
require 'includes/oos_display.php';

