<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {css_submit_button} function plugin
 *
 * Type:     function<br>
 * Name:     css_submit_button<br>
 * Input:<br>
 *         - value = button 
 *
 * Examples: {css_submit_button value=$lang.image_button_login}
 * @author r23 <info@r23.de>
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 * @uses smarty_function_escape_special_chars()
 * @Version:  $Revision: 1.3 $ - changed by $Author: r23 $ on $Date: 2008/01/21 10:17:15 $
 */
function smarty_function_css_submit_button($params, &$smarty)
{

    require_once $smarty->_get_plugin_filepath('shared','escape_special_chars');

    $value = '';
    $color = 'btnR pink';

    foreach($params as $_key => $_val) {
        switch($_key) {

            case 'value':
            case 'color':
                $$_key = (string)$_val;
                break;

            default:
                if(!is_array($_val)) {
                    $extra .= ' '.$_key.'="'.smarty_function_escape_special_chars($_val).'"';
                } else {
                    $smarty->trigger_error("css_submit_button: extra attribute '$_key' cannot be an array", E_USER_NOTICE);
                }
                break;
        }
    }

    $value = decode($value);
    return '<input type="submit" id="submit_btn" value="' . $value . '" class="' . $color . '" />';

}

?>