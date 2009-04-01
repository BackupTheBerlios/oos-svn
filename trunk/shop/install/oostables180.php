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


?>