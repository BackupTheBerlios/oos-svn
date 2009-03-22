<?php

/**
 * Swift Connection Exception
 * Please read the LICENSE file
 * @copyright Chris Corbyn <chris@w3style.co.uk>
 * @author Chris Corbyn <chris@w3style.co.uk>
 * @package Swift_Connection
 * @license GNU Lesser General Public License
 */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

require_once dirname(__FILE__) . "/ClassLoader.php";
Swift_ClassLoader::load("Swift_Exception");

/**
 * Swift Connection Exception
 * @package Swift_Connection
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
class Swift_ConnectionException extends Swift_Exception
{
}
