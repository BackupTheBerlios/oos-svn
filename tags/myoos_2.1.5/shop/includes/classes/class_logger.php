<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: logger.php,v 1.2 2002/05/03 10:33:59 hpdl
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
 * Class logger.
 *
 * @category   OOS [OSIS Online Shop]
 * @package    logger
 * @copyright  Copyright (c) 2003 - 2009 by the OOS Development Team. (http://www.oos-shop.de/)
 * @license    http://www.gnu.org/licenses/gpl.html GNU General Public License
 */
class logger
{
    var $timer_start;
    var $timer_stop;
    var $timer_total;

// class constructor
    public function __construct()
    {
        $this->timer_start();
    }


    function timer_start()
    {
        if (defined("PAGE_PARSE_START_TIME")) {
            $this->timer_start = PAGE_PARSE_START_TIME;
        } else {
            $this->timer_start = microtime();
        }
    }


    function timer_stop($display = '0')
    {
        $this->timer_stop = microtime();

        $time_start = explode(' ', $this->timer_start);
        $time_end = explode(' ', $this->timer_stop);

        $this->timer_total = number_format(($time_end[1] + $time_end[0] - ($time_start[1] + $time_start[0])), 3);

        $this->write(oos_server_get_var('REQUEST_URI'), $this->timer_total . 's');

        if ($display == '1') {
            return $this->timer_display();
        }
    }

    function timer_display()
    {
        return '<span class="smallText">Parse Time: ' . $this->timer_total . 's</span>';
    }

    function write($message, $timer)
    {
        error_log(strftime(STORE_PARSE_DATE_TIME_FORMAT) . ' [' . $timer . '] ' . $message . "\n", 3, STORE_PAGE_PARSE_TIME_LOG);
    }

}
