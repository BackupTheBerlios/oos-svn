<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: customers_status.php,v 1.1 2003/01/08 10:53:01 elarifr
   ----------------------------------------------------------------------
   For Customers Status v3.x
   Based on original module from OSCommerce CVS 2.2 2002/08/28
   Copyright elari@free.fr

   Download area : www.unlockgsm.com/dload-osc/
   CVS : http://cvs.sourceforge.net/cgi-bin/viewcvs.cgi/elari/?sortby=date#dirlist
   Released under the GNU General Public License.
   You have no rights to remove any greetings or copyrights notice or my name elari

   Bugs fixed by Guido.winger@post.rwth-aachen.de
   In version 3.x images will be uploaded into the catalog/images/icons instead of admin/images/icons
   If the directory doesn't exists, create it with your FTP program and chmod it to :
   (guido : chmod 777)
   (elari : chmod 744 is more secure if it works  for you)

   Contribution based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('OOS_VALID_MOD', 'yes');
require 'includes/oos_main.php';

if (!isset($_SESSION['login_id'])) {
    oos_redirect_admin(oos_href_link_admin($aFilename['login'], '', 'SSL'));
}

if ( !current_user_can('customers_status') )
    oos_redirect_admin(oos_href_link_admin($aFilename['forbiden']));


