<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: create_account.php,v 1.59 2003/02/14 05:51:17 hpdl
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

require 'includes/languages/' . $sLanguage . '/user_create_account.php';

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title'], oos_href_link($aPages['create_account']));

$snapshot = count($_SESSION['navigation']->snapshot);
if (isset($_GET['email_address'])) {
    $email_address = oos_db_prepare_input($_GET['email_address']);
}
$account['entry_country_id'] = STORE_COUNTRY;

ob_start();
require 'js/form_check.js.php';
$javascript = ob_get_contents();
ob_end_clean();

$aOption['template_main'] = $sTheme . '/modules/user_create_account.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
$aOption['breadcrumb'] = 'default/system/breadcrumb.html';

$nPageType = OOS_PAGE_TYPE_ACCOUNT;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}
$read = '0';
$oSmarty->assign('read', $read);
$oSmarty->assign('oos_js', $javascript);

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

      )
);

$oSmarty->assign('account', $account);
$oSmarty->assign('email_address', $email_address);

if ((CUSTOMER_NOT_LOGIN == '1') or (MAKE_PASSWORD == '1')) {
    $show_password = false;
} else {
    $show_password = '1';
}
$oSmarty->assign('show_password', $show_password);

$oSmarty->assign('snapshot', $snapshot);
$oSmarty->assign('login_orgin_text', sprintf($aLang['text_origin_login'], oos_href_link($aPages['login'], oos_get_all_get_parameters(), 'SSL')));

$oSmarty->assign('newsletter_ids', array(0,1));
$oSmarty->assign('newsletter', array($aLang['entry_newsletter_no'],$aLang['entry_newsletter_yes']));

$oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

