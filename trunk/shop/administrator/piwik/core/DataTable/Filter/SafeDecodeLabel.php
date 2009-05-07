<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: SafeDecodeLabel.php 731 2008-11-21 16:07:04Z matt $
 * 
 * @package Piwik_DataTable
 */

/**
 * 
 * @package Piwik_DataTable
 * @subpackage Piwik_DataTable_Filter 
 */
class Piwik_DataTable_Filter_SafeDecodeLabel extends Piwik_DataTable_Filter
{
	private $columnToDecode;
	public function __construct( $table )
	{
		parent::__construct($table);
		$this->columnToDecode = 'label';
		$this->filter();
	}
	
	protected function filter()
	{
		foreach($this->table->getRows() as $row)
		{
			$row->setColumn( 	$this->columnToDecode, 
								htmlspecialchars(
									htmlspecialchars_decode(
										urldecode($row->getColumn($this->columnToDecode)),
										ENT_QUOTES), 
									ENT_QUOTES)
					);
		}
	}
}

