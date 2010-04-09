<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: redirect.php,v 1.9 2003/02/13 04:23:23 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); 
    header("Location: /");
    header("Connection: close");
    exit;
}

switch ($_GET['action']) {
    case 'url':    if (isset($_GET['goto'])) {
                       MyOOS_CoreApi::redirect('http://' . $_GET['goto']);
                   } else {
                       MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
                   }
                   break;


    case 'manufacturer' : if (isset($_GET['manufacturers_id'])) {
                              $manufacturers_id = intval($_GET['manufacturers_id']);
                              $manufacturers_infotable = $oostable['manufacturers_info'];
                              $sql = "SELECT manufacturers_url
                                      FROM $manufacturers_infotable
                                      WHERE manufacturers_id = '" . intval($manufacturers_id) . "'
                                        AND manufacturers_languages_id = '" .  intval($nLanguageID) . "'";
                              $manufacturer_result = $dbconn->Execute($sql);
                              if (!$manufacturer_result->RecordCount()) {
                                  // no url exists for the selected language, lets use the default language then
                                  $manufacturers_infotable = $oostable['manufacturers_info'];
                                  $languagestable = $oostable['languages'];
                                  $sql = "SELECT mi.manufacturers_languages_id, mi.manufacturers_url
                                          FROM $manufacturers_infotable mi,
                                               $languagestable l
                                          WHERE mi.manufacturers_id = '" . intval($manufacturers_id) . "'
                                            AND mi.manufacturers_languages_id = l.iso_639_2
                                            AND l.iso_639_2 = '" . DEFAULT_LANGUAGE . "'";
                                  $manufacturer_result = $dbconn->Execute($sql);
                                  if (!$manufacturer_result->RecordCount()) {
                                      // no url exists, return to the site
                                      MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
                                  } else {
                                      $manufacturer = $manufacturer_result->fields;
                                      $manufacturers_infotable = $oostable['manufacturers_info'];
                                      $dbconn->Execute("UPDATE $manufacturers_infotable SET url_clicked = url_clicked+1, date_last_click = '" . date("Y-m-d H:i:s", time()) . "' WHERE manufacturers_id = '" . intval($manufacturers_id) . "' AND manufacturers_languages_id = '" . $manufacturer['manufacturers_languages_id'] . "'");
                                  }
                              } else {
                                  // url exists in selected language
                                  $manufacturer = $manufacturer_result->fields;
                                  $manufacturers_infotable = $oostable['manufacturers_info'];
                                  $dbconn->Execute("UPDATE $manufacturers_infotable SET url_clicked = url_clicked+1, date_last_click = '" . date("Y-m-d H:i:s", time()) . "' WHERE manufacturers_id = '" . intval($manufacturers_id) . "' AND manufacturers_languages_id = '" .  intval($nLanguageID) . "'");
                              }

                              MyOOS_CoreApi::redirect($manufacturer['manufacturers_url']);
                          } else {
                              MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
                          }
                          break;

    default:       MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
                   break;
}

