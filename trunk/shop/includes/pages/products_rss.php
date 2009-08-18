<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}

  if (DISPLAY_NEWSFEED != '1') {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
  }

  $newsfeedtable = $oostable['newsfeed'];
  $newsfeed_infotable = $oostable['newsfeed_info'];
  $newsfeed_info_sql = "SELECT n.newsfeed_id, n.newsfeed_type, n.newsfeed_image, ni.newsfeed_name,
                               ni.newsfeed_title, ni.newsfeed_description
                        FROM $newsfeedtable n,
                             $newsfeed_infotable ni
                        WHERE n.newsfeed_type = 'products_new'
                          AND ni.newsfeed_id = n.newsfeed_id
                          AND ni.newsfeed_languages_id = '" . intval($nLanguageID) . "'";
  $newsfeed_info_result = $dbconn->Execute($newsfeed_info_sql);

  if (!$newsfeed_info_result->RecordCount()) {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['main']));
  } else {
    $newsfeed_info = $newsfeed_info_result->fields;
    $newsfeed_infotable = $oostable['newsfeed_info'];
    $query = "UPDATE $newsfeed_infotable"
        . " SET newsfeed_viewed = newsfeed_viewed+1"
        . " WHERE newsfeed_id = ?"
        . "   AND newsfeed_languages_id = ?";
    $result =& $dbconn->Execute($query, array((int)$newsfeed_info['newsfeed_id'], (int)$nLanguageID));


    $schema = '<?xml version="1.0" encoding="' . CHARSET . '"<rdf:RDF xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns="http://purl.org/rss/1.0/">' . "\n" .
              '<channel rdf:about="' . OOS_HTTP_SERVER . OOS_SHOP .'">' . "\n" .
              '<title>' . htmlspecialchars($newsfeed_info['newsfeed_title']) . '</title>' . "\n" .
              '<link>' . OOS_HTTP_SERVER . OOS_SHOP . '</link>' . "\n" .
              '<description>' . htmlspecialchars($newsfeed_info['newsfeed_description']) .'</description>' . "\n";

    // logo
    if (is_readable(OOS_IMAGES . $newsfeed_info['newsfeed_image'])) {
      $imageInfo = @GetImageSize(OOS_IMAGES . $newsfeed_info['newsfeed_image']);
      $schema .= '<image rdf:resource="' . OOS_HTTP_SERVER . OOS_SHOP . OOS_IMAGES . $newsfeed_info['newsfeed_image'] .'">' . "\n" .
                 '      <link>' . OOS_HTTP_SERVER . OOS_SHOP . '</link>' . "\n" .
                 '      <title>' . STORE_NAME . '</title>' . "\n" .
                 '      <url>' . OOS_HTTP_SERVER . OOS_SHOP . OOS_IMAGES . $newsfeed_info['newsfeed_image'] . '</url>' . "\n" .
                 '      <width>' . $imageInfo[0] . '</width>' . "\n" .
                 '      <height>' . $imageInfo[1] . '</height>' . "\n" .
                 '</image>' . "\n";
    }
    $schema .= '</channel>' . "\n";

    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $products_sql = "SELECT p.products_id, pd.products_name, pd.products_description, p.products_date_added
                     FROM $productstable p,
                          $products_descriptiontable pd
                     WHERE p.products_status >= '1'
                       AND p.products_id = pd.products_id
                       AND pd.products_languages_id = '" . intval($nLanguageID) . "'
                     ORDER BY p.products_date_added DESC, pd.products_name";
    $products_result = $dbconn->SelectLimit($products_sql, MAX_DISPLAY_PRODUCTS_NEWSFEED);
    if ($products_result->RecordCount() >= MIN_DISPLAY_PRODUCTS_NEWSFEED) {
      $rows = 0;
      while ($products = $products_result->fields)
      {
        $rows++;
        $products_description = strip_tags($products['products_description']);
        $products_description = substr($products_description, 0, 250) . '..';
        $products_description = str_replace(";",", ",$products_description);
        $products_description = str_replace("\n"," ",$products_description);
        $products_description = str_replace("\r"," ",$products_description);
        $products_description = str_replace("\t"," ",$products_description);
        $products_description = str_replace("\v"," ",$products_description);
        $products_description = str_replace("&quot,"," \"",$products_description);
        $products_description = htmlspecialchars($products_description);
        $products_description = substr($products_description, 0, 100) . '..';

        if ($oEvent->installed_plugin('sefu')) {
          $schema .= '<item rdf:about="' . OOS_HTTP_SERVER . OOS_SHOP . 'index.php/page/' . $aPages['product_info'] . '/products_id/' . $products['products_id'] . '">' .
                     '<title>' . htmlspecialchars($products['products_name']) . '</title>' .
                     '<link>' . OOS_HTTP_SERVER . OOS_SHOP . 'index.php/page/' . $aPages['product_info'] . '/products_id/' . $products['products_id'] . '</link>' .
                     '<description>' . $products_description . '</description></item>';
        } else {
          $schema .= '<item rdf:about="' . OOS_HTTP_SERVER . OOS_SHOP . 'index.php?page=' . $aPages['product_info'] . '&amp;products_id=' . $products['products_id'] . '">' .
                     '<title>' . htmlspecialchars($products['products_name']) . '</title>' .
                     '<link>' . OOS_HTTP_SERVER . OOS_SHOP . 'index.php?page=' . $aPages['product_info'] . '&amp;products_id=' . $products['products_id'] . '</link>' .
                     '<description>' . $products_description . '</description></item>';

        }
        $products_result->MoveNext();
      }
      // Close result set
      $products_result->Close();
    }
    $schema .= '</rdf:RDF>' . "\n";
  }
  header('Content-type: application/xml');
  echo $schema;
  oos_session_close();
