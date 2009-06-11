<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2008 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/*
  error_reporting(E_ALL & ~E_NOTICE);
  ini_set('display_errors',1);
*/

  define('OOS_VALID_MOD', 'yes');
  require 'includes/oos_main.php';


  $kelkoo_file = "kelkoo.txt";

/*
  Tragen Sie 001 ein, wenn die Lieferzeit "bis 5 Tage" betraegt
  Tragen Sie 002 ein, wenn die Lieferzeit "bis 10 Tage" betraegt
  Tragen Sie 003 ein, wenn die Lieferzeit "ueber 10 Tage" betraegt
*/
  $availability = '003';

/*
  die genauen Versandkosten des jeweiligen Artikels. 
  Sollte der Versand portofrei erfolgen oder ab einem 
  bestimmten Bestellbetrag frei sein, so schreiben 
*/
  $deliverycost = 'EUR 4,80';

/*
  Das Beschreibungsfeld ist auf max. 160 Zeichen 
  inklusive Leerzeichen begrenzt.
*/
  $length = 160;


  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (!empty($action)) {
    switch ($action) {
      case 'make_file_now':
        oos_set_time_limit(0);

        $schema .= 'url'."\t".'title'."\t".'description'."\t".'price'."\t".'offerid'."\t".'image'."\t".'availability'."\t".'deliverycost'."\n";

        $productstable = $oostable['products'];
        $products_descriptiontable = $oostable['products_description'];
        $manufacturerstable = $oostable['manufacturers'];
        $specialstable = $oostable['specials'];

        $products_sql = "SELECT 
                             p.products_id, pd.products_name, pd.products_description, p.products_model, p.products_image, p.products_price, p.products_status, 
                             p.products_discount_allowed, p.products_tax_class_id,
                             IF(s.status, s.specials_new_products_price, NULL) AS specials_new_products_price, 
                             p.products_date_added, m.manufacturers_name
                         FROM
                             $productstable p LEFT JOIN
                             $manufacturerstable m
                           ON p.manufacturers_id = m.manufacturers_id LEFT JOIN
                             $products_descriptiontable pd
                           ON p.products_id = pd.products_id AND
                            pd.products_languages_id = '1' LEFT JOIN
                             $specialstable s
                           ON p.products_id = s.products_id
                         WHERE p.products_status >= '1'
                           AND p.products_access = '0'
                           AND pd.products_languages_id = '1'
                      ORDER BY p.products_date_added DESC,
                               pd.products_name";
        $products_result = $dbconn->Execute($products_sql);
        while ($products = $products_result->fields) {
          if ( (oos_is_not_null($products['products_name'])) && (oos_is_not_null($products['products_model'])) && (oos_is_not_null($products['products_description'])) ) {
            // remove trash
            $products_description = strip_tags($products['products_description']);
            $products_description = str_replace(";",", ",$products_description);
            $products_description = str_replace("'",", ",$products_description);
            $products_description = str_replace("\n"," ",$products_description);
            $products_description = str_replace("\r"," ",$products_description);
            $products_description = str_replace("\t"," ",$products_description);
            $products_description = str_replace("\v"," ",$products_description);
            $products_description = str_replace("&quot,"," \"",$products_description);
            $products_description = str_replace("&qout,"," \"",$products_description);

            $products_description = substr($products_description, 0, $length-4) . '...';

            if (isset($products['specials_new_products_price'])) {
              $products_price = $products['specials_new_products_price'];
            } else {
              $products_price = $products['products_price'];
            }
            $tax = (100+oos_get_tax_rate($products['products_tax_class_id']))/100;
            $products_price = number_format($products_price*$tax,2,".","");

            if ($products['products_image'] == ''){
              $kelkoo_image = "";
            } else {
              $kelkoo_image= OOS_HTTP_SERVER . '/' . OOS_IMAGES . $products['products_image'];
            }

            $schema .= OOS_HTTP_SERVER . OOS_SHOP . 'index.php?mp=' . $oosModules['products'] . '&file=' . $oosCatalogFilename['product_info'] . '&products_id=' . $products['products_id'] . "\t".
                       $products['products_name'] . "\t".
                       $products_description . "\t".
                       $products_price . "\t" .
                       $products['products_id'] . "\t" .
                       $kelkoo_image . "\t" .
                       $availability . "\t" .
                       $deliverycost . "\n";

          }

          // Move that ADOdb pointer!
          $products_result->MoveNext();
        }
        // Close result set
        $products_result->Close();

        if ( file_exists( OOS_FEEDS_EXPORT_PATH . $kelkoo_file ) ) {
           unlink( OOS_FEEDS_EXPORT_PATH . $kelkoo_file );
        }
        if ($fp = fopen( OOS_FEEDS_EXPORT_PATH . $kelkoo_file, 'w')) {
          fputs($fp, $schema);
          fclose($fp);
          $messageStack->add_session(SUCCESS_EXPORT_DATABASE_SAVED, 'success');
        }

        oos_redirect_admin(oos_href_link_admin($aFilename['export_kelkoo']));
        break;

      case 'download':
        $extension = substr($_GET['file'], -3);
        if ($extension == 'txt') {
          if ($fp = fopen(OOS_FEEDS_EXPORT_PATH . $_GET['file'], 'rb')) {
            $buffer = fread($fp, filesize(OOS_FEEDS_EXPORT_PATH . $_GET['file']));
            fclose($fp);
            header('Content-type: application/x-octet-stream');
            header('Content-disposition: attachment; filename=' . $_GET['file']);
            echo $buffer;
            exit;
          }
        } else {
          $messageStack->add(ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE, 'error');
        }
        break;

      case 'deleteconfirm':
        if (strstr($_GET['file'], '..')) oos_redirect_admin(oos_href_link_admin($aFilename['export_kelkoo']));

        oos_remove(OOS_FEEDS_EXPORT_PATH . $_GET['file']);
        if (!$oos_remove_error) {
          $messageStack->add_session(SUCCESS_EXPORT_DELETED, 'success');
          oos_redirect_admin(oos_href_link_admin($aFilename['export_kelkoo']));
        }
        break;
    }
  }


