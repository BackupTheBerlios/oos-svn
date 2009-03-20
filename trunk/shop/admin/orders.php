<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: orders.php,v 1.107 2003/02/06 17:37:08 thomasamoulton
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
  * Remove Order
  *
  * @param $order_id
  * @param $restock
  */
  function oos_remove_order($order_id, $restock = false) {

    // Get database information
    $dbconn =& oosDBGetConn();
    $oostable =& oosDBGetTables();

    if (is_numeric($order_id)) {
      if ($restock == 'on') {
        $orders_productstable = $oostable['orders_products'];
        $order_sql = "SELECT products_id, products_quantity
                      FROM $orders_productstable
                      WHERE orders_id = '" . (int)$order_id . "'";
        $order_result = $dbconn->Execute($order_sql);
        while ($order = $order_result->fields) {
          $productstable = $oostable['products'];
          $dbconn->Execute("UPDATE $productstable
                            SET products_quantity = products_quantity + " . $order['products_quantity'] . ",
                                products_ordered = products_ordered - " . $order['products_quantity'] . "
                          WHERE products_id = '" . $order['products_id'] . "'");

          // Move that ADOdb pointer!
          $order_result->MoveNext();
        }
      }

      $orderstable = $oostable['orders'];
      $dbconn->Execute("DELETE FROM $orderstable WHERE orders_id = '" . oos_db_input($order_id) . "'");
      $orders_productstable = $oostable['orders_products'];
      $dbconn->Execute("DELETE FROM $orders_productstable WHERE orders_id = '" . oos_db_input($order_id) . "'");
      $orders_products_attributesstable = $oostable['orders_products_attributes'];
      $dbconn->Execute("DELETE FROM $orders_products_attributesstable WHERE orders_id = '" . oos_db_input($order_id) . "'");
      $orders_status_historytable = $oostable['orders_status_history'];
      $dbconn->Execute("DELETE FROM $orders_status_historytable WHERE orders_id = '" . oos_db_input($order_id) . "'");
      $orders_totaltable = $oostable['orders_total'];
      $dbconn->Execute("DELETE FROM $orders_totaltable WHERE orders_id = '" . oos_db_input($order_id) . "'");
      $banktransfertable = $oostable['banktransfer'];
      $dbconn->Execute("DELETE FROM $banktransfertable WHERE orders_id = '" . oos_db_input($order_id) . "'");
    }
  }


  function oos_get_languages_id ($iso_639_2) {

    $dbconn =& oosDBGetConn();
    $oostable =& oosDBGetTables();

    $languagestable = $oostable['languages'];
    $languages_result = $dbconn->Execute("SELECT languages_id, iso_639_2 FROM $languagestable WHERE iso_639_2 = '" . oos_db_input($iso_639_2) . "'");
    if (!$languages_result->RecordCount()) {
      $LangID = $_SESSION['language_id'];
    } else {
      $LangID = $languages_result->fields['languages_id'];
    }

    return $LangID;
  }


  require 'includes/classes/class_currencies.php';
  $currencies = new currencies();

  $orders_statuses = array();
  $orders_status_array = array();
  $orders_statustable = $oostable['orders_status'];
  $orders_status_result = $dbconn->Execute("SELECT orders_status_id, orders_status_name FROM $orders_statustable WHERE orders_languages_id = '" . intval($_SESSION['language_id']) . "'");
  while ($orders_status = $orders_status_result->fields) {
    $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                               'text' => $orders_status['orders_status_name']);
    $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];

    // Move that ADOdb pointer!
    $orders_status_result->MoveNext();
  }


  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (!empty($action)) {
    switch ($action) {
      case 'update_order':
        $oID = oos_db_prepare_input($_GET['oID']);

        $order_updated = false;

        $orderstable = $oostable['orders'];
        $check_status_result = $dbconn->Execute("SELECT customers_name, customers_email_address, orders_status, date_purchased, orders_language FROM $orderstable WHERE orders_id = '" . oos_db_input($oID) . "'");
        $check_status = $check_status_result->fields;

        if ($check_status['orders_status'] != $status || $comments != '' || ($status == DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE) ) {
          $orderstable = $oostable['orders'];
          $dbconn->Execute("UPDATE $orderstable SET orders_status = '" . oos_db_input($status) . "', last_modified = now() WHERE orders_id = '" . oos_db_input($oID) . "'");

          $orderstable = $oostable['orders'];
          $check_status_result2 = $dbconn->Execute("SELECT customers_name, customers_email_address, orders_status, date_purchased FROM $orderstable WHERE orders_id = '" . oos_db_input($oID) . "'");
          $check_status2 = $check_status_result2->fields;

          if ( $check_status2['orders_status'] == DOWNLOADS_ORDERS_STATUS_UPDATED_VALUE ) {
            $orders_products_downloadtable = $oostable['orders_products_download'];
            $dbconn->Execute("UPDATE $orders_products_downloadtable SET download_maxdays = '" . oos_db_input(DOWNLOAD_MAX_DAYS) . "', download_count = '" . oos_db_input(DOWNLOAD_MAX_COUNT) . "' WHERE orders_id = '" . oos_db_input($oID) . "'");
          }

          $customer_notified = '0';

          if (isset($_POST['notify']) && ($_POST['notify'] == 'on')) {

            if (oos_is_not_null($check_status['orders_language'])) {
              include 'includes/languages/' . $check_status['orders_language'] . '/email_orders.php';
              $nLangID = oos_get_languages_id($check_status['orders_language']);
              $orders_statustable = $oostable['orders_status'];
              $orders_status_result = $dbconn->Execute("SELECT orders_status_id, orders_status_name FROM $orders_statustable WHERE orders_languages_id = '" . intval($nLangID) . "'");
            } else {
              $orders_statustable = $oostable['orders_status'];
              include 'includes/languages/' . $_SESSION['language'] . '/email_orders.php';
              $orders_status_result = $dbconn->Execute("SELECT orders_status_id, orders_status_name FROM $orders_statustable WHERE orders_languages_id = '" . intval($_SESSION['language_id']) . "'");
            }

            $orders_statuses = array();
            $orders_status_array = array();
            while ($orders_status = $orders_status_result->fields) {
              $orders_statuses[] = array('id' => $orders_status['orders_status_id'],
                                         'text' => $orders_status['orders_status_name']);
              $orders_status_array[$orders_status['orders_status_id']] = $orders_status['orders_status_name'];
              // Move that ADOdb pointer!
              $orders_status_result->MoveNext();
            }

            // status query
            $orders_statustable = $oostable['orders_status'];
            $orders_status_result = $dbconn->Execute("SELECT orders_status_name FROM $orders_statustable WHERE orders_languages_id = '" . intval($_SESSION['language_id']) . "' AND orders_status_id = '" . oos_db_input($status) . "'");
            $o_status = $orders_status_result->fields;
            $o_status = $o_status['orders_status_name'];

            $notify_comments = '';
            if (isset($_POST['notify_comments']) && ($_POST['notify_comments'] == 'on')) {
              if (isset($comments)) {
                $notify_comments = sprintf(EMAIL_TEXT_COMMENTS_UPDATE, $comments) . "\n\n";
              }
            }
            $email = STORE_NAME . "\n" . EMAIL_SEPARATOR . "\n" . EMAIL_TEXT_ORDER_NUMBER . ' ' . $oID . "\n" . EMAIL_TEXT_INVOICE_URL . ' ' . oos_catalog_link($oosModules['account'], $oosCatalogFilename['account_history_info'], 'order_id=' . $oID, 'SSL') . "\n" . EMAIL_TEXT_DATE_ORDERED . ' ' . oos_date_long($check_status['date_purchased']) . "\n\n" . $notify_comments . sprintf(EMAIL_TEXT_STATUS_UPDATE, $orders_status_array[$status]);
            oos_mail($check_status['customers_name'], $check_status['customers_email_address'], EMAIL_TEXT_SUBJECT, nl2br($email), STORE_OWNER, STORE_OWNER_EMAIL_ADDRESS);
            $customer_notified = '1';
          }

          $orders_status_historytable = $oostable['orders_status_history'];
          $dbconn->Execute("INSERT INTO $orders_status_historytable (orders_id, orders_status_id, date_added, customer_notified, comments) VALUES ('" . oos_db_input($oID) . "', '" . oos_db_input($status) . "', now(), '" . $customer_notified . "', '" . oos_db_input($comments)  . "')");

          $order_updated = true;
        }

        if ($order_updated) {
          $messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');
        } else {
          $messageStack->add_session(WARNING_ORDER_NOT_UPDATED, 'warning');
        }

        oos_redirect_admin(oos_href_link_admin($aFilename['orders'], oos_get_all_get_params(array('action')) . 'action=edit'));
        break;

      case 'update_serial':
        $oID = oos_db_prepare_input($_GET['oID']);

        $serial_number = oos_db_prepare_input($_POST['serial_number']);
        $serial = oos_db_prepare_input($_GET['serial']);

        $orders_productstable = $oostable['orders_products'];
        $dbconn->Execute("UPDATE $orders_productstable SET products_serial_number = '" . oos_db_input($serial_number) . "' WHERE orders_id = '" . oos_db_input($oID) . "' AND orders_products_id = '" . oos_db_input($serial) . "'");

        $messageStack->add_session(SUCCESS_ORDER_UPDATED, 'success');

        oos_redirect_admin(oos_href_link_admin($aFilename['orders'], oos_get_all_get_params(array('action')) . 'action=edit&serial_updated=1'));
        break;

    case 'deleteconfirm':
        $oID = oos_db_prepare_input($_GET['oID']);

        oos_remove_order($oID, $_POST['restock']);

        oos_redirect_admin(oos_href_link_admin($aFilename['orders'], oos_get_all_get_params(array('oID', 'action'))));
        break;

    }
  }
  if (($action == 'edit') && isset($_GET['oID'])) {
    $oID = oos_db_prepare_input($_GET['oID']);

    $orderstable = $oostable['orders'];
    $orders_result = $dbconn->Execute("SELECT orders_id FROM $orderstable WHERE orders_id = '" . oos_db_input($oID) . "'");
    $order_exists = true;
    if (!$orders_result->RecordCount()) {
      $order_exists = false;
      $messageStack->add(sprintf(ERROR_ORDER_DOES_NOT_EXIST, $oID), 'error');
    }
  }

  include '../includes/classes/class_order.php';

  $no_js_general = true;
  require 'includes/oos_header.php';