require 'includes/functions/function_customer.php';
require 'includes/classes/class_currencies.php';

  $currencies = new currencies();

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (!empty($action)) {
    switch ($action) {
      case 'insert':
      case 'save':
        $customers_status_id = oos_db_prepare_input($_GET['cID']);

        $languages = oos_get_languages();
        for ($i = 0, $n = count($languages); $i < $n; $i++) {
          $customers_status_name_array = $_POST['customers_status_name'];
          $lang_id = $languages[$i]['id'];

          if (isset($_REQUEST['payment'])) {
            $customers_status_payment = implode(';', $_REQUEST['payment']);
          }

          $sql_data_array = array('customers_status_name' => $customers_status_name_array[$lang_id],
                                  'customers_status_public' => $customers_status_public,
                                  'customers_status_show_price' => $customers_status_show_price,
                                  'customers_status_show_price_tax' => $customers_status_show_price_tax,
                                  'customers_status_discount' => $customers_status_discount,
                                  'customers_status_ot_discount_flag' => $customers_status_ot_discount_flag,
                                  'customers_status_ot_discount' => $customers_status_ot_discount,
                                  'customers_status_ot_minimum' => $customers_status_ot_minimum,
                                  'customers_status_qty_discounts' => $customers_status_qty_discounts,
                                  'customers_status_payment' => $customers_status_payment
                                  );
          if ($action == 'insert') {
            if (empty($customers_status_id)) {
              $next_id_result = $dbconn->Execute("SELECT max(customers_status_id) as customers_status_id FROM " . $oostable['customers_status'] . "");
              $next_id = $next_id_result->fields;
              $customers_status_id = $next_id['customers_status_id'] + 1;
            }

            $insert_sql_data = array('customers_status_id' => oos_db_prepare_input($customers_status_id),
                                     'customers_status_languages_id' => $lang_id);

            $sql_data_array = array_merge($sql_data_array, $insert_sql_data);

            oos_db_perform($oostable['customers_status'], $sql_data_array);
          } elseif ($action == 'save') {
            oos_db_perform($oostable['customers_status'], $sql_data_array, 'update', "customers_status_id = '" . oos_db_input($customers_status_id) . "' and customers_status_languages_id = '" . intval($lang_id) . "'");
          }
        }
        // Changes by Guido Start
        $customers_status_image = oos_get_uploaded_file('customers_status_image');
        $image_directory = oos_get_local_path(OOS_ABSOLUTE_PATH . OOS_IMAGES . 'icons/');

        if (is_uploaded_file($customers_status_image['tmp_name'])) {
          if (!is_writeable($image_directory)) {
            if (is_dir($image_directory)) {
              $messageStack->add_session(sprintf(ERROR_DIRECTORY_NOT_WRITEABLE, $image_directory), 'error');
            } else {
              $messageStack->add_session(sprintf(ERROR_DIRECTORY_DOES_NOT_EXIST, $image_directory), 'error');
            }
          } else {
            $dbconn->Execute("UPDATE " . $oostable['customers_status'] . " SET customers_status_image = '" . $customers_status_image['name'] . "' WHERE customers_status_id = '" . oos_db_input($customers_status_id) . "'");
            oos_get_copy_uploaded_file($customers_status_image, $image_directory);
          }
        }
        // Changes by Guido END

        if (isset($_POST['default']) && ($_POST['default'] == 'on')) {
          $dbconn->Execute("UPDATE " . $oostable['configuration'] . " SET configuration_value = '" . oos_db_input($customers_status_id) . "' WHERE configuration_key = 'DEFAULT_CUSTOMERS_STATUS_ID'");
        }

        oos_redirect_admin(oos_href_link_admin($aFilename['customers_status'], 'page=' . $_GET['page'] . '&cID=' . $customers_status_id));
        break;

      case 'deleteconfirm':
        $cID = oos_db_prepare_input($_GET['cID']);

        $customers_status_result = $dbconn->Execute("SELECT configuration_value FROM " . $oostable['configuration'] . " WHERE configuration_key = 'DEFAULT_CUSTOMERS_STATUS_ID'");
        $customers_status = $customers_status_result->fields;
        if ($customers_status['configuration_value'] == $cID) {
          $dbconn->Execute("UPDATE " . $oostable['configuration'] . " SET configuration_value = '' WHERE configuration_key = 'DEFAULT_CUSTOMERS_STATUS_ID'");
        }

        $dbconn->Execute("DELETE FROM " . $oostable['customers_status'] . " WHERE customers_status_id = '" . oos_db_input($cID) . "'");

        oos_redirect_admin(oos_href_link_admin($aFilename['customers_status'], 'page=' . $_GET['page']));
        break;

      case 'delete':
        $cID = oos_db_prepare_input($_GET['cID']);

        $status_result = $dbconn->Execute("SELECT COUNT(*) AS count FROM " . $oostable['customers'] . " WHERE customers_status = '" . oos_db_input($cID) . "'");
        $status = $status_result->fields;

        $remove_status = true;
        if (($cID == DEFAULT_CUSTOMERS_STATUS_ID) || ($cID == DEFAULT_CUSTOMERS_STATUS_ID_GUEST) || ($cID == DEFAULT_CUSTOMERS_STATUS_ID_NEWSLETTER)) {
          $remove_status = false;
          $messageStack->add(ERROR_REMOVE_DEFAULT_CUSTOMERS_STATUS, 'error');
        } elseif ($status['count'] > 0) {
          $remove_status = false;
          $messageStack->add(ERROR_STATUS_USED_IN_CUSTOMERS, 'error');
        } else {
          $history_result = $dbconn->Execute("SELECT COUNT(*) AS count FROM " . $oostable['customers_status_history'] . " WHERE '" . oos_db_input($cID) . "' in (new_value, old_value)");
          $history = $history_result->fields;
          if ($history['count'] > 0) {
            $remove_status = false;
            $messageStack->add(ERROR_STATUS_USED_IN_HISTORY, 'error');
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
                <td class="dataTableHeadingContent" align="left" width="8%"><?php echo 'icon'; ?></td>
                <td class="dataTableHeadingContent" align="left" width="40%"><?php echo TABLE_HEADING_CUSTOMERS_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="center" width="5%"></td>
                <td class="dataTableHeadingContent" align="center" width="5%"><?php echo '%'; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_AMOUNT; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo '%'; ?></td>
                <td class="dataTableHeadingContent" width="10%"><?php echo TABLE_HEADING_CUSTOMERS_QTY_DISCOUNTS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  // Add V1.1  //Change from V3 i reuse same string entry_yes entry_no instead of entry_ot_xmember_yes/no these change are also reported in language file
  $customers_status_ot_discount_flag_array = array(array('id' => '0', 'text' => ENTRY_NO),
                                                   array('id' => '1', 'text' => ENTRY_YES) );
  $customers_status_qty_discounts_array =    array(array('id' => '0', 'text' => ENTRY_NO),
                                                   array('id' => '1', 'text' => ENTRY_YES) );
  $customers_status_public_array =           array(array('id' => '0', 'text' => ENTRY_NO),
                                                   array('id' => '1', 'text' => ENTRY_YES) );
  $customers_status_show_price_array =       array(array('id' => '0', 'text' => ENTRY_NO),
                                                   array('id' => '1', 'text' => ENTRY_YES) );
  $customers_status_show_price_tax_array =   array(array('id' => '0', 'text' => ENTRY_TAX_NO),
                                                   array('id' => '1', 'text' => ENTRY_TAX_YES) );
  $customers_status_result_raw = "SELECT
                                     customers_status_id, customers_status_name, customers_status_public,
                                     customers_status_show_price, customers_status_show_price_tax,
                                     customers_status_image, customers_status_discount,
                                     customers_status_ot_discount_flag , customers_status_ot_discount,
                                     customers_status_ot_minimum, customers_status_qty_discounts,
                                     customers_status_payment
                                  FROM
                                     " . $oostable['customers_status'] . "
                                  WHERE
                                     customers_status_languages_id = '" . intval($_SESSION['language_id']) . "'
                                  ORDER BY
                                     customers_status_id";
  $customers_status_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $customers_status_result_raw, $customers_status_result_numrows);
  $customers_status_result = $dbconn->Execute($customers_status_result_raw);
  while ($customers_status = $customers_status_result->fields) {
    if ((!isset($_GET['cID']) || (isset($_GET['cID']) && ($_GET['cID'] == $customers_status['customers_status_id']))) && !isset($cInfo) && (substr($action, 0, 3) != 'new')) {
      $cInfo = new objectInfo($customers_status);
    }

    if (isset($cInfo) && is_object($cInfo) && ($customers_status['customers_status_id'] == $cInfo->customers_status_id)) {
      echo '<tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['customers_status'], 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['customers_status'], 'page=' . $_GET['page'] . '&cID=' . $customers_status['customers_status_id']) . '\'">' . "\n";
    }
      echo '<td class="dataTableContent" align="left">'    . oos_image(OOS_SHOP_IMAGES . 'icons/' . $customers_status['customers_status_image'] , IMAGE_ICON_INFO) . '</td>';
      if ($customers_status['customers_status_id'] == DEFAULT_CUSTOMERS_STATUS_ID ) {
        echo '<td class="dataTableContent" align="left"><b>' . $customers_status['customers_status_name'];
        echo ' (' . TEXT_DEFAULT . ')';
      } else {
        echo '<td class="dataTableContent" align="left">' . $customers_status['customers_status_name'];
      }
      if ($customers_status['customers_status_public'] == '1') {
        echo ', public ';
      }
      echo '</b></td>';
      if ($customers_status['customers_status_show_price'] == '1') {
        echo '<td class="smallText" align="left">&euro;';
        if ($customers_status['customers_status_show_price_tax'] == '0') {
          echo '+';
        }
      } else {
        echo '<td class="smallText" align="left"> ';
      }

      echo '</td>';
      echo '<td class="smallText" align="right">' . $customers_status['customers_status_discount'] . '%</td>';
      echo '<td class="dataTableContent" align="center">' . $currencies->format($customers_status['customers_status_ot_minimum']) . '</td>';
      echo '<td class="dataTableContent" align="right">' . $customers_status['customers_status_ot_discount'] . '%</td>';
      echo '<td class="dataTableContent" align="center">';

      if ($customers_status['customers_status_qty_discounts'] == '1') {
        echo ENTRY_YES;
      } else {
        echo ENTRY_NO;
      }
      echo '</td>';
      echo "\n";

?>
                <td class="dataTableContent" align="right"><?php if (isset($cInfo) && is_object($cInfo) && ($customers_status['customers_status_id'] == $cInfo->customers_status_id) ) { echo oos_image(OOS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . oos_href_link_admin($aFilename['customers_status'], 'page=' . $_GET['page'] . '&cID=' . $customers_status['customers_status_id']) . '">' . oos_image(OOS_IMAGES . 'icon_information.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    // Move that ADOdb pointer!
    $customers_status_result->MoveNext();
  }

  // Close result set
  $customers_status_result->Close();

?>
              <tr>
                <td colspan="8"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $customers_status_split->display_count($customers_status_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CUSTOMERS_STATUS); ?></td>
                    <td class="smallText" align="right"><?php echo $customers_status_split->display_links($customers_status_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
   if (empty($action)) {
?>
                  <tr>
                    <td colspan="2" align="right"><?php echo '<a href="' . oos_href_link_admin($aFilename['customers_status'], 'page=' . $_GET['page'] . '&action=new') . '">' . oos_image_swap_button('insert','insert_off.gif', IMAGE_INSERT) . '</a>'; ?></td>
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
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_CUSTOMERS_STATUS . '</b>');
      $contents = array('form' => oos_draw_form('status', $aFilename['customers_status'], 'page=' . $_GET['page'] . '&action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);
      $customers_status_inputs_string = '';
      $languages = oos_get_languages();
      for ($i = 0, $n = count($languages); $i < $n; $i++) {
        $customers_status_inputs_string .= '<br />' . oos_image(OOS_SHOP_IMAGES . 'flags/' . $languages[$i]['iso_639_2'] . '.gif', $languages[$i]['name']) . '&nbsp;' . oos_draw_input_field('customers_status_name[' . $languages[$i]['id'] . ']');
      }

      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_NAME . $customers_status_inputs_string);
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_IMAGE . '<br />' . oos_draw_file_field('customers_status_image'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_PUBLIC_INTRO . '<br /><b>' . ENTRY_CUSTOMERS_STATUS_PUBLIC . '</b> ' . oos_draw_pull_down_menu('customers_status_public', $customers_status_public_array, $cInfo->customers_status_public ))  ;
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_INTRO     . '<br /><b>' . ENTRY_CUSTOMERS_STATUS_SHOW_PRICE . '</b> ' . oos_draw_pull_down_menu('customers_status_show_price', $customers_status_show_price_array, $cInfo->customers_status_show_price ))  ;
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_TAX_INTRO . '<br /><b>' . ENTRY_CUSTOMERS_STATUS_SHOW_PRICE_TAX . '</b> ' . oos_draw_pull_down_menu('customers_status_show_price_tax', $customers_status_show_price_tax_array, $cInfo->customers_status_show_price_tax ))  ;
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE_INTRO . '<br /><b>' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . '</b><br />' . oos_draw_input_field('customers_status_discount', $cInfo->customers_status_discount));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_OT_XMEMBER_INTRO . '<br /><b>' . ENTRY_OT_XMEMBER . '</b> ' . oos_draw_pull_down_menu('customers_status_ot_discount_flag', $customers_status_ot_discount_flag_array, $cInfo->customers_status_ot_discount_flag). '<br />' . TEXT_INFO_CUSTOMERS_STATUS_MINIMUM_AMOUNT_OT_XMEMBER_INTRO . '<br /><b>' . ENTRY_MINIMUM_AMOUNT_OT_XMEMBER . '</b><br />' . oos_draw_input_field('customers_status_ot_minimum', $cInfo->customers_status_ot_minimum) . '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . '<br />' . oos_draw_input_field('customers_status_ot_discount', $cInfo->customers_status_ot_discount));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_STAFFELPREIS_INTRO . '<br /><b>' . ENTRY_STAFFELPREIS . '</b> ' . oos_draw_pull_down_menu('customers_status_qty_discounts', $customers_status_qty_discounts_array, $cInfo->customers_status_qty_discounts ))  ;
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_PAYMENT_INTRO . '<br /><b>' . ENTRY_CUSTOMERS_STATUS_PAYMENT . '</b><br /> ' . oos_installed_payment($cInfo->customers_status_payment))  ;
      $contents[] = array('text' => '<br />' . oos_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('insert','insert_off.gif', IMAGE_INSERT) . ' <a href="' . oos_href_link_admin($aFilename['customers_status'], 'page=' . $_GET['page']) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_CUSTOMERS_STATUS . '</b>');
      $contents = array('form' => oos_draw_form('status', $aFilename['customers_status'], 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id  .'&action=save', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_INFO_EDIT_INTRO);
      $customers_status_inputs_string = '';
      $languages = oos_get_languages();
      for ($i = 0, $n = count($languages); $i < $n; $i++) {
        $customers_status_inputs_string .= '<br />' . oos_image(OOS_SHOP_IMAGES . 'flags/' . $languages[$i]['iso_639_2'] . '.gif', $languages[$i]['name']) . '&nbsp;' . oos_draw_input_field('customers_status_name[' . $languages[$i]['id'] . ']', oos_get_customer_status_name($cInfo->customers_status_id, $languages[$i]['id']));
      }
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_NAME . $customers_status_inputs_string);
      $contents[] = array('text' => '<br />' . oos_image(OOS_SHOP_IMAGES . 'icons/' . $cInfo->customers_status_image, $cInfo->customers_status_name) . '<br />' . OOS_SHOP_IMAGES . 'icons/<br /><b>' . $cInfo->customers_status_image . '</b>');
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_IMAGE . '<br />' . oos_draw_file_field('customers_status_image'));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_PUBLIC_INTRO . '<br /><b>' . ENTRY_CUSTOMERS_STATUS_PUBLIC . '</b> ' . oos_draw_pull_down_menu('customers_status_public', $customers_status_public_array, $cInfo->customers_status_public ))  ;
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_INTRO     . '<br /><b>' . ENTRY_CUSTOMERS_STATUS_SHOW_PRICE . '</b> ' . oos_draw_pull_down_menu('customers_status_show_price', $customers_status_show_price_array, $cInfo->customers_status_show_price ))  ;
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_SHOW_PRICE_TAX_INTRO . '<br /><b>' . ENTRY_CUSTOMERS_STATUS_SHOW_PRICE_TAX . '</b> ' . oos_draw_pull_down_menu('customers_status_show_price_tax', $customers_status_show_price_tax_array, $cInfo->customers_status_show_price_tax ))  ;
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE_INTRO . '<br /><b>' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . '</b> ' . oos_draw_input_field('customers_status_discount', $cInfo->customers_status_discount));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_OT_XMEMBER_INTRO . '<br /><b>' . ENTRY_OT_XMEMBER . '</b> ' . oos_draw_pull_down_menu('customers_status_ot_discount_flag', $customers_status_ot_discount_flag_array, $cInfo->customers_status_ot_discount_flag). '<br />' . TEXT_INFO_CUSTOMERS_STATUS_MINIMUM_AMOUNT_OT_XMEMBER_INTRO . '<br /><b>' . ENTRY_MINIMUM_AMOUNT_OT_XMEMBER . '</b><br />' . oos_draw_input_field('customers_status_ot_minimum', $cInfo->customers_status_ot_minimum) . '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . '<br />' . oos_draw_input_field('customers_status_ot_discount', $cInfo->customers_status_ot_discount));
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_STAFFELPREIS_INTRO . '<br /><b>' . ENTRY_STAFFELPREIS . '</b> ' . oos_draw_pull_down_menu('customers_status_qty_discounts', $customers_status_qty_discounts_array, $cInfo->customers_status_qty_discounts))  ;
      $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_PAYMENT_INTRO . '<br /><b>' . ENTRY_CUSTOMERS_STATUS_PAYMENT . '</b><br />'.  oos_installed_payment($cInfo->customers_status_payment));
      if (DEFAULT_CUSTOMERS_STATUS_ID != $cInfo->customers_status_id) $contents[] = array('text' => '<br />' . oos_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('update','update_off.gif', IMAGE_UPDATE) . ' <a href="' . oos_href_link_admin($aFilename['customers_status'], 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_CUSTOMERS_STATUS . '</b>');

      $contents = array('form' => oos_draw_form('status', $aFilename['customers_status'], 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id  . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $cInfo->customers_status_name . '</b>');
      if ($remove_status) $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('delete','delete_off.gif', IMAGE_DELETE) . ' <a href="' . oos_href_link_admin($aFilename['customers_status'], 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    default:
      if (isset($cInfo) && is_object($cInfo)) {
        $heading[] = array('text' => '<b>' . $cInfo->customers_status_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . oos_href_link_admin($aFilename['customers_status'], 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id . '&action=edit') . '">' . oos_image_swap_button('edit','edit_off.gif', IMAGE_EDIT) . '</a> <a href="' . oos_href_link_admin($aFilename['customers_status'], 'page=' . $_GET['page'] . '&cID=' . $cInfo->customers_status_id . '&action=delete') . '">' . oos_image_swap_button('delete','delete_off.gif', IMAGE_DELETE) . '</a>');
        $customers_status_inputs_string = '';
        $languages = oos_get_languages();
        for ($i = 0, $n = count($languages); $i < $n; $i++) {
          $customers_status_inputs_string .= '<br />' . oos_image(OOS_SHOP_IMAGES . 'flags/' . $languages[$i]['iso_639_2'] . '.gif', $languages[$i]['name']) . '&nbsp;' . oos_get_customer_status_name($cInfo->customers_status_id, $languages[$i]['id']);
        }
        $contents[] = array('text' => $customers_status_inputs_string);
        $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE_INTRO . '<br /><b>' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_PRICE . ' ' . $cInfo->customers_status_discount . '%</b>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_DISCOUNT_OT_XMEMBER_INTRO . '<br /><b>' . ENTRY_OT_XMEMBER . ' ' . $customers_status_ot_discount_flag_array[$cInfo->customers_status_ot_discount_flag]['text'] . ' (' . $cInfo->customers_status_ot_discount_flag . ')' . '</b><br />' . ENTRY_MINIMUM_AMOUNT_OT_XMEMBER . ':<br /><b>' .  $currencies->format($cInfo->customers_status_ot_minimum) . ' - ' . $cInfo->customers_status_ot_discount . '%</b>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_STAFFELPREIS_INTRO . '<br /><b>' . ENTRY_STAFFELPREIS . ' ' . $customers_status_qty_discounts_array[$cInfo->customers_status_qty_discounts]['text'] . ' (' . $cInfo->customers_status_qty_discounts . ')</b>' );
        $contents[] = array('text' => '<br />' . TEXT_INFO_CUSTOMERS_STATUS_PAYMENT_INTRO . '<br /><b>' . ENTRY_CUSTOMERS_STATUS_PAYMENT . '</b>' );
        $contents[] = array('text' => '<br />'  . oos_customers_payment($cInfo->customers_status_payment));
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