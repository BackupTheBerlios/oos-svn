<?php
/* ----------------------------------------------------------------------
   $Id: oos_event_down_for_maintenance.php,v 1.8 2007/05/07 09:16:17 r23 Exp $

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

  class oos_event_down_for_maintenance {

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
    function oos_event_down_for_maintenance() {

      $this->name          = PLUGIN_EVENT_DOWN_FOR_MAINTENANCE_NAME;
      $this->description   = PLUGIN_EVENT_DOWN_FOR_MAINTENANCE_DESC;
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

      $aFilename = oos_get_filename();
      $aModules = oos_get_modules();

      if ($_GET['file'] != $aFilename['info_down_for_maintenance']) {
        oos_redirect(oos_href_link($aModules['info'], $aFilename['info_down_for_maintenance'], '', 'NONSSL', true, false));
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
