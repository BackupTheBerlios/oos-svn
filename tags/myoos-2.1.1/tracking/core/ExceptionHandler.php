<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: ExceptionHandler.php 444 2008-04-11 13:38:22Z johmathe $
 * 
 * @package Piwik_Helper
 */

require_once "Piwik.php";

/**
 * Exception handler used to display nicely exceptions in Piwik
 * 
 * @package Piwik_Helper
 */
function Piwik_ExceptionHandler(Exception $exception) 
{
	try	{
		Zend_Registry::get('logger_exception')->log($exception);
	} catch(Exception $e) {
		// case when the exception is raised before the logger being ready
		// we handle the exception a la mano, but using the Logger formatting properties
		require_once "Log/Exception.php";
		
		$event = array();
		$event['errno'] 	= $exception->getCode();
		$event['message'] 	= $exception->getMessage();
		$event['errfile'] 	= $exception->getFile();
		$event['errline'] 	= $exception->getLine();
		$event['backtrace'] = $exception->getTraceAsString();
		
		$formatter = new Piwik_Log_Formatter_Exception_ScreenFormatter;
		
		$message = $formatter->format($event);
		$message .= "<br><br>And this exception raised another exception \"". $e->getMessage()."\"";
		
		Piwik::exitWithErrorMessage( $message );
	}
}

