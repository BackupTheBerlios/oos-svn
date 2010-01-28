<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File:  xsell_products.php, v1  2002/09/11
   ----------------------------------------------------------------------
   Cross-Sell

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

if ( !current_user_can('xsell_products') )
    oos_redirect_admin(oos_href_link_admin($aFilename['forbiden']));

  require 'includes/classes/class_currencies.php';
  $currencies = new currencies();

  $language = $_SESSION['language'];

  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  switch($action) {
    case 'update_cross':
      if ($_POST['product']) {
        foreach ($_POST['product'] as $temp_prod) {
          $products_xselltable = $oostable['products_xsell'];
          $dbconn->Execute("DELETE FROM $products_xselltable WHERE xsell_id = '" . $temp_prod . "' AND products_id = '" . $_GET['add_related_product_ID'] . "'");
        }
      }

      $products_xselltable = $oostable['products_xsell'];
      $sort_start_result = $dbconn->Execute("SELECT sort_order FROM $products_xselltable WHERE products_id = '" . $_GET['add_related_product_ID'] . "' ORDER BY sort_order desc LIMIT 1");
      $sort_start = $sort_start_result->fields;

      $sort = (($sort_start['sort_order'] > 0) ? $sort_start['sort_order'] : '0');
      if ($_POST['cross']){
        foreach ($_POST['cross'] as $temp) {
          $sort++;
          $insert_array = array();
          $insert_array = array('products_id' => $_GET['add_related_product_ID'],
                                'xsell_id' => $temp,
                                'sort_order' => $sort);
          oos_db_perform($oostable['products_xsell'], $insert_array);
        }
      }
      $messageStack->add(CROSS_SELL_SUCCESS, 'success');
      break;

    case 'update_sort' :
      foreach ($_POST as $key_a => $value_a) {
        $products_xselltable = $oostable['products_xsell'];
        $dbconn->Execute("UPDATE $products_xselltable SET sort_order = '" . $value_a . "' WHERE xsell_id = '" . $key_a . "'");
      }
      $messageStack->add(SORT_CROSS_SELL_SUCCESS, 'success');
      break;
  }

  require 'includes/oos_header.php';

?>
<!-- body //-->
<style>
.productmenutitle{
cursor:pointer;
margin-bottom: 0px;
background-color:orange;
color:#FFFFFF;
font-weight:bold;
font-family:ms sans serif;
width:100%;
padding:3px;
font-size:12px;
text-align:center;
/* / */border:1px solid #000000;/* */
}
.productmenutitle1{
cursor:pointer;
margin-bottom: 0px;
background-color: red;
color:#FFFFFF;
font-weight:bold;
font-family:ms sans serif;
width:100%;
padding:3px;
font-size:12px;
text-align:center;
/* */border:1px solid #000000;/* */
}
</style>
<script language="JavaScript1.2">

function cOn(td)
{
if(document.getElementById||(document.all && !(document.getElementById)))
{
td.style.backgroundColor="#CCCCCC";
}
}

function cOnA(td)
{
if(document.getElementById||(document.all && !(document.getElementById)))
{
td.style.backgroundColor="#CCFFFF";
}
}

function cOut(td)
{
if(document.getElementById||(document.all && !(document.getElementById)))
{
td.style.backgroundColor="DFE4F4";
}
}
</script>

<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<?php require 'includes/oos_blocks.php'; ?>
    </table></td>
<!-- body_text //-->
      <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr>
          <td><?php echo oos_draw_separator('trans.gif', '100%', '10');?></td>
        </tr>
        <tr>
          <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
        </tr>
        <tr>
          <td><?php echo oos_draw_separator('trans.gif', '100%', '15');?></td>
        </tr>
      </table>

