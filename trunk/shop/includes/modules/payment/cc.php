<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: cc.php,v 1.53 2003/02/04 09:55:01 project3000
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  class cc {
    var $code, $title, $description, $enabled = false;

// class constructor
    function cc() {
      global $oOrder, $aLang;

      $this->code = 'cc';
      $this->title = $aLang['module_payment_cc_text_title'];
      $this->description = $aLang['module_payment_cc_text_description'];
      $this->enabled = (defined('MODULE_PAYMENT_CC_STATUS') && (MODULE_PAYMENT_CC_STATUS == '1') ? true : false);
      $this->sort_order = (defined('MODULE_PAYMENT_CC_SORT_ORDER') ? MODULE_PAYMENT_CC_SORT_ORDER : null);
      $this->accepted = '';
      if ((int)MODULE_PAYMENT_CC_ORDER_STATUS_ID > 0) {
        $this->order_status = MODULE_PAYMENT_CC_ORDER_STATUS_ID;
      }

      if (is_object($oOrder)) $this->update_status();
    }

// class methods
    function update_status() {
      global $oOrder;

      if ($_SESSION['shipping']['id'] == 'selfpickup_selfpickup') {
        $this->enabled = false;
      }

      if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_CC_ZONE > 0) ) {
        $check_flag = false;

        // Get database information
        $dbconn =& oosDBGetConn();
        $oostable =& oosDBGetTables();

        $zones_to_geo_zonestable = $oostable['zones_to_geo_zones'];
        $check_result = $dbconn->Execute("SELECT zone_id FROM $zones_to_geo_zonestable WHERE geo_zone_id = '" . MODULE_PAYMENT_CC_ZONE . "' AND zone_country_id = '" . $oOrder->billing['country']['id'] . "' ORDER BY zone_id");
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
      global $aLang;

      if (USE_CC_CVV == '1') {
        $js = '  if (payment_value == "' . $this->code . '") {' . "\n" .
              '    var cc_owner = document.checkout_payment.cc_owner.value;' . "\n" .
              '    var cc_number = document.checkout_payment.cc_number.value;' . "\n" .
              '    if (cc_owner == "" || cc_owner.length < ' . CC_OWNER_MIN_LENGTH . ') {' . "\n" .
              '      error_message = error_message + "' . $aLang['module_payment_cc_text_js_cc_owner'] . '";' . "\n" .
              '      error = 1;' . "\n" .
              '    }' . "\n" .
              '    if (cc_number == "" || cc_number.length < ' . CC_NUMBER_MIN_LENGTH . ') {' . "\n" .
              '      error_message = error_message + "' . $aLang['module_payment_cc_text_js_cc_number'] . '";' . "\n" .
              '      error = 1;' . "\n" .
              '    }' . "\n" .
              '    if (cc_cvv == "" || cc_cvv.length <= 2) {'."\n".
              '     error_message = error_message + "' . $aLang['module_payment_cc_text_js_cc_cvv'] . '";' . "\n" .
              '     error = 1;'."\n".'	 }'."\n".
              '    }' . "\n" .
              '  }' . "\n";
        return $js;
      } else {
        $js = '  if (payment_value == "' . $this->code . '") {' . "\n" .
              '    var cc_owner = document.checkout_payment.cc_owner.value;' . "\n" .
              '    var cc_number = document.checkout_payment.cc_number.value;' . "\n" .
              '    if (cc_owner == "" || cc_owner.length < ' . CC_OWNER_MIN_LENGTH . ') {' . "\n" .
              '      error_message = error_message + "' . $aLang['module_payment_cc_text_js_cc_owner'] . '";' . "\n" .
              '      error = 1;' . "\n" .
              '    }' . "\n" .
              '    if (cc_number == "" || cc_number.length < ' . CC_NUMBER_MIN_LENGTH . ') {' . "\n" .
              '      error_message = error_message + "' . $aLang['module_payment_cc_text_js_cc_number'] . '";' . "\n" .
              '      error = 1;' . "\n" .
              '    }' . "\n" .
              '  }' . "\n";
        return $js;
      }
    }

    function selection() {
      global $oOrder, $aLang;

      for ($i=1; $i<13; $i++) {
        $expires_month[] = array('id' => sprintf('%02d', $i), 'text' => strftime('%B',mktime(0,0,0,$i,1,2000)));
      }

      $today = getdate();
      for ($i=$today['year']; $i < $today['year']+10; $i++) {
        $expires_year[] = array('id' => strftime('%y',mktime(0,0,0,1,1,$i)), 'text' => strftime('%Y',mktime(0,0,0,1,1,$i)));
      }


      for ($i = 1; $i < 13; $i ++) {
        $start_month[] = array ('id' => sprintf('%02d', $i), 'text' => strftime('%B', mktime(0,0,0,$i,1,2000)));
      }

      $today = getdate();
      for ($i = $today['year'] - 4; $i <= $today['year']; $i ++) {
        $start_year[] = array ('id' => strftime('%y', mktime(0,0,0,1,1,$i)), 'text' => strftime('%Y', mktime(0, 0, 0, 1, 1, $i)));
      }

      $form_array = array ();

      // Owner
      $form_array = array_merge($form_array, array(array('title' => $aLang['module_payment_cc_text_credit_card_owner'], 'field' => oos_draw_input_field('cc_owner', $oOrder->billing['firstname'] . ' ' . $oOrder->billing['lastname']))));

      // CC Number
      $form_array = array_merge($form_array, array(array('title' => $aLang['module_payment_cc_text_credit_card_number'], 'field' => oos_draw_input_field('cc_number'))));


      // Startdate
      if (USE_CC_START == '1') {
        $form_array = array_merge($form_array, array(array('title' => $aLang['module_payment_cc_text_credit_card_start'], 'field' => oos_draw_pull_down_menu('cc_start_month', $start_month).'&nbsp;'.oos_draw_pull_down_menu('cc_start_year', $start_year))));
      }
      // expire date
      $form_array = array_merge($form_array, array(array('title' => $aLang['module_payment_cc_text_credit_card_expires'], 'field' => oos_draw_pull_down_menu('cc_expires_month', $expires_month) . '&nbsp;' . oos_draw_pull_down_menu('cc_expires_year', $expires_year))));


      // CVV
      if (USE_CC_CVV == '1') {
        $form_array = array_merge($form_array, array(array('title' => $aLang['module_payment_cc_text_credit_card_cvv'], 'field' => oos_draw_input_field('cc_cvv', '', 'size=4 maxlength=4'))));
      }

      if (USE_CC_ISS == '1') {
        $form_array = array_merge($form_array, array(array('title' => $aLang['module_payment_cc_text_credit_card_issue'], 'field' => oos_draw_input_field('cc_issue', '', 'size=2 maxlength=2'))));
      }


      // cards
      if (MODULE_PAYMENT_CC_ACCEPT_VISA == '1')
        $this->accepted .= oos_image(OOS_ICONS . 'cc_visa.jpg');
      if (MODULE_PAYMENT_CC_ACCEPT_MASTERCARD == '1')
        $this->accepted .= oos_image(OOS_ICONS . 'cc_mastercard.jpg');
      if (MODULE_PAYMENT_CC_ACCEPT_AMERICANEXPRESS == '1')
        $this->accepted .= oos_image(OOS_ICONS . 'cc_amex.jpg');
      if (MODULE_PAYMENT_CC_ACCEPT_DINERSCLUB == '1')
        $this->accepted .= oos_image(OOS_ICONS . 'cc_diners.jpg');
      if (MODULE_PAYMENT_CC_ACCEPT_DISCOVERNOVUS == '1')
        $this->accepted .= oos_image(OOS_ICONS . 'cc_discover.jpg');
      if (MODULE_PAYMENT_CC_ACCEPT_JCB == '1')
        $this->accepted .= oos_image(OOS_ICONS . 'cc_jcb.jpg');
      if (MODULE_PAYMENT_CC_ACCEPT_OZBANKCARD == '1')
        $this->accepted .='';

      $form_array = array_merge(array(array('title'=>$aLang['module_payment_cc_accepted_cards'],'field'=>$this->accepted)),$form_array);

      $selection = array ('id' => $this->code,
                          'module' => $this->title,
                          'fields' => $form_array);

      return $selection;
    }

    function pre_confirmation_check() {
      global $aLang;

      include 'includes/classes/class_cc_validation.php';

      $cc_validation = new cc_validation();
      $result = $cc_validation->validate($_POST['cc_number'], $_POST['cc_expires_month'], $_POST['cc_expires_year'], $_POST['cc_start_month'], $_POST['cc_start_year'], $_POST['cc_cvv'], $_POST['cc_issue']);

      $error = '';
     switch ($result) {
        case -1 :
          $error = sprintf($aLang['text_ccval_error_unknown_card'], substr($cc_validation->cc_number, 0, 4));
          break ;
        case -2 :
        case -3 :
        case -4 :
          $error = $aLang['text_ccval_error_invalid_date'];
          break;
        case -5 :
          $cards = '';
          if (MODULE_PAYMENT_CC_ACCEPT_VISA == '1')
            $cards .= ' Visa,';
          if (MODULE_PAYMENT_CC_ACCEPT_MASTERCARD == '1')
            $cards .= ' Master Card,';
          if (MODULE_PAYMENT_CC_ACCEPT_AMERICANEXPRESS == '1')
            $cards .= ' American Express,';
          if (MODULE_PAYMENT_CC_ACCEPT_DINERSCLUB == '1')
            $cards .= ' Diners Club,';
          if (MODULE_PAYMENT_CC_ACCEPT_DISCOVERNOVUS == '1')
            $cards .= ' Discover,';
          if (MODULE_PAYMENT_CC_ACCEPT_JCB == '1')
            $cards .= ' JCB,';
          if (MODULE_PAYMENT_CC_ACCEPT_OZBANKCARD == '1')
            $cards .= ' Australian BankCard,';
          $error = sprintf($aLang['text_card_not_aczepted'], $cc_validation->cc_type).$cards;
          break;

        case false:
          $error = $aLang['text_ccval_error_invalid_number'];
          break;
      }


      if ( ($result == false) || ($result < 1) ) {
        $payment_error_return = 'payment_error=' . $this->code . '&error=' . urlencode($error) . '&cc_owner=' . urlencode($_POST['cc_owner']) . '&cc_expires_month=' . $_POST['cc_expires_month'] . '&cc_expires_year=' . $_POST['cc_expires_year'];

        $aPages = oos_get_pages();
        MyOOS_CoreApi::redirect(oos_href_link($aModules['checkout'], $aFilename['checkout_payment'], $payment_error_return, 'SSL', true, false));
      }

	  if (USE_CC_CVV != '1') {
        $this->cc_cvv = '000';
      }

      $this->cc_card_type = $cc_validation->cc_type;
      $this->cc_card_number = $cc_validation->cc_number;
    }


    function confirmation() {
      global $aLang;


      $form_array = array ();

      // CC Owner
      $form_array = array_merge($form_array, array (array ('title' => $aLang['module_payment_cc_text_credit_card_owner'], 'field' => $_POST['cc_owner'])));

      // CC Number
      $form_array = array_merge($form_array, array (array ('title' => $aLang['module_payment_cc_text_credit_card_number'], 'field' => substr($_POST['cc_number'], 0, 4).str_repeat('X', (strlen($_POST['cc_number']) - 8)).substr($_POST['cc_number'], -4))));

      // startdate
      if (strtolower(USE_CC_START) == '1') {
        $form_array = array_merge($form_array, array (array ('title' => $aLang['module_payment_cc_text_credit_card_start'], 'field' => strftime('%B, %Y', mktime(0, 0, 0, $_POST['cc_start_month'], 1, $_POST['cc_start_year'])))));
      }

      //expire date
      $form_array = array_merge($form_array, array (array ('title' => $aLang['module_payment_cc_text_credit_card_expires'], 'field' => strftime('%B, %Y', mktime(0, 0, 0, $_POST['cc_expires_month'], 1, '20'.$_POST['cc_expires_year'])))));


      if (USE_CC_CVV == '1') {
        $form_array = array_merge($form_array, array (array ('title' => $aLang['module_payment_cc_text_credit_card_cvv'], 'field' => $_POST['cc_cvv'])));
      }

      // ISS
      if (strtolower(USE_CC_ISS) == '1') {
        $form_array = array_merge($form_array, array (array ('title' => $aLang['module_payment_cc_text_credit_card_issue'], 'field' => $_POST['cc_issue'])));
      }


      $confirmation = array ('title' => $this->title.': '.$this->cc_card_type, 'fields' => $form_array);


      return $confirmation;
    }

    function process_button() {

      $process_button_string = oos_draw_hidden_field('cc_owner', $_POST['cc_owner']) .
                               oos_draw_hidden_field('cc_expires', $_POST['cc_expires_month'] . $_POST['cc_expires_year']) .
                               oos_draw_hidden_field('cc_start', $_POST['cc_start_month'].$_POST['cc_start_year']) .
                               oos_draw_hidden_field('cc_cvv', $_POST['cc_cvv']) .
                               oos_draw_hidden_field('cc_issue', $_POST['cc_issue']) .
                               oos_draw_hidden_field('cc_type', $this->cc_card_type) .
                               oos_draw_hidden_field('cc_number', $this->cc_card_number);

      return $process_button_string;
    }

    function before_process() {
      global $oOrder;

      if ( (defined('MODULE_PAYMENT_CC_EMAIL')) && (oos_validate_is_email(MODULE_PAYMENT_CC_EMAIL)) ) {
        $len = strlen($_POST['cc_number']);

        $this->cc_middle = substr($_POST['cc_number'], 4, ($len-8));
        $oOrder->info['cc_number'] = substr($_POST['cc_number'], 0, 4) . str_repeat('X', (strlen($_POST['cc_number']) - 8)) . substr($_POST['cc_number'], -4);

        $this->cc_cvv = oos_var_prep_for_os($_POST['cc_cvv']);
        $this->cc_start = oos_var_prep_for_os($_POST['cc_start']);
        $this->cc_issue = oos_var_prep_for_os($_POST['cc_issue']);

      }
    }

    function after_process() {
      global $insert_id;

      if ( (defined('MODULE_PAYMENT_CC_EMAIL')) && (oos_validate_is_email(MODULE_PAYMENT_CC_EMAIL)) ) {
        $message = 'Order #' . $insert_id . "\n\n" . 'Middle: ' . $this->cc_middle . "\n\n" .
                   'CVV:' . $this->cc_cvv . "\n\n" . 'Start:' . $this->cc_start . "\n\n" .
                   'ISSUE:' . $this->cc_issue . "\n\n";


        oos_mail('', MODULE_PAYMENT_CC_EMAIL, 'Extra Order Info: #' . $insert_id, $message, STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
      }
    }

    function get_error() {
      global $aLang;

      $error = array('title' => $aLang['module_payment_cc_text_error'],
                     'error' => stripslashes(urldecode($_GET['error'])));

      return $error;
    }

    function check() {
      if (!isset($this->_check)) {
        $this->_check = defined('MODULE_PAYMENT_CC_STATUS');
      }

      return $this->_check;
    }

    function install() {

      // Get database information
      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      $configurationtable = $oostable['configuration'];
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PAYMENT_CC_STATUS', '1', '6', '0', 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('MODULE_PAYMENT_CC_ZONE', '0', '6', '2', 'oos_cfg_get_zone_class_title', 'oos_cfg_pull_down_zone_classes(', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('USE_CC_CVV', '1', '6', '0', 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('USE_CC_ISS', '1', '6', '0', 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('USE_CC_START', '1', '6', '0', 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('CC_VAL', '1', '6', '0', 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('CC_ENC', '1', '6', '0', 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_CC_ACCEPT_DINERSCLUB','0', 6, 0, 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_CC_ACCEPT_AMERICANEXPRESS','0', 6, 0, 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_CC_ACCEPT_OZBANKCARD','0', 6, 0, 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_CC_ACCEPT_DISCOVERNOVUS','0', 6, 0, 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_CC_ACCEPT_MASTERCARD','0', 6, 0, 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_CC_ACCEPT_JCB','0', 6, 0, 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_CC_ACCEPT_VISA','0', 6, 0, 'oos_cfg_select_option(array(\'1\', \'0\'), ', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('CC_CVV_MIN_LENGTH', '3', '6', '0', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_CC_EMAIL', '', '6', '0', '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_CC_SORT_ORDER', '0', '6', '0' , '" . date("Y-m-d H:i:s", time()) . "')");
      $dbconn->Execute("INSERT INTO $configurationtable (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) VALUES ('MODULE_PAYMENT_CC_ORDER_STATUS_ID', '0', '6', '0', 'oos_cfg_pull_down_order_statuses(', 'oos_cfg_get_order_status_name', '" . date("Y-m-d H:i:s", time()) . "')");


    }

    function remove() {

      // Get database information
      $dbconn =& oosDBGetConn();
      $oostable =& oosDBGetTables();

      $configurationtable = $oostable['configuration'];
      $dbconn->Execute("DELETE FROM $configurationtable WHERE configuration_key in ('" . implode("', '", $this->keys()) . "')");
    }

    function keys() {
       return array ('MODULE_PAYMENT_CC_STATUS', 'MODULE_PAYMENT_CC_ZONE', 'USE_CC_CVV', 'USE_CC_ISS', 'USE_CC_START', 'CC_CVV_MIN_LENGTH', 'CC_ENC', 'CC_VAL', 'MODULE_PAYMENT_CC_EMAIL', 'MODULE_PAYMENT_CC_ZONE', 'MODULE_PAYMENT_CC_ORDER_STATUS_ID', 'MODULE_PAYMENT_CC_SORT_ORDER', 'MODULE_PAYMENT_CC_ACCEPT_DINERSCLUB', 'MODULE_PAYMENT_CC_ACCEPT_AMERICANEXPRESS', 'MODULE_PAYMENT_CC_ACCEPT_OZBANKCARD', 'MODULE_PAYMENT_CC_ACCEPT_DISCOVERNOVUS', 'MODULE_PAYMENT_CC_ACCEPT_MASTERCARD', 'MODULE_PAYMENT_CC_ACCEPT_JCB', 'MODULE_PAYMENT_CC_ACCEPT_VISA');

    }
  }

