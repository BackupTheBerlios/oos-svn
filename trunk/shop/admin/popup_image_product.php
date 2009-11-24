<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   popup_image.php,v 1.13 2002/08/24 11:08:39 project3000
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 osCommerce
   Big Image Modification 2002/03/04
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('OOS_VALID_MOD', 'yes');
require 'includes/oos_main.php';

if (!isset($_SESSION['login_id'])) {
    oos_redirect_admin(oos_href_link_admin($aFilename['login'], '', 'SSL'));
}

if ( !current_user_can('popup_image_product') )
    oos_redirect_admin(oos_href_link_admin($aFilename['forbiden']));

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<title><?php echo $products_values['products_name']; ?> - Administration [OOS]</title>
<base href="<?php echo (getenv('HTTPS') == 'on' ? OOS_HTTPS_SERVER : OOS_HTTP_SERVER) . OOS_SHOP; ?>">
<script language="javascript"><!--
var i=0;
function resize() {
  if (navigator.appName == 'Netscape') i=40;
  if (document.images[0]) window.resizeTo(document.images[0].width +30, document.images[0].height+60-i);
  self.focus();
}
//--></script>
</head>
<body onload="resize();">
<?php
  if (file_exists(OOS_ABSOLUTE_PATH . OOS_IMAGES . OOS_POPUP_IMAGES . $_GET['bimage'])) {
    $image= OOS_HTTP_SERVER . OOS_SHOP . OOS_IMAGES . OOS_POPUP_IMAGES . $_GET['bimage'];
  } else {
    $image= OOS_HTTP_SERVER . OOS_SHOP . OOS_IMAGES . $_GET['bimage'];
  }
  echo oos_image($image, $products_values['products_name']);
?>
</body>
</html>
<?php require 'includes/oos_nice_exit.php'; ?>