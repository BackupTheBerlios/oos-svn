<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: reviews.php,v 1.39 2002/03/17 17:49:46 harley_vb
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

if ( !current_user_can('reviews') )
    oos_redirect_admin(oos_href_link_admin($aFilename['forbiden']));


  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (!empty($action)) {
    switch ($action) {
      case 'update':
        $reviews_id = oos_db_prepare_input($_GET['rID']);

        $reviewstable = $oostable['reviews'];
        $dbconn->Execute("UPDATE $reviewstable SET reviews_rating = '" . oos_db_input($reviews_rating) . "', last_modified = '" . date("Y-m-d H:i:s", time()) . "' WHERE reviews_id = '" . oos_db_input($reviews_id) . "'");
        $reviews_descriptiontable = $oostable['reviews_description'];
        $dbconn->Execute("UPDATE $reviews_descriptiontable SET reviews_text = '" . oos_db_input($reviews_text) . "' WHERE reviews_id = '" . oos_db_input($reviews_id) . "'");

        oos_redirect_admin(oos_href_link_admin($aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $reviews_id));
        break;

      case 'deleteconfirm':
        $reviews_id = oos_db_prepare_input($_GET['rID']);

        $reviewstable = $oostable['reviews'];
        $dbconn->Execute("DELETE FROM $reviewstable WHERE reviews_id = '" . oos_db_input($reviews_id) . "'");
        $reviews_descriptiontable = $oostable['reviews_description'];
        $dbconn->Execute("DELETE FROM $reviews_descriptiontable WHERE reviews_id = '" . oos_db_input($reviews_id) . "'");

        oos_redirect_admin(oos_href_link_admin($aFilename['reviews'], 'page=' . $_GET['page']));
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
        <td width="100%"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo oos_draw_separator('trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
<?php
  if ($action == 'edit') {
    $rID = oos_db_prepare_input($_GET['rID']);

    $reviewstable = $oostable['reviews'];
    $reviews_descriptiontable = $oostable['reviews_description'];
    $reviews_result = $dbconn->Execute("SELECT r.reviews_id, r.products_id, r.customers_name, r.date_added, r.last_modified, r.reviews_read, rd.reviews_text, r.reviews_rating FROM $reviewstable r, $reviews_descriptiontable rd WHERE r.reviews_id = '" . oos_db_input($rID) . "' AND r.reviews_id = rd.reviews_id");
    $reviews = $reviews_result->fields;

    $productstable = $oostable['products'];
    $products_result = $dbconn->Execute("SELECT products_image FROM $productstable WHERE products_id = '" . $reviews['products_id'] . "'");
    $products = $products_result->fields;

    $products_descriptiontable = $oostable['products_description'];
    $products_name_result = $dbconn->Execute("SELECT products_name FROM $products_descriptiontable WHERE products_id = '" . $reviews['products_id'] . "' AND products_languages_id = '" . intval($_SESSION['language_id']) . "'");
    $products_name = $products_name_result->fields;

    $rInfo_array = array_merge($reviews, $products, $products_name);
    $rInfo = new objectInfo($rInfo_array);
?>
      <tr><?php echo oos_draw_form('review', $aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $_GET['rID'] . '&action=preview'); ?>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_PRODUCT; ?></b> <?php echo $rInfo->products_name; ?><br /><b><?php echo ENTRY_FROM; ?></b> <?php echo $rInfo->customers_name; ?><br /><br /><b><?php echo ENTRY_DATE; ?></b> <?php echo oos_date_short($rInfo->date_added); ?></td>
            <td class="main" align="right" valign="top"><?php echo oos_image(OOS_HTTP_SERVER . OOS_IMAGES . $rInfo->products_image, $rInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"'); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_REVIEW; ?></b><br /><br /><?php echo oos_draw_textarea_field('reviews_text', 'soft', '60', '15', $rInfo->reviews_text); ?></td>
          </tr>
          <tr>
            <td class="smallText" align="right"><?php echo ENTRY_REVIEW_TEXT; ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo ENTRY_RATING; ?></b>&nbsp;<?php echo TEXT_BAD; ?>&nbsp;<?php for ($i=1; $i<=5; $i++) echo oos_draw_radio_field('reviews_rating', $i, '', $rInfo->reviews_rating) . '&nbsp;'; echo TEXT_GOOD; ?></td>
      </tr>
      <tr>
        <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td align="right" class="main"><?php echo oos_draw_hidden_field('reviews_id', $rInfo->reviews_id) . oos_draw_hidden_field('products_id', $rInfo->products_id) . oos_draw_hidden_field('customers_name', $rInfo->customers_name) . oos_draw_hidden_field('products_name', $rInfo->products_name) . oos_draw_hidden_field('products_image', $rInfo->products_image) . oos_draw_hidden_field('date_added', $rInfo->date_added) . oos_image_swap_submits('preview', 'preview_off.gif', IMAGE_PREVIEW) . ' <a href="' . oos_href_link_admin($aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $_GET['rID']) . '">' . oos_image_swap_button('cancel', 'cancel_off.gif', IMAGE_CANCEL) . '</a>'; ?></td>
      </form></tr>
<?php
  } elseif ($action == 'preview') {
    if (isset($_POST)) {
      $rInfo = new objectInfo($_POST);
    } else {
      $reviewstable = $oostable['reviews'];
      $reviews_descriptiontable = $oostable['reviews_description'];
      $reviews_result = $dbconn->Execute("SELECT r.reviews_id, r.products_id, r.customers_name, r.date_added, r.last_modified, r.reviews_read, rd.reviews_text, r.reviews_rating FROM $reviewstable r, $reviews_descriptiontable rd WHERE r.reviews_id = '" . $_GET['rID'] . "' AND r.reviews_id = rd.reviews_id");
      $reviews = $reviews_result->fields;

      $productstable = $oostable['products'];
      $products_result = $dbconn->Execute("SELECT products_image FROM $productstable WHERE products_id = '" . $reviews['products_id'] . "'");
      $products = $products_result->fields;

      $products_descriptiontable = $oostable['products_description'];
      $products_name_result = $dbconn->Execute("SELECT products_name FROM $products_descriptiontable WHERE products_id = '" . $reviews['products_id'] . "' AND products_languages_id = '" . intval($_SESSION['language_id']) . "'");
      $products_name = $products_name_result->fields;

      $rInfo_array = array_merge($reviews, $products, $products_name);
      $rInfo = new objectInfo($rInfo_array);
    }
?>
      <tr><?php echo oos_draw_form('update', $aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $_GET['rID'] . '&action=update', 'post', 'enctype="multipart/form-data"'); ?>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="main" valign="top"><b><?php echo ENTRY_PRODUCT; ?></b> <?php echo $rInfo->products_name; ?><br /><b><?php echo ENTRY_FROM; ?></b> <?php echo $rInfo->customers_name; ?><br /><br /><b><?php echo ENTRY_DATE; ?></b> <?php echo oos_date_short($rInfo->date_added); ?></td>
            <td class="main" align="right" valign="top"><?php echo oos_image(OOS_HTTP_SERVER . OOS_IMAGES . $rInfo->products_image, $rInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT, 'hspace="5" vspace="5"'); ?></td>
          </tr>
        </table>
      </tr>
      <tr>
        <td><table witdh="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top" class="main"><b><?php echo ENTRY_REVIEW; ?></b><br /><br /><?php echo nl2br(htmlspecialchars(oos_break_string($rInfo->reviews_text, 15))); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td class="main"><b><?php echo ENTRY_RATING; ?></b>&nbsp;<?php echo oos_image(OOS_SHOP_IMAGES . 'stars_' . $rInfo->reviews_rating . '.gif', sprintf(TEXT_OF_5_STARS, $rInfo->reviews_rating)); ?>&nbsp;<small>[<?php echo sprintf(TEXT_OF_5_STARS, $rInfo->reviews_rating); ?>]</small></td>
      </tr>
      <tr>
        <td><?php echo oos_draw_separator('trans.gif', '1', '10'); ?></td>
      </tr>
<?php
    if (isset($_POST)) {
/* Re-Post all POST'ed variables */
      reset($_POST);
      while(list($key, $value) = each($_POST)) echo '<input type="hidden" name="' . $key . '" value="' . htmlspecialchars(stripslashes($value)) . '">';
?>
      <tr>
        <td align="right" class="smallText"><?php echo '<a href="' . oos_href_link_admin($aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=edit') . '">' . oos_image_swap_button('back','back_off.gif', IMAGE_BACK) . '</a> ' . oos_image_swap_submits('update','update_off.gif', IMAGE_UPDATE) . ' <a href="' . oos_href_link_admin($aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>'; ?></td>
      </form></tr>
<?php
    } else {
      if (isset($_GET['origin'])) {
        $back_url = $_GET['origin'];
        $back_url_params = '';
      } else {
        $back_url = $aFilename['reviews'];
        $back_url_params = 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id;
      }
?>
      <tr>
        <td align="right"><?php echo '<a href="' . oos_href_link_admin($back_url, $back_url_params, 'NONSSL') . '">' . oos_image_swap_button('back','back_off.gif', IMAGE_BACK) . '</a>'; ?></td>
      </tr>
<?php
    }
  } else {
?>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_RATING; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_DATE_ADDED; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
    $reviewstable = $oostable['reviews'];
    $reviews_result_raw = "SELECT reviews_id, products_id, date_added, last_modified, reviews_rating
                           FROM $reviewstable
                           ORDER BY date_added DESC";
    $reviews_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $reviews_result_raw, $reviews_result_numrows);
    $reviews_result = $dbconn->Execute($reviews_result_raw);
    while ($reviews = $reviews_result->fields) {
      if ( ((!$_GET['rID']) || ($_GET['rID'] == $reviews['reviews_id'])) && (!$rInfo) ) {
        $reviewstable = $oostable['reviews'];
        $reviews_descriptiontable = $oostable['reviews_description'];
        $reviews_text_result = $dbconn->Execute("SELECT r.reviews_read, r.customers_name, length(rd.reviews_text) as reviews_text_size FROM $reviewstable r, $reviews_descriptiontable rd WHERE r.reviews_id = '" . $reviews['reviews_id'] . "' AND r.reviews_id = rd.reviews_id");
        $reviews_text = $reviews_text_result->fields;

        $productstable = $oostable['products'];
        $products_image_result = $dbconn->Execute("SELECT products_image FROM $productstable WHERE products_id = '" . $reviews['products_id'] . "'");
        $products_image = $products_image_result->fields;

        $products_descriptiontable = $oostable['products_description'];
        $products_name_result = $dbconn->Execute("SELECT products_name FROM $products_descriptiontable WHERE products_id = '" . $reviews['products_id'] . "' AND products_languages_id = '" . intval($_SESSION['language_id']) . "'");
        $products_name = $products_name_result->fields;

        $reviewstable = $oostable['reviews'];
        $reviews_average_result = $dbconn->Execute("SELECT (avg(reviews_rating) / 5 * 100) as average_rating FROM $reviewstable WHERE products_id = '" . $reviews['products_id'] . "'");
        $reviews_average = $reviews_average_result->fields;

        $review_info = array_merge($reviews_text, $reviews_average, $products_name);
        $rInfo_array = array_merge($reviews, $review_info, $products_image);
        $rInfo = new objectInfo($rInfo_array);
      }

      if (isset($rInfo) && is_object($rInfo) && ($reviews['reviews_id'] == $rInfo->reviews_id) ) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=preview') . '\'">' . "\n";
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . oos_href_link_admin($aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $reviews['reviews_id']) . '\'">' . "\n";
      }
?>
                <td class="dataTableContent"><?php echo '<a href="' . oos_href_link_admin($aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $reviews['reviews_id'] . '&action=preview') . '">' . oos_image(OOS_IMAGES . 'icons/preview.gif', ICON_PREVIEW) . '</a>&nbsp;' . oos_get_products_name($reviews['products_id']); ?></td>
                <td class="dataTableContent" align="right"><?php echo oos_image(OOS_HTTP_SERVER . OOS_SHOP . OOS_IMAGES . 'stars_' . $reviews['reviews_rating'] . '.gif'); ?></td>
                <td class="dataTableContent" align="right"><?php echo oos_date_short($reviews['date_added']); ?></td>
                <td class="dataTableContent" align="right"><?php if (isset($rInfo) && is_object($rInfo) && ($reviews['reviews_id'] == $rInfo->reviews_id) ) { echo oos_image(OOS_IMAGES . 'icon_arrow_right.gif'); } else { echo '<a href="' . oos_href_link_admin($aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $reviews['reviews_id']) . '">' . oos_image(OOS_IMAGES . 'icon_information.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
      // Move that ADOdb pointer!
      $reviews_result->MoveNext();
    }

    // Close result set
    $reviews_result->Close();
?>
              <tr>
                <td colspan="4"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $reviews_split->display_count($reviews_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_REVIEWS); ?></td>
                    <td class="smallText" align="right"><?php echo $reviews_split->display_links($reviews_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
<?php
    $heading = array();
    $contents = array();

    switch ($action) {
      case 'delete':
        $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_REVIEW . '</b>');

        $contents = array('form' => oos_draw_form('reviews', $aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=deleteconfirm'));
        $contents[] = array('text' => TEXT_INFO_DELETE_REVIEW_INTRO);
        $contents[] = array('text' => '<br /><b>' . $rInfo->products_name . '</b>');
        $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('delete', 'delete_off.gif', IMAGE_DELETE) . ' <a href="' . oos_href_link_admin($aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id) . '">' . oos_image_swap_button('cancel', 'cancel_off.gif', IMAGE_CANCEL) . '</a>');
        break;

      default:
      if (isset($rInfo) && is_object($rInfo)) {
        $heading[] = array('text' => '<b>' . $rInfo->products_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . oos_href_link_admin($aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=edit') . '">' . oos_image_swap_button('edit','edit_off.gif', IMAGE_EDIT) . '</a> <a href="' . oos_href_link_admin($aFilename['reviews'], 'page=' . $_GET['page'] . '&rID=' . $rInfo->reviews_id . '&action=delete') . '">' . oos_image_swap_button('delete', 'delete_off.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_DATE_ADDED . ' ' . oos_date_short($rInfo->date_added));
        if (!empty($rInfo->last_modified)) $contents[] = array('text' => TEXT_INFO_LAST_MODIFIED . ' ' . oos_date_short($rInfo->last_modified));
        $contents[] = array('text' => '<br />' . oos_info_image($rInfo->products_image, $rInfo->products_name, SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT));
        $contents[] = array('text' => '<br />' . TEXT_INFO_REVIEW_AUTHOR . ' ' . $rInfo->customers_name);
        $contents[] = array('text' => TEXT_INFO_REVIEW_RATING . ' ' . oos_image(OOS_HTTP_SERVER . OOS_SHOP . OOS_IMAGES . 'stars_' . $rInfo->reviews_rating . '.gif'));
        $contents[] = array('text' => TEXT_INFO_REVIEW_READ . ' ' . $rInfo->reviews_read);
        $contents[] = array('text' => '<br />' . TEXT_INFO_REVIEW_SIZE . ' ' . $rInfo->reviews_text_size . ' bytes');
        $contents[] = array('text' => '<br />' . TEXT_INFO_PRODUCTS_AVERAGE_RATING . ' ' . number_format($rInfo->average_rating, 2) . '%');
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