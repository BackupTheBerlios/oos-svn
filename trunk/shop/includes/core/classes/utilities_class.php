<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   File: GalleryUtilities.class Revision: 17582
   ----------------------------------------------------------------------
   Gallery - a web based photo album viewer and editor
   http://gallery.menalto.com/

   Copyright (C) 2000-2008 Bharat Mediratta
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );



/*
 * Gallery - a web based photo album viewer and editor
 * Copyright (C) 2000-2008 Bharat Mediratta
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or (at
 * your option) any later version.
 *
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street - Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * A collection of useful utilities that have no obvious home.
 *
 * All of these utilities should be accessed in a static sense, ie.
 *   MyOOS_Utilities::getFileExtension($filename);
 *
 * Try not to jam too many methods into this class.  Only put methods here if they are of obvious
 * value to the class layer and there's no other home for them.
 *
 * @package GalleryCore
 * @subpackage Classes
 * @author Bharat Mediratta <bharat@menalto.com>
 * @version Revision: 17582
 * @static
 */
class MyOOS_Utilities {

    /**
     * Get the type of the file from its filename.
     * eg. "foo.jpg" yields 'foo', 'jpg'
     *     "foo.bar.jpeg" yields 'foo.bar', 'jpeg'
     *
     * @param string $filename
     * @return array the file basename, the file extension
     */
    function getFileNameComponents($filename)
    {

        $pos = strrpos($filename, '.');

        /* No dot == it's all base, no extension */
        if ($pos === false) {
            return array($filename, '');
        }

        $pos++;

        /* If it's the last char in the name, just return the base */
        if ($pos >= strlen($filename)) {
            return array(substr($filename, 0, $pos - 1), '');
        }

        return array(substr($filename, 0, $pos - 1), substr($filename, $pos));
    }

    /**
     * Return the file's extension.
     * eg. "foo.jpg" yields "jpg"
     *
     * @param string $filename
     * @return array the file extension
     */
    function getFileExtension($filename)
    {
        list ($base, $extension) = MyOOS_Utilities::getFileNameComponents($filename);
        return $extension;
    }

    /**
     * Return the file's basename.
     * eg. "foo.jpg" yields "foo"
     *
     * @param string $filename
     * @return array the file base
     */
    function getFileBase($filename)
    {
        list ($base, $extension) = MyOOS_Utilities::getFileNameComponents($filename);
        return $base;
    }

    /**
     * Return data about file attached to request.
     * @param string $key
     * @param boolean $prefix (optional) false to omit Gallery variable prefix (not recommended)
     * @return array file data
     */
    function getFile($key, $prefix=true)
    {
        $file = array();
        if ($prefix) {
            $key = MYOOS_FORM_VARIABLE_PREFIX . $key;
        }
        if (isset($_FILES[$key])) {
            /*
             * Later during our sanitization process we call stripslashes on our file name.  But it
             * may legitimately have backslashes in it (eg. c:\apache\tmp\php195.jpg), so make sure
             * those are escaped at this time.  There's gotta be a better way to handle this.
             */
            $file = $_FILES[$key];
            if (get_magic_quotes_gpc()) {
                $file['tmp_name'] = addslashes($file['tmp_name']);
            }

            /* Perform any necessary transformations on our values */
            MyOOS_Utilities::sanitizeInputValues($file);
        }

        return $file;
    }

    /**
     * Return all request variables that match the prefix.
     * @param string $key
     * @param boolean $prefix (optional) false to omit Gallery variable prefix (not recommended)
     * @return array key value pairs
     */
    function getFormVariables($key, $prefix=true)
    {
        if ($prefix) {
            $key = MYOOS_FORM_VARIABLE_PREFIX . $key;
        }
        $form = array();
        if (isset($_POST[$key]) && is_array($_POST[$key])) {
            $form = $_POST[$key];
        }

        if (isset($_FILES[$key]) && is_array($_FILES[$key])) {
            /*
             * Later during our sanitization process we call stripslashes on our file name.  But it
             * may legitimately have backslashes in it (eg. c:\apache\tmp\php195.jpg), so make sure
             * those are escaped at this time.  There's gotta be a better way to handle this.
             */
            $postForm = $_FILES[$key];
            if (get_magic_quotes_gpc()) {
                foreach ($postForm['tmp_name'] as $i => $unused) {
                    $postForm['tmp_name'][$i] = addslashes($postForm['tmp_name'][$i]);
                }
            }
            $form = MyOOS_Utilities::array_merge_replace($form, $postForm);
        }

        if (isset($_GET[$key]) && is_array($_GET[$key])) {
            $form = MyOOS_Utilities::array_merge_replace($form, $_GET[$key]);
        }

        /* Perform any necessary transformations on our values */
        MyOOS_Utilities::sanitizeInputValues($form);

        return $form;
    }

