<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * Smarty Template System
 *
 * {@link http://smarty.net/ smarty.net}
 * {@link http://smarty.incutio.com/ smarty wiki}
 * {@link http://smarty.net/resources.php?category=7 Mailing lists}
 */
if (!class_exists('Smarty')) {
    MyOOS_CoreApi::requireOnce('lib/smarty/libs/Smarty.class.php');
    // MyOOS_CoreApi::requireOnce('lib/smarty/libs/SmartyValidate.class.php');
}

/**
 * Class Smarty Template engine
 *
 * @category   OOS [OSIS Online Shop]
 * @package    Smarty Template engine
 * @copyright  Copyright (c) 2003 - 2009 by the OOS Development Team. (http://www.oos-shop.de/)
 * @license    http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class Template extends Smarty
{

    /**
     * Constructor
     */
    function Template()
    {

         $this->Smarty();

         $this->left_delimiter =  '{';
         $this->right_delimiter =  '}';

         $dir = OOS_TEMP_PATH;
         if (substr($dir, -1) != "/") {
             $dir = $dir."/";
         }

         $this->template_dir = $dir . 'shop/templates/';
         $this->compile_dir = $dir . 'shop/templates_c/';
         $this->config_dir = $dir . 'shop/configs/';
         $this->cache_dir = $dir . 'shop/cache/';

         $this->plugins_dir = array (
                'plugins', // the default under SMARTY_DIR
                BP . DS . 'lib/smarty-plugins/gettext',
                BP . DS . 'lib/smarty-plugins/myoos');


         $this->use_sub_dirs = true;

         $thstamp  = mktime(0, 0, 0, date ("m") , date ("d")+80, date("Y"));
         $oos_date = date("D,d M Y", $thstamp);

         $this->assign(
             array(
                 'oos_revision_date' => $oos_date,
                 'oos_date_long'     => strftime(DATE_FORMAT_LONG)
             )
         );

      }

}

