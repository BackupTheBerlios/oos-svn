<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: Gallery.class Revision: 17580
   ----------------------------------------------------------------------
   Gallery - a web based photo album viewer and editor
   http://gallery.menalto.com/

   Copyright (C) 2000-2008 Bharat Mediratta
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

/*
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2008 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * Global storage container and utility class for Gallery.
 * This is a container for global information required for Gallery operation, such as configuration,
 * session, user, etc.
 *
 * @package GalleryCore
 * @subpackage Classes
 * @author Bharat Mediratta <bharat@menalto.com>
 * @version Revision: 17580
 */
class MyOOS {

    /**
     * The active GalleryUser instance
     * @var GalleryUser
     * @access private
     */
    var $_activeUser;

    /**
     * Storage for all configuration variables, set in config.php.  The values contained here can't
     * be modified.  Well, they can be modified but they can't be saved so it's not a good idea.
     * @var array
     * @access private
     */
    var $_config;

    /**
     * The current debugging mode.  One of 'buffered', 'logged', 'immediate' or false.
     * @var string
     * @access private
     */
    var $_debug;

    /**
     * Where to send debug output (when the debugging mode is set to 'logged')
     * @var string
     * @access private
     */
    var $_debugLogFile;

    /**
     * A place to temporarily store debug output when the debugging mode is set to 'buffered'
     * @var string
     * @access private
     */
    var $_debugBuffer;

    /**
     * A secondary debug buffer used to record debug output even if regular debug mode is disabled.
     * @var string
     * @access private
     */
    var $_debugSnippet = null;

    /**
     * Are we currently recording a debug snippet?
     * @var boolean
     * @access private
     */
    var $_debugSnippetActive = false;

    /**
     * The active GalleryLockSystem implementation
     * @var GalleryLockSystem
     * @access private
     */
    var $_lockSystem;

    /**
     * An instance of the GalleryPlatform class
     * @var GalleryPlatform
     * @access private
     */
    var $_platform;

    /**
     * The current profiling mode.
     * @var string
     * @access private
     */
    var $_profile;

    /**
     * Storage for all session variables.
     * @var GallerySession
     * @access private
     */
    var $_session;

    /**
     * The backend persistent store for the Gallery class
     * @var GalleryStorage
     * @access private
     */
    var $_storage;

    /**
     * The adapter between the template system and any Gallery callbacks that want to use in the
     * template process.
     * @var GalleryTemplateAdapter
     * @access private
     */
    var $_templateAdapter;

    /**
     * Instance of the GalleryTranslator class
     * @var GalleryTranslator
     * @access private
     */
    var $_translator;

    /**
     * Instance of the GalleryUrlGenerator class
     * @var GalleryUrlGenerator
     * @access private
     */
    var $_urlGenerator;

    /**
     * The name of the current view
     * @var string
     * @access private
     */
    var $_currentView = '';

    /**
     * The time at which we should cease whatever operation we're doing
     * @var int
     * @access private
     */
    var $_timeLimit;

    /**
     * Actions to perform at the end of the request
     * @var array
     * @access private
     */
    var $_shutdownActions;

    /**
     * A facade in front of the PHP virtual machine.  We use this as an abstraction layer to let us
     * interpose mock objects between our code and the VM for testing purposes.  When we're not in a
     * test environment, this is always an instance of GalleryPhpVm.
     * @var GalleryPhpVm
     * @access private
     */
    var $_phpVm = null;


    function MyOOS()
    {
        $this->_activeUser = null;

        /* Set up a shutdown function to release any hanging locks */
        register_shutdown_function(array(&$this, '_shutdown'));

        /* Default config settings (can be overridden via config.php or embedded environment) */
        $this->_config = array(
            'login' => true,        /* Offer UserAdmin links (Login/Logout/Your Account) */

            /* UrlGenerator parameters for redirect URL to login page. Can be overridden. */
            'loginRedirect' => array('view' => 'core.UserAdmin',
                         'subView' => 'core.UserLogin', 'return' => true),

            'link' => true,         /* @deprecated - Allow item linking */
                         /* (now unused, there is a separate replica module */

            'showSidebarBlocks' => true, /* Can we allow themes to show the sidebar? */

            'systemCharset' => null,     /* Specify system character set, skip autodetect */
            'defaultAlbumId' => null,    /* Initial album to display instead of root album */
            'breadcrumbRootId' => null,  /* Can omit parents above this id in fetchParentSequence */
            'anonymousUserId' => null,   /* Alternate user account for guest sessions */
        );
    }

    /**
     * @see GalleryStorage::search
     */
    function search($query, $data=array(), $options=array()) {
    $storage =& $this->getStorage();
    list ($ret, $results) = $storage->search($query, $data, $options);
    if ($ret) {
        return array($ret, null);
    }

    return array(null, $results);
    }


    /**
     * Store a value in the Gallery config table
     *
     * @param string $key
     * @param mixed $value
     */
    function setConfig($key, $value)
    {
        assert('!empty($key)');
        $this->_config[$key] = $value;
    }

