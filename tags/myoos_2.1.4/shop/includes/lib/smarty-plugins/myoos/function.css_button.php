<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {css_button} function plugin
 *
 * Type:     function
 * Name:     css_button
 * @Version:  $Revision: 1.2 $ - changed by $Author: r23 $ on $Date: 2008/01/09 22:03:20 $
 */

function smarty_function_css_button($params, &$smarty)
{
    global $oEvent, $spider_kill_sid;

    MyOOS_CoreApi::requireOnce('lib/smarty/libs/plugins/shared.escape_special_chars.php');

    $modul = '';
    $file = '';
    $parameters = '';
    $connection = 'NONSSL';
    $add_session_id = '1';
    $search_engine_safe = '1';

    $title = '';
    $color = 'btnR blue';


    foreach($params as $_key => $_val) {
      switch($_key) {
        case 'modul':
          if(!is_array($_val)) {
            $$_key = smarty_function_escape_special_chars($_val);
          } else {
            $smarty->trigger_error("css_button: Unable to determine the page link!", E_USER_NOTICE);
          }
          break;

        case 'file':
          if(!is_array($_val)) {
            $$_key = smarty_function_escape_special_chars($_val);
          } else {
            $smarty->trigger_error("css_button: Unable to determine the page link!", E_USER_NOTICE);
          }
          break;

        case 'oos_get':
        case 'addentry_id':
        case 'connection':
        case 'add_session_id':
        case 'search_engine_safe':
        case 'title':
            $$_key = (string)$_val;
            break;

        case 'color':
            $$_key = (string)$_val;
            break;

        case 'anchor':
            $anchor = smarty_function_escape_special_chars($_val);
            break;

        default:
          if(!is_array($_val)) {
            $parameters .= $_key.'='.smarty_function_escape_special_chars($_val).'&amp;';
          } else {
            $smarty->trigger_error("css_button: parameters '$_key' cannot be an array", E_USER_NOTICE);
          }
          break;
       }
    }


    if (empty($modul)) {
      $smarty->trigger_error("css_button: Unable to determine the page link!", E_USER_NOTICE);
    }

    if (empty($file)) {
      $smarty->trigger_error("css_button: Unable to determine the page link!", E_USER_NOTICE);
    }

    if (isset($addentry_id)) {
      $addentry_id = $addentry_id + 2;
      $parameters .= 'entry_id='.$addentry_id.'&amp;';
    }
    if (isset($oos_get)) {
      $parameters .= $oos_get;
    }

    $file = trim($file);

    if ($connection == 'NONSSL') {
      $link = OOS_HTTP_SERVER . OOS_SHOP;
    } elseif ($connection == 'SSL') {
      if (ENABLE_SSL == '1') {
        $link = OOS_HTTPS_SERVER . OOS_SHOP;
      } else {
        $link = OOS_HTTP_SERVER . OOS_SHOP;
      }
    } else {
      $smarty->trigger_error("css_button: Unable to determine the page link!", E_USER_NOTICE);
    }

    if (isset($parameters)) {
      $link .= 'index.php?mp=' . $modul . '&amp;file=' . $file . '&amp;' . oos_output_string($parameters);
    } else {
      $link .= 'index.php?mp=' . $modul . '&amp;file=' . $file;
    }

    $separator = '&amp;';

    while ( (substr($link, -5) == '&amp;') || (substr($link, -1) == '?') ) {
      if (substr($link, -1) == '?') {
        $link = substr($link, 0, -1);
      } else {
        $link = substr($link, 0, -5);
      }
    }

    if (isset($anchor)) {
      $link .= '#' . $anchor;
    }


// Add the session ID when moving from HTTP and HTTPS servers or when SID is defined
    if ( (ENABLE_SSL == '1' ) && ($connection == 'SSL') && ($add_session_id == '1') ) {
      $_sid = oos_session_name() . '=' . oos_session_id();
    } elseif ( ($add_session_id == '1') && (oos_is_not_null(SID)) ) {
      $_sid = SID;
    }

    if ( $spider_kill_sid == '1') $_sid = NULL;

/*
    if ( ($search_engine_safe == '1') &&  $oEvent->installed_plugin('sefu') ) {
      $link = str_replace(array('?', '&amp;', '='), '/', $link);

      $separator = '?';

      $pos = strpos ($link, 'action');
      if ($pos === false) {
        $url_rewrite = new url_rewrite;
        $link = $url_rewrite->transform_uri($link);
      }
    }
*/


    if (isset($_sid)) {
      $link .= $separator . oos_output_string($_sid);
    }


    $title = decode($title);

    return '<a href="' . $link . '" title="' . $title . '" class="' . $color . '">' . $title . '</a>';


  }


