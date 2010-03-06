<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: MyOOS_CoreApi.class Revision: 17691
   ----------------------------------------------------------------------
   Gallery - a web based photo album viewer and editor
   http://gallery.menalto.com/

   Copyright (C) 2000-2008 Bharat Mediratta
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}


/**
 * This is the unified API for MyOOS.
 *
 * @package MyOOSCore
 * @subpackage Classes
 * @static
 */
class MyOOS_CoreApi {

    /**
     * Return the major and minor version of the Core API.
     *
     *
     * @return array major number, minor number
     */
    function getApiVersion() {
        return array(2, 1);
    }


    /**
     * Require a file, but only once. All specified paths must be relative to the Shop
     * directory. Think of it as a virtual PHP include_path.
     *
     * Surprisingly, tracking what's been already loaded in a static variable is actually 10x+
     * faster than just calling require_once directly, even when using this extra API method
     * to wrap it.
     *
     * @param string $file
     */
    function requireOnce($file)
    {
        static $loaded;
        if (!isset($loaded[$file])) {
            $loaded[$file] = true;
            if (strpos($file, '..') !== false) {
                return;
            }
            // debug echo BP . DS . $file .'<br>';
            require BP . DS . $file;
        }
    }


    /**
     * Redirect to another page or site
     *
     * @param string site URL to redirect to
     * @param  string  HTTP method of redirect
     * @return void
     */
    function redirect($sUrl, $sMethod = '302')
    {

        $aCodes = array
             (
                   'refresh' => 'Refresh',
                   '301' => 'Moved Permanently',
                   '302' => 'Found',
                   '303' => 'See Other',
                   '304' => 'Not Modified',
                   '305' => 'Use Proxy',
                   '307' => 'Temporary Redirect' 
             );

        // Validate the method and default to 302
        $sMethod = isset($aCodes[$sMethod]) ? (string) $sMethod : '302';

        if ( ( strpos($sUrl, "\n") !== false ) || ( strpos($sUrl, "\r") !== false ) ) {
            $aPages = oos_get_pages();
	          $sUrl = oos_href_link($aPages['main'], null, 'NONSSL', false);
        }

        if ( strpos($sUrl, '&amp;') !== false ) {
            $sUrl = str_replace('&amp;', '&', $sUrl);
        }

        if ($sMethod === 'refresh') {
			       header('Refresh: 0; url=' . $sUrl);
        } else {
			       header('HTTP/1.1 ' . $sMethod . ' ' .$aCodes[$sMethod]);
			       header('Location: ' . $sUrl);
		    }

        exit('<h1>' . $sMethod . ' - ' . $aCodes[$sMethod] . '</h1>' . '<p>' . $sUrl . '</p>');
    }



}
