<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: application_top.php,v 1.264 2003/02/17 16:37:52 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


$bInfoMessage = false;
$parameters = '';

if (DISPLAY_CART == '1') {
    $goto_file = $aPages['shopping_cart'];
} else {
    $goto_file = $sPage;

    if (isset($aData['manufacturers_id']) && is_numeric($aData['manufacturers_id'])) {
       $parameters .= 'manufacturers_id=' .  intval($aData['manufacturers_id']) . '&amp;';
    }
    if (isset($aData['nv']) && is_numeric($aData['nv'])) { 
       $parameters .= 'nv=' .  intval($aData['nv']) . '&amp;';
    }
    if (isset($aData['filter_id']) && is_numeric($aData['filter_id'])) { 
       $parameters .= 'filter_id=' .  intval($aData['filter_id']) . '&amp;';
    } 
    if (isset($aData['categories']) && is_string($aData['categories']))  {
       $parameters .= 'categories=' .  rawurlencode(oos_var_prep_for_os($aData['categories'])) . '&amp;';
    }
    if (isset($aData['sort']) && is_string($aData['sort'])) { 
       $parameters .= 'sort=' .  rawurlencode(oos_var_prep_for_os($aData['sort'])) . '&amp;';
    }   
    if (isset($aData['dfrom']) && !empty($aData['dfrom']))  {
        $dfrom = (($aData['dfrom'] == DOB_FORMAT_STRING) ? '' : oos_prepare_input($aData['dfrom']));
        $parameters .= 'dfrom=' . rawurlencode($dfrom) . '&amp;';
    }
    if (isset($aData['dto']) && !empty($aData['dto']))  {
        $dto = (($_GET['dto'] == DOB_FORMAT_STRING) ? '' : oos_prepare_input($_GET['dto']));
        $parameters .= 'dto=' . rawurlencode($dto) . '&amp;'; 
    }
    if (isset($aData['pfrom']) && !empty($aData['pfrom']))  {
        $pfrom = oos_prepare_input($_GET['pfrom']);
        $parameters .= 'pfrom=' . rawurlencode($pfrom) . '&amp;';
    }
    if (isset($aData['pto']) && !empty($aData['pto']))  {
        $pto = oos_prepare_input($_GET['pto']);
        $parameters .= 'pfrom=' . rawurlencode($pto) . '&amp;';
    }
    if (isset($aData['keywords']) && !empty($aData['keywords']))  {
        $sKeywords = oos_prepare_input($aData['keywords']);

        if ( isset( $sKeywords ) || is_string( $sKeywords ) )      
            $parameters .= 'keywords=' . rawurlencode($sKeywords) . '&amp;';
    }

    if (isset($aData['categories_id']) && is_numeric($aData['categories_id'])) {
        if (isset($aData['inc_subcat']) && ($aData['inc_subcat'] == '1')) {
            $parameters .= 'inc_subcat=1&amp;';
        }
    }    
}

if (isset($aData['action'])) {
    $action = oos_var_prep_for_os($aData['action']);
} 

