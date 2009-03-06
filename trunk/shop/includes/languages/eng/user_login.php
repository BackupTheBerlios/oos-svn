<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: login.php,v 1.11 2002/11/12 00:45:21 dgw_ 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/* ----------------------------------------------------------------------
   If you made a translation, please send to
      lang@oos-shop.de
   the translated file.
   ---------------------------------------------------------------------- */


if (isset($_GET['origin']) && ($_GET['origin'] == $aFilename['checkout_payment'])) {
  $aLang['navbar_title'] = 'Order';
  $aLang['heading_title'] = 'Ordering online is easy.';
} else {
  $aLang['navbar_title'] = 'Login';
  $aLang['heading_title'] = 'Welcome, Please Sign In';
}

$aLang['heading_new_customer'] = 'New Customer';
$aLang['text_new_customer'] = 'I am a new customer.';
$aLang['text_new_customer_introduction'] = 'By creating an account at ' . STORE_NAME . ' you will be able to shop faster, be up to date on an orders status, and keep track of the orders you have previously made.';

$aLang['heading_returning_customer'] = 'Returning Customer';
$aLang['text_returning_customer'] = 'I am a returning customer.';

$aLang['entry_remember_me'] = 'Remember me<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="javascript:win_autologon(\'' . oos_href_link($aModules['main'], $aFilename['info_autologon']) . '\');"><b><u>Read this first!</u></b></a>';
$aLang['text_password_forgotten'] = 'Password forgotten? Click here.';

$aLang['text_login_error'] = '<strong>ERROR:</strong> No match for \'E-Mail Address\' and/or \'Password\'.';
$aLang['text_visitors_cart'] = '<strong>NOTE:</strong> Your &quot;Visitors Cart&quot; contents will be merged with your &quot;Members Cart&quot; contents once you have logged on. <a href="javascript:session_win(\'' . oos_href_link($aModules['main'], $aFilename['info_shopping_cart']) . '\');">[More Info]</a>';
?>
