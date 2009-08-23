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


/**
 * Class Plugin Event
 *
 * @category   OOS [OSIS Online Shop]
 * @package    Plugin Event
 * @copyright  Copyright (c) 2003 - 2009 by the OOS Development Team. (http://www.oos-shop.de/)
 * @license    http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class plugin_event
{
    var $aEventPlugins, $aPlugins;

    function plugin_event()
    {
        $this->aEventPlugins = explode(';', MODULE_PLUGIN_EVENT_INSTALLED);
    }


    function getInstance()
    {
        $this->aPlugins = array();

        foreach ($this->aEventPlugins as $event) {
            $this->load_plugin($event);
        }
    }


    function load_plugin($sInstance, $sPluginPath = '')
    {

        $sName = 'oos_event_' . $sInstance;
        // echo $sName . '<br />';

        if (!class_exists($sName)) {
            if (empty($sPluginPath)) {
                $sPluginPath = $sName;
            }


            $sPluginPath = oos_var_prep_for_os($sPluginPath);
            $sName = oos_var_prep_for_os($sName);

            if (is_readable('includes/plugins/' . $sPluginPath . '/' . $sName . '.php')) {
                MyOOS_CoreApi::requireOnce('plugins/' . $sPluginPath . '/' . $sName . '.php');
            }


            if (!class_exists($sName)) {
                return false;
            }
        }

        if (@call_user_func(array('oos_event_' . $sInstance, 'create_plugin_instance'))) {
            $this->aPlugins[] = $sName;
        }

        return true;
    }


    function introspect()
    {
        $this->aPlugins = array();

        foreach ($this->aEventPlugins as $event) {
            $this->get_intro($event);
        }
    }


    function get_intro($event)
    {
        @call_user_func(array('oos_event_' . $event, 'intro'));
    }


    function installed_plugin($event)
    {
         return in_array($event, $this->aEventPlugins);
    }

}
