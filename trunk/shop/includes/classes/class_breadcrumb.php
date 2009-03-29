<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: breadcrumb.php,v 1.3 2003/02/11 00:04:50 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * Class breadcrumb.
 *
 * @category   OOS [OSIS Online Shop]
 * @package    breadcrumb
 * @copyright  Copyright (c) 2003 - 2009 by the OOS Development Team. (http://www.oos-shop.de/)
 * @license    Released under the GNU General Public License
 */
class breadcrumb
{
    var $_trail;

    function breadcrumb()
    {
        $this->reset();
    }


    function reset()
    {
        $this->_trail = array();
    }


    function add($title, $link = '')
    {
        $this->_trail[] = array('title' => $title, 'link' => $link);
    }


    function trail($separator = ' - ')
    {
        $trail_string = '';

        for ($i=0, $n=sizeof($this->_trail); $i<$n; $i++) {
            if (isset($this->_trail[$i]['link']) && oos_is_not_null($this->_trail[$i]['link'])) {
                $trail_string .= '<a href="' . $this->_trail[$i]['link'] . '" title="' . $this->_trail[$i]['title'] . '" class="headerNavigation">' . $this->_trail[$i]['title'] . '</a>';
            } else {
                $trail_string .= $this->_trail[$i]['title'];
            }

            if (($i+1) < $n) $trail_string .= $separator;
        }

        return $trail_string;
    }


    function trail_title($separator = ' - ')
    {
        $trail_title_string = '';
        $trail_title_size = sizeof($this->_trail);

        for ($i=0; $i<$trail_title_size; $i++) {
            $trail_title_string .= $this->_trail[$i]['title'];
            if(($i+1) < $trail_title_size) $trail_title_string .= $separator;
        }
        return $trail_title_string;
    }

}
