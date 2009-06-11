<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if (!isset($_SESSION['customer_id'])) {
    $_SESSION['navigation']->set_snapshot();
    MyOOS_CoreApi::redirect(oos_href_link($aModules['user'], $aFilename['login'], '', 'SSL'));
}

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
$oBreadcrumb->add($aLang['navbar_title_1'], oos_href_link($aModules['user'], $aFilename['account'], '', 'SSL'));
$oBreadcrumb->add($aLang['navbar_title_2'], oos_href_link($aModules['user'], $aFilename['password_edit'], '', 'SSL'));

ob_start();
require 'js/form_check.js.php';
$javascript = ob_get_contents();
ob_end_clean();

$aOption['template_main'] = $sTheme . '/modules/user_password_edit.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';

$nPageType = OOS_PAGE_TYPE_ACCOUNT;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

// assign Smarty variables;
$oSmarty->assign(
      array(
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

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