// check if the backup directory exists
  $dir_ok = false;
  if (is_dir(oos_get_local_path(OOS_FEEDS_EXPORT_PATH))) {
    if (is_writeable(oos_get_local_path(OOS_FEEDS_EXPORT_PATH))) {
      $dir_ok = true;
    } else {
      $messageStack->add(ERROR_EXPORT_DIRECTORY_NOT_WRITEABLE, 'error');
    }
  } else {
    $messageStack->add(ERROR_EXPORT_DIRECTORY_DOES_NOT_EXIST, 'error');
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
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_TITLE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_FILE_DATE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_FILE_SIZE; ?></td>
                <td class="dataTableHeadingContent" align="right"><?php echo TABLE_HEADING_ACTION; ?>&nbsp;</td>
              </tr>
<?php
  if ($dir_ok) {
    $dir = dir(OOS_FEEDS_EXPORT_PATH);
    $contents = array();
    while ($file = $dir->read()) {
      if (!is_dir(OOS_FEEDS_EXPORT_PATH . $file)) {
        $contents[] = $file;
      }
    }
    sort($contents);


    for ($files = 0, $count = count($contents); $files < $count; $files++) {
      $entry = $contents[$files];

      $check = 0;

      if (((!$_GET['file']) || ($_GET['file'] == $entry)) && (!$psmInfo) && ($action != 'make_file') && ($action != 'restorelocal')) {
        $file_array['file'] = $entry;
        $file_array['date'] = date(PHP_DATE_TIME_FORMAT, filemtime(OOS_FEEDS_EXPORT_PATH . $entry));
        $file_array['size'] = number_format(filesize(OOS_FEEDS_EXPORT_PATH . $entry)) . ' bytes';

        $psmInfo = new objectInfo($file_array);
      }

      if (isset($psmInfo) && is_object($psmInfo) && ($entry == $psmInfo->file)) {
        echo '              <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'">' . "\n";
        $onclick_link = 'file=' . $psmInfo->file . '&action=restore';
      } else {
        echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";
        $onclick_link = 'file=' . $entry;
      }
?>
                <td class="dataTableContent" onclick="document.location.href='<?php echo oos_href_link_admin($aFilename['export_kelkoo'], $onclick_link); ?>'"><?php echo '<a href="' . oos_href_link_admin($aFilename['export_kelkoo'], 'action=download&file=' . $entry) . '">' . oos_image(OOS_IMAGES . 'icons/file_download.gif', ICON_FILE_DOWNLOAD) . '</a>&nbsp;' . $entry; ?></td>
                <td class="dataTableContent" align="center" onclick="document.location.href='<?php echo oos_href_link_admin($aFilename['export_kelkoo'], $onclick_link); ?>'"><?php echo date(PHP_DATE_TIME_FORMAT, filemtime(OOS_FEEDS_EXPORT_PATH . $entry)); ?></td>
                <td class="dataTableContent" align="right" onclick="document.location.href='<?php echo oos_href_link_admin($aFilename['export_kelkoo'], $onclick_link); ?>'"><?php echo number_format(filesize(OOS_FEEDS_EXPORT_PATH . $entry)); ?> bytes</td>
                <td class="dataTableContent" align="right"><?php if (isset($psmInfo) && is_object($psmInfo) && ($entry == $psmInfo->file) ) { echo oos_image(OOS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . oos_href_link_admin($aFilename['export_kelkoo'], 'file=' . $entry) . '">' . oos_image(OOS_IMAGES . 'icon_information.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
    $dir->close();
  }
?>
              <tr>
                <td class="smallText" colspan="3"><?php echo TEXT_EXPORT_DIRECTORY . ' ' . OOS_FEEDS_EXPORT_PATH; ?></td>
                <td align="right" class="smallText"><?php if ( ($action != 'make_file') && ($dir) )  echo '<a href="' . oos_href_link_admin($aFilename['export_kelkoo'], 'action=make_file') . '">' . oos_image_swap_button('backup', 'backup_off.gif', IMAGE_BACKUP) . '</a>'; ?></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'make_file':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW . '</b>');

      $contents = array('form' => oos_draw_form('make_file', $aFilename['export_kelkoo'], 'action=make_file_now'));
      $contents[] = array('text' => TEXT_INFO_NEW_INFO);

      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('backup', 'backup_off.gif', IMAGE_BACKUP) . '&nbsp;<a href="' . oos_href_link_admin($aFilename['export_kelkoo']) . '">' . oos_image_swap_button('cancel', 'cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . $psmInfo->date . '</b>');

      $contents = array('form' => oos_draw_form('delete', $aFilename['export_kelkoo'], 'file=' . $psmInfo->file . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $psmInfo->file . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('delete', 'delete_off.gif', IMAGE_DELETE) . ' <a href="' . oos_href_link_admin($aFilename['export_kelkoo'], 'file=' . $psmInfo->file) . '">' . oos_image_swap_button('cancel', 'cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    default:
      if (isset($psmInfo) && is_object($psmInfo)) {
        $heading[] = array('text' => '<b>' . $psmInfo->date . '</b>');

        $contents[] = array('align' => 'center', 'text' =>  '<a href="' . oos_href_link_admin($aFilename['export_kelkoo'], 'file=' . $psmInfo->file . '&action=delete') . '">' . oos_image_swap_button('delete', 'delete_off.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_DATE . ' ' . $psmInfo->date);
        $contents[] = array('text' => TEXT_INFO_SIZE . ' ' . $psmInfo->size);
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