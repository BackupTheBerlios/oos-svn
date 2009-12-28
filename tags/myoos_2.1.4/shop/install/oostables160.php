<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2007 by the OOS Development Team.
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


$table = $prefix_table . 'products_units';
$flds = "
  products_units_id I DEFAULT '0' NOTNULL PRIMARY,
  languages_id I NOTNULL DEFAULT '1' PRIMARY,
  products_unit_name C(60) NOTNULL
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