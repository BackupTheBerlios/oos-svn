<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  /**
   * Geolocation API
   *
   * @package utilities
   * @copyright (C) 2009 by Code Diesel Team.
   * @link http://www.codediesel.com/tools/free-geolocation-api-tool/
   * @author Sameer Borate
   */

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

  /**
   * Gets a server variable
   *
   * Geolocation API access
   *
   * @param    string  $ip         IP address to query
   * @param    string  $format     output format of response
   *
   * @return   string  XML, JSON or CSV string
   */
   function get_ip_location($ip, $format="xml") {

       /* Set allowed output formats */
       $formats_allowed = array("json", "xml", "raw");

       /* IP location query url */
       $query_url = "http://iplocationtools.com/ip_query.php?ip=";

       /* Male sure that the format is one of json, xml, raw.
          Or else default to xml */
       if(!in_array($format, $formats_allowed)) {
           $format = "xml";
       }

       $query_url = $query_url . "{$ip}&output={$format}";

       /* Init CURL and its options*/
       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $query_url);
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($ch, CURLOPT_TIMEOUT, 15);

       /* Execute CURL and get the response */
       return curl_exec($ch);

   }