?>
<?php
  if (defined('GOOGLE_MAP_API_KEY')) {
?>
<script language="javascript"><!--
function popupGoogleMap(url) {
  window.open(url,'popupImageWindow','toolbar=no,location=no,directories=no,status=no,menubar=no,scrollbars=no,resizable=yes,copyhistory=no,width=550,height=400,screenX=150,screenY=150,top=150,left=150')
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
<?php
  if (($action == 'edit') && ($order_exists == true)) {
    $order = new order($oID);
    $the_customers_id = $order->customer['id'];

    // Look up things in customers
    $customerstable = $oostable['customers'];
    $the_extra_result= $dbconn->Execute("SELECT customers_fax FROM $customerstable WHERE customers_id = '" . (int)$the_customers_id . "'");
    $the_customers_fax = $the_extra_result->fields['customers_fax'];
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo oos_draw_separator('trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td class="pageHeading" align="right">
            <?php echo '<a href="' . oos_href_link_admin($aFilename['edit_orders'], oos_get_all_get_params(array('action'))) . '">' . oos_image_swap_button('edit','edit_off.gif', IMAGE_EDIT) . '</a> &nbsp; '; ?>
            <?php echo '<a href="' . oos_href_link_admin($aFilename['orders'], oos_get_all_get_params(array('action'))) . '">' . oos_image_swap_button('back','back_off.gif', IMAGE_BACK) . '</a>'; ?>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td colspan="3"><?php echo oos_draw_separator(); ?></td>
          </tr>
          <tr>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_CUSTOMER; ?></b></td>
                <td class="main"><?php echo oos_address_format($order->customer['format_id'], $order->customer, 1, '&nbsp;', '<br />'); ?></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo oos_draw_separator('trans.gif', '1', '5'); ?></td>
              </tr>
<?php
      if (defined('GOOGLE_MAP_API_KEY')) {
?>
              <tr>
                <td class="main" valign="top"><b>Google Map</b></td>
                <td class="main"><?php echo '<a href="javascript:popupGoogleMap(\'' . $aFilename['popup_google_map'] . '?query=' . rawurlencode($order->customer['city']. ', '.$order->customer['country']) . '\')">' . oos_image(OOS_IMAGES . 'icon_popup.gif', 'View Google Map'); ?></a></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo oos_draw_separator('trans.gif', '1', '5'); ?></td>
              </tr>
<?php
      }
?>
              <tr>
                <td class="main"><b><?php echo ENTRY_TELEPHONE; ?></b></td>
                <td class="main"><?php echo $order->customer['telephone']; ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo 'FAX #:'; ?></b></td>
                <td class="main"><?php echo $the_customers_fax; ?></td>
              </tr>
            <tr>
                <td class="main"><b><?php echo ENTRY_EMAIL_ADDRESS; ?></b></td>
                <td class="main"><?php echo '<a href="mailto:' . $order->customer['email_address'] . '"><u>' . $order->customer['email_address'] . '</u></a>'; ?></td>
              </tr>
            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_SHIPPING_ADDRESS; ?></b></td>
                <td class="main"><?php echo oos_address_format($order->delivery['format_id'], $order->delivery, 1, '&nbsp;', '<br />'); ?></td>
              </tr>
<?php
      if (defined('GOOGLE_MAP_API_KEY')) {
?>
              <tr>
                <td class="main" valign="top"><b>Google Map</b></td>
                <td class="main"><?php echo '<a href="javascript:popupGoogleMap(\'' . $aFilename['popup_google_map'] . '?query=' . rawurlencode($order->delivery['city']. ', '.$order->delivery['country']) . '\')">' . oos_image(OOS_IMAGES . 'icon_popup.gif', 'View Google Map'); ?></a></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo oos_draw_separator('trans.gif', '1', '5'); ?></td>
              </tr>
<?php
      }
?>

            </table></td>
            <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td class="main" valign="top"><b><?php echo ENTRY_BILLING_ADDRESS; ?></b></td>
                <td class="main"><?php echo oos_address_format($order->billing['format_id'], $order->billing, 1, '&nbsp;', '<br />'); ?></td>
              </tr>
<?php
      if (defined('GOOGLE_MAP_API_KEY')) {
?>
              <tr>
                <td class="main" valign="top"><b>Google Map</b></td>
                <td class="main"><?php echo '<a href="javascript:popupGoogleMap(\'' . $aFilename['popup_google_map'] . '?query=' . rawurlencode($order->billing['city']. ', '.$order->billing['country']) . '\')">' . oos_image(OOS_IMAGES . 'icon_popup.gif', 'View Google Map'); ?></a></td>
              </tr>
              <tr>
                <td colspan="2"><?php echo oos_draw_separator('trans.gif', '1', '5'); ?></td>
              </tr>
<?php
      }
?>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main"><b><?php echo ENTRY_ORDER_NUMBER; ?></b></td>
            <td class="main"><?php echo intval($oID); ?></td>
          <tr>
          <tr>
            <td class="main"><b><?php echo ENTRY_ORDER_DATE; ?></b></td>
            <td class="main"><?php echo oos_datetime_short($order->info['date_purchased']); ?></td>
          <tr>
          <tr>
            <td class="main"><b><?php echo ENTRY_CAMPAIGNS; ?></b></td>
            <td class="main"><?php echo $order->info['campaigns']; ?></td>
          <tr>
          <tr>
            <td class="main"><b><?php echo ENTRY_PAYMENT_METHOD; ?></b></td>
            <td class="main"><?php echo $order->info['payment_method']; ?></td>
          </tr>
<?php
    if (oos_is_not_null($order->info['cc_type']) || oos_is_not_null($order->info['cc_owner']) || oos_is_not_null($order->info['cc_number'])) {
?>
          <tr>
            <td colspan="2"><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_TYPE; ?></td>
            <td class="main"><?php echo $order->info['cc_type']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_OWNER; ?></td>
            <td class="main"><?php echo $order->info['cc_owner']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_NUMBER; ?></td>
            <td class="main"><?php echo $order->info['cc_number']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo ENTRY_CREDIT_CARD_EXPIRES; ?></td>
            <td class="main"><?php echo $order->info['cc_expires']; ?></td>
          </tr>
<?php
    }

    $banktransfertable = $oostable['banktransfer'];
    $banktransfer_result = $dbconn->Execute("SELECT banktransfer_prz, banktransfer_status, banktransfer_owner, banktransfer_number, banktransfer_bankname, banktransfer_blz, banktransfer_fax FROM $banktransfertable  WHERE orders_id = '" . oos_db_input($_GET['oID']) . "'");
    $banktransfer = $banktransfer_result->fields;
    if (($banktransfer['banktransfer_bankname']) || ($banktransfer['banktransfer_blz']) || ($banktransfer['banktransfer_number'])) {
?>
          <tr>
            <td colspan="2"><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_BANK_NAME; ?></td>
            <td class="main"><?php echo $banktransfer['banktransfer_bankname']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_BANK_BLZ; ?></td>
            <td class="main"><?php echo $banktransfer['banktransfer_blz']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_BANK_NUMBER; ?></td>
            <td class="main"><?php echo $banktransfer['banktransfer_number']; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_BANK_OWNER; ?></td>
            <td class="main"><?php echo $banktransfer['banktransfer_owner']; ?></td>
          </tr>
<?php
      if ($banktransfer['banktransfer_status'] == 0) {
?>
          <tr>
            <td class="main"><?php echo TEXT_BANK_STATUS; ?></td>
            <td class="main"><?php echo "OK"; ?></td>
          </tr>
<?php
      } else {
?>
          <tr>
            <td class="main"><?php echo TEXT_BANK_STATUS; ?></td>
            <td class="main"><?php echo $banktransfer['banktransfer_status']; ?></td>
          </tr>
<?php
        switch ($banktransfer['banktransfer_status']) {
          case 1: $error_val = TEXT_BANK_ERROR_1; break;
          case 2: $error_val = TEXT_BANK_ERROR_2; break;
          case 3: $error_val = TEXT_BANK_ERROR_3; break;
          case 4: $error_val = TEXT_BANK_ERROR_4; break;
          case 5: $error_val = TEXT_BANK_ERROR_5; break;
          case 8: $error_val = TEXT_BANK_ERROR_8; break;
          case 9: $error_val = TEXT_BANK_ERROR_9; break;
        }
?>
          <tr>
            <td class="main"><?php echo TEXT_BANK_ERRORCODE; ?></td>
            <td class="main"><?php echo $error_val; ?></td>
          </tr>
          <tr>
            <td class="main"><?php echo TEXT_BANK_PRZ; ?></td>
            <td class="main"><?php echo $banktransfer['banktransfer_prz']; ?></td>
          </tr>
<?php
      }
    }
    if ($banktransfer['banktransfer_fax']) {
?>
          <tr>
            <td class="main"><?php echo TEXT_BANK_FAX; ?></td>
            <td class="main"><?php echo $banktransfer['banktransfer_fax']; ?></td>
          </tr>
<?php
    }
?>
        </table></td>
      </tr>
      <tr>
        <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr class="dataTableHeadingRow">
            <td class="dataTableHeadingContent" colspan="2"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_SERIAL_NUMBER; ?></td>
            <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_MODEL; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_EXCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_PRICE_INCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_EXCLUDING_TAX; ?></td>
            <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_INCLUDING_TAX; ?></td>
          </tr>
<?php
    for ($i = 0, $n = count($order->products); $i < $n; $i++) {
      echo '          <tr class="dataTableRow">' . "\n" .
           '            <td class="dataTableContent" valign="top" align="right">' . $order->products[$i]['qty'] . '&nbsp;x</td>' . "\n" .
           '            <td class="dataTableContent" valign="top">' . $order->products[$i]['name'];

      if (count($order->products[$i]['attributes']) > 0) {
        for ($j = 0, $k = count($order->products[$i]['attributes']); $j < $k; $j++) {
          echo '<br /><nobr><small>&nbsp;<i> - ' . $order->products[$i]['attributes'][$j]['option'] . ': ' . $order->products[$i]['attributes'][$j]['value'];
          if ($order->products[$i]['attributes'][$j]['price'] != '0') echo ' (' . $order->products[$i]['attributes'][$j]['prefix'] . $currencies->format($order->products[$i]['attributes'][$j]['price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . ')';
          echo '</i></small></nobr>';
        }
      }
      echo '            </td>' . "\n";

      $serial_number = "Add Serial #";
      if (oos_is_not_null($order->products[$i]['serial_number'])) $serial_number = $order->products[$i]['serial_number'];
      echo '            <td class="dataTableContent" valign="top"><a href="' . oos_href_link_admin($aFilename['orders'], 'action=edit&oID=' . $oID . '&serial=' . $i, 'NONSSL') . '">' . $serial_number . '</a></td>' . "\n" .
           '            <td class="dataTableContent" valign="top">' . $order->products[$i]['model'] . '</td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top">' . oos_display_tax_value($order->products[$i]['tax']) . '%</td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(oos_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']), true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format($order->products[$i]['final_price'] * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n" .
           '            <td class="dataTableContent" align="right" valign="top"><b>' . $currencies->format(oos_add_tax($order->products[$i]['final_price'], $order->products[$i]['tax']) * $order->products[$i]['qty'], true, $order->info['currency'], $order->info['currency_value']) . '</b></td>' . "\n";
      echo '          </tr>' . "\n";

      if (oos_is_not_null($_GET['serial']) && ($_GET['serial'] == $i) && ($_GET['serial_updated'] <> 1)) {
        echo '          <tr class="dataTableRow">' . "\n" .
             '            <td class="dataTableContent" colspan="2" valign="top" align="right">Enter Serial #:&nbsp;</td>' . "\n";

        echo '            <td class="dataTableContent" colspan="7" valign="top">' .
                          oos_draw_form('serial_form', $aFilename['orders'], 'action=update_serial&oID=' . $oID . '&serial=' . $order->products[$i]['id'], 'post', '') .
                          oos_draw_input_field('serial_number', $serial_number, '', false, 'text', true) . '&nbsp;&nbsp;' . oos_image_swap_submits('update','update_off.gif', IMAGE_UPDATE) . '</td>' . "\n" .
             '          </tr>' . "\n";
      }
    }
?>
          <tr>
            <td align="right" colspan="9"><table border="0" cellspacing="0" cellpadding="2">
<?php
    for ($i = 0, $n = count($order->totals); $i < $n; $i++) {
      echo '              <tr>' . "\n" .
           '                <td align="right" class="smallText">' . $order->totals[$i]['title'] . '</td>' . "\n" .
           '                <td align="right" class="smallText">' . $order->totals[$i]['text'] . '</td>' . "\n" .
           '              </tr>' . "\n";
    }
?>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><table border="1" cellspacing="0" cellpadding="5">
          <tr>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_DATE_ADDED; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_CUSTOMER_NOTIFIED; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_STATUS; ?></b></td>
            <td class="smallText" align="center"><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
          </tr>
<?php
    $orders_status_historytable = $oostable['orders_status_history'];
    $orders_history_result = $dbconn->Execute("SELECT orders_status_id, date_added, customer_notified, comments FROM $orders_status_historytable WHERE orders_id = '" . oos_db_input($oID) . "' ORDER BY date_added");
    if ($orders_history_result->RecordCount()) {
      while ($orders_history = $orders_history_result->fields) {
        echo '          <tr>' . "\n" .
             '            <td class="smallText" align="center">' . oos_datetime_short($orders_history['date_added']) . '</td>' . "\n" .
             '            <td class="smallText" align="center">';
        if ($orders_history['customer_notified'] == '1') {
          echo oos_image(OOS_IMAGES . 'icons/tick.gif', ICON_TICK) . "</td>\n";
        } else {
          echo oos_image(OOS_IMAGES . 'icons/cross.gif', ICON_CROSS) . "</td>\n";
        }
        echo '            <td class="smallText">' . $orders_status_array[$orders_history['orders_status_id']] . '</td>' . "\n" .
             '            <td class="smallText">' . nl2br(oosDBOutput($orders_history['comments'])) . '&nbsp;</td>' . "\n" .
             '          </tr>' . "\n";
         // Move that ADOdb pointer!
        $orders_history_result->MoveNext();
      }
    } else {
        echo '          <tr>' . "\n" .
             '            <td class="smallText" colspan="5">' . TEXT_NO_ORDER_HISTORY . '</td>' . "\n" .
             '          </tr>' . "\n";
    }
?>
        </table></td>
      </tr>
      <tr>
        <td class="main"><br /><b><?php echo TABLE_HEADING_COMMENTS; ?></b></td>
      </tr>
      <tr>
        <td><?php echo oos_draw_separator('trans.gif', '1', '5'); ?></td>
      </tr>
      <tr><?php echo oos_draw_form('status', $aFilename['orders'], oos_get_all_get_params(array('action')) . 'action=update_order'); ?>
        <td class="main"><?php echo oos_draw_textarea_field('comments', 'soft', '60', '5'); ?></td>
      </tr>
      <tr>
        <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td><table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td><table border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td colspan="2" class="main"><b><?php echo ENTRY_STATUS; ?></b> <?php echo oos_draw_pull_down_menu('status', $orders_statuses, $order->info['orders_status']); ?></td>
              </tr>
              <tr>
                <td class="main"><b><?php echo ENTRY_NOTIFY_CUSTOMER; ?></b> <?php echo oos_draw_checkbox_field('notify', '', true); ?></td>
                <td class="main"><b><?php echo ENTRY_NOTIFY_COMMENTS; ?></b> <?php echo oos_draw_checkbox_field('notify_comments', '', true); ?></td>
              </tr>

            </table></td>
            <td valign="top"><?php echo oos_image_swap_submits('update','update_off.gif', IMAGE_UPDATE); ?></td>
          </tr>
        </table></td>
      </form></tr>
      <tr>
        <td colspan="2" align="right"><?php echo '<a href="' . oos_href_link_admin($aFilename['invoice'], 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . oos_image_swap_button('invoice','invoice_off.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . oos_href_link_admin($aFilename['packingslip'], 'oID=' . $_GET['oID']) . '" TARGET="_blank">' . oos_image_swap_button('pachingslip','packingslip_off.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a> <a href="' . oos_href_link_admin($aFilename['orders'], oos_get_all_get_params(array('action'))) . '">' . oos_image_swap_button('back','back_off.gif', IMAGE_BACK) . '</a>'; ?></td>
      </tr>
<?php
  } else {
?>
      <tr>
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo oos_draw_separator('trans.gif', 1, HEADING_IMAGE_HEIGHT); ?></td>
            <td align="right"><table border="0" width="100%" cellspacing="0" cellpadding="0">
              <tr><?php echo oos_draw_form('orders', $aFilename['orders'], '', 'get'); ?>
                <td class="smallText" align="right"><?php echo HEADING_TITLE_SEARCH . ' ' . oos_draw_input_field('oID', '', 'size="12"') . oos_draw_hidden_field('action', 'edit'); ?></td>
              </form></tr>
              <tr><?php echo oos_draw_form('status', $aFilename['orders'], '', 'get'); ?>
                <td class="smallText" align="right"><?php echo HEADING_TITLE_STATUS . ' ' . oos_draw_pull_down_menu('status', array_merge(array(array('id' => '', 'text' => TEXT_ALL_ORDERS)), $orders_statuses), '', 'onChange="this.form.submit();"'); ?></td>
              </form></tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_CUSTOMERS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ORDER_TOTAL; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_DATE_PURCHASED; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_STATUS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    if (isset($_GET['cID'])) {
      $cID = oos_db_prepare_input($_GET['cID']);

      $orderstable = $oostable['orders'];
      $orders_totaltable = $oostable['orders_total'];
      $orders_statustable = $oostable['orders_status'];
      $orders_result_raw = "SELECT o.orders_id, o.customers_name, o.customers_id, o.payment_method, o.date_purchased,
                                   o.last_modified, o.currency, o.currency_value, s.orders_status_name, ot.text AS order_total
                             FROM  $orderstable o LEFT JOIN
                                   $orders_totaltable ot
                                ON (o.orders_id = ot.orders_id),
                                   $orders_statustable s
                             WHERE o.customers_id = '" . oos_db_input($cID) . "' AND
                                   o.orders_status = s.orders_status_id AND
                                   s.orders_languages_id = '" . intval($_SESSION['language_id']) . "' AND
                                   ot.class = 'ot_total'
                             ORDER BY orders_id DESC";
    } elseif (isset($_GET['status'])) {
      $status = oos_db_prepare_input($_GET['status']);

      $orderstable = $oostable['orders'];
      $orders_totaltable = $oostable['orders_total'];
      $orders_statustable = $oostable['orders_status'];
      $orders_result_raw = "SELECT o.orders_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified,
                                   o.currency, o.currency_value, s.orders_status_name, ot.text as order_total
                             FROM $orderstable o LEFT JOIN
                                  $orders_totaltable ot
                               ON (o.orders_id = ot.orders_id),
                                  $orders_statustable s
                            WHERE o.orders_status = s.orders_status_id AND
                                  s.orders_languages_id = '" . intval($_SESSION['language_id']) . "' AND
                                  s.orders_status_id = '" . oos_db_input($status) . "' AND
                                  ot.class = 'ot_total'
                            ORDER BY o.orders_id DESC";
    } else {
      $orderstable = $oostable['orders'];
      $orders_totaltable = $oostable['orders_total'];
      $orders_statustable = $oostable['orders_status'];
      $orders_result_raw = "SELECT o.orders_id, o.customers_name, o.payment_method, o.date_purchased, o.last_modified,
                                   o.currency, o.currency_value, s.orders_status_name, ot.text as order_total
                             FROM $orderstable o LEFT JOIN
                                  $orders_totaltable ot
                               ON (o.orders_id = ot.orders_id),
                                  $orders_statustable s
                            WHERE o.orders_status = s.orders_status_id AND
                                  s.orders_languages_id = '" . intval($_SESSION['language_id']) . "' AND
                                  ot.class = 'ot_total'
                           ORDER BY o.orders_id DESC";
    }
    $orders_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $orders_result_raw, $orders_result_numrows);
    $orders_result = $dbconn->Execute($orders_result_raw);
    while ($orders = $orders_result->fields) {
      if ((!isset($_GET['oID']) || (isset($_GET['oID']) && ($_GET['oID'] == $orders['orders_id']))) && !isset($oInfo)) {
        $oInfo = new objectInfo($orders);
      }

      if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id)) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['orders'], oos_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['orders'], oos_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . oos_href_link_admin($aFilename['orders'], oos_get_all_get_params(array('oID', 'action')) . 'oID=' . $orders['orders_id'] . '&action=edit') . '">' . oos_image(OOS_IMAGES . 'icons/preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . $orders['customers_name']; ?></td>
                <td class="dataTableContent" align="right"><?php echo strip_tags($orders['order_total']); ?></td>
                <td class="dataTableContent" align="center"><?php echo oos_datetime_short($orders['date_purchased']); ?></td>
                <td class="dataTableContent" align="right"><?php echo $orders['orders_status_name']; ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($oInfo) && is_object($oInfo) && ($orders['orders_id'] == $oInfo->orders_id) ) { echo oos_image(OOS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . oos_href_link_admin($aFilename['orders'], oos_get_all_get_params(array('oID')) . 'oID=' . $orders['orders_id']) . '">' . oos_image(OOS_IMAGES . 'icon_information.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
      // Move that ADOdb pointer!
      $orders_result->MoveNext();
    }
?>
              <tr>
                <td colspan="5"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $orders_split->display_count($orders_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_ORDERS); ?></td>
                    <td class="smallText" align="right"><?php echo $orders_split->display_links($orders_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], oos_get_all_get_params(array('page', 'oID', 'action'))); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_ORDER . '</b>');

      $contents = array('form' => oos_draw_form('orders', $aFilename['orders'], oos_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO . '<br /><br /><b>' . $cInfo->customers_firstname . ' ' . $cInfo->customers_lastname . '</b>');
      $contents[] = array('text' => '<br />' . oos_draw_checkbox_field('restock') . ' ' . TEXT_INFO_RESTOCK_PRODUCT_QUANTITY);
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('delete','delete_off.gif', IMAGE_DELETE) . ' <a href="' . oos_href_link_admin($aFilename['orders'], oos_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    default:
      if (isset($oInfo) && is_object($oInfo)) {
        $heading[] = array('text' => '<b>[' . $oInfo->orders_id . ']&nbsp;&nbsp;' . oos_datetime_short($oInfo->date_purchased) . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . oos_href_link_admin($aFilename['orders'], oos_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=edit') . '">' . oos_image_swap_button('edit','edit_off.gif', IMAGE_EDIT) . '</a> <a href="' . oos_href_link_admin($aFilename['orders'], oos_get_all_get_params(array('oID', 'action')) . 'oID=' . $oInfo->orders_id . '&action=delete') . '">' . oos_image_swap_button('delete','delete_off.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('align' => 'center', 'text' => '<a href="' . oos_href_link_admin($aFilename['invoice'], 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . oos_image_swap_button('invoice','invoice_off.gif', IMAGE_ORDERS_INVOICE) . '</a> <a href="' . oos_href_link_admin($aFilename['packingslip'], 'oID=' . $oInfo->orders_id) . '" TARGET="_blank">' . oos_image_swap_button('packingslip','packingslip_off.gif', IMAGE_ORDERS_PACKINGSLIP) . '</a>');

        $contents[] = array('text' => '<br />' . TEXT_DATE_ORDER_CREATED . ' ' . oos_date_short($oInfo->date_purchased));
        if (oos_is_not_null($oInfo->last_modified)) $contents[] = array('text' => TEXT_DATE_ORDER_LAST_MODIFIED . ' ' . oos_date_short($oInfo->last_modified));
        $contents[] = array('text' => '<br />' . TEXT_INFO_PAYMENT_METHOD . ' '  . $oInfo->payment_method);
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
<?php
  }
?>
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