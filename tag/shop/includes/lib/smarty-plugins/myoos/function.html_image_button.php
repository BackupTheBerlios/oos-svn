<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_image_button} function plugin
 *
 * Type:     function<br>
 * Name:     html_image_button<br>
 * Date:     September 15, 2003
 * Input:<br>
 *         - button = button (and path) of image (required)
 *         - border = border width (optional, default 0)
 *         - height = image height (optional, default actual height)
 *         - basedir = base directory
 *
 * Examples: {html_image_button image="images/masthead.gif"}
 * Output:   <img src="images/masthead.gif" border=0 width=400 height=23>
 * @author r23 <info@r23.de>
 * @author credits to Monte Ohrt <monte@ispi.net>
 * @author credits to Duda <duda@big.hu> - wrote first image function
 *           in repository, helped with lots of functionality
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 * @uses smarty_function_escape_special_chars()
 */
function smarty_function_html_image_button($params, &$smarty)
{

    MyOOS_CoreApi::requireOnce('lib/smarty/libs/plugins/shared.escape_special_chars.php');


    $image = '';
    $alt = '';
    $border = 0;
    $extra = '';

    $sTheme = oos_var_prep_for_os($_SESSION['theme']);
    $sLanguage = oos_var_prep_for_os($_SESSION['language']);

    $basedir = STATIC1_HTTP_SERVER . '/themes/' . $sTheme . '/images/buttons/' . $sLanguage . '/';

    foreach($params as $_key => $_val) {
        switch($_key) {
            case 'image':
            case 'basedir':
                $$_key = $_val;
                break;

            case 'alt':
                if(!is_array($_val)) {
                    $$_key = smarty_function_escape_special_chars($_val);
                } else {
                    $smarty->trigger_error("html_image_button: extra attribute '$_key' cannot be an array", E_USER_NOTICE);
                }
                break;

            default:
                if(!is_array($_val)) {
                    $extra .= ' '.$_key.'="'.smarty_function_escape_special_chars($_val).'"';
                } else {
                    $smarty->trigger_error("html_image_button: extra attribute '$_key' cannot be an array", E_USER_NOTICE);
                }
                break;
        }
    }

    if (empty($image)) {
        $smarty->trigger_error("html_image_button: missing 'button' parameter", E_USER_NOTICE);
        return;
    }

    $_image_path = $basedir . $image;


    $sSlash = (defined('OOS_XHTML') && (OOS_XHTML == '1') ? ' /' : '');

    return '<img src="'.$basedir.$image.'" alt="'.$alt.'" border="'.$border.'" .$extra.$sSlash.'>';

}

