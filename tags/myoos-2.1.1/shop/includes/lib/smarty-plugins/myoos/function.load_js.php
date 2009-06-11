<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     function
 * Name:     load_js
 * Purpose:  initialize JavaScript
 * -------------------------------------------------------------
 */
function smarty_function_load_js($params, &$smarty)
{
    if (!empty($params['src'])) {
    	return '<script type="text/javascript" language="JavaScript" src="' . STATIC1_HTTP_SERVER . '/js/' . $params['src'] .'"></script>' . "\n";
    } else {
        $smarty->trigger_error("formtool_init: missing src parameter");
    }
}

/* vim: set expandtab: */

