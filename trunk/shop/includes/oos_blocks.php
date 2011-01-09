<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2010 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   osCommerce, Open Source E-Commerce Solutions
   http://www.oscommerce.com

   Copyright (c) 2003 osCommerce
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

// DO NOT RUN THIS SCRIPT STANDALONE
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


$aContentBlock = array();

$blocktable = $oostable['block'];
$block_infotable = $oostable['block_info'];
$block_to_page_typetable = $oostable['block_to_page_type'];
$block_sql = "SELECT b.block_id, b.block_side, b.block_status, b.block_file, b.block_type,
                     b.block_sort_order, b.block_login_flag, b.block_cache, bi.block_name
              FROM $blocktable b,
                   $block_to_page_typetable b2p,
                   $block_infotable bi
              WHERE b.block_status = '1'
                AND b.block_id = b2p.block_id
                AND bi.block_id = b2p.block_id
                AND bi.block_languages_id = '" .  intval($nLanguageID) . "'
                AND b2p.page_type_id = '" . intval($nPageType) . "'";
if (isset($_SESSION['customer_id'])) {
    $block_sql .= "  AND ( b.block_login_flag = '0' OR b.block_login_flag = '1')";
} else {
    $block_sql .= "  AND b.block_login_flag = '0'";
}
$block_sql .= " ORDER BY b.block_side, b.block_sort_order ASC";

if (USE_DB_CACHE == '1') {
    $dbconn->cacheSecs = 3600*24; // cache 24 hours
    $block_result = $dbconn->CacheExecute($block_sql);
} else {
    $block_result = $dbconn->GetAll($block_sql);
}


foreach ($block_result as $block) {
    $block_heading = $block['block_name'];
    $block_file = trim($block['block_file']);
    $block_side = $block['block_side'];

    if (empty($block_file)) {
        continue;
    }

    $block_tpl = $sTheme . '/blocks/' . $block_file . '.html';

    if ($block['block_cache'] != '') {
        if ( (USE_CACHE == '1') && (!SID) ) {
            $oSmarty->caching = true;
        }
        $bid = trim('oos_' . $block['block_cache'] . '_cache_id');

        if (!$oSmarty->is_cached($block_tpl, ${$bid})) {
            include 'includes/blocks/block_' . $block_file . '.php';
        }
        $block_content = $oSmarty->fetch($block_tpl, ${$bid});
    } else {

        $oSmarty->caching = false;
        include 'includes/blocks/block_' . $block_file . '.php';
        $block_content = $oSmarty->fetch($block_tpl);
    }

    $aContentBlock[] = array('side' => $block_side,
                             'block_content' => $block_content );

}


$nArrayCountContentBlock = count( $aContentBlock );
for ($i = 0, $n = $nArrayCountContentBlock; $i < $n; $i++) {
     switch ($aContentBlock[$i]['side']) {

         case 'left':
             $oSmarty->append('oos_blockleft', array('content' => $aContentBlock[$i]['block_content']));
             break;

         case 'right':
             $oSmarty->append('oos_blockright', array('content' => $aContentBlock[$i]['block_content']));
             break;

     }
}

$oSmarty->caching = false;