switch ($action) {
    case 'update_product' :
      // customer wants to update the product quantity in their shopping cart
      $nArrayCountProducts = count( $_POST['products_id'] );
      for ($i=0, $n=$nArrayCountProducts; $i<$n; $i++) {
        if (in_array($_POST['products_id'][$i], (is_array($_POST['cart_delete']) ? $_POST['cart_delete'] : array())) or $_POST['cart_quantity'][$i] == 0) {
          $_SESSION['cart']->remove($_POST['products_id'][$i]);
        } else {

          if (DECIMAL_CART_QUANTITY == '1') {
            $_POST['cart_quantity'][$i] = str_replace(',', '.', $_POST['cart_quantity'][$i]);
          }

          $products_order_min = oos_get_products_quantity_order_min($_POST['products_id'][$i]);
          $products_order_units = oos_get_products_quantity_order_units($_POST['products_id'][$i]);

          if ( ($_POST['cart_quantity'][$i] >= $products_order_min) ) {
            if ($_POST['cart_quantity'][$i]%$products_order_units == 0) {
              $attributes = ($_POST['id'][$_POST['products_id'][$i]]) ? $_POST['id'][$_POST['products_id'][$i]] : '';
              $_SESSION['cart']->add_cart($_POST['products_id'][$i], $_POST['cart_quantity'][$i], $attributes, false, $_POST['to_wl_id'][$i]);
            } else {
              $bInfoMessage = true;
              $_SESSION['error_cart_msg'] = trim($_SESSION['error_cart_msg']) . '<br />' . trim(oos_image(OOS_IMAGES . 'pixel_trans.gif','', '11', '10') . $aLang['error_products_quantity_order_min_text'] . ' ' . oos_get_products_name($_POST['products_id'][$i]) . ' - ' . $aLang['error_products_units_invalid'] . ' ' . $_POST['cart_quantity'][$i] . ' - ' . $aLang['products_order_qty_unit_text_cart'] . ' ' . $products_order_units);
            }
          } else {
            $bInfoMessage = true;
            $_SESSION['error_cart_msg'] = trim($_SESSION['error_cart_msg']) . '<br />' . trim(oos_image(OOS_IMAGES . 'pixel_trans.gif','', '11', '10') . $aLang['error_products_quantity_order_min_text'] . ' ' . oos_get_products_name($_POST['products_id'][$i]) . ' - ' . $aLang['error_products_quantity_invalid'] . ' ' . $_POST['cart_quantity'][$i] . ' - ' . $aLang['products_order_qty_min_text_cart'] . ' ' . $products_order_min);
          }
        }
      }

      MyOOS_CoreApi::redirect(oos_href_link($aPages['shopping_cart'], '', 'NONSSL'));
      break;


    case 'add_product' :
       // customer adds a product from the products page
      if (isset($_POST['products_id']) && is_numeric($_POST['products_id'])) {

        if (isset($_POST['edit_product'])) {
          $_SESSION['cart']->remove($_POST['edit_product']);
        }

        $real_ids = $_POST['id'];
        // File_upload
        if (isset($_POST['number_of_uploads']) && is_numeric($_POST['number_of_uploads']) && ($_POST['number_of_uploads'] > 0)) {
          require_once 'includes/classes/class_upload.php';
          for ($i = 1; $i <= $_POST['number_of_uploads']; $i++) {
            if (!empty($_FILES['id']['tmp_name'][TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]]) and ($_FILES['id']['tmp_name'][TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]] != 'none')) {

              $products_options_file = new upload('id');
              $products_options_file->set_destination(OOS_UPLOADS);
              $files_uploadedtable = $oostable['files_uploaded'];

              if ($products_options_file->parse(TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i])) {
                if (isset($_SESSION['customer_id'])) {
                  $dbconn->Execute("INSERT INTO " . $files_uploadedtable . " (sesskey, customers_id, files_uploaded_name) VALUES ('" . oos_session_id() . "', '" . intval($_SESSION['customer_id']) . "', '" . oos_db_input($products_options_file->filename) . "')");
                } else {
                  $dbconn->Execute("INSERT INTO " . $files_uploadedtable . " (sesskey, files_uploaded_name) VALUES ('" . oos_session_id() . "', '" . oos_db_input($products_options_file->filename) . "')");
                }
                $insert_id = $dbconn->Insert_ID();
                $real_ids[TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]] = $insert_id . ". " . $products_options_file->filename;
                $products_options_file->set_filename("$insert_id" . $products_options_file->filename);
                if (!($products_options_file->save())) {
                  break 2;
                }
              } else {
                break 2;
              }
            } else { // No file uploaded -- use previous value
              $real_ids[TEXT_PREFIX . $_POST[UPLOAD_PREFIX . $i]] = $_POST[TEXT_PREFIX . UPLOAD_PREFIX . $i];
            }
          }
        }
        // File_upload end

        if (isset($_REQUEST['button']['wishlist'])) {
          if ( !isset( $_SESSION['customer_id'] ) || !is_numeric( $_SESSION['customer_id'] )) {

            $aSetPage = array();
            $aSetPage['page'] = $sPage;
            $aSetPage['mode'] = $request_type;
            $aSetPage['get'] = 'products_id=' . rawurlencode($_POST['products_id']) . '&amp;action=add_wishlist';
            $_SESSION['navigation']->set_snapshot($aSetPage);

            MyOOS_CoreApi::redirect(oos_href_link($aPages['login'], '', 'SSL'));
          } else {
            $wishlist_products_id = oos_get_uprid($_POST['products_id'], $_POST['id']);

            $customers_wishlisttable = $oostable['customers_wishlist'];
            $dbconn->Execute("DELETE FROM $customers_wishlisttable WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'  AND products_id = '" . oos_db_input($wishlist_products_id) . "'");

            $customers_wishlist_attributestable = $oostable['customers_wishlist_attributes'];
            $dbconn->Execute("DELETE FROM $customers_wishlist_attributestable WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'  AND products_id = '" . oos_db_input($wishlist_products_id) . "'");

            $contents = array();
            $contents[] = array($wishlist_products_id);

            $customers_wishlisttable = $oostable['customers_wishlist'];
            $dbconn->Execute("INSERT INTO $customers_wishlisttable
                          (customers_id, customers_wishlist_link_id, products_id,
                           customers_wishlist_date_added) VALUES (" . $dbconn->qstr($_SESSION['customer_id']) . ','
                                                                    . $dbconn->qstr($_SESSION['customer_wishlist_link_id']) . ','
                                                                    . $dbconn->qstr($wishlist_products_id) . ','
                                                                    . $dbconn->qstr(date("Y-m-d", time())) . ")");
            if (is_array($_POST['id'])) {
              foreach ($_POST['id'] as $option => $value) {
                $contents[$wishlist_products_id]['attributes'][$option] = $value;

                $customers_wishlist_attributestable = $oostable['customers_wishlist_attributes'];
                $dbconn->Execute("INSERT INTO $customers_wishlist_attributestable
                              (customers_id, customers_wishlist_link_id, products_id, products_options_id,
                               products_options_value_id) VALUES (" . $dbconn->qstr($_SESSION['customer_id']) . ','
                                                                    . $dbconn->qstr($_SESSION['customer_wishlist_link_id']) . ','
                                                                    . $dbconn->qstr($wishlist_products_id) . ','
                                                                    . $dbconn->qstr($option) . ','
                                                                    . $dbconn->qstr($value) . ")");
              }
            }
            MyOOS_CoreApi::redirect(oos_href_link($aPages['account_my_wishlist']));
          }
        } else {

          if (DECIMAL_CART_QUANTITY == '1') {
            $_POST['cart_quantity'] = str_replace(',', '.', $_POST['cart_quantity']);
          }

          if (isset($_POST['cart_quantity']) && is_numeric($_POST['cart_quantity'])) {

            $cart_quantity = oos_prepare_input($_POST['cart_quantity']);
            $cart_qty = $_SESSION['cart']->get_quantity(oos_get_uprid($_POST['products_id'], $real_ids));
            $news_qty = $cart_qty + $cart_quantity;

            $products_order_min = oos_get_products_quantity_order_min($_POST['products_id']);
            $products_order_units = oos_get_products_quantity_order_units($_POST['products_id']);

            if ( ($cart_quantity >= $products_order_min) or ($cart_qty >= $products_order_min) ) {
              if ( ($cart_quantity%$products_order_units == 0) and ($news_qty >= $products_order_min) ) {
                $_SESSION['cart']->add_cart($_POST['products_id'], $news_qty, $real_ids);
              } else {
                $bInfoMessage = true;
                $_SESSION['error_cart_msg'] = $aLang['error_products_quantity_order_min_text'] . $aLang['error_products_units_invalid'] . $cart_quantity  . ' - ' . $aLang['products_order_qty_unit_text_info'] . ' ' . $products_order_units;
              }
            } else {
              $bInfoMessage = true;
              $_SESSION['error_cart_msg'] = $aLang['error_products_quantity_order_min_text'] . $aLang['error_products_quantity_invalid'] . $cart_quantity . ' - ' . $aLang['products_order_qty_min_text_info'] . ' ' . $products_order_min;
            }

            if ($bInfoMessage == true) {
                MyOOS_CoreApi::redirect(oos_href_link($aPages['product_info'], 'products_id=' . $_POST['products_id']));
            } else {
                MyOOS_CoreApi::redirect(oos_href_link($goto_file, $parameters, 'NONSSL'));  
            }
          }
        }
      }
      break;


    case 'remove_wishlist' :
      if (isset($_SESSION['customer_id']) && isset($_GET['pid'])) {
        $customers_wishlisttable = $oostable['customers_wishlist'];
        $dbconn->Execute("DELETE FROM $customers_wishlisttable WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'  AND products_id = '" . oos_db_input($_GET['pid']) . "'");

        $customers_wishlist_attributestable = $oostable['customers_wishlist_attributes'];
        $dbconn->Execute("DELETE FROM $customers_wishlist_attributestable WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'  AND products_id = '" . oos_db_input($_GET['pid']) . "'");
      }
      break;


    case 'add_wishlist' :
      if (isset($_GET['products_id']) && is_numeric($_GET['products_id']) && isset($_SESSION['customer_id'])) {
        if (oos_has_product_attributes($_GET['products_id'])) {
          MyOOS_CoreApi::redirect(oos_href_link($aPages['product_info'], 'products_id=' . $_GET['products_id']));
        }

        $wishlist_products_id = oos_prepare_input($_GET['products_id']);

        $customers_wishlisttable = $oostable['customers_wishlist'];
        $dbconn->Execute("DELETE FROM $customers_wishlisttable WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'  AND products_id = '" . oos_db_input($wishlist_products_id) . "'");

        $dbconn->Execute("INSERT INTO $customers_wishlisttable
                          (customers_id, customers_wishlist_link_id, products_id,
                           customers_wishlist_date_added) VALUES (" . $dbconn->qstr($_SESSION['customer_id']) . ','
                                                                    . $dbconn->qstr($_SESSION['customer_wishlist_link_id']) . ','
                                                                    . $dbconn->qstr($wishlist_products_id) . ','
                                                                    . $dbconn->qstr(date("Y-m-d", time())) . ")");
         MyOOS_CoreApi::redirect(oos_href_link($aPages['account_my_wishlist']));
       }
      break;


    case 'buy_now' :
      if (isset($aData['products_id']) && is_numeric($aData['products_id'])) {
        if (oos_has_product_attributes($aData['products_id'])) {
          MyOOS_CoreApi::redirect(oos_href_link($aPages['product_info'], 'products_id=' . $aData['products_id']));
        } else {

          if (DECIMAL_CART_QUANTITY == '1') {
            $aData['cart_quantity'] = str_replace(',', '.', $aData['cart_quantity']);
          }

          if (isset($aData['cart_quantity']) && is_numeric($aData['cart_quantity'])) {

            $cart_quantity = oos_prepare_input($aData['cart_quantity']);
            $cart_qty = $_SESSION['cart']->get_quantity($aData['products_id']);
            $news_qty = $cart_qty + $cart_quantity;

            $products_order_min = oos_get_products_quantity_order_min($aData['products_id']);
            $products_order_units = oos_get_products_quantity_order_units($aData['products_id']);

            if ( ($cart_quantity >= $products_order_min) or ($cart_qty >= $products_order_min) ) {
              if ( ($cart_quantity%$products_order_units == 0) and ($news_qty >= $products_order_min) ) {
                $_SESSION['cart']->add_cart($aData['products_id'], $news_qty);
              } else {
                $bInfoMessage = true;
                $_SESSION['error_cart_msg'] = $aLang['error_products_quantity_order_min_text'] . $aLang['error_products_units_invalid'] . $cart_quantity  . ' - ' . $aLang['products_order_qty_unit_text_info'] . ' ' . $products_order_units;
              }
            } else {
              $bInfoMessage = true;
              $_SESSION['error_cart_msg'] = $aLang['error_products_quantity_order_min_text'] . $aLang['error_products_quantity_invalid'] . $cart_quantity . ' - ' . $aLang['products_order_qty_min_text_info'] . ' ' . $products_order_min;
            }
          }
          if ($bInfoMessage == true) {
              MyOOS_CoreApi::redirect(oos_href_link($aPages['product_info'], 'products_id=' . $aData['products_id']));
          } else {
              MyOOS_CoreApi::redirect(oos_href_link($goto_file, $parameters, 'NONSSL'));  
          }      
        }
      }
      break;


    case 'buy_slave' :
      if (isset($aData['slave_id']) ) {
        if (oos_has_product_attributes($aData['slave_id'])) {
          MyOOS_CoreApi::redirect(oos_href_link($aPages['product_info'], 'products_id=' . $aData['slave_id']));
        } else {

          if (DECIMAL_CART_QUANTITY == '1') {
            $aData['cart_quantity'] = str_replace(',', '.', $aData['cart_quantity']);
          }

          if (isset($aData['cart_quantity']) && is_numeric($aData['cart_quantity'])) {
          
            $cart_quantity = oos_prepare_input($aData['cart_quantity']);
            $cart_qty = $_SESSION['cart']->get_quantity($aData['slave_id']);
            $news_qty = $cart_qty + $cart_quantity;

            $products_order_min = oos_get_products_quantity_order_min($aData['slave_id']);
            $products_order_units = oos_get_products_quantity_order_units($aData['slave_id']);

            if ( ($cart_quantity >= $products_order_min) or ($cart_qty >= $products_order_min) ) {
              if ( ($cart_quantity%$products_order_units == 0) and ($news_qty >= $products_order_min) ) {
                $_SESSION['cart']->add_cart($aData['slave_id'], $news_qty);
              } else {
                $bInfoMessage = true;
                $_SESSION['error_cart_msg'] = $aLang['error_products_quantity_order_min_text'] . $aLang['error_products_units_invalid'] . $cart_quantity  . ' - ' . $aLang['products_order_qty_unit_text_info'] . ' ' . $products_order_units;
              }
            } else {
              $bInfoMessage = true;
              $_SESSION['error_cart_msg'] = $aLang['error_products_quantity_order_min_text'] . $aLang['error_products_quantity_invalid'] . $cart_quantity . ' - ' . $aLang['products_order_qty_min_text_info'] . ' ' . $products_order_min;
            }
          }
        }
        if ($bInfoMessage == true) {
            MyOOS_CoreApi::redirect(oos_href_link($aPages['product_info'], 'products_id=' . $aData['slave_id']));
        } else {
            MyOOS_CoreApi::redirect(oos_href_link($goto_file, $parameters, 'NONSSL'));  
        }  
      }
      break;


    case 'add_a_quickie' :
      if (DECIMAL_CART_QUANTITY == '1') {
        $_POST['cart_quantity'] = str_replace(',', '.', $_POST['cart_quantity']);
        $cart_quantity = oos_prepare_input($_POST['cart_quantity']);
      }

      if (isset($_POST['cart_quantity']) && is_numeric($_POST['cart_quantity'])) {
        if (isset($_POST['quickie']) && is_string($_POST['quickie'])) {
          $sQuickie = oos_var_prep_for_os($aData['sort']);
          $productstable = $oostable['products'];
          $quickie_result = $dbconn->Execute("SELECT products_id FROM $productstable WHERE (products_model = '" . addslashes($sQuickie) . "' OR products_ean = '" . addslashes($sQuickie) . "')");
          if (!$quickie_result->RecordCount()) {
            $productstable = $oostable['products'];
            $quickie_result = $dbconn->Execute("SELECT products_id FROM $productstable WHERE (products_model LIKE '%" . addslashes($sQuickie) . "%' OR products_ean LIKE '%" . addslashes($sQuickie) . "%')");
          }
          if ($quickie_result->RecordCount() != 1) {
            MyOOS_CoreApi::redirect(oos_href_link($aPages['advanced_search_result'], 'keywords=' . rawurlencode($sQuickie), 'NONSSL'));
          }
          $products_quickie = $quickie_result->fields;

          if (oos_has_product_attributes($products_quickie['products_id'])) {
            MyOOS_CoreApi::redirect(oos_href_link($aPages['product_info'], 'products_id=' . $products_quickie['products_id'], 'NONSSL'));
          } else {

            $cart_qty = $_SESSION['cart']->get_quantity($products_quickie['products_id']);
            $news_qty = $cart_qty + $cart_quantity;

            $products_order_min = oos_get_products_quantity_order_min($products_quickie['products_id']);
            $products_order_units = oos_get_products_quantity_order_units($products_quickie['products_id']);

            if ( ($cart_quantity >= $products_order_min) or ($cart_qty >= $products_order_min) ) {
              if ( ($cart_quantity%$products_order_units == 0) and ($news_qty >= $products_order_min) ) {
                $_SESSION['cart']->add_cart($products_quickie['products_id'], $news_qty);
              } else {
                $bInfoMessage = true;
                $_SESSION['error_cart_msg'] = $aLang['error_products_quantity_order_min_text'] . $aLang['error_products_units_invalid'] . $cart_quantity  . ' - ' . $aLang['products_order_qty_unit_text_info'] . ' ' . $products_order_units;
              }
            } else {
              $bInfoMessage = true;
              $_SESSION['error_cart_msg'] = $aLang['error_products_quantity_order_min_text'] . $aLang['error_products_quantity_invalid'] . $cart_quantity . ' - ' . $aLang['products_order_qty_min_text_info'] . ' ' . $products_order_min;
            }

            if ($bInfoMessage == true) {
                MyOOS_CoreApi::redirect(oos_href_link($aPages['product_info'], 'products_id=' . $products_quickie['products_id']));
            } else {
                MyOOS_CoreApi::redirect(oos_href_link($goto_file, $parameters, 'NONSSL'));  
            }  
          }
        }
      }
      break;


    case 'cust_order' :
      if (isset($_SESSION['customer_id']) && isset($_GET['pid'])) {
        if (oos_has_product_attributes($_GET['pid'])) {
          MyOOS_CoreApi::redirect(oos_href_link($aPages['product_info'], 'products_id=' . $_GET['pid']));
        } else {
          $cart_qty = $_SESSION['cart']->get_quantity($_GET['pid']);
          $news_qty = $cart_qty + 1;
          $_SESSION['cart']->add_cart($_GET['pid'], intval($news_qty));
        }
      }
      MyOOS_CoreApi::redirect(oos_href_link($goto_file, $parameters));
      break;


    case 'cust_wishlist_add_product' :
      if (isset($_SESSION['customer_id']) && isset($_POST['products_id'])) {
        if (isset($_POST['cart_quantity']) && is_numeric($_POST['cart_quantity'])) {

          $cart_qty = $_SESSION['cart']->get_quantity(oos_get_uprid($_POST['products_id'], $_POST['id']));
          $news_qty = $cart_qty + $cart_quantity;

          $products_order_min = oos_get_products_quantity_order_min($_POST['products_id']);
          $products_order_units = oos_get_products_quantity_order_units($_POST['products_id']);

          $customers_wishlisttable = $oostable['customers_wishlist'];
          $customers_wishlist_attributestable = $oostable['customers_wishlist_attributes'];

          if ( ($cart_quantity >= $products_order_min) or ($cart_qty >= $products_order_min) ) {
            if ( ($cart_quantity%$products_order_units == 0) and ($news_qty >= $products_order_min) ) {
              $_SESSION['cart']->add_cart($_POST['products_id'], intval($news_qty), $_POST['id']);
              $dbconn->Execute("DELETE FROM $customers_wishlisttable WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'  AND products_id = '" . oos_db_input($wl_products_id) . "'");
              $dbconn->Execute("DELETE FROM $customers_wishlist_attributestable WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'  AND products_id = '" . oos_db_input($wl_products_id) . "'");
            } else {
              $bInfoMessage = true;
              $_SESSION['error_cart_msg'] = $aLang['error_products_quantity_order_min_text'] . $aLang['error_products_units_invalid'] . $cart_quantity  . ' - ' . $aLang['products_order_qty_unit_text_info'] . ' ' . $products_order_units;
            }
          } else {
            $bInfoMessage = true;
            $_SESSION['error_cart_msg'] = $aLang['error_products_quantity_order_min_text'] . $aLang['error_products_quantity_invalid'] . $cart_quantity . ' - ' . $aLang['products_order_qty_min_text_info'] . ' ' . $products_order_min;
          }
        }

        if ($bInfoMessage == true) {
             MyOOS_CoreApi::redirect(oos_href_link($aPages['product_info'], 'products_id=' . $_POST['products_id']));
        } else {
             MyOOS_CoreApi::redirect(oos_href_link($goto_file, $parameters, 'NONSSL'));  
        } 
      }
      break;


    case 'frend_wishlist_add_product' :
      if (isset($_POST['products_id']) && is_numeric($_POST['cart_quantity'])) {

        $cart_qty = $_SESSION['cart']->get_quantity(oos_get_uprid($_POST['products_id'], $_POST['id']));
        $news_qty = $cart_qty + $cart_quantity;

        $products_order_min = oos_get_products_quantity_order_min($_POST['products_id']);
        $products_order_units = oos_get_products_quantity_order_units($_POST['products_id']);

        if ( ($cart_quantity >= $products_order_min) or ($cart_qty >= $products_order_min) ) {
          if ( ($cart_quantity%$products_order_units == 0) and ($news_qty >= $products_order_min) ) {
            $_SESSION['cart']->add_cart($_POST['products_id'], intval($news_qty), $_POST['id'], true, $_POST['to_wl_id']);
          } else {
            $bInfoMessage = true;
            $_SESSION['error_cart_msg'] = $aLang['error_products_quantity_order_min_text'] . $aLang['error_products_units_invalid'] . $cart_quantity  . ' - ' . $aLang['products_order_qty_unit_text_info'] . ' ' . $products_order_units;
          }
        } else {
          $bInfoMessage = true;
          $_SESSION['error_cart_msg'] = $aLang['error_products_quantity_order_min_text'] . $aLang['error_products_quantity_invalid'] . $cart_quantity . ' - ' . $aLang['products_order_qty_min_text_info'] . ' ' . $products_order_min;
        }
        if ($bInfoMessage == true) {
             MyOOS_CoreApi::redirect(oos_href_link($aPages['product_info'], 'products_id=' . $_POST['products_id']));
        } else {
             MyOOS_CoreApi::redirect(oos_href_link($goto_file, $parameters, 'NONSSL'));  
        }
      }
      break;

}
