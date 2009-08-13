<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: advanced_search.php,v 1.49 2003/02/13 04:23:22 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

function oos_get_manufacturers($aManufacturers = '') {

    if (!is_array($aManufacturers)) $aManufacturers = array();

    $dbconn =& oosDBGetConn();
    $oostable = oosDBGetTables();

    $manufacturers_result = $dbconn->Execute("SELECT manufacturers_id, manufacturers_name FROM " . $oostable['manufacturers'] . " ORDER BY manufacturers_name");
    while ($manufacturers = $manufacturers_result->fields)
    {
        $aManufacturers[] = array('id' => $manufacturers['manufacturers_id'], 'text' => $manufacturers['manufacturers_name']);
        $manufacturers_result->MoveNext();
    }
    return $aManufacturers;
}


require 'includes/languages/' . $sLanguage . '/search_advanced.php';

// links breadcrumb
$oBreadcrumb->add($aLang['navbar_title'], oos_href_link($aPages['advanced_search']));

ob_start();
require 'js/advanced_search.js.php';
$javascript = ob_get_contents();
ob_end_clean();

$info_message = '';
if (isset($_GET['errorno'])) {
    if (($_GET['errorno'] & 1) == 1) {
        $info_message = str_replace('\n', '<br />', $aLang['js_at_least_one_input']);
    }
    if (($_GET['errorno'] & 10) == 10) {
        $info_message = str_replace('\n', '<br />', $aLang['js_invalid_from_date']);
    }
    if (($_GET['errorno'] & 100) == 100) {
        $info_message = str_replace('\n', '<br />', $aLang['js_invalid_to_date']);
    }
    if (($_GET['errorno'] & 1000) == 1000) {
        $info_message = str_replace('\n', '<br />', $aLang['js_to_date_less_than_from_date']);
    }
    if (($_GET['errorno'] & 10000) == 10000) {
        $info_message = str_replace('\n', '<br />', $aLang['js_price_from_must_be_num']);
    }
    if (($_GET['errorno'] & 100000) == 100000) {
        $info_message = str_replace('\n', '<br />', $aLang['js_price_to_must_be_num']);
    }
    if (($_GET['errorno'] & 1000000) == 1000000) {
        $info_message = str_replace('\n', '<br />', $aLang['js_price_to_less_than_price_from']);
    }
    if (($_GET['errorno'] & 10000000) == 10000000) {
        $info_message = str_replace('\n', '<br />', $aLang['js_invalid_keywords']);
    }
}

$pull_down_menu_categories =  oos_draw_pull_down_menu('categories_id', oos_get_categories(array(array('id' => '', 'text' => $aLang['text_all_categories']))), '', 'id="categories"');
$pull_down_menu_manufacturers =  oos_draw_pull_down_menu('manufacturers_id', oos_get_manufacturers(array(array('id' => '', 'text' => $aLang['text_all_manufacturers']))), '', 'id="manufacturers"');

/*
$options_box .= '  <tr>' . "\n" .
                  '    <td class="fieldKey">' . $aLang['entry_date_from'] . '</td>' . "\n" .
                  '    <td class="fieldValue">' . oos_draw_input_field('dfrom', DOB_FORMAT_STRING, 'onFocus="RemoveFormatString(this, \'' . DOB_FORMAT_STRING . '\')"') . '</td>' . "\n" .
                  '  </tr>' . "\n" .
                  '  <tr>' . "\n" .
                  '    <td class="fieldKey">' . $aLang['entry_date_to'] . '</td>' . "\n" .
                  '    <td class="fieldValue">' . oos_draw_input_field('dto', DOB_FORMAT_STRING, 'onFocus="RemoveFormatString(this, \'' . DOB_FORMAT_STRING . '\')"') . '</td>' . "\n" .
                  '  </tr>' . "\n";
*/

$aOption['template_main'] = $sTheme . '/modules/advanced_search.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';
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
          'oos_heading_image' => 'browse.gif',

          'info_message'      => $info_message,

          'pull_down_menu_categories'    => $pull_down_menu_categories,
          'pull_down_menu_manufacturers' => $pull_down_menu_manufacturers,

          'oos_js'            => $javascript
      )
);

$oSmarty->assign('oosBreadcrumb', $oSmarty->fetch($aOption['breadcrumb']));
$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

