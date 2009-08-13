<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {categories_link} function plugin
 *
 * Type:     function<br>
 * Name:     categories_link<br>
 * Date:     Oct 27, 2008<br>
 * Purpose:  URL for the categorie info<br>
 * Input:<br>
 *         - categories
 *
 * Examples: {categories_link categories=17}
 * Output:   http:// ... index.php?mp=mp&amp;file=shop&amp;categories=17
 * @author   r23 <info@r23.de>
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 * @uses smarty_function_html_href_link()
 */
function smarty_function_categories_link($params, &$smarty)
{

  require_once $smarty->_get_plugin_filepath('function','html_href_link');

  $aPages = oos_get_pages();

  $result = array();
  $link_params = array();
  $link_params = array('modul' => $aModules['main'],
                       'file' => $aFilename['shop']);

  if (is_array($params)) {
    $result = array_merge($link_params, $params);
  } else {
    $smarty->trigger_error("categories_link: extra attribute '$params' must an array", E_USER_NOTICE);
  }

  return smarty_function_html_href_link($result, $smarty);

}

