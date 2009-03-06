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

  class paymentModuleInfo {
    var $payment_code;
    var $keys;

// class constructor
    function paymentModuleInfo($pmInfo_array) {

      $this->payment_code = $pmInfo_array['payment_code'];

      // Get database information
      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      for ($i = 0, $n = count($pmInfo_array) - 1; $i < $n; $i++) {

        $query = "SELECT configuration_value 
                  FROM " . $oostable['configuration'] . " 
                  WHERE configuration_key = '" . $pmInfo_array[$i] . "'";
        $result =& $dbconn->Execute($query);
        $key_value = $result->fields;

        $this->keys[$pmInfo_array[$i]]['title'] = constant(strtoupper($pmInfo_array[$i] . '_TITLE'));
        $this->keys[$pmInfo_array[$i]]['value'] = $key_value['configuration_value'];
        $this->keys[$pmInfo_array[$i]]['description'] = constant(strtoupper($pmInfo_array[$i] . '_DESC'));
      }
    }
  }
?>