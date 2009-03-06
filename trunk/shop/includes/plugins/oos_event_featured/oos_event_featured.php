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

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


  class oos_event_featured {

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
    function oos_event_featured() {

      $this->name          = PLUGIN_EVENT_FEATURED_NAME;
      $this->description   = PLUGIN_EVENT_FEATURED_DESC;
      $this->uninstallable = true;
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

      include 'includes/functions/function_featured.php';
      oos_expire_featured();

      return true;
    }

    function install() {

      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      $blocktable = $oostable['block'];
      $dbconn->Execute("UPDATE $blocktable
                        SET block_status = 1
                        WHERE block_file = 'specials'");

      $today = date("Y-m-d H:i:s");

      $configurationtable = $oostable['configuration'];
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAX_DISPLAY_FEATURED_PRODUCTS', '6', 6, 1, NULL, " . $dbconn->DBTimeStamp($today) . ", NULL, NULL)");

      return true;
    }

    function remove() {

      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      $configurationtable = $oostable['configuration'];
      $dbconn->Execute("DELETE FROM $configurationtable WHERE configuration_key in ('" . implode("', '", $this->config_item()) . "')");

      return true;
    }

    function config_item() {
      return array('MAX_DISPLAY_FEATURED_PRODUCTS');

    }
  }

?>