    /**
     * Return all request variables from the URL except the listed keys.
     * @param array $skip (optional) keys to skip
     * @param boolean $prefix (optional) if true, remove form variable prefix from keys in result
     * @return array unsanitized key value pairs
     */
    function getUrlVariablesFiltered($skip=array(), $prefix=false)
    {
        $filter = array();
        foreach ($skip as $key) {
            $filter[MYOOS_FORM_VARIABLE_PREFIX . $key] = true;
        }

        $values = array();
        $prefixLength = strlen(MYOOS_FORM_VARIABLE_PREFIX);
        foreach ($_GET as $key => $value) {
            if (empty($filter[$key])) {
                $values[$prefix ? substr($key, $prefixLength) : $key] = $value;
            }
        }

        return $values;
    }

    /**
     * Merges two arrays and replace existing entries, like the PHP function array_merge_recursive.
     * The main difference is that existing keys will be replaced with new values, not combined in a
     * new sub array.
     *
     * Usage: $newArray = array_merge_replace( $array, $newValues );
     *
     * @param array $array first array with 'replaceable' values
     * @param array $newValues array which will be merged into first one
     * @return array resulting array
     * @author Tobias Tom <t.tom@succont.de>
     * @todo Verify that both arguments are arrays.
     */
    function array_merge_replace($array, $newValues)
    {
        foreach ($newValues as $key => $value) {
            if (is_array($value)) {
                if (!isset($array[$key])) {
                    $array[$key] = array();
                }
                $array[$key] = MyOOS_Utilities::array_merge_replace($array[$key], $value);
            } else {
                if (isset($array[$key]) && is_array($array[$key])) {
                    $array[$key][0] = $value;
                } else {
                    if (isset($array) && !is_array($array)) {
                        $temp = $array;
                        $array = array();
                        $array[0] = $temp;
                    }
                    $array[$key] = $value;
                }
            }
        }
        return $array;
    }

    /**
     * Remove all request variables that match the prefix.
     * @param string $key
     * @param boolean $prefix (optional) false to omit Gallery variable prefix (not recommended)
     */
    function removeFormVariables($key, $prefix=true)
    {
        /* Remove all matching GET and POST variables */
        if ($prefix) {
            $key = MYOOS_FORM_VARIABLE_PREFIX . $key;
        }
        unset($_POST[$key]);
        unset($_FILES[$key]);
        unset($_GET[$key]);
    }

    /**
     * Return the specified request variables.  Accept any number of keys and return that number of
     * values, in order.
     * @param one or more string parameters
     * @return mixed a single string value or many values
     */
    function getRequestVariables()
    {
        $values = array();
        foreach (func_get_args() as $argName) {
            $values[] = MyOOS_Utilities::_getRequestVariable(
            MYOOS_FORM_VARIABLE_PREFIX . $argName);
        }

        /* Sanitize the input */
        MyOOS_Utilities::sanitizeInputValues($values);

        if (func_num_args() == 1) {
            return array_shift($values);
        }
        return $values;
    }

    /**
     * Return all request variables with the Gallery variable prefix.
     * @return array request variable name => value
     */
    function getAllRequestVariables()
    {
        $values = array();
        $prefixLength = strlen(MYOOS_FORM_VARIABLE_PREFIX);
        foreach ($_POST as $key => $value) {
            if (substr($key, 0, $prefixLength) == MYOOS_FORM_VARIABLE_PREFIX) {
                $values[substr($key, $prefixLength)] = $value;
            }
        }

        foreach ($_GET as $key => $value) {
            if (substr($key, 0, $prefixLength) == MYOOS_FORM_VARIABLE_PREFIX) {
                $values[substr($key, $prefixLength)] = $value;
            }
        }

        /* Sanitize the input */
        MyOOS_Utilities::sanitizeInputValues($values);

        return $values;
    }

    /**
     * Return the specified request variables (omit Gallery variable prefix).  Should be used only
     * when interacting with an external API where prefix can't be used.  Accept any number of keys
     * and return that number of values, in order.
     * @param one or more string parameters
     * @return mixed a single string value or many values
     */
    function getRequestVariablesNoPrefix()
    {
        $values = array();
        foreach (func_get_args() as $argName) {
            $values[] = MyOOS_Utilities::_getRequestVariable($argName);
        }

        /* Sanitize the input */
        MyOOS_Utilities::sanitizeInputValues($values);

        if (func_num_args() == 1) {
            return array_shift($values);
        }
        return $values;
    }

    /**
     * Push the given key => value pair back into the request.
     * @param string $key
     * @param string $value
     * @param boolean $prefix (optional) false to omit Gallery variable prefix (not recommended)
     */
    function putRequestVariable($key, $value, $prefix=true)
    {
        if ($prefix) {
            $key = MYOOS_FORM_VARIABLE_PREFIX . $key;
    }

        /* Simulate the damage caused by magic_quotes */
        MyOOS_Utilities::unsanitizeInputValues($key);
        MyOOS_Utilities::unsanitizeInputValues($value);

        $keyPath = preg_split('/[\[\]]/', $key, -1, PREG_SPLIT_NO_EMPTY);
        MyOOS_Utilities::_internalPutRequestVariable($keyPath, $value, $_GET);
    }

