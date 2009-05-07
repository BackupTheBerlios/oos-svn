<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: FormFirstWebsiteSetup.php 870 2009-01-14 03:40:55Z matt $
 * 
 * @package Piwik_Installation
 */

require_once "Form.php";

/**
 * 
 * @package Piwik_Installation
 */
class Piwik_Installation_FormFirstWebsiteSetup extends Piwik_Form
{
	function init()
	{
		$urlToGoAfter = Piwik_Url::getCurrentUrl();			
		
		$urlExample = 'http://example.org';
		$javascriptOnClickUrlExample = "\"javascript:if(this.value=='$urlExample'){this.value='http://';} this.style.color='black';\"";
		
		$formElements = array(
			array('text', 'siteName', 'website name'),
			array('text', 'url', 'website URL', "style='color:rgb(153, 153, 153);' value=$urlExample onfocus=".$javascriptOnClickUrlExample." onclick=".$javascriptOnClickUrlExample),
		);
		$this->addElements( $formElements );
		
		$formRules = array();
		foreach($formElements as $row)
		{
			$formRules[] = array($row[1], sprintf('%s required', $row[2]), 'required');
		}
		
		$this->addRules( $formRules );	
		
		$this->addElement('submit', 'submit', 'Go!');
	}	
}
