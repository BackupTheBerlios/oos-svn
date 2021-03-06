<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if ( !isset( $_SESSION['customer_id'] ) || !is_numeric( $_SESSION['customer_id'] )) {
    $_SESSION['navigation']->set_snapshot();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['login'], '', 'SSL'), '301');
}

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/user_yourstore.php';

$customerstable = $oostable['customers'];
$sql = "SELECT customers_gender, customers_firstname, customers_lastname,
               customers_image, customers_dob, customers_number, customers_email_address,
               customers_vat_id, customers_telephone, customers_fax, customers_newsletter
        FROM $customerstable
        WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'";
$account = $dbconn->GetRow($sql);

if ($account['customers_gender'] == 'm') {
    $gender = $aLang['male'];
} elseif ($account['customers_gender'] == 'f') {
    $gender = $aLang['female'];
}


// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title']);

$aOption['template_main'] = $sTheme . '/modules/user_yourstore.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';

$nPageType = OOS_PAGE_TYPE_ACCOUNT;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

$oos_pagetitle = $oBreadcrumb->trail_title(' &raquo; ');
$oos_pagetitle .= '&raquo;' . OOS_META_TITLE;

// assign Smarty variables;
$oSmarty->assign(
      array(
          'pagetitle'         => htmlspecialchars($oos_pagetitle),
          'meta_description'  => htmlspecialchars($oos_meta_description),
          'meta_keywords'     => htmlspecialchars($oos_meta_keywords),
          'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
          'oos_heading_title'    => $aLang['heading_title'],
          'oos_heading_image'    => 'account.gif',

          'account'              => $account,
          'gender'               => $gender
      )
);

if ($_SESSION['cart']->count_contents() > 0) {
    $product_ids = $_SESSION['cart']->get_numeric_product_id_list();

    $products_up_selltable = $oostable['products_up_sell'];
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];

    $sql = "SELECT DISTINCT p.products_id, p.products_image, pd.products_name,
                 substring(pd.products_description, 1, 150) AS products_description
            FROM $products_up_selltable up,
                 $productstable p,
                 $products_descriptiontable pd
           WHERE up.products_id IN (" . $product_ids . ")
              AND up.up_sell_id = p.products_id
              AND p.products_id = pd.products_id
              AND pd.products_languages_id = '" . intval($nLanguageID) . "'
              AND p.products_status >= '1'
            ORDER BY up.products_id ASC";
    $up_sell_products_result = $dbconn->SelectLimit($sql, MAX_DISPLAY_XSELL_PRODUCTS);

    if ($up_sell_products_result->RecordCount() >=  0) {
        $oSmarty->assign('oos_up_sell_products_array', $up_sell_products_result->GetArray());
    }
}

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';
