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
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}

if ( !isset( $_SESSION['customer_id'] ) || !is_numeric( $_SESSION['customer_id'] )) {
    $_SESSION['navigation']->set_snapshot();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['login'], '', 'SSL'));
}

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/user_password_edit.php';

$customerstable = $oostable['customers'];
$sql = "SELECT c.customers_gender, c.customers_firstname, c.customers_lastname,
               c.customers_number, c.customers_email_address
        FROM $customerstable c
        WHERE c.customers_id = '" . intval($_SESSION['customer_id']) . "'";
$account = $dbconn->GetRow($sql);

$email_address = $account['customers_email_address'];
$number = $account['customers_number'];

$no_edit = true;
$show_password = true;

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aPages['account'], '', 'SSL'));
$oBreadcrumb->add($aLang['navbar_title_2'], oos_href_link($aPages['password_edit'], '', 'SSL'), bookmark);

ob_start();
require 'js/form_check.js.php';
$javascript = ob_get_contents();
ob_end_clean();

$aOption['template_main'] = $sTheme . '/modules/user_password_edit.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['breadcrumb'] = 'default/system/breadcrumb.html';

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
          'oos_heading_title' => $aLang['heading_title'],
          'oos_heading_image' => 'account.gif',

          'account'           => $account,
          'email_address'     => $email_address,
          'show_password'     => $show_password

      )
);

// JavaScript
$oSmarty->assign('oos_js', $javascript);

$oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

