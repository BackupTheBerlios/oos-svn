<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: ChartVerticalBar.php 1296 2009-07-08 04:19:14Z vipsoft $
 * 
 * @package Piwik_ViewDataTable
 */

/**
 * 
 * Generates HTML embed for the vertical bar chart
 * 
 * @package Piwik_ViewDataTable
 *
 */
class Piwik_ViewDataTable_GenerateGraphHTML_ChartVerticalBar extends Piwik_ViewDataTable_GenerateGraphHTML
{
	protected function getViewDataTableId()
	{
		return 'graphVerticalBar';
	}
	
	protected function getViewDataTableIdToLoad()
	{
		return 'generateDataChartVerticalBar';
	}
}
