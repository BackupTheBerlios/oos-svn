<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}

if (isset($option) && ($option == 'print')) {
    $oSmarty->display('default/print.html');
} else {
    // load_filter
    // $oSmarty->load_filter('output', 'png_image');
    // $oSmarty->load_filter('output', 'highlight');
    // $oSmarty->load_filter('output', 'trimwhitespace');

    $oSmarty->display($sTheme.'/theme.html');
}
