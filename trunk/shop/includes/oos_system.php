<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

//smarty
require 'includes/classes/class_template.php';
$oSmarty = new Template();

//debug
if ($oEvent->installed_plugin('debug')) {
    $oSmarty->force_compile   = true;
    $oSmarty->debugging       = true;
    $oSmarty->clear_all_cache();
    $oSmarty->clear_compiled_tpl();
}



// object register
$oSmarty->register_object("cart", $_SESSION['cart'],array('count_contents', 'get_products'));
$oSmarty->assign_by_ref("oEvent", $oEvent);


// cache_id
$oos_cache_id                   = $sTheme . '|block|' . $sLanguage. '|' . intval($nGroupID);
$oos_system_cache_id            = $sTheme . '|block|' . $sLanguage. '|' . intval($nGroupID);
$oos_categories_cache_id        = $sTheme . '|block|categories|' . $sLanguage . '|' . $categories . '|' . intval($nGroupID);
$oos_modules_cache_id           = $sTheme . '|modules|' . $sLanguage . '|' . $_SESSION['currency']. '|' . intval($nGroupID);
$oos_news_cache_id              = $sTheme . '|modules|news|' . $sLanguage. '|' . intval($nGroupID);
$oos_manufacturers_cache_id     = $sTheme . '|block|manufacturers|' . $sLanguage . '|' . intval($nManufacturersId) . '|' . intval($nGroupID);
$oos_manufacturer_info_cache_id = $sTheme . '|block|manufacturer_info|' . $sLanguage . '|' . intval($nManufacturersId) . '|' . intval($nGroupID);

if (isset($_GET['products_id'])) {
    if (!isset($nProductsId)) $nProductsId = oos_get_product_id($_GET['products_id']);

    $oos_social_bookmarks_cache_id = '|social_bookmarks|' . $sLanguage . '|' . intval($nProductsId). '|' . intval($nGroupID);
    $oos_manufacturer_info_cache_id = $sTheme . '|block|manufacturer_info|' . $sLanguage . '|' . intval($nProductsId) . '|' . intval($nGroupID);
    $oos_products_info_cache_id     = $sTheme . '|products_info|' . $sLanguage . '|' . intval($nProductsId) . '|' . intval($nGroupID);
    $oos_xsell_products_cache_id    = $sTheme . '|block|products|' . $sLanguage . '|' . intval($nProductsId) . '|' . intval($nGroupID);
}

// Meta-Tags
if (empty($oos_pagetitle)) $oos_pagetitle = OOS_META_TITLE;
if (empty($oos_meta_description)) $oos_meta_description = OOS_META_DESCRIPTION;
if (empty($oos_meta_keywords)) $oos_meta_keywords = OOS_META_KEYWORDS;

$sFormid = md5(uniqid(rand(), true));
$_SESSION['formid'] = $sFormid;

$cart_count_contents = $_SESSION['cart']->count_contents();
$cart_show_total = $oCurrencies->format($_SESSION['cart']->show_total());

$oSmarty->assign(
      array(
          'pages'               => $aPages,
          'page_file'           => $sPage,

          'formid'              => $sFormid,

          'request_type'        => $request_type,

          'cart_show_total'     => $cart_show_total,
          'cart_count_contents' => $cart_count_contents,

          'is_xhtml'            => true,
          'theme_set'           => $sTheme,
          'theme_image'         => STATIC1_HTTP_SERVER . '/themes/' . $sTheme . '/images',
          'theme_css'           => STATIC1_HTTP_SERVER . '/themes/' . $sTheme,

          'lang'                => $aLang,
          'language'            => $sLanguage,

          'pangv'               => $sPAngV,
          'products_units'      => $products_units,

          'pagetitle'           => htmlspecialchars($oos_pagetitle),

          'meta_description'    => htmlspecialchars($oos_meta_description),
          'meta_keywords'       => htmlspecialchars($oos_meta_keywords)
      )
);

$oSmarty->assign('oos_base', (($request_type == 'SSL') ? OOS_HTTPS_SERVER : OOS_HTTP_SERVER) . OOS_SHOP);

