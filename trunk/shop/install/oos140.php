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

require 'oostables140.php';


$table = $prefix_table . 'configuration';
$aKeys = array('EMAIL_FROM',
               'SEND_EMAILS',
               'SEND_EXTRA_ORDER_EMAILS_TO',
               'SEND_BANKINFO_TO_ADMIN',
               'EMAIL_TRANSPORT',
               'EMAIL_LINEFEED',
               'EMAIL_USE_HTML',
               'ENTRY_EMAIL_ADDRESS_CHECK',
               'OOS_META_DETAILS',
               'OOS_META_LANGUAGE',
               'SEARCH_ENGINE_FRIENDLY_URLS',
               'DOWN_FOR_MAINTENANCE_NO_STORE',
               'DOWN_FOR_MAINTENANCE',
               'DOWN_FOR_MAINTENANCE_NO_PRICES',
               'DOWN_FOR_MAINTENANCE_LOGIN_OFF',
               'CUSTOMER_MUST_LOGIN',
               'ALLOW_AUTOLOGON', 
               'FEATURED_PRODUCTS_DISPLAY',
               'GZIP_COMPRESSION',
               'REVIEW_TEXT_MIN_LENGTH_TITLE',
               'MIN_DISPLAY_NEW_SPEZILAS_TITLE',
               'MAX_DISPLAY_SPECIAL_PRODUCTS_TITLE',
               'MAX_DISPLAY_NEW_REVIEWS_TITLE',
               'MAX_RANDOM_SELECT_REVIEWS_TITLE',
               'MAX_RANDOM_SELECT_NEW_TITLE',
               'MAX_RANDOM_SELECT_SPECIALS_TITLE',
               'MAX_DISPLAY_NEW_SPEZILAS_TITLE',
               'MAX_DISPLAY_FEATURED_PRODUCTS_TITLE',
               'MAX_DISPLAY_FEATURED_PRODUCTS_TITLE',
               'MAX_DISPLAY_FEATURED_PRODUCTS_DESC',
               'MAX_DISPLAY_FEATURED_PRODUCTS_TITLE',
               'MAX_DISPLAY_MANUFACTURERS_IN_A_LIST',
               'MAX_MANUFACTURERS_LIST',
               'MAX_DISPLAY_MANUFACTURER_NAME_LEN',
               'WEB_PRINTER',
               'WEB_PRINTER_EMAIL',
               'WEB_PRINTER_FTP',
               'WEB_PRINTER_XML',
               'MIN_DISPLAY_NEW_NEWS',
               'DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE',
               'DOWNLOADS_CONTROLLER_ON_HOLD_MSG',
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
               'PDF_TO_MM_FACTOR',
               'MAX_DISPLAY_WISHLIST_PRODUCTS',
               'MAX_DISPLAY_WISHLIST_BOX',
               'BLOCK_WISHLIST_IMAGE',
               'OOS_SPAW',
               'OOS_IMAGE_SWF',
               'OOS_SWF_MOVIECLIP',
               'OOS_SWF_BGCOLOUR_R',
               'OOS_SWF_BGCOLOUR_G',
               'OOS_SWF_BGCOLOUR_B',
               'CATEGORIES_BOX_SCROLL_LIST_ON',
               'CATEGORIES_SCROLL_BOX_LEN',
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
               'AFFILIATE_OWNER_TITLE',
               'AFFILIATE_EMAIL_ADDRESS_TITLE',
               'AFFILIATE_PERCENT_TITLE',
               'AFFILIATE_THRESHOLD_TITLE',
               'AFFILIATE_BILLING_TIME_TITLE',
               'AFFILIATE_COOKIE_LIFETIME_TITLE',
               'AFFILIATE_PAYMENT_ORDER_MIN_STATUS_TITLE',
               'AFFILIATE_USE_CHECK_TITLE',
               'AFFILIATE_USE_PAYPAL_TITLE',
               'AFFILIATE_USE_BANK_TITLE',
               'AFFILATE_INDIVIDUAL_PERCENTAGE_TITLE',
               'AFFILIATE_OWNER_TITLE',
               'AFFILIATE_OWNER_DESC',
               'GZIP_LEVEL');
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




$table = $prefix_table . 'admin_files';
$result = $db->Execute("DELETE FROM " . $table . " WHERE admin_files_name = 'create_spider_site'");

$result = $db->Execute("DELETE FROM " . $table . " WHERE admin_files_name = 'backup'");


