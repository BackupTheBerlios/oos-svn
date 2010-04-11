<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
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

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); 
    header("Location: /");
    header("Connection: close");
    exit;
}

if (!isset($aInfoMessage)) $aInfoMessage = array();


if (isset($_SESSION['error_message']) && !empty($_SESSION['error_message'])) {
    $aInfoMessage[] = array('type' => 'error',
                            'text' => oos_var_prep_for_os($_SESSION['error_message']));
    unset($_SESSION['error_message']);
}

if (isset($_SESSION['info_message']) && !empty($_SESSION['info_message'])) {
    $aInfoMessage[] = array('type' => 'info',
                            'text' => oos_var_prep_for_os($_SESSION['info_message']));
    unset($_SESSION['info_message']);
}

if ($oMessage->size('upload') > 0) {
    $aInfoMessage = array_merge ($aInfoMessage, $oMessage->output('upload') );
}


$nArrayCountInfoMessage = count( $aInfoMessage );
for ($i = 0; $i < $nArrayCountInfoMessage; $i++) {
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
