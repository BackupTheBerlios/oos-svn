<?php
/* ----------------------------------------------------------------------
   $Id: oostables140.php,v 1.16 2009/02/05 16:31:26 r23 Exp $

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   POST-NUKE Content Management System
   Copyright (C) 2001 by the Post-Nuke Development Team.
   http://www.postnuke.com/
   ----------------------------------------------------------------------
   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2002 - 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

function dosql($table, $flds) {
   GLOBAL $db;

   $dict = NewDataDictionary($db);

   $taboptarray = array('mysql' => 'TYPE=MyISAM', 'REPLACE');

   $sqlarray = $dict->CreateTableSQL($table, $flds, $taboptarray);
   $dict->ExecuteSQLArray($sqlarray); 

  echo '<br /><img src="images/yes.gif" alt="" border="0" align="absmiddle"> <font class="oos-title">' . $table . " " . MADE . '</font>';
}

function idxsql($idxname, $table, $idxflds) {
   GLOBAL $db;

   $dict = NewDataDictionary($db);

   $sqlarray = $dict->CreateIndexSQL($idxname, $table, $idxflds);
   $dict->ExecuteSQLArray($sqlarray);
}

$table = $prefix_table . 'campaigns';
$flds = "
   campaigns_id I DEFAULT '0' NOTNULL PRIMARY,
   campaigns_languages_id I NOTNULL DEFAULT '1' PRIMARY,
   campaigns_name C(32) NOTNULL
";
dosql($table, $flds);


$idxname = 'idx_campaigns_name'; 
$idxflds = 'campaigns_name';
idxsql($idxname, $table, $idxflds);



$table = $prefix_table . 'customers_points_pending';
$flds = "
  unique_id I NOTNULL AUTO PRIMARY,
  customer_id I NOTNULL DEFAULT '0',
  orders_id I NOTNULL DEFAULT '0',
  points_pending N '15.8' NOTNULL DEFAULT '0.00000000',
  points_comment C(200) NULL,
  date_added T,
  points_status C(1) DEFAULT '1' NOTNULL,
  points_type C(2) NOT NULL DEFAULT 'SP'
";
dosql($table, $flds);


$table = $prefix_table . 'recovercartsales';
$flds = "
  recovercartsales_id I NOTNULL AUTO PRIMARY,
  customers_id I unsigned NOTNULL,
  recovercartsales_date_added C(8) NOTNULL,
  recovercartsales_date_modified C(8) NOTNULL
";
dosql($table, $flds);


$table = $prefix_table . 'information';
$flds = "
  information_id I NOTNULL AUTO PRIMARY,
  information_image C(64) NULL,
  sort_order I1,
  date_added T,
  last_modified T,
  status I1 NOTNULL DEFAULT '0'
";
dosql($table, $flds);


$table = $prefix_table . 'information_description';
$flds = "
  information_id I NOTNULL PRIMARY,
  information_languages_id I NOTNULL DEFAULT '1' PRIMARY,
  information_url C(255) NOTNULL,
  information_name C(64) NULL,
  information_heading_title C(64) NULL,
  information_description X
";
dosql($table, $flds);


$table = $prefix_table . 'products_units';
$flds = "
  products_units_id I DEFAULT '0' NOTNULL PRIMARY,
  languages_id I NOTNULL DEFAULT '1' PRIMARY,
  products_unit_name C(60) NOTNULL
";
dosql($table, $flds);

$table = $prefix_table . 'products_up_sell';
$flds = "
  ID I NOTNULL AUTO PRIMARY,
  products_id I unsigned NOTNULL DEFAULT '1',
  up_sell_id I unsigned NOTNULL DEFAULT '1',
  sort_order I unsigned NOTNULL DEFAULT '1'
";
dosql($table, $flds);

$table = $prefix_table . 'sessions';
$flds = "
  SESSKEY C(64) NOTNULL PRIMARY,
  EXPIRY D NOTNULL,
  EXPIREREF C(250),
  CREATED T NOTNULL,
  MODIFIED T NOTNULL,
  SESSDATA XL
";
dosql($table, $flds);

?>
