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

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

  class oos_event_DEBUG {

    var $name;
    var $description;
    var $uninstallable;
    var $depends = 'language';
    var $preceeds;
    var $author;
    var $version;
    var $requirements;


   /**
    *  class constructor
    */
    function oos_event_debug() {

      $this->name          = PLUGIN_EVENT_DEBUG_NAME;
      $this->description   = PLUGIN_EVENT_DEBUG_DESC;
      $this->uninstallable = true;
      $this->author        = 'OOS Development Team';
      $this->version       = '1.0';
      $this->requirements  = array(
                               'oos'         => '1.5.0',
                               'smarty'      => '2.6.9',
                               'adodb'       => '4.62',
                               'php'         => '4.2.0'
      );
    }

    function create_plugin_instance() {
       global $aInfoMessage, $aLang;

       if (!isset($aInfoMessage)) $aInfoMessage = array();

       // check if the 'install' directory exists, and warn of its existence
       if (WARN_INSTALL_EXISTENCE == '1') {
         if (file_exists(dirname(oos_server_get_var('SCRIPT_FILENAME')) . '/install')) {
           $aInfoMessage[] = array('type' => 'warning',
                                   'text' => $aLang['warning_install_directory_exists']);
         }
       }

       // check if the configure.php file is writeable
       if (WARN_CONFIG_WRITEABLE == '1') {
         if ( (file_exists(dirname(oos_server_get_var('SCRIPT_FILENAME')) . '/includes/configure.php')) && (is_writeable(dirname(oos_server_get_var('SCRIPT_FILENAME')) . '/includes/configure.php')) ) {
           $aInfoMessage[] = array('type' => 'warning',
                                   'text' => $aLang['warning_config_file_writeable']);
         }
       }

       // check if the session folder is writeable
       if (WARN_SESSION_DIRECTORY_NOT_WRITEABLE == '1') {
         if (STORE_SESSIONS == '0') {
           if (!is_dir(oos_session_save_path())) {
             $aInfoMessage[] = array('type' => 'warning',
                                     'text' => $aLang['warning_session_directory_non_existent']);
           } elseif (!is_writeable(oos_session_save_path())) {
             $aInfoMessage[] = array('type' => 'warning',
                                    'text' => $aLang['warning_session_directory_not_writeable']);
           }
         }
       }

      // check session.auto_start is disabled
      if ( (function_exists('ini_get')) && (WARN_SESSION_AUTO_START == '1') ) {
        if (ini_get('session.auto_start') == '1') {
          $aInfoMessage[] = array('type' => 'warning',
                                  'text' => $aLang['warning_session_auto_start']);
        }
      }

      if ( (WARN_DOWNLOAD_DIRECTORY_NOT_READABLE == '1') && (DOWNLOAD_ENABLED == '1') ) {
        if (!is_dir(OOS_DOWNLOAD_PATH)) {
          $aInfoMessage[] = array('type' => 'warning',
                                 'text' => $aLang['warning_download_directory_non_existent']);
        }
      }

      return true;
    }

    function install() {
      return true;
    }

    function remove() {
      return true;
    }

    function config_item() {
      return false;
    }
  }

?>
