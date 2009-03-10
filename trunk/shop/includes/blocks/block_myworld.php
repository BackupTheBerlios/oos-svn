<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

if ($oEvent->installed_plugin('down_for_maintenance')) return false;
if ($sFile == $aFilename['customers_image']) return false;

$myworld_block = 'false';

if (isset($_SESSION['customer_id'])) {
    $myworld_block = 'true';

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
        $myworld_gender = $aLang['male'];
    } elseif ($account['customers_gender'] == 'f') {
        $myworld_gender = $aLang['female'];
    }

    $sCountryName = oos_get_country_name($myworld['entry_country_id']);
    $sAccountCreated = oos_date_short($myworld['date_account_created']);

    // assign Smarty variables;
    $oSmarty->assign(
        array(
            'myworld'         => $myworld,
            'myworld_gender'          => $myworld_gender,
            'country_name'    => $sCountryName,
            'account_created' => $sAccountCreated
        )
    );
}

$oSmarty->assign('block_heading_myworld', $block_heading);
$oSmarty->assign('myworld_block', $myworld_block);

?>