<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: ot_redemptions.php,2.00 2006/JULY/06 15:55:30 dsa_ 
   ----------------------------------------------------------------------
   created by Ben Zukrel, Deep Silver Accessories
   http://www.deep-silver.com

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */


  class ot_redemptions {
    var $title, $output, $enabled = false;

    function ot_redemptions() {
      global $oEvent, $aLang;

      $this->code = 'ot_redemptions';
      $this->title = $aLang['module_order_total_redemptions_title'];
      $this->description = $aLang['module_order_total_redemptions_description'];

      if (is_object($oEvent) && ($oEvent->installed_plugin('points')) )  {
        $this->enabled = true;
      } else {
        $this->enabled = false;
      }

      $this->sort_order = (defined('MODULE_ORDER_TOTAL_REDEMPTIONS_SORT_ORDER') ? MODULE_ORDER_TOTAL_REDEMPTIONS_SORT_ORDER : null);

      $this->output = array();

    }

    function process() {
      global $oOrder, $oCurrencies, $customer_shopping_points_spending, $aLang;

// if customer is using points to pay   
      if ($customer_shopping_points_spending > 0){

        $oOrder->info['total'] = $oOrder->info['total'] - (oos_calc_shopping_pvalue($customer_shopping_points_spending));

        $this->output[] = array('title' => $aLang['module_order_total_redemptions_text'] . ':',
                                'text' => '<font color="FF0000">-'.$oCurrencies->format(oos_calc_shopping_pvalue($customer_shopping_points_spending), true, $oOrder->info['currency'], $oOrder->info['currency_value'].'</font>'),
                                'value' => oos_calc_shopping_pvalue($customer_shopping_points_spending));

      }
    }

    function check() {
      if (!isset($this->_check)) {
        $this->_check = defined('MODULE_ORDER_TOTAL_REDEMPTIONS_SORT_ORDER');
      }

      return $this->_check;
    }

    function keys() {
      return array('MODULE_ORDER_TOTAL_REDEMPTIONS_SORT_ORDER');
    }

    function install() {

      // Get database information
      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      $configurationtable = $oostable['configuration'];
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_ORDER_TOTAL_REDEMPTIONS_SORT_ORDER', '9', '6', '2', now())");
    }

    function remove() {

      // Get database information
      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      $configurationtable = $oostable['configuration'];
      $dbconn->Execute("DELETE FROM $configurationtable WHERE configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }
  }

?>
