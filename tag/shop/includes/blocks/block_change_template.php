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

$sLocaleDir = $oSmarty->template_dir;
$aSkins = array();

if (is_dir($sLocaleDir)) {
    if ($dh = opendir($sLocaleDir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file == '.' || $file == '..' || $file == 'CVS'|| $file == '.svn' || $file == 'default' || filetype($sLocaleDir . $file) == 'file' ) continue;
            if (filetype(realpath($sLocaleDir . $file)) == 'dir') {
                $aSkins[] = $file;
            }
        }
        closedir($dh);
    }
}

sort($aSkins);

$oSmarty->assign(
      array(
          'skins' => $aSkins,
          'block_heading_change_template' => $block_heading
     )
);


