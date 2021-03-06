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

  class oos_event_mail {

    var $name;
    var $description;
    var $uninstallable;
    var $depends;
    var $preceeds = 'session';
    var $author;
    var $version;
    var $requirements;


   /**
    *  class constructor
    */
    function oos_event_mail() {

      $this->name          = PLUGIN_EVENT_MAIL_NAME;
      $this->description   = PLUGIN_EVENT_MAIL_DESC;
      $this->uninstallable = true;
      $this->preceeds      = 'session';
      $this->author        = 'OOS Development Team';
      $this->version       = '1.0';
      $this->requirements  = array(
                               'oos'         => '1.7.0',
                               'smarty'      => '2.6.9',
                               'adodb'       => '4.62',
                               'php'         => '4.2.0'
      );
    }


    function create_plugin_instance() {

      return true;
    }

    function install() {

      // Get database information
      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      $configurationtable = $oostable['configuration'];
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SEND_EXTRA_ORDER_EMAILS_TO', '', 6, 1, NULL, '" . date("Y-m-d H:i:s", time()) . "', NULL, NULL)");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SEND_BANKINFO_TO_ADMIN', '0', 6, 2, NULL, '" . date("Y-m-d H:i:s", time()) . "', NULL, 'oos_cfg_select_option(array(\'1\', \'0\'),')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_TRANSPORT', 'mail', 6, 3, NULL, '" . date("Y-m-d H:i:s", time()) . "', NULL, 'oos_cfg_select_option(array(\'mail\', \'sendmail\', \'smtp\'),')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_LINEFEED', 'LF', 6, 4, NULL, '" . date("Y-m-d H:i:s", time()) . "', NULL, 'oos_cfg_select_option(array(\'LF\', \'CRLF\'),')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('EMAIL_USE_HTML', '0', 6, 5, NULL, '" . date("Y-m-d H:i:s", time()) . "', NULL, 'oos_cfg_select_option(array(\'1\', \'0\'),')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('OOS_SMTPAUTH', '1', 6, 7, NULL, '" . date("Y-m-d H:i:s", time()) . "', NULL, 'oos_cfg_select_option(array(\'1\', \'0\'),')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('OOS_SMTPUSER', '', 6, 8, NULL, '" . date("Y-m-d H:i:s", time()) . "', NULL, NULL)");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('OOS_SMTPPASS', '', 6, 9, NULL, '" . date("Y-m-d H:i:s", time()) . "', NULL, NULL)");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('OOS_SMTPHOST', '', 6, 10, NULL, '" . date("Y-m-d H:i:s", time()) . "', NULL, NULL)");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('OOS_SENDMAIL', '', 6, 11, NULL, '" . date("Y-m-d H:i:s", time()) . "', NULL, NULL)");

      return true;
    }

    function remove() {

      // Get database information
      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      $configurationtable = $oostable['configuration'];
      $dbconn->Execute("DELETE FROM $configurationtable WHERE configuration_key in ('" . implode("', '", $this->config_item()) . "')");

      return true;
    }

    function config_item() {
      return array('SEND_EXTRA_ORDER_EMAILS_TO', 'SEND_BANKINFO_TO_ADMIN', 'EMAIL_TRANSPORT', 'EMAIL_LINEFEED', 'EMAIL_USE_HTML', 'OOS_SMTPAUTH', 'OOS_SMTPUSER', 'OOS_SMTPPASS', 'OOS_SMTPHOST', 'OOS_SENDMAIL');
    }
  }

