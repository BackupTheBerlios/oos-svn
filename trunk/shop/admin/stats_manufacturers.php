<?php
/* ----------------------------------------------------------------------
   $Id: stats_customers.php 44 2009-03-06 10:34:19Z r23 $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: stats_customers.php,v 1.29 2002/05/16 15:32:22 hpdl
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

if ( !current_user_can('stats_customers') )
    oos_redirect_admin(oos_href_link_admin($aFilename['forbiden']));

  require 'includes/classes/class_currencies.php';
  $currencies = new currencies();

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
            <td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo oos_draw_separator('trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_NUMBER; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_MENUFACTURERS; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TOTAL_PRODUCTS; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_PRODUCTS_ONLINE; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_AVERAGE_PRICE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_TOTAL_PURCHASED; ?>&nbsp;</td>
              </tr>
<?php
  if (isset($_GET['page']) && ($_GET['page'] > 1)) $rows = $_GET['page'] * MAX_DISPLAY_SEARCH_RESULTS - MAX_DISPLAY_SEARCH_RESULTS;

  $orders_productstable = $oostable['orders_products'];
  $orderstable = $oostable['orders'];
  $productstable = $oostable['products'];
  $manufacturersstable = $oostable['manufacturers'];
  $manufacturers_sql_raw = "SELECT m.manufacturers_name, m.manufacturers_id,
                                 sum(op.products_quantity) AS products_quantity_sum,
                                 sum(op.final_price * op.products_quantity) AS ordersum
                          FROM $orderstable o,
                               $orders_productstable op,
                               $productstable p,
                               $manufacturersstable m
                          WHERE o.orders_id = op.orders_id
                            AND op.products_id = p.products_id
                            AND p.manufacturers_id = m.manufacturers_id
                            GROUP BY m.manufacturers_name
                            ORDER BY ordersum DESC";

  $manufacturers_split = new splitPageResults($_GET['page'], MAX_DISPLAY_SEARCH_RESULTS, $manufacturers_sql_raw, $customers_result_numrows);
// fix counted customers
  $orderstable = $oostable['orders'];
  $customers_result_numrows = $dbconn->Execute("SELECT customers_id
                                                FROM $orderstable
                                               GROUP BY customers_id");
  $customers_result_numrows = $customers_result_numrows->RecordCount();

  $customers_result = $dbconn->Execute($customers_sql_raw);
  while ($customers = $customers_result->fields) {
    $rows++;

    if (strlen($rows) < 2) {
      $rows = '0' . $rows;
    }
?>
              <tr class="dataTableRow" onmouseover="this.className='dataTableRowOver';this.style.cursor='hand'" onmouseout="this.className='dataTableRow'" onclick="document.location.href='<?php echo oos_href_link_admin($aFilename['customers'], 'search=' . $customers['customers_lastname'], 'NONSSL'); ?>'">
                <td class="dataTableContent"><?php echo $rows; ?>.</td>
                <td class="dataTableContent"><?php echo '<a href="' . oos_href_link_admin($aFilename['customers'], 'search=' . $customers['customers_lastname'], 'NONSSL') . '">' . $customers['customers_firstname'] . ' ' . $customers['customers_lastname'] . '</a>'; ?></td>
                <td class="dataTableContent" align="right"><?php echo $currencies->format($customers['ordersum']); ?>&nbsp;</td>
              </tr>
<?php
    // Move that ADOdb pointer!
    $customers_result->MoveNext();
  }

  // Close result set
  $customers_result->Close();
?>
            </table></td>
          </tr>
          <tr>
            <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr>
                <td class="smallText" valign="top"><?php echo $customers_split->display_count($customers_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, $_GET['page'], TEXT_DISPLAY_NUMBER_OF_CUSTOMERS); ?></td>
                <td class="smallText" align="right"><?php echo $customers_split->display_links($customers_result_numrows, MAX_DISPLAY_SEARCH_RESULTS, MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?>&nbsp;</td>
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