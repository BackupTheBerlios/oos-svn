<?php
/* ----------------------------------------------------------------------
   $Id: export.php,v 1.15 2008/01/01 16:57:00 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */
?>
<!-- export //-->
          <tr>
            <td>
<?php
  $heading = array();
  $contents = array();

  $heading[] = array('text'  => BOX_HEADING_EXPORT,
                     'link'  => oos_href_link_admin(basename($_SERVER['PHP_SELF']), oos_get_all_get_params(array('selected_box')) . 'selected_box=export'));

  if ($_SESSION['selected_box'] == 'export' || $menu_dhtml == true) {
    $contents[] = array('text'  => oos_admin_files_boxes('export_stampit', BOX_CUSTOMERS_EXPORT_STAMPIT) .
                                   oos_admin_files_boxes('export_googlebase', BOX_EXPORT_GOOGLEBASE) .
                                   oos_admin_files_boxes('export_kelkoo', BOX_EXPORT_KELKOO) .
                                   oos_admin_files_boxes('export_preissuchmaschine', BOX_EXPORT_PREISSUCHMASCHINE));
  }

  $box = new box;
  echo $box->menuBox($heading, $contents);
?>
            </td>
          </tr>
<!-- export_eof //-->
