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

define('WEBMASTER_NAME', STORE_OWNER);
define('WEBMASTER_EMAIL_ADDRESS', STORE_OWNER_EMAIL_ADDRESS);

 /**
  * For debugging purposes
  *
  * @package  core
  * @access   public
  *
  * @author   r23 <info@r23.de>
  * @since    OOS 1.3.1
  */
  set_error_handler('oos_error_log_handler');

  if (function_exists('ini_set')) {
    ini_set('allow_call_time_pass_reference',1);
    ini_set('track_errors',1);
 /*
    ini_set('error_reporting',E_ALL & ~E_NOTICE);
    ini_set('display_errors',0);
    ini_set('log_errors',1);
 */
    ini_set('error_reporting',E_ALL);
    ini_set('display_errors',1);
    ini_set('log_errors',0);
  }

  /**
   * Error log handler
   *
   * @access  public
   * @param   string
   * @param   string
   * @param   string
   * @param   string
   * @param   string
   * @return  boolean
   *
   * @author  r23 <info@r23.de>
   * @since   OOS 1.3.1
   */
  function oos_error_log_handler($sErrNo, $sErrMsg, $sErrFile, $sErrLine, $sErrVars) {
    if (substr($sErrMsg, 0, 4) == 'stat') {
      return true;
    }


    // define an assoc array of error string
    // in reality the only entries we should
    // consider are 2,8,256,512 and 1024
    $errortype = array ( 1   =>  'Error',
                         2   =>  'Warning',
                         4   =>  'Parsing Error',
                         8   =>  'Notice',
                         16  =>  'Core Error',
                         32  =>  'Core Warning',
                         64  =>  'Compile Error',
                         128 =>  'Compile Warning',
                         256 =>  'User Error',
                         512 =>  'User Warning',
                         1024=>  'User Notice');

    // $aErrUser = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
    $aErrUser = array(E_USER_ERROR);

    if (in_array($sErrNo, $aErrUser)) {
      $sUserIP = oos_server_get_remote();

      $sErr = '[' . date('D M j G:i:s Y') . ']'
             .' [error]'
             .' [client ' . $sUserIP . '] ';

      $sErr .= '( MyOOS )'
              .' '. $errortype[$sErrNo]
              .' '. $sErrMsg
              .' in file '.$sErrFile
              .' line '.$sErrLine . "\n";

      @error_log($sErr, 3, OOS_TEMP_PATH . 'logs/php_error.log');

      if ($sErrNo == E_USER_ERROR){
        oos_mail(WEBMASTER_NAME, WEBMASTER_NAME_EMAIL_ADDRESS, '[ERROR] Critical User Error', nl2br($sErr), WEBMASTER_NAME, WEBMASTER_NAME_EMAIL_ADDRESS, '1');
      }
    }
  }
