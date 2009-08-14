<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

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


$aLang['navbar_title'] = 'RDS/RSS Newsfeed';
$aLang['heading_title'] = 'RDS/RSS Newsfeed';

$aLang['text_information'] = 'Put here your information..<br /><b>URL:</b><br />';
if ($oEvent->installed_plugin('sefu')) {
  $aLang['text_information'] .= '<a href="' . OOS_HTTP_SERVER . OOS_SHOP . 'index.php/page/' . $aPages['products_rss'] . ' target="_blank">' . OOS_HTTP_SERVER . OOS_SHOP . 'index.php/page/' . $aPages['products_rss'] .'</a>';
} else {
  $aLang['text_information'] .= '<a href="' . OOS_HTTP_SERVER . OOS_SHOP . 'index.php?page=' . $aPages['products_rss'] . ' target="_blank">' . OOS_HTTP_SERVER . OOS_SHOP . 'index.php?page=' . $aPages['products_rss'] .'</a>';
}
$aLang['text_information'] .= '<br /><br /><br />';
?>
