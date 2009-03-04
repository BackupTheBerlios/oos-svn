<?php
/* ----------------------------------------------------------------------
   $Id: info_message.php,v 1.25 2009/02/21 22:33:11 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: header.php,v 1.39 2003/02/13 04:23:23 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if (!isset($aInfoMessage)) $aInfoMessage = array();


// Todo Remove 
  if (isset($_GET['error_message']) && oos_is_not_null($_GET['error_message'])) {
    $aInfoMessage[] = array('type' => 'error',
                            'text' => urldecode($_GET['error_message']));
  }

  if (isset($_GET['info_message']) && oos_is_not_null($_GET['info_message'])) {
    $aInfoMessage[] = array('type' => 'info',
                            'text' => urldecode($_GET['info_message']));
  }

  if ($oMessage->size('upload') > 0) {
    $aInfoMessage = array_merge ($aInfoMessage, $oMessage->output('upload') );
  }


for ($i = 0; $i < count($aInfoMessage); $i++) {
   switch ($aInfoMessage[$i]['type']) {
       case 'warning':
           $oSmarty->append('oos_info_warning', array('text' => $aInfoMessage[$i]['text']));
           break;

       case 'error':
           $oSmarty->append('oos_error_message', array('text' => $aInfoMessage[$i]['text']));
           break;

       case 'info':
       case 'success':
           $oSmarty->append('oos_info_message', array('text' => $aInfoMessage[$i]['text']));
           break;
   }
}

?>
