<?php
/* ----------------------------------------------------------------------
   $Id: logoff.php,v 1.38 2007/05/07 09:16:10 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: logoff.php,v 1.12 2003/02/13 03:01:51 hpdl 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  define('OOS_VALID_MOD', 'yes');
  require 'includes/oos_main.php';

  require('includes/languages/' . $_SESSION['language'] . '/' . $aFilename['logoff']);

  unset($_SESSION['login_id']);
  unset($_SESSION['login_firstname']);
  unset($_SESSION['login_groups_id']);
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo CHARSET; ?>">
<title><?php echo TITLE; ?> - Administration [OOS]</title>
<style type="text/css">
@import url(includes/admin_login.css);
</style>
</head>
<body>

<div id="ctr" align="center">
	<div class="login">
		<div class="login-form">
			<img src="images/login.gif" alt="<?php echo HEADING_PASSWORD_FORGOTTEN; ?>" />
			<div class="form-block">
			<div class="clr"></div>
			<div class="smallText"><?php echo TEXT_MAIN; ?></div>
			<div id="break"></div>
			<div align="left"><a href="<?php echo oos_href_link_admin($aFilename['login'], '', 'SSL') . '">' . oos_image_swap_button('back','back_off.gif', IMAGE_BACK); ?></a></div> 


		</div>
	</div>
		<div class="login-text">

			<div class="ctr"><img src="images/security.gif" width="64" height="64" alt="security" /></div>
			<p><?php echo HEADING_TITLE; ?></p>

		</div>
		<div class="clr"></div>
	</div>
</div>
<div id="break"></div>


</body>
</html>
<?php require 'includes/oos_nice_exit.php'; ?>