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

    public function __construct()
    {
        $this->reset();
    }


    function reset()
    {
        $this->_trail = array();
    }

    function add($title, $link = '', $rel = null, $accesskey = null)
    {

        $this->_trail[] = array('title' => $title, 'link' => $link , 'rel' => $rel, 'accesskey' => $accesskey);
    }


    function trail($separator = ' - ')
    {

        $trail_string = '<ul>' . "\n";

        $nTrailTitle = count($this->_trail);
        for ($i=0, $n=$nTrailTitle; $i<$n; $i++) {
            if (isset($this->_trail[$i]['link']) && !empty($this->_trail[$i]['link'])) {

                $trail_string .= '<li><a class="page_item-' . $i . '" href="' . $this->_trail[$i]['link'] . '"';

                if (isset($this->_trail[$i]['accesskey'])) {
			              $trail_string .= ' accesskey="' . $this->_trail[$i]['accesskey'] . '"';
			          }

                if (isset($this->_trail[$i]['rel'])) {
			             $trail_string .= ' rel="bookmark" title="Permalink zu ' . $this->_trail[$i]['title'] . '"><strong>' . $this->_trail[$i]['title'] . '</strong></a></li>' . "\n";
			          } else {
			             $trail_string .= ' title="' . $this->_trail[$i]['title'] . '"><span>' . $this->_trail[$i]['title'] . '</span></a></li>' . "\n";
                }
            } else {
                $trail_string .= '<li><strong>' . $this->_trail[$i]['title'] . '</strong></li>' . "\n";
            }

        }

        $trail_string .= '</ul>'. "\n";


        return $trail_string;
    }



    function trail_title($separator = ' - ')
    {
        $trail_title_string = '';

        $nTrailTitle = count($this->_trail);
        for ($i=0; $i<$nTrailTitle; $i++) {
            $trail_title_string .= $this->_trail[$i]['title'];
            if(($i+1) < $nTrailTitle) $trail_title_string .= $separator;
        }
        return $trail_title_string;
    }

}
