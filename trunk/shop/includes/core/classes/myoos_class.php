<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
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

