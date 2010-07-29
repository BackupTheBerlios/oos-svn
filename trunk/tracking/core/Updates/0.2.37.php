<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: 0.2.37.php 2739 2010-07-28 02:39:50Z vipsoft $
 *
 * @category Piwik
 * @package Updates
 */

/**
 * @package Updates
 */
class Piwik_Updates_0_2_37 extends Piwik_Updates
{
	static function getSql($schema = 'Myisam')
	{
		return array(
			'DELETE FROM `'.  Piwik_Common::prefixTable('user_dashboard') ."`
				WHERE layout LIKE '%.getLastVisitsGraph%'
				OR layout LIKE '%.getLastVisitsReturningGraph%'" => false,
		);
	}

	static function update()
	{
		Piwik_Updater::updateDatabase(__FILE__, self::getSql());
	}
}
