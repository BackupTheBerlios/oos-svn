<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {css_back_button} function plugin
 *
 * Type:     function
 * Name:     css_back_button
 * @Version:  $Revision: 1.1 $ - changed by $Author: r23 $ on $Date: 2008/01/09 22:03:20 $
 */

function smarty_function_css_back_button($params, &$smarty)
{
    global $oEvent, $spider_kill_sid;

    MyOOS_CoreApi::requireOnce('lib/smarty/libs/plugins/shared.escape_special_chars.php');

    $title = '';
    $color = 'btnR green';


    foreach($params as $_key => $_val) {
      switch($_key) {

        case 'title':
            $$_key = (string)$_val;
            break;

        case 'color':
            $$_key = (string)$_val;
            break;

        default:
          break;
       }
    }

    $aModules = oos_get_modules();
    $aFilename =  oos_get_filename();

    if (count($_SESSION['navigation']->path)-2 > 0) {
      $back = count($_SESSION['navigation']->path)-2;
      $link = oos_href_link($_SESSION['navigation']->path[$back]['modules'], $_SESSION['navigation']->path[$back]['file'], $_SESSION['navigation']->path[$back]['get'].'&amp;history_back=true', $_SESSION['navigation']->path[$back]['mode']);
    } else {
      if (strstr(HTTP_SERVER, $_SERVER['HTTP_REFERER'])) {
        $link = $_SERVER['HTTP_REFERER'];
      } else {
        $link = oos_href_link($aModules['main'], $aFilename['main']);
      }
    }

    while ( (substr($link, -5) == '&amp;') || (substr($link, -1) == '?') ) {
      if (substr($link, -1) == '?') {
        $link = substr($link, 0, -1);
      } else {
        $link = substr($link, 0, -5);
      }
    }


    $title = decode($title);

    return '<a href="' . $link . '" title="' . $title . '" class="' . $color . '">' . $title . '</a>';


  }


