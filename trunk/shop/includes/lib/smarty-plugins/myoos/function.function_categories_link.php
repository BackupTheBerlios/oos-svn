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
 * Output:   http:// ... index.php?page=shop&amp;categories=17
 * @author   r23 <info@r23.de>
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 * @uses smarty_function_html_href_link()
 */
function smarty_function_categories_link($params, &$smarty)
{

  MyOOS_CoreApi::requireOnce('lib/smarty-plugins/myoos/function.html_href_link.php');

  $aPages = oos_get_pages();

  $result = array();
  $link_params = array();
  $link_params = array('page' => $aPages['shop']);

  if (is_array($params)) {
    $result = array_merge($link_params, $params);
  } else {
    $smarty->trigger_error("categories_link: extra attribute '$params' must an array", E_USER_NOTICE);
  }

  return smarty_function_html_href_link($result, $smarty);

}

