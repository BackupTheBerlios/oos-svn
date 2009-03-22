<?php

/**
 * Swift Mailer Before Command Event Listener Interface
 * Please read the LICENSE file
 * @copyright Chris Corbyn <chris@w3style.co.uk>
 * @author Chris Corbyn <chris@w3style.co.uk>
 * @package Swift_Events
 * @license GNU Lesser General Public License
 */

/** ensure this file is being included by a parent file */
defined( 'OOS_VALID_MOD' ) or die( 'Direct Access to this location is not allowed.' );

/**
 * Contains the list of methods a plugin requiring the use of a CommandEvent, before it is sent must implement
 * @package Swift_Events
 * @author Chris Corbyn <chris@w3style.co.uk>
 */
interface Swift_Events_BeforeCommandListener extends Swift_Events_Listener
{
  /**
   * Executes just before Swift sends a command
   * @param Swift_Events_CommandEvent Information about the being command sent
   */
  public function beforeCommandSent(Swift_Events_CommandEvent $e);
}