    /**
     * Get a value from the Gallery configuration settings
     *
     * @return mixed an arbitrary value
     */
    function getConfig($key) {
    assert('!empty($key)');
    return $this->_config[$key];
    }

    /**
     * Initialize an empty session.
     */
    function initEmptySession() {
    MyOOS_CoreApi::requireOnce('modules/core/classes/GallerySession.class');
    $this->_session = new GallerySession();
    }


    /**
     * Return a reference to our GalleryTranslator instance
     *
     * @return GalleryTranslator
     */
    function &getTranslator() {
    return $this->_translator;
    }

    /**
     * Initialize our GalleryTranslator
     *
     * @param boolean $dontUseDatabase (optional) true if we should not use the database
     * @return GalleryStatus a status code
     */
    function initTranslator($dontUseDatabase=false) {
    if (empty($this->_translator)) {
        /* Load the translator class */
        MyOOS_CoreApi::requireOnce('modules/core/classes/GalleryTranslator.class');

        /* Do we already have an activeLanguage for this session? */
        list ($ret, $language) = $this->getActiveLanguageCode();
        if ($ret) {
        return $ret;

        }

        $this->_translator = new GalleryTranslator();
        list ($ret, $languageCode) = $this->_translator->init($language, $dontUseDatabase);
        if ($ret) {
        return $ret;
        }
        $ret = $this->setActiveLanguageCode($languageCode);
        if ($ret) {
        return $ret;
        }
    }

    return null;
    }


    /**
     * Output a debug message
     * @param string $msg a message
     */
    function debug($msg) {
    if (empty($msg)) {
        return;
    }

    if (!empty($this->_debug)) {
        if (!strcmp($this->_debug, 'buffered')) {
        $this->_debugBuffer .= wordwrap($msg) . "\n";
        } elseif (!strcmp($this->_debug, 'logged')) {
        /* Don't use platform calls for these as they call debug internally! */
        if ($fd = fopen($this->_debugLogFile, 'a')) {
            $date = date('Y-m-d H:i:s');
            $session =& $this->getSession();
            if (!empty($session)) {
            $id = $session->getId();
            } else {
            $id = '<no session id>';
            }
            fwrite($fd, "$date [" . $id . "] $msg\n");
            fclose($fd);
        }
        } elseif (!strcmp($this->_debug, 'immediate')) {
        print "$msg\n";
        }
    }

    if ($this->_debugSnippetActive) {
        $this->_debugSnippet .= wordwrap($msg) . "\n";
    }
    }

    /**
     * Output a print_r style debug message
     *
     * @param mixed $object any object or value
     * @param boolean $escapeHtmlEntities true if the output should be run through htmlentities()
     */
    function debug_r($object, $escapeHtmlEntities=false) {
    if (!empty($this->_debug)) {
        $buf = print_r($object, true);
        if ($escapeHtmlEntities) {
        $buf = htmlentities($buf);
        }
        $this->debug($buf);
    }
    }


    /**
     * Mark a string as being internationalized.  This is a semaphore method; it does nothing but it
     * allows us to easily identify strings that require translation.  Generally this is used to
     * mark strings that will be stored in the database (like module names and descriptions).
     *
     * Consider this case:
     *   $message_to_be_localized = 'TEST to be displayed in different languages';
     *   print $this->translate($message_to_be_localized);
     *
     * The translate() method is called in the right place for runtime handling, but there is no
     * message at gettext preprocessing time to be given to the translation teams, just a variable
     * name. Translation of the variable name would break the code! So all places potentially
     * feeding this variable have to be marked to be given to translation teams, but not translated
     * at runtime!
     *
     * This method resolves all such cases. Simply mark the candidates:
     *   $message_to_be_localized = $gallery->i18n('TEST to be displayed in different languages');
     *   print $this->translate($message_to_be_localized);
     *
     * @param mixed $value string or array (array must have 'text' key; hint/cFormat keys optional)
     * @return string the text value
     * @see GalleryPlugin::translate
     */
    function i18n($value) {
    return is_array($value) ? $value['text'] : $value;  /* Just pass the text through */
    }


    /**
     * Return a date and time string that is conformant to RFC 2616
     * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec3.html#sec3.3
     *
     * @param int $time the unix timestamp of the date we want to return,
     *                empty if we want the current time
     * @return string a date-string conformant to the RFC 2616
     */
    function getHttpDate($time='')
    {
        if ($time == '') {
            $time = time();
        }
        /* Use fixed list of weekdays and months, so we don't have to fiddle with locale stuff */
        $months = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar',
                '04' => 'Apr', '05' => 'May', '06' => 'Jun',
                '07' => 'Jul', '08' => 'Aug', '09' => 'Sep',
                '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
        $weekdays = array('1' => 'Mon', '2' => 'Tue', '3' => 'Wed',
                  '4' => 'Thu', '5' => 'Fri', '6' => 'Sat',
                  '0' => 'Sun');
        $dow = $weekdays[gmstrftime('%w', $time)];
        $month = $months[gmstrftime('%m', $time)];
        $out = gmstrftime('%%s, %d %%s %Y %H:%M:%S GMT', $time);
        return sprintf($out, $dow, $month);
    }


}

