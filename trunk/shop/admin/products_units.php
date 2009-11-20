<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: products_units.php,v 1.19 2003/02/06 17:37:09 thomasamoulton
   ----------------------------------------------------------------------
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


 /**
  * Return Orders Status Name
  *
  * @param $products_units_id
  * @param $language
  * @return string
  */
  function oos_get_products_units_name($products_units_id, $lang_id = '') {

    if (!$lang_id) $lang_id = $_SESSION['language_id'];

    // Get database information
    $dbconn =& oosDBGetConn();
    $oostable =& oosDBGetTables();

    $products_unitstable = $oostable['products_units'];
    $orders_sql = "SELECT products_unit_name
                   FROM $products_unitstable
                   WHERE products_units_id = '" . intval($products_units_id) . "'
                   AND languages_id = '" . intval($lang_id) . "'";
    $products_units = $dbconn->Execute($orders_sql);

    return $products_units->fields['products_unit_name'];
  }


 /**
  * Return Orders Status
  *
  * @param $products_units_id
  * @param $language
  * @return array
  */
  function oos_get_products_units() {

    $products_units_array = array();

    $dbconn =& oosDBGetConn();
    $oostable =& oosDBGetTables();

    $products_unitstable = $oostable['products_units'];
    $products_units_sql = "SELECT products_units_id, products_unit_name
                          FROM $products_unitstable
                          WHERE languages_id = '" . intval($_SESSION['language_id']) . "'
                          ORDER BY products_units_id";
    $products_units_result = $dbconn->Execute($products_units_sql);
    while ($products_units = $products_units_result->fields) {
      $products_units_array[] = array('id' => $products_units['products_units_id'],
                                     'text' => $products_units['products_unit_name']);

      // Move that ADOdb pointer!
      $products_units_result->MoveNext();
    }

    return $products_units_array;
  }



  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (!empty($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        $products_units_id = oos_db_prepare_input($_GET['uID']);

        $languages = oos_get_languages();
        for ($i = 0, $n = count($languages); $i < $n; $i++) {
          $products_unit_name_array = $_POST['products_unit_name'];
          $lang_id = $languages[$i]['id'];

          $sql_data_array = array('products_unit_name' => oos_db_prepare_input($products_unit_name_array[$lang_id]));

          if ($action == 'insert') {
            if (oos_empty($products_units_id)) {

              $products_unitstable = $oostable['products_units'];
              $next_id_result = $dbconn->Execute("SELECT max(products_units_id) as products_units_id FROM $products_unitstable");
              $next_id = $next_id_result->fields;
              $products_units_id = $next_id['products_units_id'] + 1;
            }

            $insert_sql_data = array('products_units_id' => $products_units_id,
                                     'languages_id' => $lang_id);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            oos_db_perform($oostable['products_units'], $sql_data_array);
          } elseif ($action == 'save') {
            oos_db_perform($oostable['products_units'], $sql_data_array, 'update', "products_units_id = '" . intval($products_units_id) . "' and languages_id = '" . intval($lang_id) . "'");
          }
        }

        if (isset($_POST['default']) && ($_POST['default'] == 'on')) {
          $configurationtable = $oostable['configuration'];
          $dbconn->Execute("UPDATE $configurationtable SET configuration_value = '" . intval($products_units_id) . "' WHERE configuration_key = 'DEFAULT_PRODUCTS_UNITS_ID'");
        }

        oos_redirect_admin(oos_href_link_admin($aFilename['products_units'], 'page=' . $_GET['page'] . '&uID=' . $products_units_id));
        break;

    case 'deleteconfirm':
        $uID = oos_db_prepare_input($_GET['uID']);

        $configurationtable = $oostable['configuration'];
        $products_units_result = $dbconn->Execute("SELECT configuration_value FROM $configurationtable WHERE configuration_key = 'DEFAULT_PRODUCTS_UNITS_ID'");
        $products_units = $products_units_result->fields;
        if ($products_units['configuration_value'] == $uID) {
          $dbconn->Execute("UPDATE " . $oostable['configuration'] . " SET configuration_value = '' WHERE configuration_key = 'DEFAULT_PRODUCTS_UNITS_ID'");
        }

        $products_unitstable = $oostable['products_units'];
        $dbconn->Execute("DELETE FROM $products_unitstable WHERE products_units_id = '" . intval($uID) . "'");

        oos_redirect_admin(oos_href_link_admin($aFilename['products_units'], 'page=' . $_GET['page']));
        break;

    case 'delete':
        $uID = oos_db_prepare_input($_GET['uID']);

        $productstable = $oostable['products'];
        $status_result = $dbconn->Execute("SELECT COUNT(*) AS total FROM $productstable WHERE products_units_id = '" . oos_db_input($uID) . "'");
        $status = $status_result->fields;

        $remove_status = true;
        if ($uID == DEFAULT_PRODUCTS_UNITS_ID) {
          $remove_status = false;
          $messageStack->add(ERROR_REMOVE_DEFAULT_PRODUCTS_UNITS, 'error');
        } elseif ($status['total'] > 0) {
          $remove_status = false;
          $messageStack->add(ERROR_STATUS_USED_IN_PRODUCTS, 'error');
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
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_UNITS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  $products_unitstable = $oostable['products_units'];
  $products_units_result_raw = "SELECT products_units_id, products_unit_name
                                FROM $products_unitstable
                                WHERE languages_id = '" . intval($_SESSION['language_id']) . "'
                                ORDER BY products_units_id";
  $products_units_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $products_units_result_raw, $products_units_result_numrows);
  $products_units_result = $dbconn->Execute($products_units_result_raw);
  while ($products_units = $products_units_result->fields) {
    if ((!isset($_GET['uID']) || (isset($_GET['uID']) && ($_GET['uID'] == $products_units['products_units_id']))) && !isset($oInfo) && (substr($action, 0, 3) != 'new')) {
      $oInfo = new objectInfo($products_units);
    }

    if (isset($oInfo) && is_object($oInfo) && ($products_units['products_units_id'] == $oInfo->products_units_id)) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['products_units'], 'page=' . $_GET['page'] . '&uID=' . $oInfo->products_units_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['products_units'], 'page=' . $_GET['page'] . '&uID=' . $products_units['products_units_id']) . '\'">' . "\n";
    }

    if (DEFAULT_PRODUCTS_UNITS_ID == $products_units['products_units_id']) {
      echo '                <td class="dataTableContent"><b>' . $products_units['products_unit_name'] . ' (' . TEXT_DEFAULT . ')</b></td>' . "\n";
    } else {
      echo '                <td class="dataTableContent">' . $products_units['products_unit_name'] . '</td>' . "\n";
    }
?>

                <td class="dataTableContent" align="right"><?php if (isset($oInfo) && is_object($oInfo) && ($products_units['products_units_id'] == $oInfo->products_units_id)) { echo oos_image(OOS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . oos_href_link_admin($aFilename['products_units'], 'page=' . $_GET['page'] . '&uID=' . $products_units['products_units_id']) . '">' . oos_image(OOS_IMAGES . 'icon_information.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    // Move that ADOdb pointer!
    $products_units_result->MoveNext();
  }
?>
              <tr>
                <td colspan="2"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $products_units_split->display_count($products_units_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS_UNITS); ?></td>
                    <td class="smallText" align="right"><?php echo $products_units_split->display_links($products_units_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
    if (empty($action)) {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a href="' . oos_href_link_admin($aFilename['products_units'], 'page=' . $_GET['page'] . '&action=new') . '">' . oos_image_swap_button('insert','insert_off.gif', IMAGE_INSERT) . '</a>'; ?></td>
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
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_PRODUCTS_UNITS . '</b>');

      $contents = array('form' => oos_draw_form('status', $aFilename['products_units'], 'page=' . $_GET['page'] . '&action=insert'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);

      $products_units_inputs_string = '';
      $languages = oos_get_languages();
      for ($i = 0, $n = count($languages); $i < $n; $i++) {
        $products_units_inputs_string .= '<br />' . oos_image(OOS_SHOP_IMAGES . 'flags/' . $languages[$i]['iso_639_2'] . '.gif', $languages[$i]['name']) . '&nbsp;' . oos_draw_input_field('products_unit_name[' . $languages[$i]['id'] . ']');
      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_PRODUCTS_UNITS_NAME . $products_units_inputs_string);
      $contents[] = array('text' => '<br />' . oos_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('insert','insert_off.gif', IMAGE_INSERT) . ' <a href="' . oos_href_link_admin($aFilename['products_units'], 'page=' . $_GET['page']) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_PRODUCTS_UNITS . '</b>');

      $contents = array('form' => oos_draw_form('status', $aFilename['products_units'], 'page=' . $_GET['page'] . '&uID=' . $oInfo->products_units_id  . '&action=save'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);

      $products_units_inputs_string = '';
      $languages = oos_get_languages();
      for ($i = 0, $n = count($languages); $i < $n; $i++) {
        $products_units_inputs_string .= '<br />' . oos_image(OOS_SHOP_IMAGES . 'flags/' . $languages[$i]['iso_639_2'] . '.gif', $languages[$i]['name']) . '&nbsp;' . oos_draw_input_field('products_unit_name[' . $languages[$i]['id'] . ']', oos_get_products_units_name($oInfo->products_units_id, $languages[$i]['id']));
      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_PRODUCTS_UNITS_NAME . $products_units_inputs_string);
      if (DEFAULT_PRODUCTS_UNITS_ID != $oInfo->products_units_id) $contents[] = array('text' => '<br />' . oos_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('update','update_off.gif', IMAGE_UPDATE) . ' <a href="' . oos_href_link_admin($aFilename['products_units'], 'page=' . $_GET['page'] . '&uID=' . $oInfo->products_units_id) . '">' . oos_image_swap_button('cancel', 'cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_PRODUCTS_UNITS . '</b>');

      $contents = array('form' => oos_draw_form('status', $aFilename['products_units'], 'page=' . $_GET['page'] . '&uID=' . $oInfo->products_units_id  . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $oInfo->products_unit_name . '</b>');
      if ($remove_status) $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('delete', 'delete_off.gif', IMAGE_DELETE) . ' <a href="' . oos_href_link_admin($aFilename['products_units'], 'page=' . $_GET['page'] . '&uID=' . $oInfo->products_units_id) . '">' . oos_image_swap_button('cancel', 'cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    default:
     if (isset($oInfo) && is_object($oInfo)) {
        $heading[] = array('text' => '<b>' . $oInfo->products_unit_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . oos_href_link_admin($aFilename['products_units'], 'page=' . $_GET['page'] . '&uID=' . $oInfo->products_units_id . '&action=edit') . '">' . oos_image_swap_button('edit','edit_off.gif', IMAGE_EDIT) . '</a> <a href="' . oos_href_link_admin($aFilename['products_units'], 'page=' . $_GET['page'] . '&uID=' . $oInfo->products_units_id . '&action=delete') . '">' . oos_image_swap_button('delete', 'delete_off.gif', IMAGE_DELETE) . '</a>');

        $products_units_inputs_string = '';
        $languages = oos_get_languages();
        for ($i = 0, $n = count($languages); $i < $n; $i++) {
          $products_units_inputs_string .= '<br />' . oos_image(OOS_SHOP_IMAGES . 'flags/' . $languages[$i]['iso_639_2'] . '.gif', $languages[$i]['name']) . '&nbsp;' . oos_get_products_units_name($oInfo->products_units_id, $languages[$i]['id']);
        }

        $contents[] = array('text' => $products_units_inputs_string);
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