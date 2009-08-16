<?php
/* ----------------------------------------------------------------------
   $Id$

   OOS [OSIS Online Shop]
   http://www.oos-shop.de/

   Copyright (c) 2003 - 2009 by the OOS Development Team.
   ----------------------------------------------------------------------
   Based on:

   credit card encryption functions for the catalog module

   BMC 2003 for the CC CVV Module

   (c) Mainframes 2003 http://www.mainframes.co.uk
   ----------------------------------------------------------------------
   Released under the GNU General Public License
   ---------------------------------------------------------------------- */


  /**
   * credit card encryption functions for the catalog module
   *
   * @package credit card
   * @license GPL <http://www.gnu.org/licenses/gpl.html>
   * @link http://www.mainframes.co.uk
   */

  /** ensure this file is being included by a parent file */
  defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );


  function changedatain($plain_data, $key) {

    // encode plain data with key using xoft encryption

    $key_length = 0; //key length counter
    $all_bin_chars = "";
    $cipher_data = "";

    $nStrlenPlainData = strlen($plain_data);
    for ($i=0; $i<$nStrlenPlainData; $i++) {
      $p = substr($plain_data, $i, 1);   // p = plaintext
      $k = substr($key, $key_length, 1); // k = key
      $key_length++;

      if ($key_length >= strlen($key)) {
        $key_length = 0;
      }

      $dec_chars = ord($p)^ord($k);
      $dec_chars = $dec_chars + strlen($key);
      $bin_chars = decbin($dec_chars);

      while(strlen($bin_chars) < 8) {
        $bin_chars = "0" . $bin_chars;
      }

      $all_bin_chars = $all_bin_chars . $bin_chars;

    }

    $m = 0;

    $nStrlenChars = strlen($all_bin_chars);
    for ($j=0; $j<$nStrlenChars; $j=$j+4) {
      $four_bit = substr($all_bin_chars, $j, 4);     // split 8 bit to 4 bit
      $four_bit_dec = bindec($four_bit);

      $decimal_value = $four_bit_dec * 4 + $m;     //multiply by 4 plus m where m=0,1,2, or 3

      $base64_value = dectobase64($decimal_value); //convert to base64 value
      $cipher_data = $cipher_data . $base64_value;
      $m++;

      if ($m > 3) {
        $m = 0;
      }
    }

    return $cipher_data;
  }


  function dectobase64($decimal_value) {

    // convert decimal value into base64 value

    switch ($decimal_value) {
       case 0: $base64_value = "A"; break;
       case 1: $base64_value = "B"; break;
       case 2: $base64_value = "C"; break;
       case 3: $base64_value = "D"; break;
       case 4: $base64_value = "E"; break;
       case 5: $base64_value = "F"; break;
       case 6: $base64_value = "G"; break;
       case 7: $base64_value = "H"; break;
       case 8: $base64_value = "I"; break;
       case 9: $base64_value = "J"; break;
      case 10: $base64_value = "K"; break;
      case 11: $base64_value = "L"; break;
      case 12: $base64_value = "M"; break;
      case 13: $base64_value = "N"; break;
      case 14: $base64_value = "O"; break;
      case 15: $base64_value = "P"; break;
      case 16: $base64_value = "Q"; break;
      case 17: $base64_value = "R"; break;
      case 18: $base64_value = "S"; break;
      case 19: $base64_value = "T"; break;
      case 20: $base64_value = "U"; break;
      case 21: $base64_value = "V"; break;
      case 22: $base64_value = "W"; break;
      case 23: $base64_value = "X"; break;
      case 24: $base64_value = "Y"; break;
      case 25: $base64_value = "Z"; break;
      case 26: $base64_value = "a"; break;
      case 27: $base64_value = "b"; break;
      case 28: $base64_value = "c"; break;
      case 29: $base64_value = "d"; break;
      case 30: $base64_value = "e"; break;
      case 31: $base64_value = "f"; break;
      case 32: $base64_value = "g"; break;
      case 33: $base64_value = "h"; break;
      case 34: $base64_value = "i"; break;
      case 35: $base64_value = "j"; break;
      case 36: $base64_value = "k"; break;
      case 37: $base64_value = "l"; break;
      case 38: $base64_value = "m"; break;
      case 39: $base64_value = "n"; break;
      case 40: $base64_value = "o"; break;
      case 41: $base64_value = "p"; break;
      case 42: $base64_value = "q"; break;
      case 43: $base64_value = "r"; break;
      case 44: $base64_value = "s"; break;
      case 45: $base64_value = "t"; break;
      case 46: $base64_value = "u"; break;
      case 47: $base64_value = "v"; break;
      case 48: $base64_value = "w"; break;
      case 49: $base64_value = "x"; break;
      case 50: $base64_value = "y"; break;
      case 51: $base64_value = "z"; break;
      case 52: $base64_value = "0"; break;
      case 53: $base64_value = "1"; break;
      case 54: $base64_value = "2"; break;
      case 55: $base64_value = "3"; break;
      case 56: $base64_value = "4"; break;
      case 57: $base64_value = "5"; break;
      case 58: $base64_value = "6"; break;
      case 59: $base64_value = "7"; break;
      case 60: $base64_value = "8"; break;
      case 61: $base64_value = "9"; break;
      case 62: $base64_value = "+"; break;
      case 63: $base64_value = "/"; break;
      case 64: $base64_value = "="; break;
      default: $base64_value = "a"; break;
    }

    return $base64_value;
  }

