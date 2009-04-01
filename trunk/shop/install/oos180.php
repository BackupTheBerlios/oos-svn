<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: pn64.php,v 1.45 2002/03/16 15:24:37 johnnyrocket
   ----------------------------------------------------------------------
   POST-NUKE Content Management System
   Copyright (C) 2001 by the Post-Nuke Development Team.
   http://www.postnuke.com/
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

global $db, $prefix_table, $currentlang;

if (!$prefix_table == '') $prefix_table = $prefix_table . '_';

include_once 'oostables180.php';


$table = $prefix_table . 'configuration';
$aKeys = array('PDF_DATA_SHEET',
               'HEADER_COLOR_TABLE',
               'PRODUCT_NAME_COLOR_TABLE',
               'FOOTER_CELL_BG_COLOR',
               'SHOW_BACKGROUND',
               'PAGE_BG_COLOR',
               'SHOW_WATERMARK',
               'PAGE_WATERMARK_COLOR',
               'PDF_IMAGE_KEEP_PROPORTIONS',
               'MAX_IMAGE_WIDTH',
               'MAX_IMAGE_HEIGHT',
               'MAX_DISPLAY_WISHLIST_PRODUCTS',
               'MAX_DISPLAY_WISHLIST_BOX',
               'BLOCK_WISHLIST_IMAGE',
               'MIN_DISPLAY_NEW_NEWS',
               'OOS_SPAW',
               'PDF_TO_MM_FACTOR',
               'OOS_IMAGE_SWF',
               'OOS_SWF_MOVIECLIP',
               'OOS_SWF_BGCOLOUR_R',
               'OOS_SWF_BGCOLOUR_G',
               'OOS_SWF_BGCOLOUR_B',
               'CATEGORIES_BOX_SCROLL_LIST_ON',
               'CATEGORIES_SCROLL_BOX_LEN',
               'SHOW_PRODUCTS_MODEL',
               'ENABLE_LINKS_COUNT',
               'ENABLE_SPIDER_FRIENDLY_LINKS',
               'LINKS_IMAGE_WIDTH',
               'LINKS_IMAGE_HEIGHT',
               'LINK_LIST_IMAGE',
               'LINK_LIST_URL',
               'LINK_LIST_TITLE',
               'LINK_LIST_DESCRIPTION',
               'LINK_LIST_COUNT',
               'ENTRY_LINKS_TITLE_MIN_LENGTH',
               'ENTRY_LINKS_URL_MIN_LENGTH',
               'ENTRY_LINKS_DESCRIPTION_MIN_LENGTH',
               'ENTRY_LINKS_CONTACT_NAME_MIN_LENGTH',
               'LINKS_CHECK_PHRASE',
               'STORE_PAGE_PARSE_TIME',
               'STORE_PAGE_PARSE_TIME_LOG',
               'STORE_PARSE_DATE_TIME_FORMAT',
               'DISPLAY_PAGE_PARSE_TIME',
               'SHOW_PATH',
               'SHOW_IMAGES',
               'SHOW_NAME',
               'SHOW_MODEL',
               'SHOW_DESCRIPTION',
               'SHOW_MANUFACTURER',
               'SHOW_PRICE',
               'SHOW_SPECIALS_PRICE',
               'SHOW_SPECIALS_PRICE_EXPIRES',
               'SHOW_TAX_CLASS_ID',
               'SHOW_OPTIONS',
               'SHOW_OPTIONS_PRICE',
               'WEB_SEARCH_GOOGLE_KEY');

$db->Execute("DELETE FROM " . $table . " WHERE configuration_key in ('" . implode("', '", $aKeys) . "')");


$table = $prefix_table . 'admin_files';
$aKeys = array();
$aKeys = array('affiliate_reset',
               'affiliate',
               'affiliate_banners',
               'affiliate_banners_manager',
               'affiliate_clicks',
               'affiliate_contact',
               'affiliate_help1',
               'affiliate_help2',
               'affiliate_help3',
               'affiliate_help4',
               'affiliate_help5',
               'affiliate_help6',
               'affiliate_help7',
               'affiliate_help8',
               'affiliate_invoice',
               'affiliate_payment',
               'affiliate_popup_image',
               'affiliate_sales',
               'affiliate_statistics',
               'affiliate_summary',
               'affiliate_reset',
               'content_news',
               'backup');
$db->Execute("DELETE FROM " . $table . " WHERE admin_files_name in ('" . implode("', '", $aKeys) . "')");


$table = $prefix_table . 'block';
$aKeys = array();
$aKeys = array('affiliate',
               'babelfish',
               'news_reviews',
               'translate_google');
