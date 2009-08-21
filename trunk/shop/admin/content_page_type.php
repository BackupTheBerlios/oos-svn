<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  define('OOS_VALID_MOD', 'yes');
  require 'includes/oos_main.php';

 /**
  * Return Page Type Name
  *
  * @param $page_type_id
  * @param $language
  * @return string
  */
  function oosGetPageTypeName($page_type_id,$lang_id = '') {

    if (!$lang_id) $lang_id = $_SESSION['language_id'];

    // Get database information
    $dbconn =& oosDBGetConn();
    $oostable =& oosDBGetTables();

    $page_type_sql = "SELECT page_type_name
                      FROM " . $oostable['page_type'] . "
                      WHERE page_type_id = '" . $page_type_id . "'
                      AND page_type_languages_id = '" . intval($lang_id) . "'";
    $page_type = $dbconn->Execute($page_type_sql);

    return $page_type->fields['page_type_name'];
  }


 /**
  * Return Page Type
  *
  * @return array
  */
  function oosGetPageType() {

    $page_type_array = array();

    // Get database information
    $dbconn =& oosDBGetConn();
    $oostable =& oosDBGetTables();

    $page_type_sql = "SELECT page_type_id, page_type_name
                      FROM " . $oostable['page_type'] . "
                      WHERE page_type_languages_id = '" . intval($_SESSION['language_id']) . "'
                      ORDER BY page_type_id";
    $page_type_result = $dbconn->Execute($page_type_sql);
    while ($page_type = $page_type_result->fields) {
      $page_type_array[] = array('id' => $page_type['page_type_id'],
                                 'text' => $page_type['page_type_name']
                                    );
      // Move that ADOdb pointer!
      $page_type_result->MoveNext();
    }

    // Close result set
    $page_type_result->Close();

    return $page_type_array;
  }


  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (!empty($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        $page_type_id = oos_db_prepare_input($_GET['ptID']);

        $languages = oos_get_languages();
        for ($i = 0, $n = count($languages); $i < $n; $i++) {
          $page_type_name_array = $_POST['page_type_name'];
          $lang_id = $languages[$i]['id'];

          $sql_data_array = array('page_type_name' => oos_db_prepare_input($page_type_name_array[$lang_id]));

          if ($action == 'insert') {
            if (oos_empty($page_type_id)) {
              $next_id_result = $dbconn->Execute("SELECT max(page_type_id) as page_type_id FROM " . $oostable['page_type'] . "");
              $next_id = $next_id_result->fields;
              $page_type_id = $next_id['page_type_id'] + 1;
            }

            $insert_sql_data = array('page_type_id' => $page_type_id,
                                     'page_type_languages_id' => $lang_id);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            oos_db_perform($oostable['page_type'], $sql_data_array);
          } elseif ($action == 'save') {
            oos_db_perform($oostable['page_type'], $sql_data_array, 'update', "page_type_id = '" . oos_db_input($page_type_id) . "' and page_type_languages_id = '" . intval($lang_id) . "'");
          }
        }
        oos_redirect_admin(oos_href_link_admin($aFilename['content_page_type'], 'page=' . $_GET['page'] . '&ptID=' . $page_type_id));
        break;

      case 'deleteconfirm':
        $ptID = oos_db_prepare_input($_GET['ptID']);

        $dbconn->Execute("DELETE FROM " . $oostable['page_type'] . " WHERE page_type_id = '" . oos_db_input($ptID) . "'");

        oos_redirect_admin(oos_href_link_admin($aFilename['content_page_type'], 'page=' . $_GET['page']));
        break;

      case 'delete':
        $ptID = oos_db_prepare_input($_GET['ptID']);

        $status_result = $dbconn->Execute("SELECT COUNT(*) AS total FROM " . $oostable['block_to_page_type'] . " WHERE page_type_id = '" . oos_db_input($ptID) . "'");
        $status = $status_result->fields;

        $remove_status = true;
        if ($status['total'] > 0) {
          $remove_status = false;
          $messageStack->add(ERROR_STATUS_USED_IN_ORDERS, 'error');
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PAGE_TYPE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $page_type_result_raw = "SELECT
                                  page_type_id, page_type_name
                              FROM
                                  " . $oostable['page_type'] . "
                              WHERE
                                  page_type_languages_id = '" . intval($_SESSION['language_id']) . "'
                              ORDER BY
                                  page_type_id";
  $page_type_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $page_type_result_raw, $page_type_result_numrows);
  $page_type_result = $dbconn->Execute($page_type_result_raw);
  while ($page_type = $page_type_result->fields) {
    if ((!isset($_GET['ptID']) || (isset($_GET['ptID']) && ($_GET['ptID'] == $page_type['page_type_id']))) && !isset($oInfo) && (substr($action, 0, 3) != 'new')) {
      $oInfo = new objectInfo($page_type);
    }

    if (isset($oInfo) && is_object($oInfo) && ($page_type['page_type_id'] == $oInfo->page_type_id)) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['content_page_type'], 'page=' . $_GET['page'] . '&ptID=' . $oInfo->page_type_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['content_page_type'], 'page=' . $_GET['page'] . '&ptID=' . $page_type['page_type_id']) . '\'">' . "\n";
    }

    echo '                <td class="dataTableContent">' . $page_type['page_type_name'] . '</td>' . "\n";
?>
                <td class="dataTableContent" align="right"><?php if (isset($oInfo) && is_object($oInfo) && ($page_type['page_type_id'] == $oInfo->page_type_id) ) { echo oos_image(OOS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . oos_href_link_admin($aFilename['content_page_type'], 'page=' . $_GET['page'] . '&ptID=' . $page_type['page_type_id']) . '">' . oos_image(OOS_IMAGES . 'icon_information.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    // Move that ADOdb pointer!
    $page_type_result->MoveNext();
  }

  // Close result set
  $page_type_result->Close();
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $page_type_split->display_count($page_type_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PAGE_TYPES); ?></td>
                    <td class="smallText" align="right"><?php echo $page_type_split->display_links($page_type_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (empty($action)) {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a href="' . oos_href_link_admin($aFilename['content_page_type'], 'page=' . $_GET['page'] . '&action=new') . '">' . oos_image_swap_button('insert','insert_off.gif', IMAGE_INSERT) . '</a>'; ?></td>
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
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_PAGE_TYPE . '</b>');

      $contents = array('form' => oos_draw_form('status', $aFilename['content_page_type'], 'page=' . $_GET['page'] . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);

      $page_type_inputs_string = '';
      $languages = oos_get_languages();
      for ($i = 0, $n = count($languages); $i < $n; $i++) {
        $page_type_inputs_string .= '<br />' . oos_image(OOS_SHOP_IMAGES . 'flags/' . $languages[$i]['iso_639_2'] . '.gif', $languages[$i]['name']) . '&nbsp;' . oos_draw_input_field('page_type_name[' . $languages[$i]['id'] . ']');
      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_PAGE_TYPE_NAME . $page_type_inputs_string);
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('insert','insert_off.gif', IMAGE_INSERT) . ' <a href="' . oos_href_link_admin($aFilename['content_page_type'], 'page=' . $_GET['page']) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;
    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_PAGE_TYPE . '</b>');

      $contents = array('form' => oos_draw_form('status', $aFilename['content_page_type'], 'page=' . $_GET['page'] . '&ptID=' . $oInfo->page_type_id  . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);

      $page_type_inputs_string = '';
      $languages = oos_get_languages();
      for ($i = 0, $n = count($languages); $i < $n; $i++) {
        $page_type_inputs_string .= '<br />' . oos_image(OOS_SHOP_IMAGES . 'flags/' . $languages[$i]['iso_639_2'] . '.gif', $languages[$i]['name']) . '&nbsp;' . oos_draw_input_field('page_type_name[' . $languages[$i]['id'] . ']', oosGetPageTypeName($oInfo->page_type_id, $languages[$i]['id']));
      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_PAGE_TYPE_NAME . $page_type_inputs_string);
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('update','update_off.gif', IMAGE_UPDATE) . ' <a href="' . oos_href_link_admin($aFilename['content_page_type'], 'page=' . $_GET['page'] . '&ptID=' . $oInfo->page_type_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_PAGE_TYPE . '</b>');

      $contents = array('form' => oos_draw_form('status', $aFilename['content_page_type'], 'page=' . $_GET['page'] . '&ptID=' . $oInfo->page_type_id  . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $oInfo->page_type_name . '</b>');
      if ($remove_status) $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('delete','delete_off.gif', IMAGE_DELETE) . ' <a href="' . oos_href_link_admin($aFilename['content_page_type'], 'page=' . $_GET['page'] . '&ptID=' . $oInfo->page_type_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    default:
      if (isset($oInfo) && is_object($oInfo)) {
        $heading[] = array('text' => '<b>' . $oInfo->page_type_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . oos_href_link_admin($aFilename['content_page_type'], 'page=' . $_GET['page'] . '&ptID=' . $oInfo->page_type_id . '&action=edit') . '">' . oos_image_swap_button('edit','edit_off.gif', IMAGE_EDIT) . '</a> <a href="' . oos_href_link_admin($aFilename['content_page_type'], 'page=' . $_GET['page'] . '&ptID=' . $oInfo->page_type_id . '&action=delete') . '">' . oos_image_swap_button('delete','delete_off.gif', IMAGE_DELETE) . '</a>');

        $page_type_inputs_string = '';
        $languages = oos_get_languages();
        for ($i = 0, $n = count($languages); $i < $n; $i++) {
          $page_type_inputs_string .= '<br />' . oos_image(OOS_SHOP_IMAGES . 'flags/' . $languages[$i]['iso_639_2'] . '.gif', $languages[$i]['name']) . '&nbsp;' . oosGetPageTypeName($oInfo->page_type_id, $languages[$i]['id']);
        }

        $contents[] = array('text' => $page_type_inputs_string);
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