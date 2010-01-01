<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_oos_image} function plugin
 *
 * Type:     function<br>
 * Name:     html_oos_image<br>
 * Date:     Feb 24, 2003<br>
 * Purpose:  format HTML tags for the image<br>
 * Input:<br>
 *         - file = file (and path) of image (required)
 *         - border = border width (optional, default 0)
 *         - height = image height (optional, default actual height)
 *         - image =image width (optional, default actual width)
 *         - basedir = base directory for absolute paths, default
 *                     is environment variable DOCUMENT_ROOT
 *
 * Examples: {html_oos_image file="images/masthead.gif"}
 * Output:   <img src="images/masthead.gif" border=0 width=400 height=23>
 * @link http://smarty.php.net/manual/en/language.function.html.image.php {html_oos_image}
 *      (Smarty online manual)
 * @author   Monte Ohrt <monte@ispi.net>
 * @author credits to Duda <duda@big.hu> - wrote first image function
 *           in repository, helped with lots of functionality
 * @version  1.0
 * @param array
 * @param Smarty
 * @return string
 * @uses smarty_function_escape_special_chars()
 */
function smarty_function_html_oos_image($params, &$smarty)
{
    MyOOS_CoreApi::requireOnce('lib/smarty/libs/plugins/shared.escape_special_chars.php');

    $alt = '';
    $image = '';
    $border = 0;
    $height = '';
    $width = '';
    $extra = '';

    $basedir = isset($GLOBALS['HTTP_SERVER_VARS']['DOCUMENT_ROOT'])
        ? $GLOBALS['HTTP_SERVER_VARS']['DOCUMENT_ROOT'] : '';
    if(strstr($GLOBALS['HTTP_SERVER_VARS']['HTTP_USER_AGENT'], 'Mac')) {
        $dpi_default = 72;
    } else {
        $dpi_default = 96;
    }

    foreach($params as $_key => $_val) {
        switch($_key) {
            case 'image':
            case 'border':
            case 'height':
            case 'width':
            case 'dpi':
            case 'basedir':
                $$_key = $_val;
                break;

            case 'alt':
                if(!is_array($_val)) {
                    $$_key = smarty_function_escape_special_chars($_val);
                } else {
                    $smarty->trigger_error("html_oos_image: extra attribute '$_key' cannot be an array", E_USER_NOTICE);
                }
                break;

            default:
                if(!is_array($_val)) {
                    $extra .= ' '.$_key.'="'.smarty_function_escape_special_chars($_val).'"';
                } else {
                    $smarty->trigger_error("html_oos_image: extra attribute '$_key' cannot be an array", E_USER_NOTICE);
                }
                break;
        }
    }

    $image = $basedir . $image;

    if ((empty($image) || ($image == OOS_IMAGES)) && (IMAGE_REQUIRED == '0')) {
        return false;
    }

    if ( (CONFIG_CALCULATE_IMAGE_SIZE == '1') && (empty($width) || empty($height)) ) {
        if ($image_size = @getimagesize($image)) {
            if (empty($width) && !empty($height)) {
              $ratio = $height / $image_size[1];
              $width = $image_size[0] * $ratio;
            } elseif (!empty($width) && empty($height)) {
              $ratio = $width / $image_size[0];
              $height = $image_size[1] * $ratio;
            } elseif (empty($width) && empty($height)) {
              $width = $image_size[0];
              $height = $image_size[1];
            }
        } elseif (IMAGE_REQUIRED == '0') {
            return false;
        }
    }

    if(isset($params['dpi'])) {
        $_resize = $dpi_default/$params['dpi'];
        $width = round($width * $_resize);
        $height = round($height * $_resize);
    }

    return '<img src="'.$image.'" alt="'.$alt.'" border="'.$border.'" width="'.$width.'" height="'.$height.'"'.$extra.' />';
}
