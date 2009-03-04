<?php
/* ----------------------------------------------------------------------
   $Id: catalog.php,v 1.31 2007/12/31 17:00:32 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: catalog.php,v 1.20 2002/03/16 00:20:11 hpdl
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */
?>
<!-- catalog //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_CATALOG,
                     'link'  => oos_href_link_admin(basename($_SERVER['PHP_SELF']), oos_get_all_get_params(array('selected_box')) . 'selected_box=catalog'));

  if ($_SESSION['selected_box'] == 'catalog' || $menu_dhtml == true) {
    $contents[] = array('text'  => oos_admin_files_boxes('categories', BOX_CATALOG_CATEGORIES_PRODUCTS));

    if (MULTIPLE_CATEGORIES_USE == 'true') {
      $contents[] = array('text'  =>  '<a href="' . oos_href_link_admin($aFilename['products'], 'action=new_product', 'NONSSL') . '" class="menuBoxContentLink">' . BOX_CATALOG_QADD_PRODUCT . '</a><br />');
    }
    $contents[] = array('text'  =>  oos_admin_files_boxes('specials', BOX_CATALOG_SPECIALS) .
                                   oos_admin_files_boxes('products_expected', BOX_CATALOG_PRODUCTS_EXPECTED) .
                                   oos_admin_files_boxes('featured', BOX_CATALOG_PRODUCTS_FEATURED) .
                                   oos_admin_files_boxes('products_units', BOX_CATALOG_PRODUCTS_UNITS) .
                                   oos_admin_files_boxes('products_attributes', BOX_CATALOG_CATEGORIES_PRODUCTS_ATTRIBUTES));
    if (STOCK_CHECK == 'true') {
      $contents[] = array('text'  =>  oos_admin_files_boxes('products_status', BOX_CATALOG_PRODUCTS_STATUS));
    }

    $contents[] = array('text'  =>   oos_admin_files_boxes('xsell_products', BOX_CATALOG_XSELL_PRODUCTS) .
                                     oos_admin_files_boxes('up_sell_products', BOX_CATALOG_UP_SELL_PRODUCTS) .
                                     oos_admin_files_boxes('easypopulate', BOX_CATALOG_EASYPOPULATE) .
                                     oos_admin_files_boxes('export_excel', BOX_CATALOG_EXPORT_EXCEL) .
                                     oos_admin_files_boxes('import_excel', BOX_CATALOG_IMPORT_EXCEL) .
                                     oos_admin_files_boxes('manufacturers', BOX_CATALOG_MANUFACTURERS) .
                                     oos_admin_files_boxes('reviews', BOX_CATALOG_REVIEWS));

    if (STOCK_CHECK == 'true') {
      $contents[] = array('text'  =>  oos_admin_files_boxes('quick_stockupdate', BOX_CATALOG_QUICK_STOCKUPDATE));
    }

  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- catalog_eof //-->