    /**
     * Take a path in the form of ('foo', 'bar', 'baz') and a destination array and put the value
     * into it like this:
     *   $destination['foo']['bar']['baz'] = $value;
     *
     * @access private
     * @param array $keyPath the key path
     * @param mixed $value
     * @param array $array the destination
     */
    function _internalPutRequestVariable($keyPath, $value, &$array)
    {
        $key = array_shift($keyPath);
        while (!empty($keyPath)) {
            $array =& $array[$key];
            $key = array_shift($keyPath);
        }

        $array[$key] = $value;
    }

    /**
     * Check to see if the given key is in the request.
     * @param string $key
     * @param boolean $prefix (optional) false to omit Gallery variable prefix (not recommended)
     */
    function hasRequestVariable($key, $prefix=true)
    {
        if ($prefix) {
            $key = MYOOS_FORM_VARIABLE_PREFIX . $key;
        }
        $value = MyOOS_Utilities::_getRequestVariable($key);
        return !empty($value);
    }

    /**
     * Remove a request variable.
     * @param string $key
     * @param boolean $prefix (optional) false to omit Gallery variable prefix (not recommended)
     */
    function removeRequestVariable($key, $prefix=true)
    {
        if ($prefix) {
            $key = MYOOS_FORM_VARIABLE_PREFIX . $key;
        }
        $keyPath = preg_split('/[\[\]]/', $key, -1, PREG_SPLIT_NO_EMPTY);
        MyOOS_Utilities::_internalRemoveRequestVariable($keyPath, $_GET);
        MyOOS_Utilities::_internalRemoveRequestVariable($keyPath, $_POST);
    }

    /**
     * Take a path in the form of ('foo', 'bar', 'baz') and a source array and remove the value from
     * it like this:
     *   unset($source['foo']['bar']['baz']);
     *
     * @param array $keyPath the key path
     * @param array $array the source
     * @access private
     */
    function _internalRemoveRequestVariable($keyPath, &$array)
    {
        $key = array_shift($keyPath);
        while (!empty($keyPath)) {
            if (empty($array[$key])) {
                return null;
            }

            $array =& $array[$key];
            $key = array_shift($keyPath);
        }

        unset($array[$key]);
    }

    /**
     * Return prefixed form variable name.
     * @param string $key form variable name
     * @return string prefixed form variable name
     */
    function prefixFormVariable($key)
    {
        return MYOOS_FORM_VARIABLE_PREFIX . $key;
    }

    /**
     * Return a string of ? markers.
     * @param int $count the number of markers to return
     * @return string
     */
    function makeMarkers($count, $markerFragment='?')
    {
        if (is_array($count)) {
            $count = count($count);
        }

        $markers = '';
        if ($count > 1) {
            $markers = str_repeat($markerFragment . ',', $count - 1);
        }
        if ($count != 0) {
            $markers .= $markerFragment;
        }

        return $markers;
    }

    /**
     * Round a float and convert to a string.  Replace , with . in case current locale uses comma as
     * fraction separator.
     * @param float $floatValue value to round
     * @param int $precision defaults to zero
     * @return string rounded value
     */
    function roundToString($floatValue, $precision=0)
    {
        return str_replace(',', '.', round($floatValue, $precision));
    }

    /**
     * Cast to float taking into account that older PHP versions will not treat "." as a decimal
     * separator if the current locale uses "," - when we stop supporting these older versions we
     * can ditch this method and just cast to (float).  (Note that newer PHP versions may accept
     * only "." even if locale uses ",").
     */
    function castToFloat($value)
    {
        if (is_string($value) && (float)'1.1' != 1.1
            && ($test = (string)1.1) != '1.1' && strlen($test) == 3) {
            return (float)str_replace('.', $test{1}, $value);
        }
        return (float)$value;
    }

    /**
     * Figure out if the object specified is an instance of or an instance of a sub class of the
     * class specified
     *
     * @param object $instance any kind of object
     * @param string $className
     * @return boolean
     */
    function isA($instance, $className)
    {
        return is_a($instance, $className);
    }

