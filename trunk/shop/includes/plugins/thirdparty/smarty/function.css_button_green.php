<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {css_button_green} function plugin
 *
 * Type:     function
 * Name:     css_button_green
 * @Version:  $Revision: 1.1 $ - changed by $Author: r23 $ on $Date: 2008/01/09 22:03:20 $
 */

function smarty_function_css_button_green($params, &$smarty)
{

  require_once $smarty->_get_plugin_filepath('function','css_button');

  $result = array();
  $button_params = array();
  $button_params = array('color' => 'btn green');

  if (is_array($params)) {
    $result = array_merge($button_params, $params);
  } else {
    $smarty->trigger_error("products_info_link: extra attribute '$params' must an array", E_USER_NOTICE);
  }

  return smarty_function_css_button($result, $smarty);

}


