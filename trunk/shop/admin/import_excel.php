<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

define('OOS_VALID_MOD', 'yes');
require 'includes/oos_main.php';

if (!isset($_SESSION['login_id'])) {
    oos_redirect_admin(oos_href_link_admin($aFilename['login'], '', 'SSL'));
}


  if (!defined('OOS_UPDATE_PATH')) {
    define('OOS_UPDATE_PATH', OOS_EXPORT_PATH );
  }


  function walk( $item1 ) {

   $item1 = str_replace('	','|',$item1);
   $item1 = str_replace('"','',$item1);

   $item1 = str_replace("\n",'',$item1);
   $item1 = str_replace("\r",'',$item1);

   //$item1 = str_replace("",'',$item1);
   $item1 = str_replace('"','\"',$item1);
   $item1 = str_replace("'",'\"',$item1);

   // echo $item1."<br>";
   $item1 = chop($item1);

   echo $item1."<br>";
   $items = explode("|", $item1);

   $products_id = $items[0];
   $products_model = $items[1];
   $products_name = $items[2];
   $products_tax_class_id = $items[3];
   $products_status = $items[4];
   $products_price = $items[5];

   $dbconn =& oosDBGetConn();
   $oostable =& oosDBGetTables();

   $tax_ratestable = $oostable['tax_rates'];
   $query = "SELECT tax_rate FROM $tax_ratestable WHERE tax_class_id = '" . intval($products_tax_class_id) . "'";
   $tax = $dbconn->GetOne($query);

   $price = ($products_price/($tax+100)*100);

   $productstable = $oostable['products'];
   $dbconn->Execute("UPDATE $productstable set products_price = '" . $price . "', products_status = '" . intval($products_status) . "' where products_id = '" . intval($products_id) . "'");

  }

  if (isset($_GET['split']) && !empty($_GET['split'])) {
    $split = $_GET['split'];
  }

  if (isset($_FILES['usrfl']) && !empty($_FILES['usrfl'])) {
    $usrfl = $_FILES['usrfl'];
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
            <td class="pageHeading"><?php # echo HEADING_TITLE; ?></td>
            <td class="pageHeading" align="right"><?php echo oos_draw_separator('trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>

<?php
  if (is_uploaded_file($usrfl['tmp_name'])) {

    oos_get_copy_uploaded_file($usrfl, OOS_UPDATE_PATH);

    echo "<p class=smallText>";
    echo 'File uploaded<br />';
    echo 'Temporary filename:: ' . $usrfl['tmp_name'] . '<br />';
    echo 'User filename: ' . $usrfl['name'] . '<br />';
    echo 'Size: ' . $usrfl['size'] . '<br />';
    echo '<br><br>';
    echo '<br>products_id | products_model | products_name | products_tax_class_id | products_status | products_price';
    echo '<br><br>';

    // get the entire file into an array
    $readed = file(OOS_UPDATE_PATH . $usrfl['name']);

    foreach ($readed as $arr) {
      walk($arr);
      $Counter++;
    }
    echo '<br><br>';
    echo "Total Records inserted......".$Counter."<br>";
  }
?>

<?php echo oos_draw_form('update_product', $aFilename['import_excel'], '&split=0', 'post', 'enctype="multipart/form-data"'); ?>

              <p>
                <div align = "left">
                <p><b>Upload Produkt-Datei</b></p>
                <p>
                  <INPUT TYPE="hidden" name="MAX_FILE_SIZE" value="100000000">
                  <p></p>
                  <input name="usrfl" type="file" size="50">
                  <input type="submit" name="buttoninsert" value="UPDATE" ><br />
                </p>
              </div>

      </form>


</td>
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