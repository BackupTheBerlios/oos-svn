<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

  define('OOS_VALID_MOD', 'yes');
  require 'includes/oos_main.php';


  /**
   * Field Separator
   * change this if you can't use the default of tabs
   * Tab is the default, comma and semicolon are commonly supported by various progs
   * Remember, if your descriptions contain this character, you will confuse EP!
   */
   $separator = "\t"; // tab is default
   //$separator = ","; // comma
   //$separator = ";"; // semi-colon
   //$separator = "~"; // tilde
   //$separator = "-"; // dash
   //$separator = "*"; // splat


  $action = (isset($_GET['action']) ? $_GET['action'] : '');

  if (!empty($action)) {
    switch ($action) {

      case 'make_file_now':

        $stampit_file = 'db_export_stampit-' . date('YmdHis') . '.cvs';
        $fp = fopen(OOS_EXPORT_PATH . $stampit_file, 'w');

        oos_set_time_limit(0);

        $schema = '';
        $schema .= 'Company' . $separator . 'Name' . $separator . 'Street' . $separator . 'Postcode' . $separator . 'City' . $separator . 'Country' .  "\n";


        $customerstable = $oostable['customers'];
        $address_booktable = $oostable['address_book'];
        $countriestable =  $oostable['countries'];
        $sql = "SELECT c.customers_gender, c.customers_firstname, c.customers_lastname,
                       a.entry_company, a.entry_owner, a.entry_street_address, a.entry_suburb,
                       a.entry_postcode, a.entry_city, a.entry_state, a.entry_zone_id,
                       a.entry_country_id,
                       c.customers_default_address_id, c.customers_status,
                       z.countries_id, z.countries_name
                 FROM  $customerstable c LEFT JOIN
                       $address_booktable a
                    ON c.customers_default_address_id = a.address_book_id,
                       $countriestable z
                 WHERE c.customers_login = '1'
                   AND a.customers_id = c.customers_id
                   AND z.countries_id = a.entry_country_id";
        $customers_result = $dbconn->Execute($sql);

        $rows = 0;
        while ($customers = $customers_result->fields) {
          $rows++;

          $name = $customers['customers_firstname'] . ' ' .$customers['customers_lastname'];
          $name = str_replace($separator,' ',$name);
          $name = strip_tags($name);

          if (STORE_COUNTRY == $customers['entry_country_id']) {
            $country = '';
          } else {
            $country = $customers['countries_name'];
          }


          $schema .= $customers['entry_company']. $separator . $name . $separator . $customers['entry_street_address'] . $separator . $customers['entry_postcode'] . $separator . $customers['entry_city'] . $separator . $country . "\n";

          // Move that ADOdb pointer!
          $customers_result->MoveNext();
        }
          // Close result set
        $customers_result->Close();

        fputs($fp, $schema);
        fclose($fp);

        if (isset($_POST['download']) && ($_POST['download'] == 'yes')) {
          switch ($_POST['compress']) {
            case 'gzip':
              exec(LOCAL_EXE_GZIP . ' ' . OOS_EXPORT_PATH . $stampit_file);
              $stampit_file .= '.gz';
              break;

            case 'zip':
              exec(LOCAL_EXE_ZIP . ' -j ' . OOS_EXPORT_PATH . $stampit_file . '.zip ' . OOS_EXPORT_PATH . $stampit_file);
              @unlink(OOS_EXPORT_PATH . $stampit_file);
              $stampit_file .= '.zip';
          }
          header('Content-type: application/x-octet-stream');
          header('Content-disposition: attachment; filename=' . $stampit_file);

          readfile(OOS_EXPORT_PATH . $stampit_file);
          @unlink(OOS_EXPORT_PATH . $stampit_file);

          exit;
        } else {
          switch ($_POST['compress']) {
            case 'gzip':
              exec(LOCAL_EXE_GZIP . ' ' . $stampit_file);
              break;

            case 'zip':
              exec(LOCAL_EXE_ZIP . ' -j ' . $stampit_file . '.zip ' . $stampit_file);
              unlink(OOS_EXPORT_PATH . $stampit_file);
          }
          $messageStack->add_session(SUCCESS_DATABASE_SAVED, 'success');
        }
        oos_redirect_admin(oos_href_link_admin($aFilename['export_stampit']));
        break;

      case 'download':
        $extension = substr($_GET['file'], -3);
        if ( ($extension == 'zip') || ($extension == '.gz') || ($extension == 'cvs') ) {
          if ($fp = fopen(OOS_EXPORT_PATH . $_GET['file'], 'rb')) {
            $buffer = fread($fp, filesize(OOS_EXPORT_PATH . $_GET['file']));
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
        if (strstr($_GET['file'], '..')) oos_redirect_admin(oos_href_link_admin($aFilename['export_stampit']));

        oos_remove(OOS_EXPORT_PATH . '/' . $_GET['file']);
        if (!$oos_remove_error) {
          $messageStack->add_session(SUCCESS_EXPORT_DELETED, 'success');
          oos_redirect_admin(oos_href_link_admin($aFilename['export_stampit']));
        }
        break;
    }
  }

// check if the backup directory exists
  $dir_ok = false;
  if (is_dir(oos_get_local_path(OOS_EXPORT_PATH))) {
    if (is_writeable(oos_get_local_path(OOS_EXPORT_PATH))) {
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
    $dir = dir(OOS_EXPORT_PATH);
    $contents = array();
    while ($file = $dir->read()) {
      if (!is_dir(OOS_EXPORT_PATH . $file)) {
        $contents[] = $file;
      }
    }
    sort($contents);

    for ($files = 0, $count = count($contents); $files < $count; $files++) {
      $entry = $contents[$files];

      $check = 0;

      if (((!$_GET['file']) || ($_GET['file'] == $entry)) && (!$buInfo) && ($action != 'backup')) {
        $file_array['file'] = $entry;
        $file_array['date'] = date(PHP_DATE_TIME_FORMAT, filemtime(OOS_EXPORT_PATH . $entry));
        $file_array['size'] = number_format(filesize(OOS_EXPORT_PATH . $entry)) . ' bytes';
        switch (substr($entry, -3)) {
          case 'zip': $file_array['compression'] = 'ZIP'; break;
          case '.gz': $file_array['compression'] = 'GZIP'; break;
          default: $file_array['compression'] = TEXT_NO_EXTENSION; break;
        }

        $buInfo = new objectInfo($file_array);
      }

      echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";
      $onclick_link = 'file=' . $entry;
?>
                <td class="dataTableContent" onclick="document.location.href='<?php echo oos_href_link_admin($aFilename['export_stampit'], $onclick_link); ?>'"><?php echo '<a href="' . oos_href_link_admin($aFilename['export_stampit'], 'action=download&file=' . $entry) . '">' . oos_image(OOS_IMAGES . 'icons/file_download.gif', ICON_FILE_DOWNLOAD) . '</a>&nbsp;' . $entry; ?></td>
                <td class="dataTableContent" align="center" onclick="document.location.href='<?php echo oos_href_link_admin($aFilename['export_stampit'], $onclick_link); ?>'"><?php echo date(PHP_DATE_TIME_FORMAT, filemtime(OOS_EXPORT_PATH . $entry)); ?></td>
                <td class="dataTableContent" align="right" onclick="document.location.href='<?php echo oos_href_link_admin($aFilename['export_stampit'], $onclick_link); ?>'"><?php echo number_format(filesize(OOS_EXPORT_PATH . $entry)); ?> bytes</td>
                <td class="dataTableContent" align="right"><?php if (isset($buInfo) && is_object($buInfo) && ($entry == $buInfo->file) ) { echo oos_image(OOS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . oos_href_link_admin($aFilename['export_stampit'], 'file=' . $entry) . '">' . oos_image(OOS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
    }
    $dir->close();
  }
?>
              <tr>
                <td class="smallText" colspan="3"><?php echo TEXT_EXPORT_DIRECTORY . ' ' . OOS_EXPORT_PATH; ?></td>
                <td align="right" class="smallText"><?php if ($action != 'backup')  echo '<a href="' . oos_href_link_admin($aFilename['export_stampit'], 'action=backup') . '">' . oos_image_swap_button('backup','backup_off.gif', IMAGE_BACKUP) . '</a>'; ?></td>
             </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();

  switch ($action) {
    case 'backup':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_BACKUP . '</b>');

      $contents = array('form' => oos_draw_form('backup', $aFilename['export_stampit'], 'action=make_file_now'));
      $contents[] = array('text' => TEXT_INFO_NEW_BACKUP);


      $contents[] = array('text' => '<br />' . oos_draw_radio_field('compress', 'no', true) . ' ' . TEXT_INFO_USE_NO_COMPRESSION);
      if (file_exists(LOCAL_EXE_GZIP)) $contents[] = array('text' => '<br />' . oos_draw_radio_field('compress', 'gzip') . ' ' . TEXT_INFO_USE_GZIP);
      if (file_exists(LOCAL_EXE_ZIP)) $contents[] = array('text' => oos_draw_radio_field('compress', 'zip') . ' ' . TEXT_INFO_USE_ZIP);

      if ($dir_ok == true) {
        $contents[] = array('text' => '<br />' . oos_draw_checkbox_field('download', 'yes') . ' ' . TEXT_INFO_DOWNLOAD_ONLY . '*<br /><br />*' . TEXT_INFO_BEST_THROUGH_HTTPS);
      } else {
        $contents[] = array('text' => '<br />' . oos_draw_radio_field('download', 'yes', true) . ' ' . TEXT_INFO_DOWNLOAD_ONLY . '*<br /><br />*' . TEXT_INFO_BEST_THROUGH_HTTPS);
      }

      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('backup','backup_off.gif', IMAGE_BACKUP) . '&nbsp;<a href="' . oos_href_link_admin($aFilename['export_stampit']) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . $buInfo->date . '</b>');

      $contents = array('form' => oos_draw_form('delete', $aFilename['export_stampit'], 'file=' . $buInfo->file . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $buInfo->file . '</b>');
      $contents[] = array('align' => 'center', 'text' => '<br />' . oos_image_swap_submits('delete','delete_off.gif', IMAGE_DELETE) . ' <a href="' . oos_href_link_admin($aFilename['export_stampit'], 'file=' . $buInfo->file) . '">' . oos_image_swap_button('cancel','cancel_off.gif', IMAGE_CANCEL) . '</a>');
      break;

    default:
      if (isset($buInfo) && is_object($buInfo)) {
        $heading[] = array('text' => '<b>' . $buInfo->date . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<a href="' . oos_href_link_admin($aFilename['export_stampit'], 'file=' . $buInfo->file . '&action=delete') . '">' . oos_image_swap_button('delete','delete_off.gif', IMAGE_DELETE) . '</a>');
        $contents[] = array('text' => '<br />' . TEXT_INFO_DATE . ' ' . $buInfo->date);
        $contents[] = array('text' => TEXT_INFO_SIZE . ' ' . $buInfo->size);
        $contents[] = array('text' => '<br />' . TEXT_INFO_COMPRESSION . ' ' . $buInfo->compression);
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