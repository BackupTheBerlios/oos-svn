<?php
/* ----------------------------------------------------------------------
   $Id: languages.php,v 1.80 2008/01/29 16:03:35 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: languages.php,v 1.32 2002/03/17 17:37:51 harley_vb 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  define('OOS_VALID_MOD', 'yes');
  require 'includes/oos_main.php';

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (!empty($action)) {
    switch ($action) {
      case 'setflag':
        $lID = oos_db_prepare_input($_GET['lID']);

        if ($_GET['flag'] == '0') {
          $dbconn->Execute("UPDATE " . $oostable['languages'] . "
                        SET status = '0'
                        WHERE languages_id = '" . intval($lID) . "'");
        } elseif ($_GET['flag'] == '1') {
          $dbconn->Execute("UPDATE " . $oostable['languages'] . "
                        SET status = '1'
                        WHERE languages_id = '" . intval($lID) . "'");
        }
        oos_redirect_admin(oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page']. '&lID=' . $_GET['lID']));
        break;

      case 'insert':
        $sql = "INSERT INTO " . $oostable['languages'] . "
                (name,
                 iso_639_2,
                 iso_639_1)
                 VALUES ('" . oos_db_input($name) . "',
                         '" . oos_db_input($iso_639_2) . "',
                         '" . oos_db_input($iso_639_1) . "')";
        $dbconn->Execute($sql);
        $insert_id = $dbconn->Insert_ID();
        //affiliate_payment_status
        $affiliate_payment_result = $dbconn->Execute("SELECT affiliate_payment_status_id, affiliate_payment_status_name
                                                 FROM " . $oostable['affiliate_payment_status'] . "
                                                 WHERE affiliate_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($affiliate_payment_status = $affiliate_payment_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['affiliate_payment_status'] . "
                      (affiliate_payment_status_id,
                       affiliate_languages_id,
                       affiliate_payment_status_name)
                       VALUES ('" . $affiliate_payment_status['affiliate_payment_status_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($affiliate_payment_status['affiliate_payment_status_name']) . "')");

         // Move that ADOdb pointer!
          $affiliate_payment_result->MoveNext();
        }
        //block_info
        $block_info_result = $dbconn->Execute("SELECT block_id, block_name
                                           FROM " . $oostable['block_info'] . "
                                           WHERE block_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($block_info = $block_info_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['block_info'] . "
                      (block_id,
                       block_languages_id,
                       block_name)
                       VALUES ('" . $block_info['block_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($block_info['block_name']) . "')");

          // Move that ADOdb pointer!
          $block_info_result->MoveNext();
        }
        // create additional categories_description records
        $categories_result = $dbconn->Execute("SELECT c.categories_id, cd.categories_name, cd.categories_heading_title, cd.categories_description,
                                                  cd.categories_description_meta, cd.categories_keywords_meta
                                          FROM " . $oostable['categories'] . " c LEFT JOIN
                                               " . $oostable['categories_description'] . " cd
                                             ON c.categories_id = cd.categories_id
                                          WHERE cd.categories_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($categories = $categories_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['categories_description'] . "
                      (categories_id,
                       categories_languages_id,
                       categories_name,
                       categories_heading_title,
                       categories_description,
                       categories_description_meta, 
                       categories_keywords_meta) 
                       VALUES ('" . $categories['categories_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($categories['categories_name']) . "',
                               '" . oos_db_input($categories['categories_heading_title']) . "',
                               '" . oos_db_input($categories['categories_description']) . "',
                               '" . oos_db_input($categories['categories_description_meta']) . "',
                               '" . oos_db_input($categories['categories_keywords_meta']) . "')");

          // Move that ADOdb pointer!
          $categories_result->MoveNext();
        }
        //coupons_description
        $coupon_result = $dbconn->Execute("SELECT c.coupon_id, cd.coupon_name, cd.coupon_description
                                      FROM " . $oostable['coupons'] . " c LEFT JOIN
                                           " . $oostable['coupons_description'] . " cd
                                          ON c.coupon_id = cd.coupon_id
                                      WHERE cd.coupon_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($coupon = $coupon_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['coupons_description'] . "
                      (coupon_id,
                       coupon_languages_id,
                       coupon_name,
                       coupon_description)
                       VALUES ('" . $coupon['coupon_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($coupon['coupon_name']) . "',
                               '" . oos_db_input($coupon['coupon_description']) . "')");

          // Move that ADOdb pointer!
          $coupon_result->MoveNext();
        }
        //customers_status
        $customers_status_result = $dbconn->Execute("SELECT customers_status_id, customers_status_name, customers_status_image, 
                                                        customers_status_discount, customers_status_ot_discount_flag,
                                                        customers_status_ot_discount, customers_status_ot_minimum, customers_status_public,
                                                        customers_status_show_price, customers_status_show_price_tax,
                                                        customers_status_qty_discounts, customers_status_payment
                                                FROM " . $oostable['customers_status'] . "
                                                WHERE customers_status_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($customers_status = $customers_status_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['customers_status'] . "
                      (customers_status_id,
                       customers_status_languages_id,
                       customers_status_name,
                       customers_status_image,
                       customers_status_discount,
                       customers_status_ot_discount_flag,
                       customers_status_ot_discount,
                       customers_status_ot_minimum,
                       customers_status_public,
                       customers_status_show_price,
                       customers_status_show_price_tax,
                       customers_status_qty_discounts,
                       customers_status_payment) 
                       VALUES ('" . $customers_status['customers_status_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($customers_status['customers_status_name']) . "',
                               '" . oos_db_input($customers_status['customers_status_image']) . "',
                               '" . oos_db_input($customers_status['customers_status_discount']) . "',
                               '" . oos_db_input($customers_status['customers_status_ot_discount_flag']) . "',
                               '" . oos_db_input($customers_status['customers_status_ot_discount']) . "',
                               '" . oos_db_input($customers_status['customers_status_ot_minimum']) . "',
                               '" . oos_db_input($customers_status['customers_status_public']) . "',
                               '" . oos_db_input($customers_status['customers_status_show_price']) . "',
                               '" . oos_db_input($customers_status['customers_status_show_price_tax']) . "',
                               '" . oos_db_input($customers_status['customers_status_qty_discounts']) . "',
                               '" . oos_db_input($customers_status['customers_status_payment']) . "')");

           // Move that ADOdb pointer!
           $customers_status_result->MoveNext();
        }

        //information_description
        $information_result = $dbconn->Execute("SELECT i.information_id, id.information_name, id.information_description
                                            FROM " . $oostable['information'] . " i LEFT JOIN
                                                 " . $oostable['information_description'] . " id
                                               on i.information_id = id.information_id
                                            WHERE id.information_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($information = $information_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['information_description'] . "
                      (information_id,
                       information_languages_id,
                       information_name,
                       information_description) 
                       VALUES ('" . $information['information_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($information['information_name']) . "',
                               '" . oos_db_input($information['information_description']) . "')");

          // Move that ADOdb pointer!
          $information_result->MoveNext();
        }


        // manufacturers_info
        $manufacturers_result = $dbconn->Execute("SELECT m.manufacturers_id, mi.manufacturers_url
                                             FROM " . $oostable['manufacturers'] . " m LEFT JOIN
                                                  " . $oostable['manufacturers_info'] . " mi
                                                 ON m.manufacturers_id = mi.manufacturers_id
                                             WHERE mi.manufacturers_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($manufacturers = $manufacturers_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['manufacturers_info'] . "
                      (manufacturers_id, 
                       manufacturers_languages_id,
                       manufacturers_url) 
                       VALUES ('" . $manufacturers['manufacturers_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($manufacturers['manufacturers_url']) . "')");

          // Move that ADOdb pointer!
          $manufacturers_result->MoveNext();
        }
        // newsfeed_categories
        $newsfeed_categories_result = $dbconn->Execute("SELECT newsfeed_categories_id, newsfeed_categories_name
                                                   FROM " . $oostable['newsfeed_categories'] . "
                                                   WHERE newsfeed_categories_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($newsfeed_categories = $newsfeed_categories_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['newsfeed_categories'] . "
                        (newsfeed_categories_id,
                         newsfeed_categories_languages_id,
                         newsfeed_categories_name)
                         VALUES ('" . $newsfeed_categories['newsfeed_categories_id'] . "',
                                 '" . intval($insert_id) . "',
                                 '" . oos_db_input($newsfeed_categories['newsfeed_categories_name']) . "')");

          // Move that ADOdb pointer!
          $newsfeed_categories_result->MoveNext();
        }
        // newsfeed_info
       $newsfeed_result = $dbconn->Execute("SELECT n.newsfeed_id, ni.newsfeed_name, ni.newsfeed_title,
                                               ni.newsfeed_description
                                        FROM " . $oostable['newsfeed'] . " n LEFT JOIN
                                             " . $oostable['newsfeed_info'] . " ni
                                            ON n.newsfeed_id = ni.newsfeed_id
                                        WHERE ni.newsfeed_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($newsfeed = $newsfeed_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['newsfeed_info'] . "
                      (newsfeed_id,
                       newsfeed_name,
                       newsfeed_title,
                       newsfeed_description,
                       newsfeed_languages_id) 
                       VALUES ('" . $newsfeed['newsfeed_id'] . "',
                               '" . $newsfeed['newsfeed_name'] . "',
                               '" . $newsfeed['newsfeed_title'] . "',
                               '" . $newsfeed['newsfeed_description'] . "',
                               '" . intval($insert_id) . "')");

          // Move that ADOdb pointer!
          $newsfeed_result->MoveNext();
        }
        // create additional news_categories_description records
        $news_categories_result = $dbconn->Execute("SELECT n.news_categories_id, nd.news_categories_name, nd.news_categories_heading_title, nd.news_categories_description
                                          FROM " . $oostable['news_categories'] . " n LEFT JOIN
                                               " . $oostable['news_categories_description'] . " nd
                                              ON n.news_categories_id = nd.news_categories_id
                                          WHERE nd.news_categories_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($categories = $news_categories_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['news_categories_description'] . "
                      (news_categories_id,
                       news_categories_languages_id,
                       news_categories_name,
                       news_categories_heading_title,
                       news_categories_description) 
                       VALUES ('" . $categories['news_categories_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($categories['news_categories_name']) . "',
                               '" . oos_db_input($categories['news_categories_heading_title']) . "',
                               '" . oos_db_input($categories['news_categories_description']) . "')");

          // Move that ADOdb pointer!
          $news_categories_result->MoveNext();
        }

        // orders_status
        $orders_status_result = $dbconn->Execute("SELECT orders_status_id, orders_status_name
                                              FROM " . $oostable['orders_status'] . "
                                              WHERE orders_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($orders_status = $orders_status_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['orders_status'] . "
                      (orders_status_id,
                       orders_languages_id,
                       orders_status_name)
                       VALUES ('" . $orders_status['orders_status_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($orders_status['orders_status_name']) . "')");

          // Move that ADOdb pointer!
          $orders_status_result->MoveNext();
        }

        //page_type
        $page_type_result = $dbconn->Execute("SELECT page_type_id, page_type_name
                                          FROM " . $oostable['page_type'] . "
                                          WHERE page_type_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($page_type = $page_type_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['page_type'] . "
                      (page_type_id,
                       page_type_languages_id,
                       page_type_name)
                       VALUES ('" . $page_type['page_type_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($page_type['page_type_name']) . "')");

          // Move that ADOdb pointer!
          $page_type_result->MoveNext();
        }

        //products_description
        $products_result = $dbconn->Execute("SELECT p.products_id, pd.products_name, pd.products_description, pd.products_url 
                                         FROM " . $oostable['products'] . " p LEFT JOIN
                                              " . $oostable['products_description'] . " pd
                                            ON p.products_id = pd.products_id
                                        WHERE pd.products_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($products = $products_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['products_description'] . "
                      (products_id,
                       products_languages_id,
                       products_name,
                       products_description,
                       products_url) 
                       VALUES ('" . $products['products_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($products['products_name']) . "',
                               '" . oos_db_input($products['products_description']) . "',
                               '" . oos_db_input($products['products_url']) . "')");

           // Move that ADOdb pointer!
           $products_result->MoveNext();
        }
         // products_options
        $products_options_result = $dbconn->Execute("SELECT products_options_id, products_options_name 
                                                 FROM " . $oostable['products_options'] . "
                                                WHERE products_options_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($products_options = $products_options_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['products_options'] . "
                      (products_options_id,
                       products_options_languages_id,
                       products_options_name)
                       VALUES ('" . $products_options['products_options_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($products_options['products_options_name']) . "')");

           // Move that ADOdb pointer!
           $products_options_result->MoveNext();
        }
        //products_options_values
        $products_options_values_result = $dbconn->Execute("SELECT products_options_values_id, products_options_values_name 
                                                       FROM " . $oostable['products_options_values'] . "
                                                       WHERE products_options_values_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($products_options_values = $products_options_values_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['products_options_values'] . "
                      (products_options_values_id,
                       products_options_values_languages_id,
                       products_options_values_name)
                       VALUES ('" . $products_options_values['products_options_values_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($products_options_values['products_options_values_name']) . "')");

          // Move that ADOdb pointer!
          $products_options_values_result->MoveNext();
        }

        //products_options_values
        $products_options_values_result = $dbconn->Execute("SELECT products_options_types_id, products_options_types_name
                                                       FROM " . $oostable['products_options_types'] . "
                                                       WHERE products_options_types_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($products_options_values = $products_options_values_result->fields) {
          $dbconn->Execute("INSERT INTO " .$oostable['products_options_types'] . "
                      (products_options_types_id,
                       products_options_types_languages_id,
                       products_options_types_name)
                       VALUES ('" . $products_options_values['products_options_types_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($products_options_values['products_options_types_name']) . "')");

          // Move that ADOdb pointer!
          $products_options_values_result->MoveNext();
        }

        // products_status
        $products_status_result = $dbconn->Execute("SELECT products_status_id, products_status_name
                                                FROM " . $oostable['products_status'] . "
                                                WHERE products_status_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($products_status = $products_status_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['products_status'] . "
                      (products_status_id,
                       products_status_languages_id,
                       products_status_name)
                       VALUES ('" . $products_status['products_status_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($products_status['products_status_name']) . "')");

          // Move that ADOdb pointer!
          $products_status_result->MoveNext();
        }

        // ticket_admins
        $ticket_admin_result = $dbconn->Execute("SELECT ticket_admin_id, ticket_admin_name
                                             FROM " . $oostable['ticket_admins'] . "
                                             WHERE ticket_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($ticket_admin = $ticket_admin_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['ticket_admins'] . " 
                      (ticket_admin_id,
                       ticket_languages_id,
                       ticket_admin_name)
                       VALUES ('" . $ticket_admin['ticket_admin_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($ticket_admin['ticket_admin_name']) . "')");

          // Move that ADOdb pointer!
          $ticket_admin_result->MoveNext();
        }
        //ticket_department
        $ticket_department_result = $dbconn->Execute("SELECT ticket_department_id, ticket_department_name
                                                  FROM " . $oostable['ticket_department'] . "
                                                  WHERE ticket_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($ticket_department = $ticket_department_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['ticket_department'] . "
                      (ticket_department_id,
                       ticket_languages_id,
                       ticket_department_name)
                       VALUES ('" . $ticket_department['ticket_department_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($ticket_department['ticket_department_name']) . "')");

          // Move that ADOdb pointer!
          $ticket_department_result->MoveNext();
        }
        //ticket_priority
        $ticket_priority_result = $dbconn->Execute("SELECT ticket_priority_id, ticket_priority_name
                                                FROM " . $oostable['ticket_priority'] . "
                                               WHERE ticket_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($ticket_priority = $ticket_priority_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['ticket_priority'] . "
                      (ticket_priority_id,
                       ticket_languages_id,
                       ticket_priority_name)
                       VALUES ('" . $ticket_priority['ticket_priority_id'] . "', 
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($ticket_priority['ticket_priority_name']) . "')");

          // Move that ADOdb pointer!
          $ticket_priority_result->MoveNext();
        }

        // ticket_reply
        $ticket_reply_result = $dbconn->Execute("SELECT ticket_reply_id, ticket_reply_name, ticket_reply_text
                                             FROM " . $oostable['ticket_reply'] . "
                                             WHERE ticket_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($ticket_reply = $ticket_reply_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['ticket_reply'] . "
                      (ticket_reply_id,
                       ticket_languages_id,
                       ticket_reply_name,
                       ticket_reply_text) 
                       VALUES ('" . $ticket_reply['ticket_reply_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($ticket_reply['ticket_reply_name']) . "', 
                               '" . oos_db_input($ticket_reply['ticket_reply_text']) . "')");

          // Move that ADOdb pointer!
          $ticket_reply_result->MoveNext();
        }
        // ticket_reply
        $ticket_status_result = $dbconn->Execute("SELECT ticket_status_id, ticket_status_name
                                              FROM " . $oostable['ticket_status'] . "
                                              WHERE ticket_languages_id = '" . intval($_SESSION['language_id']) . "'");
        while ($ticket_status = $ticket_status_result->fields) {
          $dbconn->Execute("INSERT INTO " . $oostable['ticket_status'] . "
                      (ticket_status_id,
                       ticket_languages_id,
                       ticket_status_name)
                       VALUES ('" . $ticket_status['ticket_status_id'] . "',
                               '" . intval($insert_id) . "',
                               '" . oos_db_input($ticket_status['ticket_status_name']) . "')");

          // Move that ADOdb pointer!
          $ticket_status_result->MoveNext();
        }
        oos_redirect_admin(oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page'] . '&lID=' . $insert_id));
        break;

      case 'save':
        $lID = oos_db_prepare_input($_GET['lID']);

        $dbconn->Execute("UPDATE " . $oostable['languages'] . "
                      SET name = '" . oos_db_input($name) . "', 
                      iso_639_2 = '" . oos_db_input($iso_639_2) . "',
                      iso_639_1 = '" . oos_db_input($iso_639_1) . "',
                      sort_order = '" . oos_db_input($sort_order) . "'
                      WHERE languages_id = '" . intval($lID) . "'");

        if (isset($_POST['default']) && ($_POST['default'] == 'on')) {
          $dbconn->Execute("UPDATE " . $oostable['configuration'] . " 
                            SET configuration_value = '" . oos_db_input($iso_639_2) . "'
                            WHERE configuration_key = 'DEFAULT_LANGUAGE'");

          $dbconn->Execute("UPDATE " . $oostable['configuration'] . " 
                            SET configuration_value = '" . intval($lID) . "'
                            WHERE configuration_key = 'DEFAULT_LANGUAGE_ID'");

        }
        oos_redirect_admin(oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page'] . '&lID=' . $_GET['lID']));
        break;

      case 'deleteconfirm':
        $lID = oos_db_prepare_input($_GET['lID']);

        $lng_result = $dbconn->Execute("SELECT iso_639_2 FROM " . $oostable['languages'] . " WHERE languages_id = '" . intval($lID) . "'");
        $lng = $lng_result->fields;
 
        $remove_language = true;
        if ($lng['iso_639_2'] == DEFAULT_LANGUAGE) {
          $remove_language = false;
          $messageStack->add_session(ERROR_REMOVE_DEFAULT_LANGUAGE, 'error');
          oos_redirect_admin(oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page']));
        }

        $dbconn->Execute("DELETE FROM " . $oostable['languages'] . " WHERE languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['affiliate_payment_status'] . " WHERE affiliate_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['block_info'] . " WHERE block_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['categories_description'] . " WHERE categories_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['coupons_description']  . " WHERE coupon_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['customers_status']  . " WHERE customers_status_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['information_description']  . " WHERE information_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['manufacturers_info'] . " WHERE manufacturers_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['newsfeed_categories'] . " WHERE newsfeed_categories_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['newsfeed_info'] . " WHERE newsfeed_languages_id = '" . intval($lID) . "'");     
        $dbconn->Execute("DELETE FROM " . $oostable['news_categories_description'] . " WHERE news_categories_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['orders_status'] . " WHERE orders_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['page_type'] . " WHERE page_type_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['products_description'] . " WHERE products_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['products_options'] . " WHERE products_options_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['products_options_types'] . " WHERE products_options_types_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['products_options_values'] . " WHERE products_options_values_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['products_status'] . " WHERE products_status_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['ticket_admins'] . " WHERE ticket_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['ticket_department'] . " WHERE ticket_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['ticket_priority'] . " WHERE ticket_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['ticket_reply'] . " WHERE ticket_languages_id = '" . intval($lID) . "'");
        $dbconn->Execute("DELETE FROM " . $oostable['ticket_status'] . " WHERE ticket_languages_id = '" . intval($lID) . "'");

        oos_redirect_admin(oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page']));
        break;

      case 'delete':
        $lID = oos_db_prepare_input($_GET['lID']);

        $lng_result = $dbconn->Execute("SELECT iso_639_2 FROM " . $oostable['languages'] . " WHERE languages_id = '" . oos_db_input($lID) . "'");
        $lng = $lng_result->fields;

        $remove_language = true;
        if ($lng['iso_639_2'] == DEFAULT_LANGUAGE) {
          $remove_language = false;
          $messageStack->add(ERROR_REMOVE_DEFAULT_LANGUAGE, 'error');
        }
        break;
    }
  }
  $lang_select_array = array(array('id' => '0', 'text' => TEXT_ALL_LANGUAGES),
                             array('id' => '1', 'text' => TEXT_ACTIVE_LANGUAGES));
  require 'includes/oos_header.php'; 
?>
<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<?php require 'includes/oos_blocks.php'; ?>
    </table></td>
<!-- body_text //-->
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
            <tr><?php echo oos_draw_form('search', $aFilename['languages'], '', 'get'); ?>
              <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . oos_draw_input_field('search'); ?></td>
              </form></tr>
            <tr><?php echo oos_draw_form('status', $aFilename['languages'], '', 'get'); ?>
              <td class="smallText" align="right"><?php echo HEADING_TITLE_STATUS . ' ' . oos_draw_pull_down_menu('status', $lang_select_array, '0', 'onChange="this.form.submit();"'); ?></td>
            </form></tr>
           </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_LANGUAGE_NAME; ?></td>
	        <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_LANGUAGE_ISO_639_2; ?></td>
	        <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_LANGUAGE_ISO_639_1; ?></td>
	        <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_LANGUAGE_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $search = '';
  if (isset($_GET['search']) && oos_is_not_null($_GET['search'])) {
    $keywords = oos_db_prepare_input($_GET['search']);
    $search = "WHERE name like '%" . $keywords . "%' OR iso_639_2 like '%" . $keywords . "%' OR iso_639_1 like '%" . $keywords . "'";
  }
  if (isset($_GET['status'])) {
    $status = oos_db_prepare_input($_GET['status']);
    if (!empty($_GET['search'])) {
      $seach .= "AND status = '" . $status . "'";
    } else {
      $search ="WHERE status = '" . $status . "'";
    }
  }
  $languages_result_raw = "SELECT languages_id, name, iso_639_2, iso_639_1, status, sort_order 
                          FROM " . $oostable['languages'] . "
                               " . $search . "
                          ORDER BY sort_order";
  $languages_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $languages_result_raw, $languages_result_numrows);
  $languages_result = $dbconn->Execute($languages_result_raw);

  while ($languages = $languages_result->fields) {
    if ((!isset($_GET['lID']) || (isset($_GET['lID']) && ($_GET['lID'] == $languages['languages_id']))) && !isset($lInfo) && (substr($action, 0, 3) != 'new')) {
      $lInfo = new objectInfo($languages);
    }

    if (isset($lInfo) && is_object($lInfo) && ($languages['languages_id'] == $lInfo->languages_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page'] . '&lID=' . $languages['languages_id']) . '\'">' . "\n";
    }

    if (DEFAULT_LANGUAGE == $languages['iso_639_2']) {
      echo '                <td class="dataTableContent"><b>' . $languages['name'] . ' (' . TEXT_DEFAULT . ')</b></td>' . "\n";
    } else {
      echo '                <td class="dataTableContent">' . $languages['name'] . '</td>' . "\n";
    }
?>
                <td class="dataTableContent" align="center"><?php echo $languages['iso_639_2']; ?></td>
                <td class="dataTableContent" align="center"><?php echo $languages['iso_639_1']; ?></td>
                <td class="dataTableContent" align="center">
<?php
  if ($languages['status'] == '1') {
    echo '<a href="' . oos_href_link_admin($aFilename['languages'], 'action=setflag&flag=0&lID=' . $languages['languages_id'] . '&page=' . $_GET['page']) . '">' . oos_image(OOS_IMAGES . 'icon_status_green.gif', IMAGE_ICON_STATUS_RED_LIGHT, 10, 10) . '</a>';
  } else {
    echo '<a href="' . oos_href_link_admin($aFilename['languages'], 'action=setflag&flag=1&lID=' . $languages['languages_id'] . '&page=' . $_GET['page']) . '">' . oos_image(OOS_IMAGES . 'icon_status_red.gif', IMAGE_ICON_STATUS_GREEN_LIGHT, 10, 10) . '</a>';
  }
?></td>

                <td class="dataTableContent" align="right"><?php if (isset($lInfo) && is_object($lInfo) && ($languages['languages_id'] == $lInfo->languages_id) ) { echo oos_image(OOS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page'] . '&lID=' . $languages['languages_id']) . '">' . oos_image(OOS_IMAGES . 'icon_information.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    // Move that ADOdb pointer!
    $languages_result->MoveNext();
  }
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $languages_split->display_count($languages_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_LANGUAGES); ?></td>
                    <td class="smallText" align="right"><?php echo $languages_split->display_links($languages_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (empty($action)) {
?>
                  <tr>
                    <td align="right" colspan="2"><?php echo '<a href="' . oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=new') . '">' . oos_image_swap_button('new_language','new_language_off.gif', IMAGE_NEW_LANGUAGE) . '</a>'; ?></td>
                  </tr>
<?php
  }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_LANGUAGE . '</b>');

      $contents = array('form' => oos_draw_form('languages', $aFilename['languages'], 'action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_NAME . '<br />' . oos_draw_input_field('name'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_ISO_639_2 . '<br />' . oos_draw_input_field('iso_639_2'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_ISO_639_1 . '<br />' . oos_draw_input_field('iso_639_1'));
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('insert','insert_off.gif', IMAGE_INSERT) . ' <a href="' . oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page'] . '&lID=' . $_GET['lID']) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_LANGUAGE . '</b>');

      $contents = array('form' => oos_draw_form('languages', $aFilename['languages'], 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_NAME . '<br />' . oos_draw_input_field('name', $lInfo->name));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_ISO_639_2 . '<br />' . oos_draw_input_field('iso_639_2', $lInfo->iso_639_2));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_ISO_639_1 . '<br />' . oos_draw_input_field('iso_639_1', $lInfo->iso_639_1));
      $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_SORT_ORDER . '<br />' . oos_draw_input_field('sort_order', $lInfo->sort_order));
      if (DEFAULT_LANGUAGE != $lInfo->iso_639_2 && $lInfo->status == '1' ) $contents[] = array('text' => '<br />' . oos_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('update','update_off.gif', IMAGE_UPDATE) . ' <a href="' . oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_LANGUAGE . '</b>');

      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $lInfo->name . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br />' . (($remove_language) ? '<a href="' . oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=deleteconfirm') . '">' . oos_image_swap_button('delete','delete_off.gif', IMAGE_DELETE) . '</a>' : '') . ' <a href="' . oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    default:
      if (isset($lInfo) && is_object($lInfo)) {
        $heading[] = array('text' => '<b>' . $lInfo->name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=edit') . '">' . oos_image_swap_button('edit','edit_off.gif', IMAGE_EDIT) . '</a> <a href="' . oos_href_link_admin($aFilename['languages'], 'page=' . $_GET['page'] . '&lID=' . $lInfo->languages_id . '&action=delete') . '">' . oos_image_swap_button('delete','delete_off.gif', IMAGE_DELETE) . '</a> <a href="' . oos_href_link_admin($aFilename['define_language'], 'lngdir=' . $lInfo->iso_639_2) . '">' . oos_image_swap_button('define','define_off.gif', IMAGE_DEFINE) . '</a>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_NAME . ' ' . $lInfo->name);
        $contents[] = array('text' => TEXT_INFO_LANGUAGE_ISO_639_2 . ' ' . $lInfo->iso_639_2);
        $contents[] = array('text' => TEXT_INFO_LANGUAGE_ISO_639_1 . ' ' . $lInfo->iso_639_1);
        $contents[] = array('text' => '<br />' . oos_image(OOS_SHOP_IMAGES . 'flags/' . $lInfo->iso_639_2 . '.gif', $lInfo->name));
        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_DIRECTORY . '<br />' . OOS_SHOP . 'includes/languages/<b>' . $lInfo->iso_639_2 . '</b>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_LANGUAGE_SORT_ORDER . ' ' . $lInfo->sort_order);

      }
      break;
  }

  if ( (oos_is_not_null($heading)) && (oos_is_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<?php require 'includes/oos_footer.php'; ?>
<br />
</body>
</html>
<?php require 'includes/oos_nice_exit.php'; ?>
