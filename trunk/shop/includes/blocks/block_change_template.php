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

$sLocaleDir = $oSmarty->template_dir;
$aSkins = array();

if (is_dir($sLocaleDir)) {
    if ($dh = opendir($sLocaleDir)) {
        while (($file = readdir($dh)) !== false) {
            if ($file == '.' || $file == '..' || $file == 'CVS'|| $file == '.svn' || $file == 'default' || $file == 'jquery' || filetype($sLocaleDir . $file) == 'file' ) continue;
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


