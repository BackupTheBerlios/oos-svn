<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: item.php,v 1.39 2003/02/05 22:41:52 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  class item {
    var $code, $title, $description, $icon, $enabled = false;

// class constructor
    function item() {
      global $oOrder, $aLang;

      $this->code = 'item';
      $this->title = $aLang['module_shipping_item_text_title'];
      $this->description = $aLang['module_shipping_item_text_description'];
      $this->sort_order = (defined('MODULE_SHIPPING_ITEM_SORT_ORDER') ? MODULE_SHIPPING_ITEM_SORT_ORDER : null);
      $this->icon = '';
      $this->tax_class = (defined('MODULE_SHIPPING_ITEM_TAX_CLASS') ? MODULE_SHIPPING_ITEM_TAX_CLASS : null);
      $this->enabled = (defined('MODULE_SHIPPING_ITEM_STATUS') && (MODULE_SHIPPING_ITEM_STATUS == '1') ? true : false);

      if ( ($this->enabled == true) && ((int)MODULE_SHIPPING_ITEM_ZONE > 0) ) {
        $check_flag = false;

        // Get database information
        $dbconn =& oosDBGetConn();
        $oostable =& oosDBGetTables();

        $zones_to_geo_zonestable = $oostable['zones_to_geo_zones'];
        $check_result = $dbconn->Execute("SELECT zone_id FROM $zones_to_geo_zonestable WHERE geo_zone_id = '" . MODULE_SHIPPING_ITEM_ZONE . "' and zone_country_id = '" . $oOrder->delivery['country']['id'] . "' ORDER BY zone_id");
        while ($check = $check_result->fields)
        {
          if ($check['zone_id'] < 1) {
            $check_flag = true;
            break;
          } elseif ($check['zone_id'] == $oOrder->delivery['zone_id']) {
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

// class methods
    function quote($method = '') {
      global $oOrder, $aLang,  $total_count;

      $this->quotes = array('id' => $this->code,
                            'module' => $aLang['module_shipping_item_text_title'],
                            'methods' => array(array('id' => $this->code,
                                                     'title' => $aLang['module_shipping_item_text_way'],
                                                     'cost' => (MODULE_SHIPPING_ITEM_COST * $total_count) + MODULE_SHIPPING_ITEM_HANDLING)));

      if ($this->tax_class > 0) {
        $this->quotes['tax'] = oos_get_tax_rate($this->tax_class, $oOrder->delivery['country']['id'], $oOrder->delivery['zone_id']);
      }

      if (oos_is_not_null($this->icon)) $this->quotes['icon'] = oos_image($this->icon, $this->title);

      return $this->quotes;
    }


    function check() {
      if (!isset($this->_check)) {
        $this->_check = defined('MODULE_SHIPPING_ITEM_STATUS');
      }

      return $this->_check;
    }


    function install() {

      // Get database information
      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      $configurationtable = $oostable['configuration'];
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_SHIPPING_ITEM_STATUS', '1', '6', '0', 'oos_cfg_select_option(array(\'1\', \'0\'), ', now())");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_SHIPPING_ITEM_COST', '2.50', '6', '0', now())");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_SHIPPING_ITEM_HANDLING', '0', '6', '0', now())");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('MODULE_SHIPPING_ITEM_TAX_CLASS', '0', '6', '0', 'oos_cfg_get_tax_class_title', 'oos_cfg_pull_down_tax_classes(', now())");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('MODULE_SHIPPING_ITEM_ZONE', '0', '6', '0', 'oos_cfg_get_zone_class_title', 'oos_cfg_pull_down_zone_classes(', now())");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_SHIPPING_ITEM_SORT_ORDER', '0', '6', '0', now())");
    }


    function remove() {

      // Get database information
      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      $configurationtable = $oostable['configuration'];
      $dbconn->Execute("DELETE FROM $configurationtable WHERE configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }


    function keys() {
      return array('MODULE_SHIPPING_ITEM_STATUS', 'MODULE_SHIPPING_ITEM_COST', 'MODULE_SHIPPING_ITEM_HANDLING', 'MODULE_SHIPPING_ITEM_TAX_CLASS', 'MODULE_SHIPPING_ITEM_ZONE', 'MODULE_SHIPPING_ITEM_SORT_ORDER');
    }
  }

