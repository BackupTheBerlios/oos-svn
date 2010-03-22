<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}


$aPages = array();
$prefix_filename = '';
if (!$prefix_filename == '') $prefix_filename = $prefix_filename . '_';


$aPages['conditions_download'] = $prefix_filename . 'conditions.pdf';

$aPages['account_address_book'] = $prefix_filename . 'account_address_book';
$aPages['account_address_book_process'] = $prefix_filename . 'account_address_book_process';
$aPages['account_history'] = $prefix_filename . 'account_history';
$aPages['account_history_info'] = $prefix_filename . 'account_history_info';

$aPages['account_my_wishlist'] = $prefix_filename . 'account_my_wishlist';
$aPages['account_order_history'] = $prefix_filename . 'account_order_history';

$aPages['admin_create_account'] = $prefix_filename . 'admin_create_account';
$aPages['admin_create_account_process'] = $prefix_filename . 'admin_create_account_process';
$aPages['admin_login'] = $prefix_filename . 'admin_login';

$aPages['checkout_confirmation'] = $prefix_filename . 'checkout_confirmation';
$aPages['checkout_payment'] = $prefix_filename . 'checkout_payment';
$aPages['checkout_payment_address'] = $prefix_filename . 'checkout_payment_address';
$aPages['checkout_process'] = $prefix_filename . 'checkout_process';
$aPages['checkout_shipping'] = $prefix_filename . 'checkout_shipping';
$aPages['checkout_shipping_address'] = $prefix_filename . 'checkout_shipping_address';
$aPages['checkout_success'] = $prefix_filename . 'checkout_success';

$aPages['error404'] = $prefix_filename . 'error404';

//includes/pages/gv
$aPages['gv_faq'] = $prefix_filename . 'gv_faq';
$aPages['gv_redeem'] = $prefix_filename . 'gv_redeem';
$aPages['gv_send'] = $prefix_filename . 'gv_send';
$aPages['popup_coupon_help'] = $prefix_filename . 'popup_coupon_help';

$aPages['info_down_for_maintenance'] = $prefix_filename . 'info_down_for_maintenance';
$aPages['info_max_order'] = $prefix_filename . 'info_max_order';
$aPages['info_sitemap'] = $prefix_filename . 'sitemap';
$aPages['info_vcard'] = $prefix_filename . 'vcard';
$aPages['information'] = $prefix_filename . 'information';


$aPages['main'] = $prefix_filename . 'main';
$aPages['shop'] = $prefix_filename . 'shop';
$aPages['redirect'] = $prefix_filename . 'redirect';
$aPages['shopping_cart'] = $prefix_filename . 'shopping_cart';
$aPages['info_autologon'] = $prefix_filename . 'info_autologon';
$aPages['info_shopping_cart'] = $prefix_filename . 'info_shopping_cart';
$aPages['main_wishlist'] = $prefix_filename . 'main_wishlist';

$aPages['contact_us'] = $prefix_filename . 'old_contact_us';


$aPages['newsletters'] = $prefix_filename . 'newsletters';
$aPages['newsletters_subscribe_success'] = $prefix_filename . 'newsletters_subscribe_success';
$aPages['newsletters_unsubscribe_success'] = $prefix_filename . 'newsletters_unsubscribe_success';
$aPages['subscription_center'] = $prefix_filename . 'subscription_center';

$aPages['cross_sell'] = $prefix_filename . 'cross_sell';
$aPages['product_info'] = $prefix_filename . 'product_info';
$aPages['products_new'] = $prefix_filename . 'products_new';
$aPages['product_zoom'] = $prefix_filename . 'product_zoom';
$aPages['product_movie'] = $prefix_filename . 'movie';
$aPages['specials'] = $prefix_filename . 'specials';
$aPages['top_viewed'] = $prefix_filename . 'top_viewed';
$aPages['popup_image'] = $prefix_filename . 'popup_image';
$aPages['popup_print'] = $prefix_filename . 'popup_print';

$aPages['download'] = $prefix_filename . 'download';

$aPages['reviews'] = $prefix_filename . 'reviews';
$aPages['product_reviews'] = $prefix_filename . 'product_reviews';
$aPages['product_reviews_info'] = $prefix_filename . 'product_reviews_info';
$aPages['product_reviews_write'] = $prefix_filename . 'product_reviews_write';


$aPages['advanced_search'] = $prefix_filename . 'advanced_search';
$aPages['advanced_search_result'] = $prefix_filename . 'advanced_search_result';
$aPages['popup_search_help'] = $prefix_filename . 'popup_search_help';
$aPages['quickfind'] = $prefix_filename . 'quickfind';

$aPages['tell_a_friend'] = $prefix_filename . 'tell_a_friend';

$aPages['account'] = $prefix_filename . 'user_account';
$aPages['account_edit'] = $prefix_filename . 'user_account_edit';
$aPages['account_edit_process'] = $prefix_filename . 'user_account_edit_process';
$aPages['password_edit'] = $prefix_filename . 'user_password_edit';
$aPages['password_edit_process'] = $prefix_filename . 'user_password_edit_process';
$aPages['create_account'] = $prefix_filename . 'user_create_account';
$aPages['create_account_process'] = $prefix_filename . 'user_create_account_process';
$aPages['create_account_success'] = $prefix_filename . 'user_create_account_success';
$aPages['login'] = $prefix_filename . 'user_login';
$aPages['logoff'] = $prefix_filename . 'user_logoff';
$aPages['password_forgotten'] = $prefix_filename . 'user_password_forgotten';
$aPages['product_notifications'] = $prefix_filename . 'user_product_notifications';
$aPages['yourstore'] = $prefix_filename . 'user_yourstore';
$aPages['customers_image'] = $prefix_filename . 'user_customers_image';


