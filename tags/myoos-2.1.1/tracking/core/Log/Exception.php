<?php
/**
 * Piwik - Open source web analytics
 *
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: Exception.php 583 2008-07-28 00:37:19Z matt $
 *
 * @package Piwik_Log
 * @subpackage Piwik_Log_Exception
 */
require_once "Log.php";

/**
 * Class used to log an exception event.
 * Displays the exception with a user friendly error message, suggests to get support from piwik.org
 *
 * @package Piwik_Log
 * @subpackage Piwik_Log_Exception
 */
class Piwik_Log_Exception extends Piwik_Log
{
	const ID = 'logger_exception';
	function __construct()
	{
		$logToFileFilename = self::ID;
		$logToDatabaseTableName = self::ID;
		$logToDatabaseColumnMapping = null;
		$screenFormatter = new Piwik_Log_Formatter_Exception_ScreenFormatter;
		$fileFormatter = new Piwik_Log_Formatter_FileFormatter;

		parent::__construct($logToFileFilename,
							$fileFormatter,
							$screenFormatter,
							$logToDatabaseTableName,
							$logToDatabaseColumnMapping );
	}

	function addWriteToScreen()
	{
		parent::addWriteToScreen();
		$writerScreen = new Zend_Log_Writer_Stream('php://stderr');
		$writerScreen->setFormatter( $this->screenFormatter );
		$this->addWriter($writerScreen);
	}

	public function log($exception)
	{
		$event = array();
		$event['errno'] 	= $exception->getCode();
		$event['message'] 	= $exception->getMessage();
		$event['errfile'] 	= $exception->getFile();
		$event['errline'] 	= $exception->getLine();
		$event['backtrace'] = $exception->getTraceAsString();
		parent::log($event);
	}
}


/**
 * Format an exception event to be displayed on the screen.
 *
 * @package Piwik_Log
 * @subpackage Piwik_Log_Exception
 */
class Piwik_Log_Formatter_Exception_ScreenFormatter extends Piwik_Log_Formatter_ScreenFormatter
{
	/**
	 * Formats data into a single line to be written by the writer.
	 *
	 * @param  array    $event    event data
	 * @return string             formatted line to write to the log
	 */
	public function format($event)
	{
    	$event = parent::formatEvent($event);
		$errno = $event['errno'] ;
		$errstr = $event['message'] ;
		$errfile = $event['errfile'] ;
		$errline = $event['errline'] ;
		$backtrace = $event['backtrace'] ;

		require_once "API/ResponseBuilder.php";
		$outputFormat = strtolower(Piwik_Common::getRequestVar('format', 'html', 'string'));
		$response = new Piwik_API_ResponseBuilder(null, $outputFormat);
		$message = $response->getResponseException(new Exception($errstr));
		return parent::format($message);
	}
}





