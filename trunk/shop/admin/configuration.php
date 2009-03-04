<?php
/* ----------------------------------------------------------------------
   $Id: configuration.php,v 1.74 2007/05/08 16:18:58 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: configuration.php,v 1.40 2002/12/29 16:55:01 dgw_ 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  define('OOS_VALID_MOD', 'yes');
  require 'includes/oos_main.php'; 
  require 'includes/functions/function_modules.php';

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (!empty($action)) {
    switch ($action) {
      case 'save':
        $configuration_value = oos_db_prepare_input($_POST['configuration_value']);
        $cID = oos_db_prepare_input($_GET['cID']);

        $dbconn->Execute("UPDATE " . $oostable['configuration'] . " SET configuration_value = '" . oos_db_input($configuration_value) . "', last_modified = now() WHERE configuration_id = '" . oos_db_input($cID) . "'");
        oos_redirect_admin(oos_href_link_admin($aFilename['configuration'], 'gID=' . $_GET['gID'] . '&cID=' . $cID));
        break;
    }
  }

  $no_js_general = true;
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
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo constant(strtoupper((int)$_GET['gID'] . '_TITLE')); ?></td>
            <td class="pageHeading" align="right"><?php echo oos_draw_separator('trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CONFIGURATION_TITLE; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CONFIGURATION_VALUE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $configuration_result = $dbconn->Execute("SELECT configuration_id, configuration_key, configuration_value, use_function FROM " . $oostable['configuration'] . " WHERE configuration_group_id = '" . $_GET['gID'] . "' ORDER BY sort_order");

  while ($configuration = $configuration_result->fields) {
    if (oos_is_not_null($configuration['use_function'])) {
      $use_function = $configuration['use_function'];
      if (ereg('->', $use_function)) {
        $class_method = explode('->', $use_function);
        if (!is_object(${$class_method[0]})) {
          include 'includes/classes/class_'. $class_method[0] . '.php';
          ${$class_method[0]} = new $class_method[0]();
        }
        $cfgValue = oos_call_function($class_method[1], $configuration['configuration_value'], ${$class_method[0]});
      } else {
        $cfgValue = oos_call_function($use_function, $configuration['configuration_value']);
      }
    } else {
      $cfgValue = $configuration['configuration_value'];
    }

    if ((!isset($_GET['cID']) || (isset($_GET['cID']) && ($_GET['cID'] == $configuration['configuration_id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
      $cfg_extra_result = $dbconn->Execute("SELECT configuration_key, date_added, last_modified, use_function, set_function FROM " . $oostable['configuration'] . " WHERE configuration_id = '" . $configuration['configuration_id'] . "'");
      $cfg_extra = $cfg_extra_result->fields;

      $cInfo_array = array_merge($configuration, $cfg_extra);
      $cInfo = new objectInfo($cInfo_array);
    }


    if (isset($cInfo) && is_object($cInfo) && ($configuration['configuration_id'] == $cInfo->configuration_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['configuration'], 'gID=' . $_GET['gID'] . '&cID=' . $cInfo->configuration_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['configuration'], 'gID=' . $_GET['gID'] . '&cID=' . $configuration['configuration_id']) . '\'">' . "\n";
    }
?>
                <td class="dataTableContent"><?php echo constant(strtoupper($configuration['configuration_key'] . '_TITLE')); ?></td>
                <td class="dataTableContent"><?php echo htmlspecialchars($cfgValue); ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($cInfo) && is_object($cInfo) && ($configuration['configuration_id'] == $cInfo->configuration_id) ) { echo oos_image(OOS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . oos_href_link_admin($aFilename['configuration'], 'gID=' . $_GET['gID'] . '&cID=' . $configuration['configuration_id']) . '">' . oos_image(OOS_IMAGES . 'icon_information.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    // Move that ADOdb pointer!
    $configuration_result->MoveNext();
  }

  // Close result set
  $configuration_result->Close();

?>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'edit':
      $heading[] = array('text' => '<b>' . constant(strtoupper($cInfo->configuration_key . '_TITLE')) . '</b>');

      if ($cInfo->set_function) {
        eval('$value_field = ' . $cInfo->set_function . '"' . htmlspecialchars($cInfo->configuration_value) . '");');
      } else {
        $value_field = oos_draw_input_field('configuration_value', $cInfo->configuration_value);
      }


      $contents = array('form' => oos_draw_form('configuration', $aFilename['configuration'], 'gID=' . $_GET['gID'] . '&cID=' . $cInfo->configuration_id . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $contents[] = array('text' => '<br /><b>' . constant(strtoupper($cInfo->configuration_key . '_TITLE')) . '</b><br />' . constant(strtoupper($cInfo->configuration_key . '_DESC')) . '<br />' . $value_field);
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('update','update_off.gif', IMAGE_UPDATE) . '&nbsp;<a href="' . oos_href_link_admin($aFilename['configuration'], 'gID=' . $_GET['gID'] . '&cID=' . $cInfo->configuration_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

   default:
      if (isset($cInfo) && is_object($cInfo)) {
        $heading[] = array('text' => '<b>' . constant(strtoupper($cInfo->configuration_key . '_TITLE')) . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<a href="' . oos_href_link_admin($aFilename['configuration'], 'gID=' . $_GET['gID'] . '&cID=' . $cInfo->configuration_id . '&action=edit') . '">' . oos_image_swap_button('edit','edit_off.gif', IMAGE_EDIT) . '</a>');
        $contents[] = array('text' => '<br />' . constant(strtoupper($cInfo->configuration_key . '_DESC')));
        $contents[] = array('text' => '<br />' . TEXT_INFO_DATE_ADDED . ' ' . oos_date_short($cInfo->date_added));
        if (oos_is_not_null($cInfo->last_modified)) $contents[] = array('text' => TEXT_INFO_LAST_MODIFIED . ' ' . oos_date_short($cInfo->last_modified));
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