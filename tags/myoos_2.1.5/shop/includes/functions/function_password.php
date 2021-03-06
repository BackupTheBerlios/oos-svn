<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: password_funcs.php,v 1.10 2003/02/11 01:31:02 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

 /**
  * This funstion validates a plain text password with an
  * encrpyted password
  *
  * @param $sPlain
  * @param $sEncrypted
  * @return boolean
  */
  function oos_validate_password($sPlain, $sEncrypted) {

    if (!empty($sPlain) && !empty($sEncrypted)) {
      // split apart the hash / salt
      $aStack = explode(':', $sEncrypted);

      if (count($aStack) != 2) return false;

      if (md5($aStack[1] . $sPlain) == $aStack[0]) {
        return true;
      }
    }

    if (!empty($_COOKIE['password']) && !empty($sEncrypted)) {
      if ($_COOKIE['password'] == $sEncrypted) {
        return true;
      }
    }

    return false;
  }


 /**
  * This function makes a new password from a plaintext password.
  *
  * @param $sPlain
  * @return string
  */
  function oos_encrypt_password($sPlain) {
    $sPassword = '';

    for ($i=0; $i<10; $i++) {
      $sPassword .= oos_rand();
    }

    $sSalt = substr(md5($sPassword), 0, 2);

    $sPassword = md5($sSalt . $sPlain) . ':' . $sSalt;

    return $sPassword;
  }


