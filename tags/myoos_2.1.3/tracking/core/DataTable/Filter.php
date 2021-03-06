<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: Filter.php 1296 2009-07-08 04:19:14Z vipsoft $
 * 
 * @package Piwik_DataTable
 */

/**
 * A filter is applied instantly to a given DataTable and can 
 * - remove rows 
 * - change columns values (lowercase the strings, truncate, etc.)
 * - add/remove columns or metadata (compute percentage values, add an 'icon' metadata based on the label, etc.)
 * - add/remove/edit sub DataTable associated to some rows
 * - whatever you can imagine
 * 
 * The concept is very simple: the filter is given the DataTable 
 * and can do whatever is necessary on the data (in the filter() method).
 * 
 * @package Piwik_DataTable
 * @subpackage Piwik_DataTable_Filter
 */
abstract class Piwik_DataTable_Filter
{
	/*
	 * @var Piwik_DataTable
	 */
	protected $table;
	
	public function __construct($table)
	{
		if(!($table instanceof Piwik_DataTable))
		{
			throw new Exception("The filter accepts only a Piwik_DataTable object.");
		}
		$this->table = $table;
	}
	
	abstract protected function filter();
}
