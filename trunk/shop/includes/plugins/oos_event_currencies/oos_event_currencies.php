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


  class oos_event_currencies {

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

    function oos_event_currencies() {

      $this->name          = PLUGIN_EVENT_CURRENCIES_NAME;
      $this->description   = PLUGIN_EVENT_CURRENCIES_DESC;
      $this->uninstallable = false;
      $this->depends       = 'language';
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
      global $oCurrencies;

      MyOOS_CoreApi::requireOnce('classes/class_currencies.php');
      $oCurrencies = new currencies();

      // currency
      if (!isset($_SESSION['currency']) || isset($_GET['currency']) || ( (USE_DEFAULT_LANGUAGE_CURRENCY == '1') && (LANGUAGE_CURRENCY != $_SESSION['currency']) ) ) {
        if (isset($_GET['currency']) && oos_currency_exits($_GET['currency'])) {
          $_SESSION['currency'] = oos_var_prep_for_os($_GET['currency']);
        } else {
          $_SESSION['currency'] = (USE_DEFAULT_LANGUAGE_CURRENCY == '1') ? LANGUAGE_CURRENCY : DEFAULT_CURRENCY;
        }
      }

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


