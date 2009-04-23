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

$table = $prefix_table . 'sessions';
$result = $db->Execute("DROP TABLE " . $table . "");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

include_once 'oostables160.php';

$table = $prefix_table . 'configuration';
$aKeys = array('EMAIL_FROM',
               'SEND_EMAILS',
               'SEND_EXTRA_ORDER_EMAILS_TO',
               'SEND_BANKINFO_TO_ADMIN',
               'EMAIL_TRANSPORT',
               'EMAIL_LINEFEED',
               'EMAIL_USE_HTML',
               'ENTRY_EMAIL_ADDRESS_CHECK',
               'OOS_META_LANGUAGE',
               'OOS_META_DETAILS',
               'WEB_PRINTER',
               'WEB_PRINTER_EMAIL',
               'WEB_PRINTER_FTP',
               'WEB_PRINTER_XML',
               'PRINTER_EMAIL',
               'OOS_PRINTER_TEMP',
               'PRINTER_DELETE_FILE',
               'PRINTER_STORE_NAME',
               'PRINTER_STORE_STREET_ADDRESS',
               'PRINTER_STORE_STREET_POSTCODE',
               'PRINTER_STORE_STREET_CITY',
               'PRINTER_STORE_COUNTRY',
               'PDF_DATA_SHEET',
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
               'OOS_SPAW',
               'PDF_TO_MM_FACTOR',
               'OOS_IMAGE_SWF',
               'CATEGORIES_BOX_SCROLL_LIST_ON',
               'CATEGORIES_SCROLL_BOX_LEN',
               'OOS_SWF_MOVIECLIP',
               'OOS_SWF_BGCOLOUR_R',
               'OOS_SWF_BGCOLOUR_G',
               'OOS_SWF_BGCOLOUR_B',
               'DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE',
               'DOWNLOADS_CONTROLLER_ON_HOLD_MSG',
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
               'SHOW_PRODUCTS_MODEL',
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
               'WEB_SEARCH_GOOGLE_KEY',
               'MAX_DISPLAY_MANUFACTURERS_IN_A_LIST',
               'MAX_MANUFACTURERS_LIST',
               'MAX_DISPLAY_MANUFACTURER_NAME_LEN');
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



// popup_google_map.php
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('popup_google_map', 0, 6, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

// campaigns
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('campaigns', 0, 6, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

// products_units.php
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('products_units', 0, 3, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

// products_attributes_add.php
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('products_attributes_add', 0, 3, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

// excel.php
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('export_excel', 0, 3, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('import_excel', 0, 3, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

// export_stampit.php
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('export_stampit', 0, 6, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('export_googlebase', 0, 18, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('export_kelkoo', 0, 18, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "block (block_id, block_side, block_status, block_file, block_cache, block_type, block_sort_order, block_login_flag, date_added, last_modified, set_function) VALUES (33, 'left', 1, 'skype', 'system', 1, 33, 0, " . $db->DBTimeStamp($today) . ",  NULL, 'oos_block_select_option(array(\'left\', \'right\',),')") or die ("<b>".NOTUPDATED . $prefix_table . "block</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block (block_id, block_side, block_status, block_file, block_cache, block_type, block_sort_order, block_login_flag, date_added, last_modified, set_function) VALUES (34, 'left', 1, 'ads', '', 1, 34, 0, " . $db->DBTimeStamp($today) . ",  NULL, 'oos_block_select_option(array(\'left\', \'right\',),')") or die ("<b>".NOTUPDATED . $prefix_table . "block</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block (block_id, block_side, block_status, block_file, block_cache, block_type, block_sort_order, block_login_flag, date_added, last_modified, set_function) VALUES (35, 'left', 1, 'myworld', '', 1, 35, 0, " . $db->DBTimeStamp($today) . ",  NULL, 'oos_block_select_option(array(\'left\', \'right\',),')") or die ("<b>".NOTUPDATED . $prefix_table . "block</b>");


$table = $prefix_table . 'block';
$result = $db->Execute("ALTER TABLE " . $table . " ADD `block_author_name` VARCHAR(32) NOT NULL AFTER `block_login_flag`");
$result = $db->Execute("ALTER TABLE " . $table . " ADD `block_author_www` VARCHAR( 255 ) NOT NULL AFTER `block_author_name`");
$result = $db->Execute("ALTER TABLE " . $table . " ADD `block_modules_group` VARCHAR( 32 ) DEFAULT 'block' NOT NULL AFTER `block_author_www`");

$table = $prefix_table . 'block';
$result = $db->Execute("UPDATE " . $table . " SET block_author_name = 'OOS [OSIS Online Shop]' WHERE block_author_name = ''");
$result = $db->Execute("UPDATE " . $table . " SET block_author_www = 'http://www.oos-shop.de' WHERE block_author_www = ''");
$result = $db->Execute("UPDATE " . $table . " SET block_modules_group = 'block' WHERE block_modules_group = ''");


echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . 'block ' . UPDATED .'</font>';

$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_languages_id, block_name) VALUES (33, 1, 'Skype')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_languages_id, block_name) VALUES (33, 2, 'Skype')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_languages_id, block_name) VALUES (33, 3, 'Skype')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_languages_id, block_name) VALUES (33, 6, 'Skype')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_languages_id, block_name) VALUES (34, 1, 'Werbung')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_languages_id, block_name) VALUES (34, 2, 'ads')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_languages_id, block_name) VALUES (34, 3, 'ads')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_languages_id, block_name) VALUES (34, 6, 'ads')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_languages_id, block_name) VALUES (35, 1, 'My World')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_languages_id, block_name) VALUES (35, 2, 'My World')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_languages_id, block_name) VALUES (35, 3, 'My World')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_languages_id, block_name) VALUES (35, 6, 'My World')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");


echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . 'block_info ' . UPDATED .'</font>';


$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (33, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (33, 2)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (33, 3)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (33, 4)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (33, 5)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (33, 6)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (33, 7)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (33, 8)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (34, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (34, 2)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (34, 3)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (34, 4)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (34, 5)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (34, 6)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (34, 7)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (34, 8)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (35, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (35, 2)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (35, 5)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");


echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . "block_to_page_type " . UPDATED .'</font>';

$table = $prefix_table . 'categories';
$result = $db->Execute("ALTER TABLE " . $table . " ADD `access` INT( 11 ) DEFAULT '0' NOT NULL AFTER `parent_id`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}

$table = $prefix_table . 'customers';
$result = $db->Execute("ALTER TABLE " . $table . " ADD `customers_image` VARCHAR(64) AFTER `customers_lastname`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}

$result = $db->Execute("INSERT INTO " . $prefix_table . "customers_status (customers_status_languages_id, customers_status_name, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_ot_minimum, customers_status_public, customers_status_show_price, customers_status_show_price_tax, customers_status_qty_discounts, customers_status_payment) VALUES (1, 1, 'Admin', 'smile-yellow.gif', '0.00', '0', '0.00', '0.00', '0', '1', '1', '1', '')") or die ("<b>".NOTUPDATED . $prefix_table . "customers_status</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "customers_status (customers_status_languages_id, customers_status_name, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_ot_minimum, customers_status_public, customers_status_show_price, customers_status_show_price_tax, customers_status_qty_discounts, customers_status_payment) VALUES (1, 2, 'Admin', 'smile-yellow.gif', '0.00', '0', '0.00', '0.00', '0', '1', '1', '1', '')") or die ("<b>".NOTUPDATED . $prefix_table . "customers_status</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "customers_status (customers_status_languages_id, customers_status_name, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_ot_minimum, customers_status_public, customers_status_show_price, customers_status_show_price_tax, customers_status_qty_discounts, customers_status_payment) VALUES (1, 3, 'Admin', 'smile-yellow.gif', '0.00', '0', '0.00', '0.00', '0', '1', '1', '1', '')") or die ("<b>".NOTUPDATED . $prefix_table . "customers_status</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "customers_status (customers_status_languages_id, customers_status_name, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_ot_minimum, customers_status_public, customers_status_show_price, customers_status_show_price_tax, customers_status_qty_discounts, customers_status_payment) VALUES (1, 6, 'Admin', 'smile-yellow.gif', '0.00', '0', '0.00', '0.00', '0', '1', '1', '1', '')") or die ("<b>".NOTUPDATED . $prefix_table . "customers_status</b>");

echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . "customers_status " . UPDATED .'</font>';


$table = $prefix_table . 'configuration';

$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'1\', \'0\'),' WHERE set_function = 'oos_cfg_select_option(array(\'true\', \'false\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'1\', \'0\'),' WHERE set_function = 'oos_cfg_select_option(array(\'True\', \'False\'),'");

$result = $db->Execute("UPDATE " . $table . " SET configuration_value = '1' WHERE configuration_value = 'true'");
$result = $db->Execute("UPDATE " . $table . " SET configuration_value = '1' WHERE configuration_value = 'True'");
$result = $db->Execute("UPDATE " . $table . " SET configuration_value = '0' WHERE configuration_value = 'false'");
$result = $db->Execute("UPDATE " . $table . " SET configuration_value = '0' WHERE configuration_value = 'False'");


$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_textarea(' WHERE set_function = 'oosCfgTextarea('");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_pull_down_country_list(' WHERE set_function = 'oosCfgPullDownCountryList('");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_pull_down_zone_list(' WHERE set_function = 'oosCfgPullDownZoneList('");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'1\', \'0\'),' WHERE set_function = 'oosCfgSelectOption(array(\'true\', \'false\'),'");

$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'and\', \'or\'),' WHERE set_function = 'oosCfgSelectOption(array(\'and\', \'or\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'1\', \'0\'),' WHERE set_function = 'oosCfgSelectOption(array(\'True\', \'False\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'sendmail\', \'smtp\'),' WHERE set_function = 'oosCfgSelectOption(array(\'sendmail\', \'smtp\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'products_name\', \'date_expected\'),' WHERE set_function = 'oosCfgSelectOption(array(\'products_name\', \'date_expected\'),'");

$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'Path and article\', \'only article\', \'no additives\'),' WHERE set_function = 'oosCfgSelectOption(array(\'Path and article\', \'only article\', \'no additives\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'None\', \'Standard\', \'Credit Note\'),' WHERE set_function = 'oosCfgSelectOption(array(\'None\', \'Standard\', \'Credit Note\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'no-cache\', \'cache\'),' WHERE set_function = 'oosCfgSelectOption(array(\'no-cache\', \'cache\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'None\', \'Standard\', \'Credit Note\'),' WHERE set_function = 'oosCfgSelectOption(array(\'None\', \'Standard\', \'Credit Note\'),'");

$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'LF\', \'CRLF\'),' WHERE set_function = 'oosCfgSelectOption(array(\'LF\', \'CRLF\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'national\', \'international\', \'both\'),' WHERE set_function = 'oosCfgSelectOption(array(\'national\', \'international\', \'both\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'Meta Tag with categories edit\', \'description tag by category description replace\', \'no description tag per category\'),' WHERE set_function = 'oosCfgSelectOption(array(\'Meta Tag with categories edit\', \'description tag by category description replace\', \'no description tag per category\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'asc\', \'desc\'),' WHERE set_function = 'oosCfgSelectOption(array(\'asc\', \'desc\'),'");

$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'1\', \'fck\', \'0\'),' WHERE set_function = 'oosCfgSelectOption(array(\'true\', \'fck\', \'false\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'Meta Tag with article edit\', \'description tag by article description replace\', \'no description tag per article\'),' WHERE set_function = 'oosCfgSelectOption(array(\'Meta Tag with article edit\', \'description tag by article description replace\', \'no description tag per article\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_select_option(array(\'INDEX,FOLLOW\', \'INDEX,NOFOLLOW\', \'NOINDEX,FOLLOW\', \'NOINDEX,NOFOLLOW\'),' WHERE set_function = 'oosCfgSelectOption(array(\'INDEX,FOLLOW\', \'INDEX,NOFOLLOW\', \'NOINDEX,FOLLOW\', \'NOINDEX,NOFOLLOW\'),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_pull_down_zone_classes(' WHERE set_function = 'oosCfgPullDownZoneClasses('");

$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_pull_down_tax_classes(' WHERE set_function = 'oosCfgPullDownTaxClasses('");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_pull_down_order_statuses(' WHERE set_function = 'oosCfgPullDownOrderStatuses('");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_cfg_pull_down_country_list(' WHERE set_function = 'oosCfgPullDownCountryList('");


$result = $db->Execute("UPDATE " . $table . " SET use_function = 'oos_cfg_get_zone_class_title' WHERE use_function = 'oosCfgGetZoneClassTitle'");
$result = $db->Execute("UPDATE " . $table . " SET use_function = 'oos_cfg_get_order_status_name' WHERE use_function = 'oosCfgGetOrderStatusName'");
$result = $db->Execute("UPDATE " . $table . " SET use_function = 'oos_cfg_get_tax_class_title' WHERE use_function = 'oosCfgGetTaxClassTitle'");
$result = $db->Execute("UPDATE " . $table . " SET use_function = 'oos_cfg_get_country_name' WHERE use_function = 'oosCfgGetCountryName'");
$result = $db->Execute("UPDATE " . $table . " SET use_function = 'oos_cfg_get_zone_name' WHERE use_function = 'oosCfgGetZoneName'");


$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SKYPE_ME', '', 1, 19, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_PRODUCTS_UNITS_ID', '1', 6, 0, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_LIST_UVP', '0', 8, 5, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_VAT_ID', '1', 5, 9, NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'1\', \'0\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_OWNER_VAT_ID', '', 1, 4, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_CAMPAIGNS_ID', '1', 6, 0, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
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


$table = $prefix_table . 'customers';
$result = $db->Execute("ALTER TABLE " . $table . " ADD `customers_language` VARCHAR(3) AFTER `customers_login`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " ADD `customers_vat_id` VARCHAR(20) AFTER `customers_default_address_id`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " ADD `customers_vat_id_status` TINYINT DEFAULT '0' NOTNULL AFTER `customers_vat_id`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}



$table = $prefix_table . 'information';
$result = $db->Execute("ALTER TABLE " . $table . " DROP `information_name`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}

$table = $prefix_table . 'products';
$result = $db->Execute("ALTER TABLE " . $table . " ADD `products_zoomify` VARCHAR(64) AFTER `products_subimage6`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " ADD `products_movie` VARCHAR(64) AFTER `products_subimage6`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " ADD `products_units_id` INT( 11 ) DEFAULT '0' NOT NULL AFTER `products_tax_class_id`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " ADD `products_access` INT( 11 ) DEFAULT '0' NOT NULL AFTER `products_weight`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}


$result = $db->Execute("ALTER TABLE " . $table . " CHANGE `products_quantity_order_min` `products_quantity_order_min` DECIMAL( 10, 2 ) DEFAULT '1' NOT NULL ");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

 $result = $db->Execute("ALTER TABLE " . $table . " CHANGE `products_discount1_qty` `products_discount1_qty` DECIMAL( 10, 2 ) DEFAULT '0' NOT NULL ");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " CHANGE `products_discount2_qty` `products_discount2_qty` DECIMAL( 10, 2 ) DEFAULT '0' NOT NULL ");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " CHANGE `products_discount3_qty` `products_discount3_qty` DECIMAL( 10, 2 ) DEFAULT '0' NOT NULL ");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " CHANGE `products_discount4_qty` `products_discount4_qty` DECIMAL( 10, 2 ) DEFAULT '0' NOT NULL ");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " ADD `permissions` TINYINT DEFAULT '0' NOTNULL AFTER `manufacturers_id`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " ADD `products_quantity_decimal` TINYINT DEFAULT '0' NOTNULL AFTER `products_ordered`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}


$table = $prefix_table . 'customers_basket';
$result = $db->Execute("ALTER TABLE " . $table . " CHANGE `customers_basket_quantity` `customers_basket_quantity` DECIMAL( 10, 2 ) NOT NULL");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

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



$table = $prefix_table . 'orders';
$result = $db->Execute("ALTER TABLE " . $table . " ADD `campaigns` SMALLINT( 6 ) NOT NULL AFTER `date_purchased`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}


$table = $prefix_table . 'orders_products';
$result = $db->Execute("ALTER TABLE " . $table . " CHANGE `products_quantity` `products_quantity` DECIMAL( 10, 2 ) NOT NULL");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}



$table = $prefix_table . 'block';
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_block_select_option(array(\'left\', \'right\'),' WHERE set_function = 'oosBlockSelectOption(array(\'left\', \'right\',),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_block_select_option(array(\'left\', \'right\'),' WHERE set_function = 'oosBlockSelectOption(array(\'left\', \'right\', \'header\',),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_block_select_option(array(\'left\', \'right\'),' WHERE set_function = 'oosBlockSelectOption(array(\'left\', \'right\', ),'");
$result = $db->Execute("UPDATE " . $table . " SET set_function = 'oos_block_select_option(array(\'left\', \'right\'),' WHERE set_function = 'oosBlockSelectOption(array(\'left\', \'right\'),'");



$table = $prefix_table . 'products_options_types';
$result = $db->Execute("INSERT INTO " . $table . " (products_options_types_id, products_options_types_languages_id, products_options_types_name) VALUES (8, 2, 'Textarea')") or die ("<b>".NOTUPDATED . $prefix_table . "products_options_types</b>");
$result = $db->Execute("INSERT INTO " . $table . " (products_options_types_id, products_options_types_languages_id, products_options_types_name) VALUES (8, 1, 'Textarea')") or die ("<b>".NOTUPDATED . $prefix_table . "products_options_types</b>");
$result = $db->Execute("INSERT INTO " . $table . " (products_options_types_id, products_options_types_languages_id, products_options_types_name) VALUES (8, 6, 'Textarea')") or die ("<b>".NOTUPDATED . $prefix_table . "products_options_types</b>");
$result = $db->Execute("INSERT INTO " . $table . " (products_options_types_id, products_options_types_languages_id, products_options_types_name) VALUES (8, 3, 'Textarea')") or die ("<b>".NOTUPDATED . $prefix_table . "products_options_types</b>");

echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . "products_options_types " . UPDATED .'</font>';


?>