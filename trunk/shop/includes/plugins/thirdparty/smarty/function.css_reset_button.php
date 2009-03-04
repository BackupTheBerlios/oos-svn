<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {css_reset_button} function plugin
 *
 * Type:     function<br>
 * Name:     css_reset_button<br>
 * Input:<br>
 *         - value = button 
 *
 * Examples: {css_reset_button value=$lang.image_button_login}
 * @author r23 <info@r23.de>
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 * @uses smarty_function_escape_special_chars()
 * @Version:  $Revision: 1.1 $ - changed by $Author: r23 $ on $Date: 2008/01/08 04:33:07 $
 */
function smarty_function_css_reset_button($params, &$smarty)
{

    require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');

    $value = '';

    foreach($params as $_key => $_val) {
        switch($_key) {

            case 'value':
                $$_key = (string)$_val;
                break;

            default:
                if(!is_array($_val)) {
                    $extra .= ' '.$_key.'="'.smarty_function_escape_special_chars($_val).'"';
                } else {
                    $smarty->trigger_error("css_reset_button: extra attribute '$_key' cannot be an array", E_USER_NOTICE);
                }
                break;
        }
    }

    $value = decode($value);

    return '<input type="button" id="reset_btn" value="' . $value . '" class="btn" />';

}

?>