<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: advanced_search_result.php,v 1.67 2003/02/13 04:23:22 hpdl
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

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/search_advanced_result.php';
require 'includes/functions/function_search.php';

$error = 0; // reset error flag to false
$errorno = 0;

if ( (isset($_GET['keywords']) && empty($_GET['keywords'])) &&
     (isset($_GET['dfrom']) && (empty($_GET['dfrom']) || ($_GET['dfrom'] == DOB_FORMAT_STRING))) &&
     (isset($_GET['dto']) && (empty($_GET['dto']) || ($_GET['dto'] == DOB_FORMAT_STRING))) &&
     (isset($_GET['pfrom']) && !is_numeric($_GET['pfrom'])) &&
     (isset($_GET['pto']) && !is_numeric($_GET['pto'])) ) {
    $errorno += 1;
    $error = 1;
} else  {
    $dfrom = '';
    $dto = '';
    $pfrom = '';
    $pto = '';
    $sKeywords = '';
    $nNV = isset($_GET['nv']) ? $_GET['nv']+0 : 1;

    if (!isset($all_get_listing)) $all_get_listing = '';
    if (!isset($sProductListBuyNowHidden)) $sProductListBuyNowHidden = '';
    
    
    if (isset($_GET['dfrom']) && !empty($_GET['dfrom']))  {   
        $dfrom = (($_GET['dfrom'] == DOB_FORMAT_STRING) ? '' : oos_prepare_input($_GET['dfrom']));
        $all_get_listing .= 'dfrom=' . rawurlencode($dfrom) . '&amp;';
        $sProductListBuyNowHidden .= '<input type="hidden" name="dfrom" value="' . $dfrom . '">';
    }

    if (isset($_GET['dto']) && !empty($_GET['dto']))  {
        $dto = (($_GET['dto'] == DOB_FORMAT_STRING) ? '' : oos_prepare_input($_GET['dto']));
        $all_get_listing .= 'dto=' . rawurlencode($dto) . '&amp;';
        $sProductListBuyNowHidden .= '<input type="hidden" name="dto" value="' . $dto . '">';
    }

    if (isset($_GET['pfrom']) && !empty($_GET['pfrom']))  {
        $pfrom = oos_prepare_input($_GET['pfrom']);
        $all_get_listing .= 'pfrom=' . rawurlencode($pfrom) . '&amp;';
        $sProductListBuyNowHidden .= '<input type="hidden" name="pfrom" value="' . $pfrom . '">';
    }
    
    if (isset($_GET['pto']) && !empty($_GET['pto']))  {
        $pto = oos_prepare_input($_GET['pto']);
        $all_get_listing .= 'pto=' . rawurlencode($pto) . '&amp;';
        $sProductListBuyNowHidden .= '<input type="hidden" name="pto" value="' . $pto . '">';
    }
    
    if (isset($_GET['keywords']) && !empty($_GET['keywords']))  {
        $sKeywords = oos_prepare_input($_GET['keywords']);

        if ( empty( $sKeywords ) || !is_string( $sKeywords ) ) {
            MyOOS_CoreApi::redirect(oos_href_link($aPages['advanced_search']), '301');
        }

        // Search enhancement mod start
        $search_keywords = oos_var_prep_for_os($sKeywords);
        $search_keywords = strip_tags($search_keywords);
        $search_keywords = addslashes($search_keywords);

        if ( empty( $search_keywords ) || !is_string( $search_keywords ) ) {
            MyOOS_CoreApi::redirect(oos_href_link($aPages['advanced_search']), '301');
        }
        
        $all_get_listing .= 'keywords=' . rawurlencode($sKeywords) . '&amp;';
        $sProductListBuyNowHidden .= '<input type="hidden" name="keywords" value="' . $sKeywords . '">';
    }

    if (isset($_GET['categories_id']) && is_numeric($_GET['categories_id'])) {
        $all_get_listing .= 'categories_id=' . intval($_GET['categories_id']) . '&amp;';
        if (isset($_GET['inc_subcat']) && ($_GET['inc_subcat'] == '1')) {
            $all_get_listing .= 'inc_subcat=1&amp;';
            $sProductListBuyNowHidden .= '<input type="hidden" name="inc_subcat" value="1">';
        }
    }

    $date_check_error = false;
    if (strlen($dfrom) > 0) {
        if (!oos_checkdate($dfrom, DOB_FORMAT_STRING, $dfrom_array)) {
            $date_check_error = true;
            $errorno += 10;
            $error = 1;
        }
    }

    if (strlen($dto) > 0) {
        if (!oos_checkdate($dto, DOB_FORMAT_STRING, $dto_array)) {
            $date_check_error = true;
            $errorno += 100;
            $error = 1;
        }
    }


    if (($date_check_error == false) && strlen($dfrom) > 0 && strlen($dto) > 0) {
        if (mktime(0, 0, 0, (int)$dfrom_array[1], (int)$dfrom_array[2], (int)$dfrom_array[0]) > mktime(0, 0, 0, (int)$dto_array[1], (int)$dto_array[2], (int)$dto_array[0])) {
            $errorno += 1000;
            $error = 1;
        }
    }

    $price_check_error = false;
    if (strlen($pfrom) > 0) {
        if (!settype($pfrom, "double")) {
            $price_check_error = true;
            $errorno += 10000;
            $error = 1;
        }
    }

    if (strlen($pto) > 0) {
        if (!settype($pto, "double")) {
            $price_check_error = true;
            $errorno += 100000;
            $error = 1;
        }
    }

    if (($price_check_error == false) && is_float($pfrom) && is_float($pto)) {
        if ($pfrom >= $pto) {
           $errorno += 1000000;
           $error = 1;
        }
    }
  
    if (strlen($sKeywords) > 0) {
        if (!oos_parse_search_string(stripslashes($sKeywords), $search_keywords)) {
            $errorno += 10000000;
            $error = 1;
        }
    }
}

