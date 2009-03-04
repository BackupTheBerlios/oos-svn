<?php

/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_get_link} function plugin
 *
 * Type:     function
 * Name:     html_get_link
 * @Version: $Revision: 1.3 $ - changed by $Author: r23 $ on $Date: 2007/10/23 15:56:54 $
 * -------------------------------------------------------------
 */

function smarty_function_html_get_link($params, &$smarty)
{

    require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');

    $connection = 'NONSSL';

    foreach($params as $_key => $_val) {
      switch($_key) {
        case 'connection':
            $$_key = (string)$_val;
            break;

        default:
            break;
       }
    }

    if ($connection == 'NONSSL') {
      $link = OOS_HTTP_SERVER . OOS_SHOP;
    } elseif ($connection == 'SSL') {
      if (ENABLE_SSL == 'true') {
        $link = OOS_HTTPS_SERVER . OOS_SHOP;
      } else {
        $link = OOS_HTTP_SERVER . OOS_SHOP;
      }
    } else {
      $smarty->trigger_error("html_get_link: Unable to determine the page link!", E_USER_NOTICE);
    }

    $link .= 'index.php';

    return $link;
}

?>