    /**
     * Figure out if the object specified is an instance of the class specified, excluding
     * subclasses
     *
     * @param object $instance any kind of object
     * @param string $className
     * @return boolean
     */
    function isExactlyA($instance, $className)
    {
        return (($instanceClass = get_class($instance)) == $className || $instanceClass ==
            strtr($className, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'));
    }

    /**
     * An entity-safe equivalent to substr (http://php.net/substr).
     * @param string $string the input string
     * @param int $start the 0 based start index (negative values mean subtract from the end)
     * @param int $length the desired length.  If negative negative then that many characters will
     *                be omitted from the end of string (after the start position has been
     *                calculated when a start is negative)
     * @param boolean $countEntitiesAsOne true if the final length be a count of entities, instead
     *                of characters. (default: true)
     * @return array int the number of entities in the string
     *               string the output string
     */
    function entitySubstr($string, $start, $length=null, $countEntitiesAsOne=true)
    {
        $stringLength = strlen($string);
        if ($stringLength < $start) {
            return array(0, false);
        }

        if (!isset($length)) {
            $length = $stringLength;
        }

        if (!$countEntitiesAsOne && $start == 0 && $length >= $stringLength) {
            return array(strlen($string), $string);
        }

        if (preg_match_all('(&#x[A-Fa-f0-9]+;|&#[0-9]+;|&[A-Za-z0-9]+;|.|\n)', $string, $reg)) {
            $charArray = $reg[0];
            $charArrayLength = count($charArray);

            /* if $length < 0, then it's really the end index */
            $cookedStart = ($start < 0) ? $charArrayLength + $start : $start;
            $cookedLength = ($length < 0) ? $charArrayLength - $cookedStart + $length : $length;

            /* We now have the proper begin/end indices, so grab that slice */
            if ($countEntitiesAsOne) {
            $slice = array_slice($charArray, $cookedStart, $cookedLength);
            return array(count($slice), join('', $slice));
        } else {
            $cookedText = '';
            $actualLength = 0;
            for ($i = $cookedStart; $i < $cookedLength; $i++) {
                if ($charArray[$i][0] == '&') {
                    $size = strlen($charArray[$i]);
                } else {
                    $size = 1;
                }

                if ($actualLength + $size > $cookedLength) {
                    /* We're done */
                    break;
                }
                    $cookedText .= $charArray[$i];
                    $actualLength += $size;
                }
                return array($actualLength, $cookedText);
            }
        } else {
            /* How could we get here?  Our regex should match everything */
            $newString = substr($string, $start, $length);
            return array(strlen($newString), $newString);
        }
    }

    /**
     * Takes a string of UTF-8 encoded characters and converts it to a string of unicode entities.
     * Each unicode entity has the form &#nnnnn; n={0..9} and can be displayed by UTF-8 supporting
     * browsers.
     *
     * This function was posted in a comment here:
     *   http://www.php.net/manual/en/function.utf8-decode.php
     * by "ronen at greyzone dot com".
     *
     * @param string $source encoded using UTF-8
     * @return string of unicode entities
     */
    function utf8ToUnicodeEntities($source)
    {
        /*
         * Array used to figure what number to decrement from character order value according to
         * number of characters used to map unicode to ASCII by UTF-8
         */
        $decrement[4] = 240;
        $decrement[3] = 224;
        $decrement[2] = 192;
        $decrement[1] = 0;

        /* Number of bits to shift each charNum by */
        $shift[1][0] = 0;
        $shift[2][0] = 6;
        $shift[2][1] = 0;
        $shift[3][0] = 12;
        $shift[3][1] = 6;
        $shift[3][2] = 0;
        $shift[4][0] = 18;
        $shift[4][1] = 12;
        $shift[4][2] = 6;
        $shift[4][3] = 0;

        $pos = 0;
        $len = strlen($source);
        $encodedString = '';
        while ($pos < $len) {
            $asciiPos = ord(substr($source, $pos, 1));
            if (($asciiPos >= 240) && ($asciiPos <= 255)) {
                /* 4 chars representing one unicode character */
                $thisLetter = substr($source, $pos, 4);
                $pos += 4;
            }
            else if (($asciiPos >= 224) && ($asciiPos <= 239)) {
                /* 3 chars representing one unicode character */
                $thisLetter = substr($source, $pos, 3);
                $pos += 3;
            }
            else if (($asciiPos >= 192) && ($asciiPos <= 223)) {
                /* 2 chars representing one unicode character */
                $thisLetter = substr($source, $pos, 2);
                $pos += 2;
            }
            else {
                /* 1 char (lower ASCII) */
                $thisLetter = substr($source, $pos, 1);
                $pos += 1;
            }

            /* Process the string representing the letter to a unicode entity */
            $thisLen = strlen ($thisLetter);
            $thisPos = 0;
            $decimalCode = 0;
            while ($thisPos < $thisLen) {
                $thisCharOrd = ord(substr($thisLetter, $thisPos, 1));
                if ($thisPos == 0) {
                    $charNum = intval($thisCharOrd - $decrement[$thisLen]);
                    $decimalCode += ($charNum << $shift[$thisLen][$thisPos]);
                } else {
                    $charNum = intval($thisCharOrd - 128);
                    $decimalCode += ($charNum << $shift[$thisLen][$thisPos]);
                }
                $thisPos++;
            }
            if (($thisLen == 1) && ($decimalCode<=128)) {
                $encodedLetter = $thisLetter;
            } else {
                $encodedLetter = '&#' . $decimalCode . ';';
            }
                $encodedString .= $encodedLetter;
        }
        return $encodedString;
    }

    /**
     * Perform necessary pre-processing on the value part of the incoming array (which may be an
     * associative array or a simple list of values).  We do the following:
     * 1.  Convert UTF-8 values to Unicode entities
     * 2.  Sanitize any input values to remove dangerous values
     *
     * @param mixed $value one value or many values
     * @param boolean $adaptForMagicQuotes (optional) false to skip undoing the damage caused
     *                by magic_quotes
     */
    function sanitizeInputValues(&$value, $adaptForMagicQuotes=true)
    {
        if (is_array($value)) {
            foreach (array_keys($value) as $key) {
                $newKey = $key;
                MyOOS_Utilities::sanitizeInputValues($newKey);
                if ($key != $newKey) {
                    $value[$newKey] =& $value[$key];
                    unset($value[$key]);
                }

                MyOOS_Utilities::sanitizeInputValues($value[$newKey]);
            }
        } else {
            /*
             * Simulate calling htmlspecialchars($value, ENT_COMPAT, 'UTF-8') We avoid using
             * htmlspecialchars directly because on some versions of PHP (notable PHP 4.1.2) it
             * changes the character set of the input data (in one environment it converted the
             * UTF-8 data to ISO-8859-1)
             */
            $value = str_replace(array('&', '"', '<', '>'),
                     array('&amp;', '&quot;', '&lt;', '&gt;'),
                     $value);

            /* Undo the damage caused by magic_quotes */
            if ($adaptForMagicQuotes) {
                if (get_magic_quotes_gpc()) {
                    $value = stripslashes($value);
                }
            }
        }
    }

    /**
     * Undo preprocessing from sanitizeInputValues (useful when we put values back in the request).
     * @param mixed $value one value or many values
     * @param boolean $adaptForMagicQuotes (optional) false to skip redoing the damage caused
     *                by magic_quotes
     */
    function unsanitizeInputValues(&$value, $adaptForMagicQuotes=true)
    {
        if (is_array($value)) {
            foreach (array_keys($value) as $key) {
                MyOOS_Utilities::unsanitizeInputValues($value[$key], $adaptForMagicQuotes);
            }
        } else {
            /* Unsanitize dangerous html entities */
            /* bugs.php.net/bug.php?id=22014 - TODO: remove empty check when min php is 4.3.2+ */
            $value = empty($value) ? $value : html_entity_decode($value);

            /* Redo the damage caused by magic_quotes */
            if ($adaptForMagicQuotes) {
                if (get_magic_quotes_gpc()) {
                    $value = addslashes($value);
                }
            }
        }
    }

    /**
     * Unescape embedded UTF-8 entities in the given string.
     * @param string $string the input string with UTF-8 entities
     * @return string the UTF-8 string
     */
    function unicodeEntitiesToUtf8($string)
    {
        $string = preg_replace('/&#([xa-f\d]+);/mei',
            "MyOOS_Utilities::unicodeValueToUtf8Value('\\1')", $string);
        return $string;
    }

    /**
     * mb_substr() for UTF-8, with PHP fallback. Truncates incomplete HTML entity at end of result.
     * @param string $string the input string containing raw UTF-8
     * @param int $start
     * @param int $length
     * @return string a multibyte safe substring of input value
     * @deprecated Please use MyOOS_CoreApi::utf8Substring instead
     */
    function utf8Substring($string, $start, $length)
    {
        return MyOOS_CoreApi::utf8Substring($string, $start, $length);
    }

    /**
     * Convert a numerical unicode value to a multibyte UTF-8 string.  Adapted from code found here:
     * http://us2.php.net/utf8_encode
     *
     * @param int $num the unicode value
     * @return string the UTF-8 string
     */
    function unicodeValueToUtf8Value($num)
    {
        if ($num[0] == 'x') {
            /* Convert hex to decimal */
            $num = hexdec(substr($num, 1));
        }

        if ($num < 128) {
            return chr($num);
        }

        if ($num < 2048) {
            return (chr(192 + ($num >> 6))
            . chr(128 + ($num & 63)));
        }

        if ($num < 65535) {
            return (chr(224 + ($num >> 12))
            . chr(128 + (($num >> 6 ) & 63))
            . chr(128 + ($num & 63)));
        }

        if ($num < 2097152) {
            return (chr(240 + ($num >> 18))
            . chr(128 + (($num >> 12) & 63))
            . chr(128 + (($num >> 6) & 63))
            . chr(128 + ($num & 63)));
        }

        return '';
    }

    /**
     * Equivalent to html_entity_decode() for PHP < 4.3.0 which doesn't have it.
     * @param string $string with html entities
     * @return same string without them
     * @deprecated
     * @todo Remove at the next major version bump of core API
     */
    function htmlEntityDecode($string)
    {
        return empty($string) ? $string : html_entity_decode($string, ENT_COMPAT);
    }

    /**
     * Apply markup to given text.
     * @param string $text
     * @param string $markupType (optional) markup type, defaults from core markup parameter
     * @return string resulting text
     */
    function markup($text, $markupType=null)
    {
        MyOOS_CoreApi::requireOnce('lib/smarty_plugins/modifier.markup.php');
        return smarty_modifier_markup($text, $markupType);
    }

    /**
     * Strip out all potentially dangerous content within HTML.
     * @param string $html HTML
     * @param boolean $decode (optional) true to decode entities, process, then recode
     * @return string safe HTML
     */
    function htmlSafe($html, $decode=false)
    {
        MyOOS_CoreApi::requireOnce('lib/pear/HTML/Safe.php');
        static $parser;
        if (!isset($parser)) {
            $parser =& new HTML_Safe();
        }
        if ($decode) {
            MyOOS_Utilities::unsanitizeInputValues($html, false);
        }
        $html = $parser->parse($html);
        if ($decode) {
            MyOOS_Utilities::sanitizeInputValues($html, false);
        }
        return $html;
    }


    /**
     * Strip out all potentially dangerous content within HTML.
     * @param string $dirty_html HTML
     * @param boolean $decode (optional) true to decode entities, process, then recode
     * @return string safe HTML
     */
    function HTMLPurifier($dirty_html, $decode=false)
    {

        MyOOS_CoreApi::requireOnce('htmlpurifier/library/HTMLPurifier.auto.php');

        static $purifier;
        if (!isset($purifier)) {

            $config = HTMLPurifier_Config::createDefault();
            $config->set('Core', 'Encoding', 'ISO-8859-1'); // replace with your encoding
            $config->set('HTML', 'Doctype', 'HTML 4.01 Transitional'); // replace with your doctype
            $purifier = new HTMLPurifier($config);
        }

        if ($decode) {
            MyOOS_Utilities::unsanitizeInputValues($dirty_html, false);
        }
        $clean_html = $purifier->purify($dirty_html);
        if ($decode) {
            MyOOS_Utilities::sanitizeInputValues($clean_html, false);
        }
        return $clean_html;
    }



    /**
     * Return a specified request variable from the GET or POST vars.
     * @param string $key a single key
     * @return string a single value
     * @access private
     */
    function _getRequestVariable($key)
    {
        $keyPath = preg_split('/[\[\]]/', $key, -1, PREG_SPLIT_NO_EMPTY);
        $result = MyOOS_Utilities::_internalGetRequestVariable($keyPath, $_GET);
        if (isset($result)) {
            return $result;
        }
        return MyOOS_Utilities::_internalGetRequestVariable($keyPath, $_POST);
    }

    /**
     * Take a path in the form of ('foo', 'bar', 'baz') and a source array and get the value from it
     * like this:
     *   return $source['foo']['bar']['baz'];
     *
     * @param array $keyPath the key path
     * @param array $array the source
     * @return the value or null if it does not exist
     * @access private
     */
    function _internalGetRequestVariable($keyPath, $array)
    {
        $key = array_shift($keyPath);
        while (!empty($keyPath)) {
            if (!isset($array[$key])) {
                return null;
            }

            $array = $array[$key];
            $key = array_shift($keyPath);
        }

        return isset($array[$key]) ? $array[$key] : null;
    }

    /**
     * Set HTTP response header.
     * @param string $header HTTP response header
     * @param boolean $replace (optional) avoid setting HTTP response header if it would replace an
     *     existing header.  This differs from the PHP header() $replace param which adds a header
     *     if it would otherwise replace and existing header.
     */
    function setResponseHeader($header, $replace=true)
    {

        /* Use our PHP VM for testability */
        global $gallery;
        $phpVm = $gallery->getPhpVm();

        $responseHeaders =& MyOOS_Utilities::_getResponseHeaders();

        /* Special case for HTTP status codes.  See http://php.net/header */
        $key = 'status';
        if (strncasecmp($header, 'HTTP/', 5)) {
            $key = MyOOS_Utilities::strToLower(substr($header, 0, strpos($header, ':')));
        }

        /* Avoid setting HTTP response header if it would replace an existing header */
        if (!$replace && (!empty($responseHeaders[$key])
            || ($key == 'location' && !empty($responseHeaders['status'])
                && !preg_match('/^HTTP\/[0-9]\.[0-9] 3/', $responseHeaders['status'])))) {
            return;
        }

        $phpVm->header($header);
        $responseHeaders[$key] = $header;

        /*
         * Special case for the Location: header.  Set HTTP status code unless some 3xx status code
         * is already set.  See http://php.net/header
         */
        if ($key == 'location' && (empty($responseHeaders['status'])
            || !preg_match('/^HTTP\/[0-9]\.[0-9] 3/', $responseHeaders['status']))) {
            $responseHeaders['status'] = 'HTTP/1.0 302 Found';
        }
    }

    /**
     * Array of response headers which have already been set.
     * @return array key => value pairs of headers
     * @access private
     */
    function &_getResponseHeaders()
    {
        static $responseHeaders;
        return $responseHeaders;
    }

    /**
     * Return true if the path exists and is in the given path list.  Make sure to pass paths in the
     * system charset to this method.
     * @param string $path
     * @param string $list the list of legal paths
     * @return boolean
     */
    function isPathInList($path, $list)
    {
        global $gallery;
        $platform =& $gallery->getPlatform();
        $slash = $platform->getDirectorySeparator();
        $path = $platform->realpath($path) . $slash;
        $compare = MyOOS_Utilities::isA($platform, 'WinNtPlatform') ? 'strncasecmp' : 'strncmp';

        foreach ($list as $element) {
            if (($element = $platform->realpath($element)) === false) {
                continue;
            }
            /*
             * Make sure the compare directory has a trailing slash so that /tmp doesn't
             * accidentally match /tmpfoo
             */
            if ($element{strlen($element)-1} != $slash) {
                $element .= $slash;
            }

            if (!$compare($element, $path, strlen($element))) {
                return true;
            }
        }
        return false;
    }

    /**
     * Is this address a trusted proxy?  Right now we consider any RFC1918 host trustworthy.
     * @param string $addr an address in dotted quad form
     * @return boolean
     */
    function isTrustedProxy($addr)
    {
        return (boolean)preg_match('/^((10\.\d{1,3}\.\d{1,3}\.\d{1,3})|'
            . '(172\.(1[6-9]|2[0-9]|3[0-1])\.\d{1,3}\.\d{1,3})|'
            . '(192\.168\.\d{1,3}\.\d{1,3}))$/', $addr);
    }

    /**
     * Return the address of the remote host.
     * @return string the remote host address (or null)
     */
    function getRemoteHostAddress()
    {
        $addr = null;
        if (isset($_SERVER['REMOTE_ADDR'])) {
            $addr = $_SERVER['REMOTE_ADDR'];
            if (MyOOS_Utilities::isTrustedProxy($addr)) {
                foreach (array('HTTP_X_FORWARDED_FOR', 'HTTP_CLIENT_IP') as $key) {
                    if (isset($_SERVER[$key]) &&
                        preg_match('/^\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}$/', $_SERVER[$key])) {
                        $addr = $_SERVER[$key];
                        break;
                    }
                }
            }
        }
        return $addr;
    }


    /**
     * Deprecated.  Use MyOOS::getHttpDate instead.
     * @see MyOOS::getHttpDate
     * @deprecated
     */
    function getHttpDate($time='')
    {
        global $gallery;
        return $gallery->getHttpDate($time);
    }

    /**
     * Get contents of MANIFEST files.
     * @return array (file => array('checksum'=>..,'size'=>..,'viewable'=>..), ..)
     */
    function readManifest()
    {
        /*
         * Be careful not to reference $gallery here; this method is called from the installer.
         * Look in (modules|themes)/.../MANIFEST and top level MANIFEST.
         */
        $base = realpath(dirname(__FILE__) . '/../../..') . '/';
        $list = array();
        if (file_exists($base . 'MANIFEST')) {
            $list[] = 'MANIFEST';
        }
        foreach (array('modules', 'themes') as $dir) {
            $dh = opendir($base . $dir);
            while (($file = readdir($dh)) !== false) {
                if ($file == '..' || $file == '.') {
                    continue;
                }
                if (file_exists($base . $dir . '/' . $file . '/MANIFEST')) {
                    $list[] = $dir . '/' . $file . '/MANIFEST';
                }
            }
            closedir($dh);
        }
        $manifest = array();
        foreach ($list as $file) {
            MyOOS_Utilities::readIndividualManifest($base . $file, $manifest);
        }
        return $manifest;
    }

    /**
     * Read one manifest file.
     * @param string $filePath the path to the MANIFEST file
     * @return array(file => array('checksum'=>..,'size'=>..,'viewable'=>..), ...)
     */
    function readIndividualManifest($filePath, &$manifest)
    {
        global $gallery;

        /* If the method getPlatform exists, then we are not installing and it is safe to use. */
        if (method_exists($gallery, "getPlatform")) {
            $platform =& $gallery->getPlatform();
            $lines = $platform->file($filePath);
        } else {
            $lines = file($filePath);
        }
        if (!empty($lines)) {
            foreach ($lines as $line) {
                $line = trim(preg_replace('/#.*/', '', $line));
                if (empty($line)) {
                    continue;
                }

                $line = explode("\t", $line);
                if (count($line) == 2 && $line[0] == 'R') {
                    $file = trim($line[1]);
                    $manifest[$file] = array('removed' => 1);
                } else {
                    list ($file, $cksum, $cksum_crlf, $size, $size_crlf) = $line;
                    $file = trim($file);
                    $manifest[$file] = array(
                    'checksum' => $cksum,
                    'checksum_crlf' => $cksum_crlf,
                    'size' => $size,
                    'size_crlf' => $size_crlf);
                }
            }
        }
        return $manifest;
    }

    /**
     * Validate string is valid format for an email address.
     * @param string $email email address
     * @return boolean
     */
    function isValidEmailString($email)
    {
        return (preg_match('/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9_.-]+\.[a-zA-Z]{2,6}$/', $email) > 0);
    }

    /**
     * Create a hashed password using md5 plus salt.
     * @param string $password plaintext password
     * @param string $salt (optional) salt or hash containing salt (randomly generated if omitted)
     * @return string hashed password
     */
    function md5Salt($password, $salt='')
    {
        if (empty($salt)) {
            for ($i = 0; $i < 4; $i++) {
                $char = mt_rand(48, 109);
                $char += ($char > 90) ? 13 : ($char > 57) ? 7 : 0;
                $salt .= chr($char);
            }
        } else {
            $salt = substr($salt, 0, 4);
        }
        return $salt . md5($salt . $password);
    }

    /**
     * Verify given password is correct.
     * @param string $guess password guess
     * @param string $hashedPassword hashed password
     * @return boolean true if correct
     */
    function isCorrectPassword($guess, $hashedPassword) {
        return (MyOOS_Utilities::md5Salt($guess, $hashedPassword) === $hashedPassword);
    }

    /**
     * Verify that the API provided is compatible with the API that we require.
     *
     * We're only compatible if the major numbers are the same, and the required minor number is
     * less than or equal to the provided minor number.
     *
     * @param array $required (major, minor)
     * @param array $provided (major, minor)
     * @return boolean true if compatible
     */
    function isCompatibleWithApi($required, $provided)
    {
        if (!is_array($required) || !is_array($provided)) {
            return false;
        }
        if (count($required) != count($provided) || count($required) != 2) {
            return false;
        }
        for ($i = 0; $i < 1; $i++) {
            if (!is_int($required[$i]) || !is_int($provided[$i])) {
                return false;
            }
        }
        if ($required[0] != $provided[0]) {
            return false;
        }
        if ($required[1] > $provided[1]) {
            return false;
        }
        return true;
    }

    /**
     * Get all array keys, looking even in arrays contained within the array.
     * @param array $array
     * @return array of keys
     */
    function arrayKeysRecursive($array)
    {
        $keys = array();
        foreach ($array as $key => $item) {
            $keys[] = $key;
            if (is_array($item) && !empty($item)) {
                $keys = array_merge($keys, MyOOS_Utilities::arrayKeysRecursive($item));
            }
        }
        return $keys;
    }

    /**
     * Get a php.ini value and return its boolean value.
     * @param string $ini_string name of the php.ini value to be retrieved
     * @return boolean value
     */
    function getPhpIniBool($ini_string)
    {
        $value = ini_get($ini_string);

        if (!strcasecmp('on', $value) || $value == 1 || $value === true) {
            return true;
        }

        if (!strcasecmp('off', $value) || $value == 0 || $value === false) {
            return false;
        }

        /* Catchall */
        return false;
    }

    /**
     * Return id of the search engine currently crawling the site by analyzing the current request.
     * @return string the crawler id, or null if it's a regular user
     */
    function identifySearchEngine()
    {
        if (!isset($_SERVER['HTTP_USER_AGENT'])) {
            return null;
        }
        $userAgent = $_SERVER['HTTP_USER_AGENT'];
        if (strstr($userAgent, 'Google') || strstr($userAgent, 'gsa-crawler')) {
            return 'google';
        } else if (strstr($userAgent, 'Yahoo')) {
            return 'yahoo';
        } else if (strstr($userAgent, 'Ask Jeeves')) {
            return 'askjeeves';
        } else if (strstr($userAgent, 'msnbot')) {
            return 'microsoft';
        } else if (strstr($userAgent, 'Yandex')) {
            return 'yandex';
        } else if (strstr($userAgent, 'StackRambler')) {
            return 'stackrambler';
        } else if (strstr($userAgent, 'ConveraCrawler')) {
            return 'convera';
        }

        return null;
    }

    /**
     * Return a sanitized version of the given variable from the _SERVER superglobal.
     * @param string $key the key in the _SERVER superglobal
     * @return string the value
     */
    function getServerVar($key)
    {
        if (!isset($_SERVER[$key])) {
            return null;
    }

        $value = $_SERVER[$key];
        MyOOS_Utilities::sanitizeInputValues($value);
        return $value;
    }

    /**
     * Return a sanitized version of the given variable from the _COOKIE superglobal.
     * @param string $key the key in the _COOKIE superglobal
     * @return string the value
     */
    function getCookieVar($key)
    {
        if (!isset($_COOKIE[$key])) {
            return null;
        }

        $value = $_COOKIE[$key];
        MyOOS_Utilities::sanitizeInputValues($value);
        return $value;
    }

    /**
     * Deprecated.  Use Gallery::isEmbedded instead.
     * @see Gallery::isEmbedded
     * @deprecated
     */
    function isEmbedded()
    {
        global $gallery;
        return $gallery->isEmbedded();
    }

    /**
     * ASCII version of PHP's strtolower().  PHP's strtolower doesn't work in all locales as
     * expected, eg. in Turkish, we get non-ASCII characters for an ASCII input string.
     * @param string $string
     * @return string lowercase version of the string
     */
    function strToLower($string)
    {
        return strtr($string, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz');
    }

    /**
     * ASCII version of PHP's strtoupper().
     * @param string $string
     * @return string uppercase version of the string
     */
    function strToUpper($string)
    {
        return strtr($string, 'abcdefghijklmnopqrstuvwxyz', 'ABCDEFGHIJKLMNOPQRSTUVWXYZ');
    }

    /**
     * Checks whether the given HTTP header is safe.
     *
     * PHP versions before PHP 4.4.2 / PHP 5.1.2 allowed for HTTP header injection (HTTP RS).
     * This function ensures that servers running older PHP versions are protected as well.
     *
     * @param string $header
     * @return bool true if the given header is safe
     */
    function isSafeHttpHeader($header)
    {
        if (!is_string($header)) {
            return false;
        }

        /* Don't allow plain occurrences of CR or LF */
        if (strpos($header, chr(13)) !== false || strpos($header, chr(10)) !== false) {
            return false;
        }

        /* Don't allow (x times) url encoded versions of CR or LF */
        if (preg_match('/%(25)*(0a|0d)/i', $header)) {
            return false;
        }

        return true;
    }

}