if ($error == 1) {
    MyOOS_CoreApi::redirect(oos_href_link($aPages['advanced_search'], 'errorno=' . $errorno . $all_get_listing));
} else {

    if (isset($_GET['keywords']) && !empty($_GET['keywords'])) {
        $sKeywords = oos_prepare_input($_GET['keywords']);
        $pw_keywords = explode(' ',stripslashes(strtolower($sKeywords)));
        $pw_boldwords = $pw_keywords;
        $sql = "SELECT sws_word, sws_replacement FROM " . $oostable['searchword_swap'];
        $sql_words = $dbconn->Execute($sql);
        $pw_replacement = '';
        while ($sql_words_result = $sql_words->fields)
        {
            if (stripslashes(strtolower($sKeywords)) == stripslashes(strtolower($sql_words_result['sws_word']))) {
       	        $pw_replacement = stripslashes($sql_words_result['sws_replacement']);
       	        $pw_link_text = '<b><i>' . stripslashes($sql_words_result['sws_replacement']) . '</i></b>';
       	        $pw_phrase = 1;
       	        $pw_mispell = 1;
       	        break;
            }
            for ($i=0; $i<count($pw_keywords); $i++) {
                if ($pw_keywords[$i]  == stripslashes(strtolower($sql_words_result['sws_word']))) {
                   $pw_keywords[$i]  = stripslashes($sql_words_result['sws_replacement']);
                   $pw_boldwords[$i] = '<b><i>' . stripslashes($sql_words_result['sws_replacement']) . '</i></b>';
                   $pw_mispell = 1;
                   break;
                }
            }
            $sql_words->MoveNext();
        }
        if (!isset($pw_phrase)) {
            for ($i=0; $i<count($pw_keywords); $i++) {
                $pw_replacement .= $pw_keywords[$i]. ' ';
                $pw_link_text   .= $pw_boldwords[$i]. ' ';
            }
        }
        $pw_replacement = trim($pw_replacement);
        $pw_link_text   = trim($pw_link_text);
        $pw_string      = '<br /><span class="main"><font color="red">' . $aLang['text_replacement_suggestion'] . '</font><a href="' . oos_href_link($aPages['advanced_search_result'] , 'keywords=' . urlencode($pw_replacement) . '&search_in_description=1' ) . '">' . $pw_link_text . '</a></span><br /><br />';
    } 
  
 
// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title1'], oos_href_link($aPages['advanced_search']));
$oBreadcrumb->add($aLang['navbar_title2']);



if ($search_keywords != $_SESSION['last_search_insert']) {
    $dbconn->Execute("INSERT INTO " . $oostable['search_queries'] . " (search_text) VALUES ('" . oos_db_input($search_keywords) . "')");
    $_SESSION['last_search_insert'] = $search_keywords;
}
// Search enhancement mod end

// create column list
$aDefineList = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                     'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                     'PRODUCT_LIST_UVP' => PRODUCT_LIST_UVP,
                     'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                     'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                     'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                     'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                     'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);
asort($aDefineList);

$column_list = array();
reset($aDefineList);
foreach ($aDefineList as $column => $value) {
     if ($value) $column_list[] = $column;
}


    $select_str = "SELECT DISTINCT pd.products_name, p.products_model, m.manufacturers_name, p.products_quantity, p.products_image, p.products_weight, m.manufacturers_id, p.products_id, pd.products_name,
                          p.products_discount1, p.products_discount2, p.products_discount3, p.products_discount4,
                          p.products_discount1_qty, p.products_discount2_qty, p.products_discount3_qty,
                          p.products_discount4_qty, p.products_tax_class_id, p.products_units_id, p.products_quantity_order_min,
                          p.products_price, p.products_price_list, p.products_base_price, p.products_base_unit, p.products_discount_allowed,
                          IF(s.status, s.specials_new_products_price, NULL) AS specials_new_products_price,
                          IF(s.status, s.specials_new_products_price, p.products_price) AS final_price ";

    if ( ($_SESSION['member']->group['show_price_tax'] == 1) && ( (isset($_GET['pfrom']) && !empty($_GET['pfrom'])) || (isset($_GET['pto']) && !empty($_GET['pto']))) ) {
      $select_str .= ", SUM(tr.tax_rate) AS tax_rate ";
    }

    $from_str = "FROM " . $oostable['products'] . " p LEFT JOIN
                      " . $oostable['manufacturers'] . " m using(manufacturers_id) LEFT JOIN
                      " . $oostable['specials'] . " s ON p.products_id = s.products_id";

    if ( ($_SESSION['member']->group['show_price_tax'] == 1) && ( (isset($_GET['pfrom']) && !empty($_GET['pfrom'])) || (isset($_GET['pto']) && !empty($_GET['pto']))) ) {
      if (!isset($_SESSION['customer_country_id'])) {
        $_SESSION['customer_country_id'] = STORE_COUNTRY;
        $_SESSION['customer_zone_id'] = STORE_ZONE;
      }
      $from_str .= " LEFT JOIN
                        " . $oostable['tax_rates'] . " tr
                     ON p.products_tax_class_id = tr.tax_class_id LEFT JOIN
                        " . $oostable['zones_to_geo_zones'] . " gz
                     ON tr.tax_zone_id = gz.geo_zone_id AND
                        (gz.zone_country_id is null OR
                         gz.zone_country_id = '0' OR
                         gz.zone_country_id = '" . intval($_SESSION['customer_country_id']) . "') AND
                        (gz.zone_id is null OR
                         gz.zone_id = '0' OR
                         gz.zone_id = '" . intval($_SESSION['customer_zone_id']) . "')";

    }

    $from_str .= ", " . $oostable['products_description'] . " pd, " . $oostable['categories'] . " c, " . $oostable['products_to_categories'] . " p2c";

    $where_str = " WHERE
                      p.products_status >= '1' AND
                      p.products_id = pd.products_id AND
                      pd.products_languages_id = '" .  intval($nLanguageID) . "' AND
                      p.products_id = p2c.products_id AND
                      p2c.categories_id = c.categories_id ";

    if (isset($_GET['categories_id']) && !empty($_GET['categories_id'])) {
     $nCategoriesID = (int)$_GET['categories_id'];
     if (isset($_GET['inc_subcat']) && ($_GET['inc_subcat'] == '1')) {
        $aSsubcategories = array();
        oos_get_subcategories($aSsubcategories, $_GET['categories_id']);
        $where_str .= " AND
                           p2c.products_id = p.products_id AND
                           p2c.products_id = pd.products_id AND
                           (p2c.categories_id = '" . intval($nCategoriesID) . "'";
        $nCountSubcategories = count($aSsubcategories);                   
        for ($i=0, $n=$nCountSubcategories; $i<$n; $i++ ) {
          $where_str .= " OR p2c.categories_id = '" . intval($aSsubcategories[$i]) . "'";
        }
        $where_str .= ")";
      } else {
        $where_str .= " AND
                           p2c.products_id = p.products_id AND
                           p2c.products_id = pd.products_id AND
                           pd.products_languages_id = '" .  intval($nLanguageID) . "' AND
                           p2c.categories_id = '" . intval($_GET['categories_id']) . "'";
      }
    }

    if (isset($_GET['manufacturers_id']) && !empty($_GET['manufacturers_id'])) {
      $nManufacturersID = (int)$_GET['manufacturers_id'];
      $where_str .= " AND m.manufacturers_id = '" . intval($nManufacturersID) . "'";
    }

    if (isset($_GET['keywords']) && !empty($_GET['keywords'])) {
      if (oos_parse_search_string(stripslashes($sKeywords), $search_keywords)) {
        $where_str .= " AND (";

        $nCountSearchKeywords = count($search_keywords);
        for ($i=0, $n=$nCountSearchKeywords; $i<$n; $i++ ) {
          switch ($search_keywords[$i]) {
            case '(':
            case ')':
            case 'and':
            case 'or':
              $where_str .= " " . $search_keywords[$i] . " ";
              break;

            default:
              $where_str .= "   (pd.products_name LIKE '%" . addslashes($search_keywords[$i]) . "%'
                              OR p.products_model LIKE '%" . addslashes($search_keywords[$i]) . "%'
                              OR p.products_ean LIKE '%" . addslashes($search_keywords[$i]) . "%'
                              OR m.manufacturers_name LIKE '%" . addslashes($search_keywords[$i]) . "%'";
              if (isset($_GET['search_in_description']) && ($_GET['search_in_description'] == '1')) $where_str .= " OR pd.products_description LIKE '%" . addslashes($search_keywords[$i]) . "%'";
                $where_str .= ')';
              break;
          }
        }
        $where_str .= " )";
      }
    }

    if (isset($_GET['dfrom']) && !empty($_GET['dfrom']) && ($_GET['dfrom'] != DOB_FORMAT_STRING)) {
      $where_str .= " AND p.products_date_added >= '" . oos_date_raw($dfrom) . "'";
    }

    if (isset($_GET['dto']) && !empty($_GET['dto']) && ($_GET['dto'] != DOB_FORMAT_STRING)) {
      $where_str .= " AND p.products_date_added <= '" . oos_date_raw($dto) . "'";
    }

    $rate = $oCurrencies->get_value($_SESSION['currency']);
    if ($rate) {
      $pfrom = oos_var_prep_for_os($_GET['pfrom'] / $rate);
      $pto = oos_var_prep_for_os($_GET['pto'] / $rate);
    }

    if ($_SESSION['member']->group['show_price_tax'] == 1) {
      if ($pfrom) $where_str .= " AND (IF(s.status, s.specials_new_products_price, p.products_price) * if(gz.geo_zone_id is null, 1, 1 + (tr.tax_rate / 100) ) >= " . oos_db_input($pfrom) . ")";
      if ($pto)   $where_str .= " AND (IF(s.status, s.specials_new_products_price, p.products_price) * if(gz.geo_zone_id is null, 1, 1 + (tr.tax_rate / 100) ) <= " . oos_db_input($pto) . ")";
    } else {
      if ($pfrom) $where_str .= " AND (IF(s.status, s.specials_new_products_price, p.products_price) >= " . (double)$pfrom . ")";
      if ($pto)   $where_str .= " AND (IF(s.status, s.specials_new_products_price, p.products_price) <= " . (double)$pto . ")";
    }

    if ( ($_SESSION['member']->group['show_price_tax'] == 1) && ((isset($_GET['pfrom']) && !empty($_GET['pfrom'])) || (isset($_GET['pto']) && !empty($_GET['pto']))) ) {
      $where_str .= " GROUP BY p.products_id, tr.tax_priority";
    }

    if ( (!isset($_GET['sort'])) || (!preg_match('/^[1-8][ad]$/', $_GET['sort'])) || (substr($_GET['sort'], 0 , 1) > count($column_list)) ) {
// Todo check $col = 1
       $col = 0;
       $sSort = $col+1 . 'a';
       $order_str = ' ORDER BY pd.products_name';
    } else {
      $sSort = oos_var_prep_for_os($_GET['sort']);
      $sort_col = substr($_GET['sort'], 0 , 1);
      $sort_order = substr($_GET['sort'], 1);
      $order_str = ' ORDER BY ';

      switch ($column_list[$sort_col-1]) {
        case 'PRODUCT_LIST_MODEL':
          $order_str .= "p.products_model " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
          break;

        case 'PRODUCT_LIST_NAME':
          $order_str .= "pd.products_name " . ($sort_order == 'd' ? "desc" : "");
          break;

        case 'PRODUCT_LIST_MANUFACTURER':
          $order_str .= "m.manufacturers_name " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
          break;

        case 'PRODUCT_LIST_QUANTITY':
          $order_str .= "p.products_quantity " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
          break;

        case 'PRODUCT_LIST_IMAGE':
          $order_str .= "pd.products_name";
          break;

        case 'PRODUCT_LIST_WEIGHT':
          $order_str .= "p.products_weight " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
          break;

        case 'PRODUCT_LIST_PRICE':
          $order_str .= "final_price " . ($sort_order == 'd' ? "desc" : "") . ", pd.products_name";
          break;

        default:
          $order_str .= "pd.products_name";
          break;
      }
    }

    $listing_sql = $select_str . $from_str . $where_str . $order_str;

    $aOption['template_main'] = $sTheme . '/modules/advanced_search_result.html';
    $aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
    $aOption['page_navigation'] = $sTheme . '/heading/page_navigation.html';

    $nPageType = OOS_PAGE_TYPE_CATALOG;

    require 'includes/oos_system.php';
    if (!isset($option)) {
        require 'includes/info_message.php';
        require 'includes/oos_blocks.php';
    }

    $oos_pagetitle = $oBreadcrumb->trail_title(' &raquo; ');
    $oos_pagetitle .= '&raquo;' . OOS_META_TITLE;

    // assign Smarty variables;
    $oSmarty->assign(
        array(
            'pagetitle'         => htmlspecialchars($oos_pagetitle),
            'meta_description'  => htmlspecialchars($oos_meta_description),
            'meta_keywords'     => htmlspecialchars($oos_meta_keywords),
            'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
            'oos_heading_title' => $aLang['heading_title'],
            'oos_heading_image' => 'browse.gif'
        )
    );

    require 'includes/modules/product_listing.php';

    $oSmarty->assign('define_list', $aDefineList);
    $oSmarty->assign('pw_mispell', $pw_mispell);
    $oSmarty->assign('pw_string', $pw_string);
    $oSmarty->assign('oos_get_all_get_params', $all_get_listing);

    $oSmarty->assign('oosPageNavigation', $oSmarty->fetch($aOption['page_navigation']));
    $oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
    $oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

    // display the template
    require 'includes/oos_display.php';
}