<?php
  if ($_GET['add_related_product_ID'] == ''){
?>
      <table border="0" cellspacing="1" cellpadding="2" bgcolor="#999999" align="center">
        <tr class="dataTableHeadingRow">
          <td class="dataTableHeadingContent" width="75"><?php echo TABLE_HEADING_PRODUCT_ID;?></td>
          <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCT_MODEL;?></td>
          <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCT_NAME;?></td>
          <td class="dataTableHeadingContent" nowrap><?php echo TABLE_HEADING_CURRENT_SELLS;?></td>
          <td class="dataTableHeadingContent" colspan="2" nowrap align="center"><?php echo TABLE_HEADING_UPDATE_SELLS;?></td>
        </tr>
<?php
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $products_result_raw = "SELECT p.products_id, p.products_model, pd.products_name, p.products_id
                            FROM $productstable p,
                                 $products_descriptiontable pd
                            WHERE p.products_id = pd.products_id
                              AND pd.products_languages_id = '" . intval($_SESSION['language_id']) . "'
                           ORDER BY p.products_id asc";
    $products_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $products_result_raw, $products_result_numrows);
    $products_result = $dbconn->Execute($products_result_raw);
    while ($products = $products_result->fields) {
?>
        <tr onMouseOver="cOn(this); this.style.cursor='pointer'; this.style.cursor='hand';" onMouseOut="cOut(this);" bgcolor='#DFE4F4' onClick=document.location.href="<?php echo oos_href_link_admin($aFilename['xsell_products'], 'add_related_product_ID=' . $products['products_id'], 'NONSSL');?>">
          <td class="dataTableContent" valign="top">&nbsp;<?php echo $products['products_id'];?>&nbsp;</td>
          <td class="dataTableContent" valign="top">&nbsp;<?php echo $products['products_model'];?>&nbsp;</td>
          <td class="dataTableContent" valign="top">&nbsp;<?php echo $products['products_name'];?>&nbsp;</td>
          <td class="dataTableContent" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
<?php
      $productstable = $oostable['products'];
      $products_descriptiontable = $oostable['products_description'];
      $products_xselltable = $oostable['products_xsell'];
      $products_cross_result = $dbconn->Execute("SELECT p.products_id, p.products_model, pd.products_name, p.products_id, x.products_id, x.xsell_id, x.sort_order, x.ID
                                                 FROM $productstable p,
                                                      $products_descriptiontable pd,
                                                      $products_xselltable x
                                                WHERE x.xsell_id = p.products_id
                                                  AND x.products_id = '" . $products['products_id'] . "'
                                                  AND p.products_id = pd.products_id
                                                  AND pd.products_languages_id = '" . intval($_SESSION['language_id']) . "'
                                                ORDER BY x.sort_order asc");
      $i = 0;
      while ($products_cross = $products_cross_result->fields){
        $i++;
?>
        <tr>
          <td class="dataTableContent">&nbsp;<?php echo $i . '.&nbsp;&nbsp;<b>' . $products_cross['products_model'] . '</b>&nbsp;' . $products_cross['products_name'];?>&nbsp;</td>
        </tr>
<?php
        // Move that ADOdb pointer!
        $products_cross_result->MoveNext();
      }
      // Close result set
      $products_cross_result->Close();

      if ($i <= 0) {
?>
        <tr>
          <td class="dataTableContent">&nbsp;--&nbsp;</td>
        </tr>
<?php
      } else {
?>
        <tr>
          <td class="dataTableContent"><?php echo oos_draw_separator('trans.gif', '100%', '10');?></td>
        </tr>
<?php
      }
?>
      </table></td>
      <td class="dataTableContent" valign="top">&nbsp;<a href="<?php echo oos_href_link_admin($aFilename['xsell_products'], oos_get_all_get_params(array('action')) . 'add_related_product_ID=' . $products['products_id'], 'NONSSL');?>"><?php echo TEXT_EDIT_SELLS;?></a>&nbsp;</td>
      <td class="dataTableContent" valign="top" align="center">&nbsp;<?php echo (($i > 0) ? '<a href="' . oos_href_link_admin($aFilename['xsell_products'], oos_get_all_get_params(array('action')) . 'sort=1&add_related_product_ID=' . $products['products_id'], 'NONSSL') .'">'.TEXT_SORT.'</a>&nbsp;' : '--')?></td>
    </tr>
<?php
      // Move that ADOdb pointer!
      $products_result->MoveNext();
    }

    // Close result set
    $products_result->Close();
?>
    <tr>
      <td colspan="6"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="infoBoxContent">
        <tr>
          <td class="smallText" valign="top"><?php echo $products_split->display_count($products_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
          <td class="smallText" align="right"><?php echo $products_split->display_links($products_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], oos_get_all_get_params(array('page', 'info', 'x', 'y', 'cID', 'action'))); ?></td>
        </tr>
      </table></td>
    </tr>
  </table>
<?php
  } elseif ($_GET['add_related_product_ID'] != '' && $_GET['sort'] == '') {
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $products_name_result = $dbconn->Execute("SELECT pd.products_name, p.products_model, p.products_image
                                          FROM $productstable p,
                                               $products_descriptiontable pd
                                          WHERE p.products_id = '" . $_GET['add_related_product_ID'] . "'
                                            AND p.products_id = pd.products_id
                                            AND pd.products_languages_id = '" . intval($_SESSION['language_id']) . "'");
    $products_name = $products_name_result->fields;
    // Close result set
    $products_name_result->Close();
?>
  <table border="0" cellspacing="0" cellpadding="0" bgcolor="#999999" align="center">
    <tr>
      <td><?php echo oos_draw_form('update_cross', $aFilename['xsell_products'], oos_get_all_get_params(array('action')) . 'action=update_cross', 'post');?><table cellpadding="1" cellspacing="1" border="0">
        <tr>
          <td colspan="6"><table cellpadding="3" cellspacing="0" border="0" width="100%">
            <tr class="dataTableHeadingRow">
              <td valign="top" align="center" colspan="2"><span class="pageHeading"><?php echo TEXT_SETTING_SELLS.': '.$products_name['products_name'].' ('.TEXT_MODEL.': '.$products_name['products_model'].') ('.TEXT_PRODUCT_ID.': '.$_GET['add_related_product_ID'].')';?></span></td>
            </tr>
            <tr class="dataTableHeadingRow">
              <td align="right"><?php echo oos_info_image($products_name['products_image'], $products_name['products_name']);?></td>
              <td align="right" valign="bottom"><?php echo oos_image_swap_submits('update','update_off.gif', IMAGE_UPDATE) . '<br /><br /><a href="'.oos_href_link_admin($aFilename['xsell_products'], 'men_id=catalog').'">' . oos_image_swap_button('cancel','cancel_off.gif') . '</a>';?></td>
            </tr>
          </table></td>
        </tr>
        <tr class="dataTableHeadingRow">
          <td class="dataTableHeadingContent" width="75">&nbsp;<?php echo TABLE_HEADING_PRODUCT_ID;?>&nbsp;</td>
          <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT_MODEL;?>&nbsp;</td>
          <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT_IMAGE;?>&nbsp;</td>
          <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_CROSS_SELL_THIS;?>&nbsp;</td>
          <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT_NAME;?>&nbsp;</td>
          <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT_PRICE;?>&nbsp;</td>
        </tr>
<?php
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $products_result_raw = "SELECT p.products_id, p.products_model, p.products_image, p.products_price, pd.products_name, p.products_id
                            FROM $productstable p,
                                 $products_descriptiontable pd
                            WHERE p.products_id = pd.products_id
                              AND pd.products_languages_id = '" . intval($_SESSION['language_id']) . "'
                            ORDER BY p.products_id asc";
    $products_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $products_result_raw, $products_result_numrows);
    $products_result = $dbconn->Execute($products_result_raw);
    while ($products = $products_result->fields) {
      $products_xselltable = $oostable['products_xsell'];
      $xsold_result = $dbconn->Execute("SELECT * FROM $products_xselltable WHERE products_id = '" .$_GET['add_related_product_ID'] . "' AND xsell_id = '" . $products['products_id'] . "'");
?>
        <tr bgcolor='#DFE4F4'>
          <td class="dataTableContent" align="center">&nbsp;<?php echo $products['products_id'];?>&nbsp;</td>
          <td class="dataTableContent" align="center">&nbsp;<?php echo $products['products_model'];?>&nbsp;</td>
          <td class="dataTableContent" align="center">&nbsp;<?php echo oos_info_image($products['products_image'], $products['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT);?>&nbsp;</td>
          <td class="dataTableContent">&nbsp;<?php echo oos_draw_hidden_field('product[]', $products['products_id']) . oos_draw_checkbox_field('cross[]', $products['products_id'], (($xsold_result->RecordCount() > 0) ? true : false), '', ' onMouseOver="this.style.cursor=\'hand\'"');?>&nbsp;<label onMouseOver="this.style.cursor='hand'"><?php echo TEXT_CROSS_SELL;?></label>&nbsp;</td>
          <td class="dataTableContent">&nbsp;<?php echo $products['products_name'];?>&nbsp;</td>
          <td class="dataTableContent">&nbsp;<?php echo $currencies->format($products['products_price']);?>&nbsp;</td>
        </tr>
<?php
      // Move that ADOdb pointer!
      $products_result->MoveNext();
    }
    // Close result set
    $products_result->Close();
?>
      </table></form></td>
    </tr>
    <tr>
      <td colspan="6"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="infoBoxContent">
        <tr>
          <td class="smallText" valign="top"><?php echo $products_split->display_count($products_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
          <td class="smallText" align="right"><?php echo $products_split->display_links($products_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], oos_get_all_get_params(array('page', 'info', 'x', 'y', 'cID', 'action'))); ?></td>
        </tr>
      </table></td>
    </tr>
  </table>
<?php
  } elseif ($_GET['add_related_product_ID'] != '' && $_GET['sort'] != '') {
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $products_name_result = $dbconn->Execute("SELECT pd.products_name, p.products_model, p.products_image
                                          FROM $productstable p,
                                               $products_descriptiontable pd
                                          WHERE p.products_id = '" . $_GET['add_related_product_ID'] . "'
                                            AND p.products_id = pd.products_id
                                            AND pd.products_languages_id = '" . intval($_SESSION['language_id']) . "'");
    $products_name = $products_name_result->fields;

    // Close result set
    $products_name_result->Close();
?>
  <table border="0" cellspacing="0" cellpadding="0" bgcolor="#999999" align="center">
    <tr>
      <td><?php echo oos_draw_form('update_sort', $aFilename['xsell_products'], oos_get_all_get_params(array('action')) . 'action=update_sort', 'post');?><table cellpadding="1" cellspacing="1" border="0">
        <tr>
          <td colspan="6"><table cellpadding="3" cellspacing="0" border="0" width="100%">
            <tr class="dataTableHeadingRow">
              <td valign="top" align="center" colspan="2"><span class="pageHeading"><?php echo 'Setting cross-sells for: '.$products_name['products_name'].' (Model: '.$products_name['products_model'].') (Product ID: '.$_GET['add_related_product_ID'].')';?></span></td>
                </tr>
                <tr class="dataTableHeadingRow">
                  <td align="right"><?php echo oos_info_image($products_name['products_image'], $products_name['products_name']);?></td>
                  <td align="right" valign="bottom"><?php echo oos_image_swap_submits('update','update_off.gif', IMAGE_UPDATE) . '<br /><br /><a href="'.oos_href_link_admin($aFilename['xsell_products'], 'men_id=catalog').'">' . oos_image_swap_button('cancel', 'cancel_off.gif') . '</a>';?></td>
                </tr>
              </table></td>
            </tr>
            <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT_ID;?>&nbsp;</td>
              <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT_MODEL;?>&nbsp;</td>
              <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT_IMAGE;?>&nbsp;</td>
              <td class="dataTableHeadingContent" align="center">&nbsp;<?php echo TABLE_HEADING_PRODUCT_NAME;?>&nbsp;</td>
              <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT_PRICE;?>&nbsp;</td>
              <td class="dataTableHeadingContent">&nbsp;<?php echo TABLE_HEADING_PRODUCT_SORT;?>&nbsp;</td>
            </tr>
<?php
    $productstable = $oostable['products'];
    $products_descriptiontable = $oostable['products_description'];
    $products_xselltable = $oostable['products_xsell'];
    $products_result_raw = "SELECT p.products_id as products_id, p.products_price, p.products_image, p.products_model, pd.products_name, p.products_id, x.products_id as xproducts_id, x.xsell_id, x.sort_order, x.ID
                           FROM $productstable p,
                                $products_descriptiontable pd,
                                $products_xselltable x
                           WHERE x.xsell_id = p.products_id
                             AND x.products_id = '" . $_GET['add_related_product_ID'] . "'
                             AND p.products_id = pd.products_id
                             AND pd.products_languages_id = '" . intval($_SESSION['language_id']) . "'
                           ORDER BY x.sort_order asc";
    $products_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $products_result_raw, $products_result_numrows);
    $sort_order_drop_array = array();
    for ($i = 1; $i <= $products_result_numrows; $i++) {
      $sort_order_drop_array[] = array('id' => $i, 'text' => $i);
    }
    $products_result = $dbconn->Execute($products_result_raw);
    while ($products = $products_result->fields) {
?>
            <tr bgcolor='#DFE4F4'>
              <td class="dataTableContent" align="center">&nbsp;<?php echo $products['products_id']; ?>&nbsp;</td>
              <td class="dataTableContent" align="center">&nbsp;<?php echo $products['products_model']; ?>&nbsp;</td>
              <td class="dataTableContent" align="center">&nbsp;<?php echo oos_info_image($products_name['products_image'], $products_name['products_name'], SMALL_IMAGE_WIDTH, SMALL_IMAGE_HEIGHT); ?>&nbsp;</td>
              <td class="dataTableContent" align="center">&nbsp;<?php echo $products['products_name']; ?>&nbsp;</td>
              <td class="dataTableContent" align="center">&nbsp;<?php echo $currencies->format($products['products_price']); ?>&nbsp;</td>
              <td class="dataTableContent" align="center">&nbsp;<?php echo oos_draw_pull_down_menu($products['products_id'], $sort_order_drop_array, $products['sort_order']); ?>&nbsp;</td>
            </tr>
<?php
      // Move that ADOdb pointer!
      $products_result->MoveNext();
    }

    // Close result set
    $products_result->Close();
?>
          </table></form></td>
        </tr>
        <tr>
          <td colspan="6"><table border="0" width="100%" cellspacing="0" cellpadding="2" class="infoBoxContent">
            <tr>
              <td class="smallText" valign="top"><?php echo $products_split->display_count($products_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
              <td class="smallText" align="right"><?php echo $products_split->display_links($products_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page'], oos_get_all_get_params(array('page', 'info', 'x', 'y', 'cID', 'action'))); ?></td>
            </tr>
          </table></td>
        </tr>
      </table>
<?php
  }
?>
<!-- body_text_eof //-->
    </td>
  </tr>
</table>
<!-- body_eof //-->

<?php require 'includes/oos_footer.php'; ?>
<br />
</body>
</html>
<?php require 'includes/oos_nice_exit.php'; ?>