// products_units.php
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('products_units', 0, 3, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

// products_attributes_add.php
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('products_attributes_add', 0, 3, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

// excel.php
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('export_excel', 0, 3, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('import_excel', 0, 3, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

// export_stampit.php
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('export_stampit', 0, 6, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");


// popup_google_map.php
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('popup_google_map', 0, 6, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

// campaigns
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('campaigns', 0, 6, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");


// reports
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('stats_referer', 0, 16, 0)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

// information.php
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('information.php', 1, 0, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('information', 0, 18, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

// plugins.php
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('plugins.php', 1, 0, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('plugins', 0, 19, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('export_googlebase', 0, 18, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "admin_files (admin_files_name, admin_files_is_boxes, admin_files_to_boxes, admin_groups_id) VALUES ('export_kelkoo', 0, 18, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "admin_files</b>");

echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . "admin_files " . UPDATED .'</font>';


$result = $db->Execute("INSERT INTO " . $prefix_table . "information (information_id, information_image, sort_order, date_added, last_modified, status) VALUES (1, 'specials.png', '1', " . $db->DBTimeStamp($today) . ", '' , '1' )") or die ("<b>".NOTUPDATED . $prefix_table . "information</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information (information_id, information_image, sort_order, date_added, last_modified, status) VALUES (2, 'specials.png', '1', " . $db->DBTimeStamp($today) . ", '' , '1' )") or die ("<b>".NOTUPDATED . $prefix_table . "information</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information (information_id, information_image, sort_order, date_added, last_modified, status) VALUES (3, 'specials.png', '1', " . $db->DBTimeStamp($today) . ", '' , '1' )") or die ("<b>".NOTUPDATED . $prefix_table . "information</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information (information_id, information_image, sort_order, date_added, last_modified, status) VALUES (4, 'specials.png', '1', " . $db->DBTimeStamp($today) . ", '' , '1' )") or die ("<b>".NOTUPDATED . $prefix_table . "information</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information (information_id, information_image, sort_order, date_added, last_modified, status) VALUES (5, 'specials.png', '1', " . $db->DBTimeStamp($today) . ", '' , '1' )") or die ("<b>".NOTUPDATED . $prefix_table . "information</b>");

echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . "information " . UPDATED .'</font>';

$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (1, 1, '', 'Liefer- und Versandbedingungen', 'Liefer- und Versandbedingungen', 'F&uuml;gen Sie hier Ihre Liefer- und Versandbedingungen ein' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (1, 2, '', 'Shipping & Returns', 'Shipping & Returns', 'Put here your Shipping & Returns information' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (1, 3, '', 'Aflevering en terugname', 'Aflevering en terugname', 'Voeg hier uw informatie over de voorwaarden die gelden voor aflevering en terugname van onze produkten in' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (1, 4, '', 'Shipping & Returns', 'Shipping & Returns', 'Put here your Shipping & Returns information' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (1, 5, '', 'Shipping & Returns', 'Shipping & Returns', 'Put here your Shipping & Returns information' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (1, 6, '', 'Envios/Devoluciones', 'Envios/Devoluciones', 'Ponga aqui informacion sobre los Envios y Devoluciones' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (2, 1, '', 'Privatsph&auml;re und Datenschutz', 'Privatsph&auml;re und Datenschutz', 'F&uuml;gen Sie hier Ihre Informationen zur Privatsph&auml;re und Datenschutz ein' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (2, 2, '', 'Privacy Notice', 'Privacy Notice', 'Put here your Privacy Notice information' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (2, 3, '', 'Privacy', 'Privacy', 'Voer hier uw informatie over privacy en gegevensbescherming in' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (2, 4, '', 'Privacy Notice', 'Privacy Notice', 'Put here your Privacy Notice information' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (2, 5, '', 'Privacy Notice', 'Privacy Notice', 'Put here your Privacy Notice information' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (2, 6, '', 'Confidencialidad', 'Confidencialidad', 'Ponga aqui informacion sobre el tratamiento de los datos' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (3, 1, '', 'Unsere AGB', 'Unsere AGB', 'F&uuml;gen Sie hier Ihre AGB ein' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (3, 2, '', 'Conditions of Use', 'Conditions of Use', 'Put here your Conditions of Use information' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (3, 3, '', 'Leveringsvoorwaarden', 'Leveringsvoorwaarden', 'Voer hier uw algemene leveringsvoorwaarden in' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (3, 4, '', 'Conditions of Use', 'Conditions of Use', 'Put here your Conditions of Use information' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (3, 5, '', 'Conditions of Use', 'Conditions of Use', 'Put here your Conditions of Use information' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (3, 6, '', 'Condiciones de uso', 'Condiciones de uso', 'Ponga aqui sus condiciones de uso' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (4, 1, '', 'Impressum', 'Impressum', 'F&uuml;gen Sie hier Ihre Informationen zum Impressum ein.' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (4, 2, '', 'Imprint', 'Imprint', 'Put here your information about your company' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (4, 3, '', 'Bedrijsgegevens', 'Bedrijsgegevens', 'Voer hier uw informatie over deze impressie in' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (4, 4, '', 'Imprint', 'Imprint', 'Put here your information about your company' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (4, 5, '', 'Imprint', 'Imprint', 'Put here your information about your company' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (4, 6, '', 'Imprint', 'Imprint', 'Put here your information about your company' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (5, 1, '', 'Haftungsausschluss', 'Haftungsausschluss', 'F&uuml;gen Sie hier Ihren Haftungsausschluss ein' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (5, 2, '', 'Disclaimer', 'Disclaimer', 'Put here your Disclaimer' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (5, 3, '', 'Disclaimer', 'Disclaimer', 'Put here your Disclaimer' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (5, 4, '', 'Disclaimer', 'Disclaimer', 'Put here your Disclaimer' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (5, 5, '', 'Disclaimer', 'Disclaimer', 'Put here your Disclaimer' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "information_description (information_id, information_languages_id, information_url, information_name, information_heading_title, information_description) VALUES (5, 6, '', 'Disclaimer', 'Disclaimer', 'Put here your Disclaimer' )") or die ("<b>".NOTUPDATED . $prefix_table . "information_description</b>");


echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . "information_description " . UPDATED .'</font>';


$result = $db->Execute("INSERT INTO " . $prefix_table . "block (block_id, block_side, block_status, block_file, block_cache, block_type, block_sort_order, block_login_flag, date_added, last_modified, set_function) VALUES (32, 'left', 1, 'change_template', '', 1, 32, 0, " . $db->DBTimeStamp($today) . ",  NULL, 'oos_block_select_option(array(\'left\', \'right\',),')") or die ("<b>".NOTUPDATED . $prefix_table . "block</b>");
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


$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (32, 'deu', 'Templates')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (32, 'eng', 'Templates')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (32, 'nld', 'Templates')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (32, 'spa', 'Templates')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (33, 'deu', 'Skype')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (33, 'eng', 'Skype')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (33, 'nld', 'Skype')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (33, 'spa', 'Skype')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (34, 'deu', 'Werbung')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (34, 'eng', 'ads')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (34, 'nld', 'ads')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (34, 'spa', 'ads')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");

$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (35, 'deu', 'myworld')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (35, 'eng', 'myworld')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (35, 'nld', 'myworld')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_info (block_id, block_language, block_name) VALUES (35, 'spa', 'myworld')") or die ("<b>".NOTUPDATED . $prefix_table . "block_info</b>");

echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . 'block_info ' . UPDATED .'</font>';


$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (32, 1)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (32, 2)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (32, 3)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (32, 4)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (32, 5)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (32, 6)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (32, 7)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "block_to_page_type (block_id, page_type_id) VALUES (32, 8)") or die ("<b>".NOTUPDATED . $prefix_table . "block_to_page_type</b>");


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
}

$result = $db->Execute("INSERT INTO " . $prefix_table . "customers_status (customers_status_languages_id, customers_status_name, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_ot_minimum, customers_status_public, customers_status_show_price, customers_status_show_price_tax, customers_status_qty_discounts, customers_status_payment) VALUES (1, 1, 'Admin', 'smile-yellow.gif', '0.00', '0', '0.00', '0.00', '0', '1', '1', '1', '')") or die ("<b>".NOTUPDATED . $prefix_table . "customers_status</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "customers_status (customers_status_languages_id, customers_status_name, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_ot_minimum, customers_status_public, customers_status_show_price, customers_status_show_price_tax, customers_status_qty_discounts, customers_status_payment) VALUES (1, 2, 'Admin', 'smile-yellow.gif', '0.00', '0', '0.00', '0.00', '0', '1', '1', '1', '')") or die ("<b>".NOTUPDATED . $prefix_table . "customers_status</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "customers_status (customers_status_languages_id, customers_status_name, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_ot_minimum, customers_status_public, customers_status_show_price, customers_status_show_price_tax, customers_status_qty_discounts, customers_status_payment) VALUES (1, 3, 'Admin', 'smile-yellow.gif', '0.00', '0', '0.00', '0.00', '0', '1', '1', '1', '')") or die ("<b>".NOTUPDATED . $prefix_table . "customers_status</b>");
$result = $db->Execute("INSERT INTO " . $prefix_table . "customers_status (customers_status_languages_id, customers_status_name, customers_status_image, customers_status_discount, customers_status_ot_discount_flag, customers_status_ot_discount, customers_status_ot_minimum, customers_status_public, customers_status_show_price, customers_status_show_price_tax, customers_status_qty_discounts, customers_status_payment) VALUES (1, 6, 'Admin', 'smile-yellow.gif', '0.00', '0', '0.00', '0.00', '0', '1', '1', '1', '')") or die ("<b>".NOTUPDATED . $prefix_table . "customers_status</b>");

echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . "customers_status " . UPDATED .'</font>';


$table = $prefix_table . 'configuration';
$result = $db->Execute("ALTER TABLE " . $table . " DROP `configuration_title` , DROP `configuration_description`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}

$table = $prefix_table . 'configuration';
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MODULE_PLUGIN_EVENT_INSTALLED', 'session;language;customer_group;category_path;breadcrumb;whos_online;currencies;spezials;featured;banner;reviews', 6, 0, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_VAT_ID', 'true', 5, 9, NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'true\', \'false\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('STORE_OWNER_VAT_ID', '', 1, 4, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_CAMPAIGNS_ID', '1', 6, 0, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_LIST_SORT_ORDER', '0', 8, 9, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCT_LIST_UVP', '0', 8, 5, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('SKYPE_ME', '', 1, 19, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_PRODUCTS_UNITS_ID', '1', 6, 0, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('OOS_FCKEDITOR', 'true', 29, '2', NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'true\', \'false\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('PRODUCTS_OPTIONS_TYPE_TEXTAREA', '8', 6, 0, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('TEXTAREA_PREFIX', 'textarea_', 6, 0, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");

$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('NEW_PRODUCT_PREVIEW', 'false', 29, '2', NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'true\', \'false\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('OOS_PRICE_IS_BRUTTO', 'true', 29, '2', NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'true\', \'false\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('OOS_BASE_PRICE', 'false', 29, '2', NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'true\', \'false\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DECIMAL_CART_QUANTITY', 'false', 29, '2', NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'true\', \'false\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");

$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('ACCOUNT_COMPANY_VAT_ID_CHECK', 'true', 5, 12, NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'true\', \'false\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('MAKE_PASSWORD', 'true', 5, 12, NULL, " . $db->DBTimeStamp($today) . ", NULL, 'oos_cfg_select_option(array(\'true\', \'false\'),')") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");
$result = $db->Execute("INSERT INTO " . $table . " (configuration_key, configuration_value, configuration_group_id, sort_order, last_modified, date_added, use_function, set_function) VALUES ('DEFAULT_LANGUAGE_ID', '1', 6, 0, NULL, " . $db->DBTimeStamp($today) . ", NULL, NULL)") or die ("<b>".NOTUPDATED . $prefix_table . "configuration</b>");

echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . "configuration " . UPDATED .'</font>';


$table = $prefix_table . 'configuration_group';
$result = $db->Execute("ALTER TABLE " . $table . " DROP `configuration_group_title` , DROP `configuration_group_description`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
} else {
  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $table . ' ' . UPDATED .'</font>';
}


$table = $prefix_table . 'customers';
$result = $db->Execute("ALTER TABLE " . $table . " ADD `customers_language` VARCHAR(3) AFTER `customers_login`");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

$result = $db->Execute("ALTER TABLE " . $table . " ADD `customers_image` VARCHAR(64) AFTER `customers_lastname`");
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



$table = $prefix_table . 'products';
$result = $db->Execute("ALTER TABLE " . $table . " ADD `products_sort_order` INT(5) NOT NULL");
if ($result === false) {
  echo '<br /><img src="images/no.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-error">' .  $db->ErrorMsg() . NOTMADE . '</font>';
}

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

require 'lang_upgrade.php';
require 'configuration_upgrade.php';

$table = $prefix_table . 'products_options_types';
$result = $db->Execute("INSERT INTO " . $table . " (products_options_types_id, products_options_types_languages_id, products_options_types_name) VALUES (8, 2, 'Textarea')") or die ("<b>".NOTUPDATED . $prefix_table . "products_options_types</b>");
$result = $db->Execute("INSERT INTO " . $table . " (products_options_types_id, products_options_types_languages_id, products_options_types_name) VALUES (8, 1, 'Textarea')") or die ("<b>".NOTUPDATED . $prefix_table . "products_options_types</b>");
$result = $db->Execute("INSERT INTO " . $table . " (products_options_types_id, products_options_types_languages_id, products_options_types_name) VALUES (8, 6, 'Textarea')") or die ("<b>".NOTUPDATED . $prefix_table . "products_options_types</b>");
$result = $db->Execute("INSERT INTO " . $table . " (products_options_types_id, products_options_types_languages_id, products_options_types_name) VALUES (8, 3, 'Textarea')") or die ("<b>".NOTUPDATED . $prefix_table . "products_options_types</b>");

echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle">&nbsp;<font class="oos-title">' . $prefix_table . "products_options_types " . UPDATED .'</font>';


?>