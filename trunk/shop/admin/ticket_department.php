<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: ticket_department.php,v 1.5 2003/04/25 21:37:11 hook
   ----------------------------------------------------------------------
   OSC-SupportTicketSystem
   Copyright (c) 2003 Henri Schmidhuber IN-Solution

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('OOS_VALID_MOD', 'yes');
require 'includes/oos_main.php';

if (!isset($_SESSION['login_id'])) {
    oos_redirect_admin(oos_href_link_admin($aFilename['login'], '', 'SSL'));
}

if ( !current_user_can('ticket_department') )
    oos_redirect_admin(oos_href_link_admin($aFilename['forbiden']));

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (!empty($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        $ticket_department_id = oos_db_prepare_input($_GET['oID']);

        $languages = oos_get_languages();
        $ticket_department_name_array = $_POST['ticket_department_name'];
        for ($i = 0; $i < count($languages); $i++) {
          $lang_id = $languages[$i]['id'];
          $sql_data_array = array('ticket_department_name' => oos_db_prepare_input($ticket_department_name_array[$lang_id]));

          if ($action == 'insert') {
            if (empty($ticket_department_id)) {
              $ticket_departmenttable = $oostable['ticket_department'];
              $next_id_result = $dbconn->Execute("SELECT max(ticket_department_id) as ticket_department_id FROM $ticket_departmenttable");
              $next_id = $next_id_result->fields;
              $ticket_department_id = $next_id['ticket_department_id'] + 1;
            }

            $insert_sql_data = array('ticket_department_id' => $ticket_department_id,
                                     'ticket_languages_id' => $lang_id);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            oos_db_perform($oostable['ticket_department'], $sql_data_array);
          } elseif ($action == 'save') {
            oos_db_perform($oostable['ticket_department'], $sql_data_array, 'update', "ticket_department_id = '" . oos_db_input($ticket_department_id) . "' and ticket_languages_id = '" . intval($lang_id) . "'");
          }
        }

        if (isset($_POST['default']) && ($_POST['default'] == 'on')) {
          $configurationtable = $oostable['configuration'];
          $dbconn->Execute("UPDATE $configurationtable SET configuration_value = '" . oos_db_input($ticket_department_id) . "' WHERE configuration_key = 'TICKET_DEFAULT_DEPARTMENT_ID'");
        }

        oos_redirect_admin(oos_href_link_admin($aFilename['ticket_department'], 'page=' . $_GET['page'] . '&oID=' . $ticket_department_id));
        break;

      case 'deleteconfirm':
        $oID = oos_db_prepare_input($_GET['oID']);

        $configurationtable = $oostable['configuration'];
        $ticket_department_result = $dbconn->Execute("SELECT configuration_value FROM $configurationtable WHERE configuration_key = 'TICKET_DEFAULT_DEPARTMENT_ID'");
        $ticket_department = $ticket_department_result->fields;
        if ($ticket_department['configuration_value'] == $oID) {
          $dbconn->Execute("UPDATE " . $oostable['configuration'] . " SET configuration_value = '' WHERE configuration_key = 'TICKET_DEFAULT_DEPARTMENT_ID'");
        }

        $dbconn->Execute("DELETE FROM " . $oostable['ticket_department'] . " WHERE ticket_department_id = '" . oos_db_input($oID) . "'");

        oos_redirect_admin(oos_href_link_admin($aFilename['ticket_department'], 'page=' . $_GET['page']));
        break;

      case 'delete':
        $oID = oos_db_prepare_input($_GET['oID']);

        $ticket_tickettable = $oostable['ticket_ticket'];
        $department_result = $dbconn->Execute("SELECT count(*) as count FROM $ticket_tickettable WHERE ticket_department_id = '" . oos_db_input($oID) . "'");
        $department = $department_result->fields;

        $remove_department = true;
        if ($oID == TICKET_DEFAULT_DEPARTMENT_ID) {
          $remove_department = false;
          $messageStack->add(ERROR_REMOVE_DEFAULT_TEXT_DEPARTMENT, 'error');
        } elseif ($department['count'] > 0) {
          $remove_department = false;
          $messageStack->add(ERROR_DEPARTMENT_USED_IN_TICKET, 'error');
        } else {
          $ticket_status_historytable = $oostable['ticket_status_history'];
          $history_result = $dbconn->Execute("SELECT count(*) as count FROM $ticket_status_historytable WHERE ticket_department_id = '" . oos_db_input($oID) . "'");
          $history = $history_result->fields;
          if ($history['count'] > 0) {
            $remove_department = false;
            $messageStack->add(ERROR_DEPARTMENT_USED_IN_HISTORY, 'error');
          }
        }
        break;
    }
  }
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
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo oos_draw_separator('trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TEXT_DEPARTMENT; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $ticket_departmenttable = $oostable['ticket_department'];
  $ticket_department_result_raw = "SELECT ticket_department_id, ticket_department_name
                                  FROM $ticket_departmenttable
                                  WHERE ticket_languages_id = '" . intval($_SESSION['language_id']) . "'
                                  ORDER BY ticket_department_id";
  $ticket_department_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $ticket_department_result_raw, $ticket_department_result_numrows);
  $ticket_department_result = $dbconn->Execute($ticket_department_result_raw);
  while ($ticket_department = $ticket_department_result->fields) {
    if ((!isset($_GET['oID']) || (isset($_GET['oID']) && ($_GET['oID'] == $ticket_department['ticket_department_id']))) && !isset($oInfo) && (substr($action, 0, 3) != 'new')) {
      $oInfo = new objectInfo($ticket_department);
    }

    if (isset($oInfo) && is_object($oInfo) && ($ticket_department['ticket_department_id'] == $oInfo->ticket_department_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['ticket_department'], 'page=' . $_GET['page'] . '&oID=' . $oInfo->ticket_department_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['ticket_department'], 'page=' . $_GET['page'] . '&oID=' . $ticket_department['ticket_department_id']) . '\'">' . "\n";
    }

    if (TICKET_DEFAULT_DEPARTMENT_ID == $ticket_department['ticket_department_id']) {
      echo '                <td class="dataTableContent"><b>' . $ticket_department['ticket_department_name'] . ' (' . TEXT_DEFAULT . ')</b></td>' . "\n";
    } else {
      echo '                <td class="dataTableContent">' . $ticket_department['ticket_department_name'] . '</td>' . "\n";
    }
?>
                <td class="dataTableContent" align="right"><?php if (isset($oInfo) && is_object($oInfo) && ($ticket_department['ticket_department_id'] == $oInfo->ticket_department_id) ) { echo oos_image(OOS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . oos_href_link_admin($aFilename['ticket_department'], 'page=' . $_GET['page'] . '&oID=' . $ticket_department['ticket_department_id']) . '">' . oos_image(OOS_IMAGES . 'icon_information.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    // Move that ADOdb pointer!
    $ticket_department_result->MoveNext();
  }

  // Close result set
  $ticket_department_result->Close();
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $ticket_department_split->display_count($ticket_department_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_TEXT_DEPARTMENT); ?></td>
                    <td class="smallText" align="right"><?php echo $ticket_department_split->display_links($ticket_department_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (empty($action)) {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a href="' . oos_href_link_admin($aFilename['ticket_department'], 'page=' . $_GET['page'] . '&action=new') . '">' . oos_image_swap_button('insert','insert_off.gif', IMAGE_INSERT) . '</a>'; ?></td>
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
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_TEXT_DEPARTMENT . '</b>');

      $contents = array('form' => oos_draw_form('department', $aFilename['ticket_department'], 'page=' . $_GET['page'] . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);

      $ticket_department_inputs_string = '';
      $languages = oos_get_languages();
      for ($i = 0, $n = count($languages); $i < $n; $i++) {
        $ticket_department_inputs_string .= '<br />' . oos_image(OOS_SHOP_IMAGES . 'flags/' . $languages[$i]['iso_639_2'] . '.gif', $languages[$i]['name']) . '&nbsp;' . oos_draw_input_field('ticket_department_name[' . $languages[$i]['id'] . ']');
      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_TEXT_DEPARTMENT_NAME . $ticket_department_inputs_string);
      $contents[] = array('text' => '<br />' . oos_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('insert','insert_off.gif', IMAGE_INSERT) . ' <a href="' . oos_href_link_admin($aFilename['ticket_department'], 'page=' . $_GET['page']) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_TEXT_DEPARTMENT . '</b>');

      $contents = array('form' => oos_draw_form('department', $aFilename['ticket_department'], 'page=' . $_GET['page'] . '&oID=' . $oInfo->ticket_department_id  . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);

      $ticket_department_inputs_string = '';
      $languages = oos_get_languages();
      for ($i = 0, $n = count($languages); $i < $n; $i++) {
        $ticket_department_inputs_string .= '<br />' . oos_image(OOS_SHOP_IMAGES . 'flags/' . $languages[$i]['iso_639_2'] . '.gif', $languages[$i]['name']) . '&nbsp;' . oos_draw_input_field('ticket_department_name[' . $languages[$i]['id'] . ']', oos_get_ticket_department_name($oInfo->ticket_department_id, $languages[$i]['id']));
      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_TEXT_DEPARTMENT_NAME . $ticket_department_inputs_string);
      if (TICKET_DEFAULT_DEPARTMENT_ID != $oInfo->ticket_department_id) $contents[] = array('text' => '<br />' . oos_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('update','update_off.gif', IMAGE_UPDATE) . ' <a href="' . oos_href_link_admin($aFilename['ticket_department'], 'page=' . $_GET['page'] . '&oID=' . $oInfo->ticket_department_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_TEXT_DEPARTMENT . '</b>');

      $contents = array('form' => oos_draw_form('department', $aFilename['ticket_department'], 'page=' . $_GET['page'] . '&oID=' . $oInfo->ticket_department_id  . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $oInfo->ticket_department_name . '</b>');
      if ($remove_department) $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('delete','delete_off.gif', IMAGE_DELETE) . ' <a href="' . oos_href_link_admin($aFilename['ticket_department'], 'page=' . $_GET['page'] . '&oID=' . $oInfo->ticket_department_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    default:
      if (isset($oInfo) && is_object($oInfo)) {
        $heading[] = array('text' => '<b>' . $oInfo->ticket_department_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . oos_href_link_admin($aFilename['ticket_department'], 'page=' . $_GET['page'] . '&oID=' . $oInfo->ticket_department_id . '&action=edit') . '">' . oos_image_swap_button('edit','edit_off.gif', IMAGE_EDIT) . '</a> <a href="' . oos_href_link_admin($aFilename['ticket_department'], 'page=' . $_GET['page'] . '&oID=' . $oInfo->ticket_department_id . '&action=delete') . '">' . oos_image_swap_button('delete','delete_off.gif', IMAGE_DELETE) . '</a>');

        $ticket_department_inputs_string = '';
        $languages = oos_get_languages();
        for ($i = 0, $n = count($languages); $i < $n; $i++) {
          $ticket_department_inputs_string .= '<br />' . oos_image(OOS_SHOP_IMAGES . 'flags/' . $languages[$i]['iso_639_2'] . '.gif', $languages[$i]['name']) . '&nbsp;' . oos_get_ticket_department_name($oInfo->ticket_department_id, $languages[$i]['id']);
        }
        $contents[] = array('text' => $ticket_department_inputs_string);
      }
      break;
  }

  if ( (!empty($heading)) && (!empty($contents) ) ) {
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