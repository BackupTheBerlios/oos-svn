<?php
/*
Plugin Name: bs-wp-noversion
Plugin URI: http://blogsecurity.net/
Description: Removes the WordPress Version to prevent targetted attacks and version fingerprinting.
Author: David Kierznowski
Version: 1.1
Author URI: http://blogsecurity.net
*/ 

/* 
    License: GPL

    Copyright (C) 2007, BlogSecurity, http://blogsecurity.net
    All rights reserved.

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.

*/

add_action("init",bs_wp_noversion,1);

function bs_wp_noversion()
{
		if (!is_admin()) {
			global $wp_version;
			$wp_version = '';
		}

}


?>