$db->Execute("DELETE FROM " . $table . " WHERE block_file in ('" . implode("', '", $aKeys) . "')");



// export_stampit.php
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('export_stampit', 0, 6, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('export_kelkoo', 0, 18, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . "admin_files " . UPDATED .'</font>';


$table = $prefix_table . 'configuration';

$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'1\', \'0\'),' WHERE set_function = 'oos_cfg_select_option(array(\'true\', \'false\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'1\', \'0\'),' WHERE set_function = 'oos_cfg_select_option(array(\'True\', \'False\'),'");

$result = $db->Execute("UPDATE " . $table . " SET configuration_value = '1' WHERE configuration_value = 'true'");
$result = $db->Execute("UPDATE " . $table . " SET configuration_value = '1' WHERE configuration_value = 'True'");
$result = $db->Execute("UPDATE " . $table . " SET configuration_value = '0' WHERE configuration_value = 'false'");
$result = $db->Execute("UPDATE " . $table . " SET configuration_value = '0' WHERE configuration_value = 'False'");


$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('OOS_FCKEDITOR', '1', 29, '2', NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'1\', \'0\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCTS_OPTIONS_TYPE_TEXTAREA', '8', 6, 0, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('TEXTAREA_PREFIX', 'textarea_', 6, 0, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");

$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('NEW_PRODUCT_PREVIEW', '0', 29, '2', NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'1\', \'0\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('OOS_PRICE_IS_BRUTTO', '1', 29, '2', NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'1\', \'0\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('OOS_BASE_PRICE', '0', 29, '2', NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'1\', \'0\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DECIMAL_CART_QUANTITY', '0', 29, '2', NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'1\', \'0\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");

$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_COMPANY_VAT_ID_CHECK', '1', 5, 12, NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'1\', \'0\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAKE_PASSWORD', '1', 5, 12, NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'1\', \'0\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_LANGUAGE_ID', '1', 6, 0, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");

echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . "configuration " . UPDATED .'</font>';



$table = $prefix_table . 'customers_basket';
$result = $db->Execute("ALTER TABLE " . $table . " CHANGE `customers_basket_date_added` `customers_basket_date_added` VARCHAR( 10 ) NULL DEFAULT NULL");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}



$table = $prefix_table . 'customers_wishlist';
$result = $db->Execute("ALTER TABLE " . $table . " CHANGE `customers_wishlist_date_added` `customers_wishlist_date_added` VARCHAR( 10 ) NULL DEFAULT NULL");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}


$table = $prefix_table . 'customers_wishlist_attributes';
$result = $db->Execute("ALTER TABLE " . $table . " CHANGE `customers_wishlist_date_added` `customers_wishlist_date_added` VARCHAR( 10 ) NULL DEFAULT NULL");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}



$table = $prefix_table . 'products';
$result = $db->Execute("ALTER TABLE " . $table . " ADD `products_access` INT( 11 ) DEFAULT '0' NOT NULL AFTER `products_weight`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}



$table = $prefix_table . 'products_options_types';
$result = $db->Execute("INSERT INTO " . $table . " (products_options_types_id, products_options_types_languages_id, products_options_types_name) VALUES (8, 2, 'Textarea')") or die ("<b>".NOTUPDATED . $prefix_table . "products_options_types</b>");
$result = $db->Execute("INSERT INTO " . $table . " (products_options_types_id, products_options_types_languages_id, products_options_types_name) VALUES (8, 1, 'Textarea')") or die ("<b>".NOTUPDATED . $prefix_table . "products_options_types</b>");
$result = $db->Execute("INSERT INTO " . $table . " (products_options_types_id, products_options_types_languages_id, products_options_types_name) VALUES (8, 6, 'Textarea')") or die ("<b>".NOTUPDATED . $prefix_table . "products_options_types</b>");
$result = $db->Execute("INSERT INTO " . $table . " (products_options_types_id, products_options_types_languages_id, products_options_types_name) VALUES (8, 3, 'Textarea')") or die ("<b>".NOTUPDATED . $prefix_table . "products_options_types</b>");

echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . "products_options_types " . UPDATED .'</font>';



$table = $prefix_table . 'orders';
$result = $db->Execute("ALTER TABLE " . $table . " ADD cc_start varchar(4) default NULL AFTER cc_expires");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " ADD cc_issue varchar(3) default NULL AFTER cc_start");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " ADD cc_cvv varchar(4) default NULL AFTER cc_issue");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " ADD `products_access` INT( 11 ) DEFAULT '0' NOT NULL AFTER `cc_expires`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . "  CHANGE `cc_number` `cc_number` VARCHAR( 64 ) DEFAULT NULL
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}

?>