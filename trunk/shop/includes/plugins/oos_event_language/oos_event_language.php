<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2005 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

  class oos_event_language {

    var $name;
    var $description;
    var $uninstallable;
    var $depends;
    var $preceeds;
    var $author;
    var $version;
    var $requirements;


   /**
    *  class constructor
    */
    function oos_event_language() {

      $this->name          = PLUGIN_EVENT_LANGUAGE_NAME;
      $this->description   = PLUGIN_EVENT_LANGUAGE_DESC;
      $this->uninstallable = false;
      $this->author        = 'OOS Development Team';
      $this->version       = '2.0';
      $this->requirements  = array(
                               'oos'         => '1.7.0',
                               'smarty'      => '2.6.9',
                               'adodb'       => '4.62',
                               'php'         => '4.2.0'
      );
    }

    function create_plugin_instance() {
      global $oLang, $aLang;

      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      $aFilename = oos_get_filename();
      $aModules = oos_get_modules();

      if (!isset($_SESSION['language']) || isset($_GET['language'])) {
        // include the language class
        include 'includes/classes/class_language.php';
        $oLang = new language;

        if (isset($_GET['language']) && oos_is_not_null($_GET['language'])) {
          $oLang->set($_GET['language']);
        } else {
          $oLang->get_browser_language();
        }
      }

      $sLanguage = oos_var_prep_for_os($_SESSION['language']);
      include 'includes/languages/' . $sLanguage . '.php';

      return true;

    }

    function install() {
      return false;
    }

    function remove() {
      return false;
    }

    function config_item() {
      return false;
    }
  }

?>
