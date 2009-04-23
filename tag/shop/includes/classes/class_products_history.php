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
 * Class Products History
 *
 * @category   OOS [OSIS Online Shop]
 * @package    Products History
 * @copyright  Copyright (c) 2003 - 2009 by the OOS Development Team. (http://www.oos-shop.de/)
 * @license    http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class oosProductsHistory
{

    /**
     * @access private
     * @var    int
     */
    var $products_history;


    /**
     * Constructor of our Class
     *
     * @access    public
     * @author    r23 <info@r23.de>
     */
    function oosProductsHistory()
    {
        $this->reset();
    }


    /**
     * @param $products_id
     */
    function add_current_products($products_id)
    {
        if (!$this->in_history($products_id)) {
            if ($this->count_history() >= MAX_DISPLAY_PRODUCTS_IN_PRODUCTS_HISTORY_BOX) {
                $temp = array_shift($this->products_history);
            }
            array_push($this->products_history, $products_id);
        }
    }


    /**
     * @param $products_id
     * @return boolean
     */
    function in_history($products_id)
    {
        if (in_array ($products_id, $this->products_history)) {
            return true;
        } else {
            return false;
        }
    }


    /**
     * get total number of products
     */
    function count_history()
    {
        return count($this->products_history);
    }


    /**
     * get Product's id
     */
    function get_product_id_list()
    {
        $product_id_list = '';
        if (is_array($this->products_history)) {
            reset($this->products_history);
            while (list($key, $products_id ) = each($this->products_history)) {
                $product_id_list .= ', ' . $products_id;
            }
        }

        return substr($product_id_list, 2);
    }


    /**
     *
     */
    function reset()
    {
        $this->products_history = array();
    }

}
