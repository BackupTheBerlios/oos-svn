<?php
/* ----------------------------------------------------------------------
   $Id: geo_zones.php,v 1.71 2007/05/08 16:18:59 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: geo_zones.php,v 1.25 2002/04/17 23:09:03 hpdl 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  define('OOS_VALID_MOD', 'yes');
  require 'includes/oos_main.php';

 /**
  * Return Geo Zone Name
  *
  * @param $geo_zone_id
  * @return string
  */
  function oosGetGeoZoneName($geo_zone_id) {

    // Get database information
    $dbconn =& oosDBGetConn();
    $oostable =& oosDBGetTables();

    $geo_zonestable = $oostable['geo_zones'];
    $zones_sql = "SELECT geo_zone_name
                  FROM $geo_zonestable
                  WHERE geo_zone_id = '" . $geo_zone_id . "'";
    $result = $dbconn->Execute($zones_sql);

    if (!$result->RecordCount()) {
      $geo_zone_name = $geo_zone_id;
    } else {
      $zones = $result->fields;
      $geo_zone_name = $zones['geo_zone_name'];
    }

    // Close result set
    $result->Close();

    return $geo_zone_name;
  }

  $saction = (isset($_GET['saction']) ? $_GET['saction'] : '');

  if (oos_is_not_null($saction)) {
    switch ($saction) {
      case 'insert_sub':
        $zID = oos_db_prepare_input($_GET['zID']);
        $zone_country_id = oos_db_prepare_input($_POST['zone_country_id']);
        $zone_id = oos_db_prepare_input($_POST['zone_id']);

        $zones_to_geo_zonestable = $oostable['zones_to_geo_zones'];
        $dbconn->Execute("INSERT INTO $zones_to_geo_zonestable (zone_country_id, zone_id, geo_zone_id, date_added) VALUES ('" . oos_db_input($zone_country_id) . "', '" . oos_db_input($zone_id) . "', '" . oos_db_input($zID) . "', now())");
        $new_subzone_id = $dbconn->Insert_ID();

        oos_redirect_admin(oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $new_subzone_id));
        break;

    case 'save_sub':
        $sID = oos_db_prepare_input($_GET['sID']);
        $zID = oos_db_prepare_input($_GET['zID']);
        $zone_country_id = oos_db_prepare_input($_POST['zone_country_id']);
        $zone_id = oos_db_prepare_input($_POST['zone_id']);

        $zones_to_geo_zonestable = $oostable['zones_to_geo_zones'];
        $dbconn->Execute("UPDATE $zones_to_geo_zonestable SET geo_zone_id = '" . oos_db_input($zID) . "', zone_country_id = '" . oos_db_input($zone_country_id) . "', zone_id = " . ((oos_db_input($zone_id)) ? "'" . oos_db_input($zone_id) . "'" : 'null') . ", last_modified = now() WHERE association_id = '" . oos_db_input($sID) . "'");

        oos_redirect_admin(oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $_GET['sID']));
        break;

    case 'deleteconfirm_sub':
        $sID = oos_db_prepare_input($_GET['sID']);

        $zones_to_geo_zonestable = $oostable['zones_to_geo_zones'];
        $dbconn->Execute("DELETE FROM $zones_to_geo_zonestable WHERE association_id = '" . oos_db_input($sID) . "'");

        oos_redirect_admin(oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage']));
        break;
    }
  }

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (!empty($action)) {
    switch ($action) { 
      case 'insert_zone':
        $geo_zone_name = oos_db_prepare_input($_POST['geo_zone_name']);
        $geo_zone_description = oos_db_prepare_input($_POST['geo_zone_description']);

        $geo_zonestable = $oostable['geo_zones'];
        $dbconn->Execute("INSERT INTO $geo_zonestable (geo_zone_name, geo_zone_description, date_added) VALUES ('" . oos_db_input($geo_zone_name) . "', '" . oos_db_input($geo_zone_description) . "', now())");
        $new_zone_id = $dbconn->Insert_ID();

        oos_redirect_admin(oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $new_zone_id));
        break;

    case 'save_zone':
        $zID = oos_db_prepare_input($_GET['zID']);
        $geo_zone_name = oos_db_prepare_input($_POST['geo_zone_name']);
        $geo_zone_description = oos_db_prepare_input($_POST['geo_zone_description']);

        $geo_zonestable = $oostable['geo_zones'];
        $dbconn->Execute("UPDATE $geo_zonestable SET geo_zone_name = '" . oos_db_input($geo_zone_name) . "', geo_zone_description = '" . oos_db_input($geo_zone_description) . "', last_modified = now() WHERE geo_zone_id = '" . oos_db_input($zID) . "'");

        oos_redirect_admin(oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID']));
        break;

    case 'deleteconfirm_zone':
        $zID = oos_db_prepare_input($_GET['zID']);

        $geo_zonestable = $oostable['geo_zones'];
        $zones_to_geo_zonestable = $oostable['zones_to_geo_zones'];
        $dbconn->Execute("DELETE FROM $geo_zonestable WHERE geo_zone_id = '" . oos_db_input($zID) . "'");
        $dbconn->Execute("DELETE FROM $zones_to_geo_zonestable WHERE geo_zone_id = '" . oos_db_input($zID) . "'");

        oos_redirect_admin(oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage']));
        break;
    }
  }
  require 'includes/oos_header.php';

  if (isset($_GET['zID'])  && (($saction == 'edit') || ($saction == 'new'))) {
?>
<script language="javascript"><!--
function resetZoneSelected(theForm) {
  if (theForm.state.value != '') {
    theForm.zone_id.selectedIndex = '0';
    if (theForm.zone_id.options.length > 0) {
      theForm.state.value = '<?php echo JS_STATE_SELECT; ?>';
    }
  }
}

function update_zone(theForm) {
  var NumState = theForm.zone_id.options.length;
  var SelectedCountry = "";

  while(NumState > 0) {
    NumState--;
    theForm.zone_id.options[NumState] = null;
  }

  SelectedCountry = theForm.zone_country_id.options[theForm.zone_country_id.selectedIndex].value;

<?php echo oos_is_zone_list('SelectedCountry', 'theForm', 'zone_id'); ?>

}
//--></script>
<?php
  }
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
            <td class="pageHeading"><?php echo HEADING_TITLE; if (isset($_GET['zone'])) echo '<br /><span class="smallText">' . oosGetGeoZoneName($_GET['zone']) . '</span>'; ?></td>
            <td class="pageHeading" align="right"><?php echo oos_draw_separator('trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
<?php
  if ($action == 'list') {
?>
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_COUNTRY; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_COUNTRY_ZONE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $rows = 0;
    $zones_result_raw = "SELECT a.association_id, a.zone_country_id, c.countries_name, a.zone_id, a.geo_zone_id, a.last_modified, a.date_added, z.zone_name FROM " . $oostable['zones_to_geo_zones'] . " a left join " . $oostable['countries'] . " c on a.zone_country_id = c.countries_id left join " . $oostable['zones'] . " z on a.zone_id = z.zone_id WHERE a.geo_zone_id = " . $_GET['zID'] . " ORDER BY association_id";
    $zones_split = new splitPageResults($_GET['spage'], MAX_DISPLAY_SEARCH_RESULTS, $zones_result_raw, $zones_result_numrows);
    $zones_result = $dbconn->Execute($zones_result_raw);
    while ($zones = $zones_result->fields) {
      $rows++;
      if ((!isset($_GET['sID']) || (isset($_GET['sID']) && ($_GET['sID'] == $zones['association_id']))) && !isset($sInfo) && (substr($saction, 0, 3) != 'new')) {
        $sInfo = new objectInfo($zones);
      }
      if (isset($sInfo) && is_object($sInfo) && ($zones['association_id'] == $sInfo->association_id)) {
        echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id . '&saction=edit') . '\'">' . "\n";
      } else {
        echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $zones['association_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo (($zones['countries_name']) ? $zones['countries_name'] : TEXT_ALL_COUNTRIES); ?></td>
                <td class="dataTableContent"><?php echo (($zones['zone_id']) ? $zones['zone_name'] : PLEASE_SELECT); ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($sInfo) && is_object($sInfo) && ($zones['association_id'] == $sInfo->association_id) ) { echo oos_image(OOS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $zones['association_id']) . '">' . oos_image(OOS_IMAGES . 'icon_information.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
      // Move that ADOdb pointer!
      $zones_result->MoveNext();
    }

    // Close result set
    $zones_result->Close();
?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $zones_split->display_count($zones_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['spage'], TEXT_DISPLAY_NUMBER_OF_COUNTRIES); ?></td>
                    <td class="smallText" align="right"><?php echo $zones_split->display_links($zones_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['spage'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list', 'spage'); ?></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="right" colspan="3"><?php if (empty($saction)) echo '<a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID']) . '">' . oos_image_swap_button('back','back_off.gif', IMAGE_BACK) . '</a> <a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id . '&saction=new') . '">' . oos_image_swap_button('insert','insert_off.gif', IMAGE_INSERT) . '</a>'; ?></td>
              </tr>
            </table>
<?php
  } else {
?>
            <table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TAX_ZONES; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $geo_zonestable = $oostable['geo_zones'];
    $zones_result_raw = "SELECT geo_zone_id, geo_zone_name, geo_zone_description, last_modified, date_added 
                        FROM $geo_zonestable
                        ORDER BY geo_zone_name";
    $zones_split = new splitPageResults($_GET['zpage'], MAX_DISPLAY_SEARCH_RESULTS, $zones_result_raw, $zones_result_numrows);
    $zones_result = $dbconn->Execute($zones_result_raw);
    while ($zones = $zones_result->fields) {
      if ((!isset($_GET['zID']) || (isset($_GET['zID']) && ($_GET['zID'] == $zones['geo_zone_id']))) && !isset($zInfo) && (substr($action, 0, 3) != 'new')) {
        $zInfo = new objectInfo($zones);
      }
      if (isset($zInfo) && is_object($zInfo) && ($zones['geo_zone_id'] == $zInfo->geo_zone_id) ) {
        echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id . '&action=list') . '\'">' . "\n";
      } else {
        echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $zones['geo_zone_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $zones['geo_zone_id'] . '&action=list') . '">' . oos_image(OOS_IMAGES . 'icons/folder.gif', ICON_FOLDER) . '</a>&nbsp;' . $zones['geo_zone_name']; ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($zInfo) && is_object($zInfo) && ($zones['geo_zone_id'] == $zInfo->geo_zone_id) ) { echo oos_image(OOS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $zones['geo_zone_id']) . '">' . oos_image(OOS_IMAGES . 'icon_information.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
      // Move that ADOdb pointer!
      $zones_result->MoveNext();
    }

    // Close result set
    $zones_result->Close();
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText"><?php echo $zones_split->display_count($zones_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['zpage'], TEXT_DISPLAY_NUMBER_OF_TAX_ZONES); ?></td>
                    <td class="smallText" align="right"><?php echo $zones_split->display_links($zones_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['zpage'], '', 'zpage'); ?></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="right" colspan="2"><?php if (empty($action)) echo '<a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id . '&action=new_zone') . '">' . oos_image_swap_button('insert','insert_off.gif', IMAGE_INSERT) . '</a>'; ?></td>
              </tr>
            </table>
<?php
  }
?>
            </td>
<?php
  $heading = array();
  $contents = array();

  if ($action == 'list') {
    switch ($saction) {
      case 'new':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_SUB_ZONE . '</b>');

        $contents = array('form' => oos_draw_form('zones', $aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $_GET['sID'] . '&saction=insert_sub'));
        $contents[] = array('text' => TEXT_INFO_NEW_SUB_ZONE_INTRO);
        $contents[] = array('text' => '<br />' . TEXT_INFO_COUNTRY . '<br />' . oos_draw_pull_down_menu('zone_country_id', oos_get_countries(TEXT_ALL_COUNTRIES), '', 'onChange="update_zone(this.form);"'));
        $contents[] = array('text' => '<br />' . TEXT_INFO_COUNTRY_ZONE . '<br />' . oos_draw_pull_down_menu('zone_id', oos_prepare_country_zones_pull_down()));
        $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('insert','insert_off.gif', IMAGE_INSERT) . ' <a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $_GET['sID']) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
        break;

      case 'edit':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_SUB_ZONE . '</b>');

        $contents = array('form' => oos_draw_form('zones', $aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id . '&saction=save_sub'));
        $contents[] = array('text' => TEXT_INFO_EDIT_SUB_ZONE_INTRO);
        $contents[] = array('text' => '<br />' . TEXT_INFO_COUNTRY . '<br />' . oos_draw_pull_down_menu('zone_country_id', oos_get_countries(TEXT_ALL_COUNTRIES), $sInfo->zone_country_id, 'onChange="update_zone(this.form);"'));
        $contents[] = array('text' => '<br />' . TEXT_INFO_COUNTRY_ZONE . '<br />' . oos_draw_pull_down_menu('zone_id', oos_prepare_country_zones_pull_down($sInfo->zone_country_id), $sInfo->zone_id));
        $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('update','update_off.gif', IMAGE_UPDATE) . ' <a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
        break;

      case 'delete':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_SUB_ZONE . '</b>');

        $contents = array('form' => oos_draw_form('zones', $aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id . '&saction=deleteconfirm_sub'));
        $contents[] = array('text' => TEXT_INFO_DELETE_SUB_ZONE_INTRO);
        $contents[] = array('text' => '<br /><b>' . $sInfo->countries_name . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('delete','delete_off.gif', IMAGE_DELETE) . ' <a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
        break;

      default:
        if (isset($sInfo) && is_object($sInfo)) {
          $heading[] = array('text' => '<b>' . $sInfo->countries_name . '</b>');

          $contents[] = array('align' => 'center', 'text' => '<a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id . '&saction=edit') . '">' . oos_image_swap_button('edit','edit_off.gif', IMAGE_EDIT) . '</a> <a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=list&spage=' . $_GET['spage'] . '&sID=' . $sInfo->association_id . '&saction=delete') . '">' . oos_image_swap_button('delete','delete_off.gif', IMAGE_DELETE) . '</a>');
          $contents[] = array('text' => '<br />' . TEXT_INFO_DATE_ADDED . ' ' . oos_date_short($sInfo->date_added));
          if (oos_is_not_null($sInfo->last_modified)) $contents[] = array('text' => TEXT_INFO_LAST_MODIFIED . ' ' . oos_date_short($sInfo->last_modified));
        }
        break;
    }
  } else {
    switch ($action) {
      case 'new_zone':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_ZONE . '</b>');

        $contents = array('form' => oos_draw_form('zones', $aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID'] . '&action=insert_zone'));
        $contents[] = array('text' => TEXT_INFO_NEW_ZONE_INTRO);
        $contents[] = array('text' => '<br />' . TEXT_INFO_ZONE_NAME . '<br />' . oos_draw_input_field('geo_zone_name'));
        $contents[] = array('text' => '<br />' . TEXT_INFO_ZONE_DESCRIPTION . '<br />' . oos_draw_input_field('geo_zone_description'));
        $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('insert','insert_off.gif', IMAGE_INSERT) . ' <a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $_GET['zID']) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
        break;

      case 'edit_zone':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_ZONE . '</b>');

        $contents = array('form' => oos_draw_form('zones', $aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id . '&action=save_zone'));
        $contents[] = array('text' => TEXT_INFO_EDIT_ZONE_INTRO);
        $contents[] = array('text' => '<br />' . TEXT_INFO_ZONE_NAME . '<br />' . oos_draw_input_field('geo_zone_name', $zInfo->geo_zone_name));
        $contents[] = array('text' => '<br />' . TEXT_INFO_ZONE_DESCRIPTION . '<br />' . oos_draw_input_field('geo_zone_description', $zInfo->geo_zone_description));
        $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('update','update_off.gif', IMAGE_UPDATE) . ' <a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
        break;

      case 'delete_zone':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ZONE . '</b>');

        $contents = array('form' => oos_draw_form('zones', $aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id . '&action=deleteconfirm_zone'));
        $contents[] = array('text' => TEXT_INFO_DELETE_ZONE_INTRO);
        $contents[] = array('text' => '<br /><b>' . $zInfo->geo_zone_name . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('delete','delete_off.gif', IMAGE_DELETE) . ' <a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
        break;

      default:
        if (isset($zInfo) && is_object($zInfo)) {
          $heading[] = array('text' => '<b>' . $zInfo->geo_zone_name . '</b>');

          $contents[] = array('align' => 'center', 'text' => '<a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id . '&action=edit_zone') . '">' . oos_image_swap_button('edit','edit_off.gif', IMAGE_EDIT) . '</a> <a href="' . oos_href_link_admin($aFilename['geo_zones'], 'zpage=' . $_GET['zpage'] . '&zID=' . $zInfo->geo_zone_id . '&action=delete_zone') . '">' . oos_image_swap_button('delete','delete_off.gif', IMAGE_DELETE) . '</a>');
          $contents[] = array('text' => '<br />' . TEXT_INFO_DATE_ADDED . ' ' . oos_date_short($zInfo->date_added));
          if (oos_is_not_null($zInfo->last_modified)) $contents[] = array('text' => TEXT_INFO_LAST_MODIFIED . ' ' . oos_date_short($zInfo->last_modified));
          $contents[] = array('text' => '<br />' . TEXT_INFO_ZONE_DESCRIPTION . '<br />' . $zInfo->geo_zone_description);
        }
        break;
    }
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