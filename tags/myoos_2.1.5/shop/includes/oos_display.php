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

if (isset($option) && ($option == 'print')) {
    $oSmarty->display('default/print.html');
} else {
    // load_filter
    // $oSmarty->load_filter('output', 'png_image');
    // $oSmarty->load_filter('output', 'highlight');
    // $oSmarty->load_filter('output', 'trimwhitespace');

    $oSmarty->display($sTheme.'/theme.html');
}
