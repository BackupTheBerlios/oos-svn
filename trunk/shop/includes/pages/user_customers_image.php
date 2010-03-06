<?php
/* ----------------------------------------------------------------------
 $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
if (count(get_included_files()) < 2) {
    header("HTTP/1.1 301 Moved Permanently"); header("Location: /"); exit;
}

function oos_get_random_picture_name($length = 24, $extension = 'jpg') {
    $sStr = "";

    for ($index = 1; $index <= $length; $index++) {
        // Pick random number between 1 and 62
        $randomNumber = rand(1, 62);
        // Select random character based on mapping.
        if ($randomNumber < 11) {
            $sStr .= Chr($randomNumber + 48 - 1); // [ 1,10] => [0,9]
        } elseif ($randomNumber < 37) {
            $sStr .= Chr($randomNumber + 65 - 10); // [11,36] => [A,Z]
        } else {
            $sStr .= Chr($randomNumber + 97 - 36); // [37,62] => [a,z]
        }
    }

    $sStr .= '.' . $extension;

    if (file_exists(OOS_ABSOLUTE_PATH . OOS_IMAGES . OOS_CUSTOMERS_IMAGES . $sStr)) {
        oos_get_random_picture_name(26, $extension);
    }
    return $sStr;
}


if ( !isset( $_SESSION['customer_id'] ) || !is_numeric( $_SESSION['customer_id'] )) {
    $_SESSION['navigation']->set_snapshot();
    MyOOS_CoreApi::redirect(oos_href_link($aPages['login'], '', 'SSL'));
}

if ( (isset($_POST['action']) && ($_POST['action'] == 'add_customers_image')) && (isset($_SESSION['formid']) && ($_SESSION['formid'] == $_POST['formid'])) ) {

    if ( ($_POST['remove_image'] == 'yes') && (isset($_SESSION['customer_id'])) ) {
        $customerstable = $oostable['customers'];
        $query = "SELECT customers_image
                  FROM $customerstable
                  WHERE customers_id = '" . intval($_SESSION['customer_id']) . "'";
        $customers_image = $dbconn->GetOne($query);

        @unlink(OOS_ABSOLUTE_PATH . OOS_IMAGES . OOS_CUSTOMERS_IMAGES . $customers_image);

        $customerstable = $oostable['customers'];
        $query = "UPDATE $customerstable"
               . " SET customers_image = ?"
               . " WHERE customers_id = ?";
        $result =& $dbconn->Execute($query, array('', (int)$_SESSION['customer_id']));
    }

    require_once 'includes/classes/class_upload.php';

    if (!empty($_FILES['id']['tmp_name']) and ($_FILES['id']['tmp_name'] != 'none')) {

        $customers_image_file = new upload('id');
        $customers_image_file->set_destination(OOS_ABSOLUTE_PATH . OOS_IMAGES . OOS_CUSTOMERS_IMAGES);

        if ($customers_image_file->parse()) {
            if (isset($_SESSION['customer_id'])) {

                $extension = MyOOS_Utilities::getFileExtension($_FILES['id']['name']);
                $picture_tempname = oos_get_random_picture_name(26, $extension);
                $customers_image_file->set_filename($picture_tempname);

                $customerstable = $oostable['customers'];
                $query = "UPDATE $customerstable"
                       . " SET customers_image = ?"
                       . " WHERE customers_id = ?";
                $result =& $dbconn->Execute($query, array((string)$picture_tempname, (int)$_SESSION['customer_id']));

               $customers_image_file->save();
            }
        }
    }
}

$sLanguage = oos_var_prep_for_os($_SESSION['language']);
require 'includes/languages/' . $sLanguage . '.php';
require 'includes/languages/' . $sLanguage . '/user_customers_image.php';

$customerstable = $oostable['customers'];
$address_bookstable = $oostable['address_book'];
$customers_infotable = $oostable['customers_info'];

$sql = "SELECT c.customers_gender, c.customers_firstname, c.customers_lastname, c.customers_image,
               a.entry_city, a.entry_country_id, ci.customers_info_date_account_created AS date_account_created
        FROM $customerstable c,
             $address_bookstable a,
             $customers_infotable ci
        WHERE c.customers_id = '" . intval($_SESSION['customer_id']) . "'
          AND a.customers_id = c.customers_id
          AND ci.customers_info_id = c.customers_id
          AND a.address_book_id = '" . intval($_SESSION['customer_default_address_id']) . "'";
$myworld = $dbconn->GetRow($sql);

if ($myworld['customers_gender'] == 'm') {
  $gender = $aLang['male'];
} elseif ($account['customers_gender'] == 'f') {
  $gender = $aLang['female'];
}

$sCountryName = oos_get_country_name($myworld['entry_country_id']);
$sAccountCreated = oos_date_short($myworld['date_account_created']);

// links breadcrumb
$oBreadcrumb->add($aLang['text_yourstore'], oos_href_link($aPages['yourstore']));
$oBreadcrumb->add($aLang['navbar_title']);

$aOption['template_main'] = $sTheme .  '/modules/customers_image.html';
$aOption['page_heading'] = $sTheme . '/heading/page_heading.html';

$nPageType = OOS_PAGE_TYPE_ACCOUNT;

require 'includes/oos_system.php';
if (!isset($option)) {
    require 'includes/info_message.php';
    require 'includes/oos_blocks.php';
}

$oos_pagetitle = $oBreadcrumb->trail_title(' &raquo; ');
$oos_pagetitle .= '&raquo;' . OOS_META_TITLE;

// assign Smarty variables;
$oSmarty->assign(
      array(
          'pagetitle'         => htmlspecialchars($oos_pagetitle),
          'meta_description'  => htmlspecialchars($oos_meta_description),
          'meta_keywords'     => htmlspecialchars($oos_meta_keywords),
          'oos_breadcrumb'    => $oBreadcrumb->trail(BREADCRUMB_SEPARATOR),
          'oos_heading_title' => $aLang['heading_title'],
          'oos_heading_image' => 'contact_us.gif',

          'customer'        => $myworld,
          'gender'          => $gender,
          'country_name'    => $sCountryName,
          'account_created' => $sAccountCreated
      )
  );

$oSmarty->assign('oosPageHeading', $oSmarty->fetch($aOption['page_heading']));
$oSmarty->assign('contents', $oSmarty->fetch($aOption['template_main']));

// display the template
require 'includes/oos_display.php';

