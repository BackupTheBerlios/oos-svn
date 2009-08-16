<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: stats_products_viewed.php,v 1.27 2003/01/29 23:22:44 hpdl 
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  define('OOS_VALID_MOD', 'yes');
  require 'includes/oos_main.php';

  if (isset($_GET['action']) && ($_GET['action'] == 'reset')) {
    $products_descriptiontable = $oostable['products_description'];
    $reset_sql = "UPDATE $products_descriptiontable SET products_viewed = '0'";
    $dbconn->Execute($reset_sql);
    oos_redirect_admin(oos_href_link_admin($aFilename['stats_products_viewed'], 'reset=1'));
  }
  if (isset($_GET['reset']) && ($_GET['reset'] == '1')) {
    $messageStack->add(TEXT_VIEWS_RESET, 'success');
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
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo oos_draw_separator('trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_NUMBER; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_VIEWED; ?>&nbsp;</td>
              </tr>
<?php
  if (isset($_GET['page']) && ($_GET['page'] > 1)) $rows = $_GET['page'] * MAX_DISPLAY_SEARCH_RESULTS - MAX_DISPLAY_SEARCH_RESULTS;

  $productstable = $oostable['products'];
  $products_dscriptiontable = $oostable['products_description'];
  $languagestable = $oostable['languages'];
  $products_sql_raw = "SELECT p.products_id, pd.products_name, pd.products_viewed, l.name
                       FROM $productstable p,
                            $products_dscriptiontable pd,
                            $languagestable l
                       WHERE p.products_id = pd.products_id
                         AND l.languages_id = pd.products_languages_id
                       ORDER BY pd.products_viewed DESC";
  $products_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $products_sql_raw, $products_numrows);
  $products_result = $dbconn->Execute($products_sql_raw);
  while ($products = $products_result->fields) {
    $rows++;

    if (strlen($rows) < 2) {
      $rows = '0' . $rows;
    }
?>
              <tr class="dataTableRow" onmouseover="this.className='dataTableRowOver';this.style.cursor='hand'" onmouseout="this.className='dataTableRow'" onclick="document.location.href='<?php echo oos_href_link_admin($aFilename['products'], 'action=new_product_preview&read=only&pID=' . $products['products_id'] . '&origin=' . $aFilename['stats_products_viewed'] . '?page=' . $_GET['page'], 'NONSSL'); ?>'">
                <td class="dataTableContent"><?php echo $rows; ?>.</td>
                <td class="dataTableContent"><?php echo '<a href="' . oos_href_link_admin($aFilename['products'], 'action=new_product_preview&read=only&pID=' . $products['products_id'] . '&origin=' . $aFilename['stats_products_viewed'] . '?page=' . $_GET['page'], 'NONSSL') . '">' . $products['products_name'] . '</a> (' . $products['name'] . ')'; ?></td>
                <td class="dataTableContent" align="center"><?php echo $products['products_viewed']; ?>&nbsp;</td>
              </tr>
<?php
     // Move that ADOdb pointer!
    $products_result->MoveNext();
  }
  // Close result set
  $products_result->Close();
?>
            </table></td>
          </tr>
          <tr>
            <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText" valign="top"><?php echo $products_split->display_count($products_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_PRODUCTS); ?></td>
                <td class="smallText" align="right"><?php echo $products_split->display_links($products_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText" valign="top"><?php echo '<a href="' . oos_href_link_admin($aFilename['stats_products_viewed'],"action=reset") . '">' . oos_image_swap_button('reset','reset_off.gif', IMAGE_RESET) . '</a>'; ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<?php require 'includes/oos_footer.php'; ?>
</body>
</html>
<?php require 'includes/oos_nice_exit.php'; ?>