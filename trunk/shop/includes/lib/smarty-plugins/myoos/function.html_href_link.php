<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_href_link} function plugin
 *
 * Type:     function
 * Name:     html_href_link
 * @Version:  $Revision: 1.8 $ - changed by $Author: r23 $ on $Date: 2008/07/08 13:19:51 $
 * -------------------------------------------------------------
 */

function smarty_function_html_href_link($params, &$smarty)
{
    global $oEvent, $spider_flag;

    MyOOS_CoreApi::requireOnce('lib/smarty/libs/plugins/shared.escape_special_chars.php');

    $page = '';
    $parameters = '';
    $connection = 'NONSSL';
    $add_session_id = '1';
    $search_engine_safe = '1';

    foreach($params as $_key => $_val) {
      switch($_key) {
        case 'page':
          if(!is_array($_val)) {
            $$_key = smarty_function_escape_special_chars($_val);
          } else {
            $smarty->trigger_error("html_href_link: Unable to determine the page link!", E_USER_NOTICE);
          }
          break;

        case 'oos_get':
        case 'addentry_id':
        case 'connection':
        case 'add_session_id':
        case 'search_engine_safe':
            $$_key = (string)$_val;
            break;

        case 'anchor':
            $anchor = smarty_function_escape_special_chars($_val);
            break;

        default:
          if(!is_array($_val)) {
            $parameters .= $_key.'='.smarty_function_escape_special_chars($_val).'&amp;';
          } else {
            $smarty->trigger_error("html_href_link: parameters '$_key' cannot be an array", E_USER_NOTICE);
          }
          break;
       }
    }


    if (empty($page)) {
      $smarty->trigger_error("html_href_link: Unable to determine the page link!", E_USER_NOTICE);
    }


    if (isset($addentry_id)) {
      $addentry_id = $addentry_id + 2;
      $parameters .= 'entry_id='.$addentry_id.'&amp;';
    }
    if (isset($oos_get)) {
      $parameters .= $oos_get;
    }

    $page = trim($page);

    if ($connection == 'NONSSL') {
      $sLink = OOS_HTTP_SERVER . OOS_SHOP;
    } elseif ($connection == 'SSL') {
      if (ENABLE_SSL == '1') {
        $sLink = OOS_HTTPS_SERVER . OOS_SHOP;
      } else {
        $sLink = OOS_HTTP_SERVER . OOS_SHOP;
      }
    } else {
      $smarty->trigger_error("html_href_link: Unable to determine the page link!", E_USER_NOTICE);
    }

    if (isset($parameters)) {
      $sLink .= 'index.php?page=' . $page . '&amp;' . oos_output_string($parameters);
    } else {
      $sLink .= 'index.php?page=' . $page;
    }

    $separator = '&amp;';

    while ( (substr($sLink, -5) == '&amp;') || (substr($sLink, -1) == '?') ) {
      if (substr($sLink, -1) == '?') {
        $sLink = substr($sLink, 0, -1);
      } else {
        $sLink = substr($sLink, 0, -5);
      }
    }

    if (isset($anchor)) {
      $sLink .= '#' . $anchor;
    }


// Add the session ID when moving from HTTP and HTTPS servers or when SID is defined
    if ( (ENABLE_SSL == '1' ) && ($connection == 'SSL') && ($add_session_id == '1') ) {
      $_sid = oos_session_name() . '=' . oos_session_id();
    } elseif ( ($add_session_id == '1') && (!oos_empty(SID)) ) {
      $_sid = SID;
    }

    if ( $spider_flag === false) $_sid = NULL;


    if ( ($search_engine_safe == '1') &&  $oEvent->installed_plugin('sefu') ) {
      $sLink = str_replace(array('?', '&amp;', '='), '/', $sLink);

      $separator = '?';

      $pos = strpos ($sLink, 'action');
      if ($pos === false) {
        $url_rewrite = new url_rewrite;
        $sLink = $url_rewrite->transform_uri($sLink);
      }
    }

    if (isset($_sid)) {
      $sLink .= $separator . oos_output_string($_sid);
    }


    return $sLink;
  }


