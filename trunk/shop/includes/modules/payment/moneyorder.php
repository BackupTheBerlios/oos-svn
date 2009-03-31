<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: moneyorder.php,v 1.10 2003/01/29 19:57:14 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  class moneyorder {
    var $code, $title, $description, $enabled = false;

// class constructor
    function moneyorder() {
      global $oOrder, $aLang;

      $this->code = 'moneyorder';
      $this->title = $aLang['module_payment_moneyorder_text_title'];
      $this->description = $aLang['module_payment_moneyorder_text_description'];
      $this->enabled = (defined('MODULE_PAYMENT_MONEYORDER_STATUS') && (MODULE_PAYMENT_MONEYORDER_STATUS == '1') ? true : false);
      $this->sort_order = (defined('MODULE_PAYMENT_MONEYORDER_SORT_ORDER') ? MODULE_PAYMENT_MONEYORDER_SORT_ORDER : null);

      if ((int)MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID;
      }

      if (is_object($oOrder)) $this->update_status();

      $this->email_footer = $aLang['module_payment_moneyorder_text_email_footer'];
    }

// class methods
    function update_status() {
      global $oOrder;

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_MONEYORDER_ZONE > 0) ) {
        $check_flag = false;

        // Get database information
        $dbconn =& oosDBGetConn();
        $oostable =& oosDBGetTables();

        $zones_to_geo_zonestable = $oostable['zones_to_geo_zones'];
        $check_result = $dbconn->Execute("SELECT zone_id FROM $zones_to_geo_zonestable WHERE geo_zone_id = '" . MODULE_PAYMENT_MONEYORDER_ZONE . "' AND zone_country_id = '" . $oOrder->billing['country']['id'] . "' ORDER BY zone_id");
        while ($check = $check_result->fields)
        {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $oOrder->billing['zone_id']) {
            $check_flag = true;
            break;
          }

          // Move that ADOdb pointer!
          $check_result->MoveNext();
        }

        // Close result set
        $check_result->Close();

        if ($check_flag == false) {
          $this->enabled = false;
        }
      }
    }

    function javascript_validation() {
      return false;
    }

    function selection() {
      return array('id' => $this->code,
                   'module' => $this->title);
    }

    function pre_confirmation_check() {
      return false;
    }

    function confirmation() {
      global $aLang;
      return array('title' => $aLang['module_payment_moneyorder_text_description']);
    }

    function process_button() {
      return false;
    }

    function before_process() {
      return false;
    }

    function after_process() {
      return false;
    }

    function get_error() {
      return false;
    }

    function check() {
      if (!isset($this->_check)) {
        $this->_check = defined('MODULE_PAYMENT_MONEYORDER_STATUS');
      }

      return $this->_check;
    }

    function install() {

      // Get database information
      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      $configurationtable = $oostable['configuration'];
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PAYMENT_MONEYORDER_STATUS', '1', '6', '1', 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d", time()) . "');");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_MONEYORDER_PAYTO', '', '6', '1', '" . date("Y-m-d", time()) . "');");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_MONEYORDER_SORT_ORDER', '0', '6', '0', '" . date("Y-m-d", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('MODULE_PAYMENT_MONEYORDER_ZONE', '0', '6', '2', 'oos_cfg_get_zone_class_title', 'oos_cfg_pull_down_zone_classes(', '" . date("Y-m-d", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID', '0', '6', '0', 'oos_cfg_pull_down_order_statuses(', 'oos_cfg_get_order_status_name', '" . date("Y-m-d", time()) . "')");
    }

    function remove() {

      // Get database information
      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      $configurationtable = $oostable['configuration'];
      $dbconn->Execute("DELETE FROM $configurationtable WHERE configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
      return array('MODULE_PAYMENT_MONEYORDER_STATUS', 'MODULE_PAYMENT_MONEYORDER_ZONE', 'MODULE_PAYMENT_MONEYORDER_ORDER_STATUS_ID', 'MODULE_PAYMENT_MONEYORDER_SORT_ORDER', 'MODULE_PAYMENT_MONEYORDER_PAYTO');
    }
  }

