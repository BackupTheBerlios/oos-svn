<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
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

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

  require 'includes/languages/' . $sLanguage . '/search_advanced_result.php';
  require 'includes/functions/function_search.php';

  // Search enhancement mod start
  if (isset($_GET['keywords']) && $_GET['keywords'] != '') {
    if (!isset($_GET['s'])){
      $pwstr_check = strtolower(substr($_GET['keywords'], strlen($_GET['keywords'])-1, strlen($_GET['keywords'])));
      if ($pwstr_check == 's') {
        $pwstr_replace = substr($_GET['keywords'], 0, strlen($_GET['keywords'])-1);
        MyOOS_CoreApi::redirect(oos_href_link($aModules['search'], $aFilename['advanced_search_result'], 'search_in_description=1&s=1&keywords=' . urlencode($pwstr_replace) . '' ));
      }
    }

    $pw_keywords = explode(' ',stripslashes(strtolower($_GET['keywords'])));
    $pw_boldwords = $pw_keywords;
    $sql = "SELECT sws_word, sws_replacement
            FROM " . $oostable['searchword_swap'];
    $sql_words = $dbconn->Execute($sql);
    $pw_replacement = '';
    while ($sql_words_result = $sql_words->fields)
    {
      if (stripslashes(strtolower($_GET['keywords'])) == stripslashes(strtolower($sql_words_result['sws_word']))) {
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
    $pw_string      = '<br /><span class="main"><font color="red">' . $aLang['text_replacement_suggestion'] . '</font><a href="' . oos_href_link($aModules['search'], $aFilename['advanced_search_result'] , 'keywords=' . urlencode($pw_replacement) . '&search_in_description=1' ) . '">' . $pw_link_text . '</a></span><br /><br />';
  }
  // Search enhancement mod end

  $error = 0; // reset error flag to false
  $errorno = 0;

  if ( (isset($_GET['keywords']) && empty($_GET['keywords'])) &&
       (isset($_GET['dfrom']) && (empty($_GET['dfrom']) || ($_GET['dfrom'] == DOB_FORMAT_STRING))) &&
       (isset($_GET['dto']) && (empty($_GET['dto']) || ($_GET['dto'] == DOB_FORMAT_STRING))) &&
       (isset($_GET['pfrom']) && empty($_GET['pfrom'])) &&
       (isset($_GET['pto']) && empty($_GET['pto'])) ) {
    $errorno += 1;
    $error = 1;
  }

  $dfrom_to_check = (($_GET['dfrom'] == DOB_FORMAT_STRING) ? '' : $_GET['dfrom']);
  $dto_to_check = (($_GET['dto'] == DOB_FORMAT_STRING) ? '' : $_GET['dto']);

  if (strlen($dfrom_to_check) > 0) {
    if (!oos_checkdate($dfrom_to_check, DOB_FORMAT_STRING, $dfrom_array)) {
      $errorno += 10;
      $error = 1;
    }
  }

  if (strlen($dto_to_check) > 0) {
    if (!oos_checkdate($dto_to_check, DOB_FORMAT_STRING, $dto_array)) {
      $errorno += 100;
      $error = 1;
    }
  }

  if (strlen($dfrom_to_check) > 0 && !(($errorno & 10) == 10) && strlen($dto_to_check) > 0 && !(($errorno & 100) == 100)) {
    if (mktime(0, 0, 0, $dfrom_array[1], $dfrom_array[2], $dfrom_array[0]) > mktime(0, 0, 0, $dto_array[1], $dto_array[2], $dto_array[0])) {
      $errorno += 1000;
      $error = 1;
    }
  }

  if (strlen($_GET['pfrom']) > 0) {
    $pfrom_to_check = oos_var_prep_for_os($_GET['pfrom']);
    if (!settype($pfrom_to_check, "double")) {
      $errorno += 10000;
      $error = 1;
    }
  }

  if (strlen($_GET['pto']) > 0) {
    $pto_to_check = oos_var_prep_for_os($_GET['pto']);
    if (!settype($pto_to_check, "double")) {
      $errorno += 100000;
      $error = 1;
    }
  }

  if (strlen($_GET['pfrom']) > 0 && !(($errorno & 10000) == 10000) && strlen($_GET['pto']) > 0 && !(($errorno & 100000) == 100000)) {
    if ($pfrom_to_check > $pto_to_check) {
      $errorno += 1000000;
      $error = 1;
    }
  }

  if (strlen($_GET['keywords']) > 0) {
    if (!oos_parse_search_string(stripslashes($_GET['keywords']), $search_keywords)) {
      $errorno += 10000000;
      $error = 1;
    }
  }

  if ($error == 1) {
    MyOOS_CoreApi::redirect(oos_href_link($aModules['search'], $aFilename['advanced_search'], 'errorno=' . $errorno . '&' . oos_get_all_get_parameters()));
  } else {
    // links breadcrumb
    $oBreadcrumb->add($aLang['navbar_title1'], oos_href_link($aModules['search'], $aFilename['advanced_search']));
    $oBreadcrumb->add($aLang['navbar_title2'], oos_href_link($aModules['search'], $aFilename['advanced_search_result'], 'keywords=' . oos_var_prep_for_os($_GET['keywords']) . '&search_in_description=' . oos_var_prep_for_os($_GET['search_in_description']) . '&categories_id=' . intval($_GET['categories_id']) . '&inc_subcat=' . intval($_GET['inc_subcat']) . '&manufacturers_id=' . intval($_GET['manufacturers_id']) . '&pfrom=' . oos_var_prep_for_os($_GET['pfrom']) . '&pto=' . oos_var_prep_for_os($_GET['pto']) . '&dfrom=' . oos_var_prep_for_os($_GET['dfrom']) . '&dto=' . oos_var_prep_for_os($_GET['dto'])), bookmark);

    // Search enhancement mod start
    $search_keywords = oos_var_prep_for_os($_GET['keywords']);
    $search_keywords = strip_tags($search_keywords);
    $search_keywords = addslashes($search_keywords);

    if ($search_keywords != $_SESSION['last_search_insert']) {
       $dbconn->Execute("INSERT INTO " . $oostable['search_queries'] . " (search_text) VALUES ('" . oos_db_input($search_keywords) . "')");
       $last_search_insert = $search_keywords;
       $_SESSION['last_search_insert'] = $last_search_insert;
    }
    // Search enhancement mod end

    // create column list
    $define_list = array('PRODUCT_LIST_MODEL' => PRODUCT_LIST_MODEL,
                         'PRODUCT_LIST_NAME' => PRODUCT_LIST_NAME,
                         'PRODUCT_LIST_MANUFACTURER' => PRODUCT_LIST_MANUFACTURER,
                         'PRODUCT_LIST_UVP' => PRODUCT_LIST_UVP,
                         'PRODUCT_LIST_PRICE' => PRODUCT_LIST_PRICE,
                         'PRODUCT_LIST_QUANTITY' => PRODUCT_LIST_QUANTITY,
                         'PRODUCT_LIST_WEIGHT' => PRODUCT_LIST_WEIGHT,
                         'PRODUCT_LIST_IMAGE' => PRODUCT_LIST_IMAGE,
                         'PRODUCT_LIST_BUY_NOW' => PRODUCT_LIST_BUY_NOW);
    asort($define_list);

    $column_list = array();
    reset($define_list);
    while (list($column, $value) = each($define_list)) {
      if ($value) $column_list[] = $column;
    }

    $select_column_list = '';

    for ($col=0, $n=count($column_list); $col<$n; $col++) {
      if ( ($column_list[$col] == 'PRODUCT_LIST_BUY_NOW')
          || ($column_list[$col] == 'PRODUCT_LIST_NAME')
          || ($column_list[$col] == 'PRODUCT_LIST_PRICE') ) {
        continue;
      }

      if (oos_is_not_null($select_column_list)) {
        $select_column_list .= ', ';
      }

      switch ($column_list[$col]) {
        case 'PRODUCT_LIST_MODEL':
          $select_column_list .= 'p.products_model';
          break;

        case 'PRODUCT_LIST_MANUFACTURER':
          $select_column_list .= 'm.manufacturers_name';
          break;

        case 'PRODUCT_LIST_QUANTITY':
          $select_column_list .= 'p.products_quantity';
          break;

        case 'PRODUCT_LIST_IMAGE':
          $select_column_list .= 'p.products_image';
          break;

        case 'PRODUCT_LIST_WEIGHT':
          $select_column_list .= 'p.products_weight';
          break;

        default:
          $select_column_list .= "pd.products_name";
          break;
      }
    }

    if (oos_is_not_null($select_column_list)) {
      $select_column_list .= ', ';
    }

    $select_str = "SELECT DISTINCT " . $select_column_list . " m.manufacturers_id, p.products_id, pd.products_name,
                          p.products_discount1, p.products_discount2, p.products_discount3, p.products_discount4,
                          p.products_discount1_qty, p.products_discount2_qty, p.products_discount3_qty,
                          p.products_discount4_qty, p.products_tax_class_id, p.products_units_id, p.products_quantity_order_min,
                          p.products_price, p.products_price_list, p.products_base_price, p.products_base_unit, p.products_discount_allowed,
                          IF(s.status, s.specials_new_products_price, NULL) AS specials_new_products_price,
                          IF(s.status, s.specials_new_products_price, p.products_price) AS final_price ";

    if ( ($_SESSION['member']->group['show_price_tax'] == 1) && ( (isset($_GET['pfrom']) && oos_is_not_null($_GET['pfrom'])) || (isset($_GET['pto']) && oos_is_not_null($_GET['pto']))) ) {
      $select_str .= ", SUM(tr.tax_rate) AS tax_rate ";
    }

    $from_str = "FROM " . $oostable['products'] . " p LEFT JOIN
                      " . $oostable['manufacturers'] . " m using(manufacturers_id) LEFT JOIN
                      " . $oostable['specials'] . " s ON p.products_id = s.products_id";

    if ( ($_SESSION['member']->group['show_price_tax'] == 1) && ( (isset($_GET['pfrom']) && oos_is_not_null($_GET['pfrom'])) || (isset($_GET['pto']) && oos_is_not_null($_GET['pto']))) ) {
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

    if (isset($_GET['categories_id']) && oos_is_not_null($_GET['categories_id'])) {
      if ($_GET['inc_subcat'] == '1') {
        $subcategories_array = array();
        oos_get_subcategories($subcategories_array, $_GET['categories_id']);
        $where_str .= " AND
                           p2c.products_id = p.products_id AND
                           p2c.products_id = pd.products_id AND
                           (p2c.categories_id = '" . intval($_GET['categories_id']) . "'";
        for ($i=0, $n=count($subcategories_array); $i<$n; $i++ ) {
          $where_str .= " OR p2c.categories_id = '" . intval($subcategories_array[$i]) . "'";
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

    if (isset($_GET['manufacturers_id']) && oos_is_not_null($_GET['manufacturers_id'])) {
      $manufacturers_id = intval($_GET['manufacturers_id']);
      $where_str .= " AND m.manufacturers_id = '" . intval($manufacturers_id) . "'";
    }

    if (isset($_GET['keywords']) && oos_is_not_null($_GET['keywords'])) {
      if (oos_parse_search_string(stripslashes($_GET['keywords']), $search_keywords)) {
        $where_str .= " AND (";
        for ($i=0, $n=count($search_keywords); $i<$n; $i++ ) {
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

    if (isset($_GET['dfrom']) && oos_is_not_null($_GET['dfrom']) && ($_GET['dfrom'] != DOB_FORMAT_STRING)) {
      $where_str .= " AND p.products_date_added >= '" . oos_date_raw($dfrom_to_check) . "'";
    }

    if (isset($_GET['dto']) && oos_is_not_null($_GET['dto']) && ($_GET['dto'] != DOB_FORMAT_STRING)) {
      $where_str .= " AND p.products_date_added <= '" . oos_date_raw($dto_to_check) . "'";
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
      if ($pfrom) $where_str .= " AND (IF(s.status, s.specials_new_products_price, p.products_price) >= " . oos_db_input($pfrom) . ")";
      if ($pto)   $where_str .= " AND (IF(s.status, s.specials_new_products_price, p.products_price) <= " . oos_db_input($pto) . ")";
    }

    if ( ($_SESSION['member']->group['show_price_tax'] == 1) && ((isset($_GET['pfrom']) && oos_is_not_null($_GET['pfrom'])) || (isset($_GET['pto']) && oos_is_not_null($_GET['pto']))) ) {
      $where_str .= " GROUP BY p.products_id, tr.tax_priority";
    }

    if ( (!isset($_GET['sort'])) || (!ereg('[1-8][ad]', $_GET['sort'])) || (substr($_GET['sort'], 0 , 1) > count($column_list)) ) {
      for ($col=0, $n=count($column_list); $col<$n; $col++) {
        if ($column_list[$col] == 'PRODUCT_LIST_NAME') {
          $_GET['sort'] = $col+1 . 'a';
          $order_str = ' ORDER BY pd.products_name';
          break;
        }
      }
    } else {
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
    $aOption['breadcrumb'] = 'default/system/breadcrumb.html';

    $nPageType = OOS_PAGE_TYPE_CATALOG;

    require 'includes/oos_system.php';
    if (!isset($option)) {
      require 'includes/info_message.php';
      require 'includes/oos_blocks.php';
    }

    // assign Smarty variables;
    $oSmarty->assign(
        array(
            'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
            'oos_heading_title' => $aLang['heading_title'],
            'oos_heading_image' => 'browse.gif'
        )
    );

    require 'includes/modules/product_listing.php';

    $oSmarty->assign('pw_mispell', $pw_mispell);
    $oSmarty->assign('pw_string', $pw_string);
    $oSmarty->assign('oos_get_all_get_params', oos_get_all_get_parameters(array('sort', 'page')));

    $oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
    $oSmarty->assign('oosPageNavigation', $oSmarty->fetch($aOption['page_navigation']));
    $oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
    $oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

    // display the template
    require 'includes/oos_display.php';
  }

