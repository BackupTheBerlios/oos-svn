<?php
/**
 * Piwik - Open source web analytics
 * 
 * @link http://piwik.org
 * @license http://www.gnu.org/licenses/gpl-3.0.html Gpl v3 or later
 * @version $Id: Cookie.php 2777 2010-07-29 02:13:37Z matt $
 * 
 * @category Piwik
 * @package Piwik
 */

/**
 * Simple class to handle the cookies:
 * - read a cookie values
 * - edit an existing cookie and save it
 * - create a new cookie, set values, expiration date, etc. and save it
 * 
 * @package Piwik
 */
class Piwik_Cookie
{
	/**
	 * Don't create a cookie bigger than 1k
	 */
	const MAX_COOKIE_SIZE = 1024;
	
	/**
	 * The name of the cookie 
	 */
	protected $name = null;
	
	/**
	 * The expire time for the cookie (expressed in UNIX Timestamp)
	 */
	protected $expire = null;
	
	/**
	 * The content of the cookie
	 */
	protected $value = array();
	
	/**
	 * The character used to separate the tuple name=value in the cookie 
	 */
	const VALUE_SEPARATOR = ':';
	
	/**
	 * Instanciate a new Cookie object and tries to load the cookie content if the cookie
	 * exists already.
	 * 
	 * @param string cookie Name
	 * @param int The timestamp after which the cookie will expire, eg time() + 86400
	 * @param string The path on the server in which the cookie will be available on. 
	 * @param string $keyStore Will be used to store several bits of data (eg. one array per website)
	 */
	public function __construct( $cookieName, $expire = null, $path = null, $keyStore = false)
	{
		$this->name = $cookieName;
		$this->path = $path;
		$this->expire = $expire;
		if(is_null($expire)
			|| !is_numeric($expire)
			|| $expire <= 0)
		{
			$this->expire = $this->getDefaultExpire();
		}
		
		$this->keyStore = $keyStore;
		if($this->isCookieFound())
		{
			$this->loadContentFromCookie();
		}
	}
	
	/**
	 * Returns true if the visitor already has the cookie.
	 *
	 * @return bool 
	 */
	public function isCookieFound()
	{
		return isset($_COOKIE[$this->name]);
	}
	
	/**
	 * Returns the default expiry time, 2 years
	 *
	 * @return int Timestamp in 2 years
	 */
	protected function getDefaultExpire()
	{
		return time() + 86400*365*2;
	}	
	
	/**
	 * We don't use the setcookie function because it is buggy for some PHP versions.
	 * 
	 * Taken from http://php.net/setcookie
	 */
	protected function setCookie($Name, $Value, $Expires, $Path = '', $Domain = '', $Secure = false, $HTTPOnly = false)
	{
		if (!empty($Domain))
		{	
			// Fix the domain to accept domains with and without 'www.'.
			if (strtolower(substr($Domain, 0, 4)) == 'www.')  $Domain = substr($Domain, 4);
			
			$Domain = '.' . $Domain;
			
			// Remove port information.
			$Port = strpos($Domain, ':');
			if ($Port !== false)  $Domain = substr($Domain, 0, $Port);
		}
		
		$header = 'Set-Cookie: ' . rawurlencode($Name) . '=' . rawurlencode($Value)
					 . (empty($Expires) ? '' : '; expires=' . gmdate('D, d-M-Y H:i:s', $Expires) . ' GMT')
					 . (empty($Path) ? '' : '; path=' . $Path)
					 . (empty($Domain) ? '' : '; domain=' . $Domain)
					 . (!$Secure ? '' : '; secure')
					 . (!$HTTPOnly ? '' : '; HttpOnly');
		 
		 header($header, false);
	}
	
	/**
	 * We set the privacy policy header
	 */
	protected function setP3PHeader()
	{
		header("P3P: CP='OTI DSP COR NID STP UNI OTPa OUR'");
	}
	
	/**
	 * Delete the cookie
	 */
	public function delete()
	{
		$this->setP3PHeader();
		setcookie($this->name, false, time() - 86400);
	}
	
	/**
	 * Saves the cookie (set the Cookie header).
	 * You have to call this method before sending any text to the browser or you would get the 
	 * "Header already sent" error.
	 */
	public function save()
	{
		$cookieString = $this->generateContentString();
		if(strlen($cookieString) > self::MAX_COOKIE_SIZE)
		{
			// If the cookie was going to be too large, instead, delete existing cookie and start afresh
			// This will result in slightly less accuracy in the case 
			// where someone visits more than dozen websites tracked by the same Piwik
			// This will usually be the Piwik super user itself checking all his websites regularly
			$this->delete();
			return;
		}
		
		$this->setP3PHeader();
		$this->setCookie( $this->name, $cookieString, $this->expire, $this->path);
	}
	
	/**
	 * Load the cookie content into a php array.
	 * Parses the cookie string to extract the different variables.
	 * Unserialize the array when necessary.
	 * Decode the non numeric values that were base64 encoded.
	 */
	protected function loadContentFromCookie()
	{
		$cookieStr = $_COOKIE[$this->name];
		$values = explode( self::VALUE_SEPARATOR, $cookieStr);
		foreach($values as $nameValue)
		{
			$equalPos = strpos($nameValue, '=');
			$varName = substr($nameValue,0,$equalPos);
			$varValue = substr($nameValue,$equalPos+1);
			
			// no numeric value are base64 encoded so we need to decode them
			if(!is_numeric($varValue))
			{
				$varValue = base64_decode($varValue);

				// some of the values may be serialized array so we try to unserialize it
				$varValue = Piwik_Common::unserialize_array($varValue);
			}
			
			$this->value[$varName] = $varValue;
		}
	}
	
	/**
	 * Returns the string to save in the cookie from the $this->value array of values.
	 * It goes through the array and generates the cookie content string.
	 *
	 * @return string Cookie content
	 */
	protected function generateContentString()
	{
		$cookieStr = '';
		foreach($this->value as $name=>$value)
		{
			if(is_array($value))
			{
				$value = serialize($value);
			}
			$value = base64_encode($value);
			
			$cookieStr .= "$name=$value" . self::VALUE_SEPARATOR;
		}
		$cookieStr = substr($cookieStr, 0, strlen($cookieStr)-1);
		return $cookieStr;
	}
	
	/**
	 * Registers a new name => value association in the cookie.
	 * 
	 * Registering new values is optimal if the value is a numeric value.
	 * If the value is a string, it will be saved as a base64 encoded string.
	 * If the value is an array, it will be saved as a serialized and base64 encoded 
	 * string which is not very good in terms of bytes usage. 
	 * You should save arrays only when you are sure about their maximum data size.
	 * A cookie has to stay small and its size shouldn't increase over time!
	 * 
	 * @param string Name of the value to save; the name will be used to retrieve this value
	 * @param string|array|numeric Value to save. If null, entry will be deleted from cookie.
	 */
	public function set( $name, $value )
	{
		$name = self::escapeValue($name);
		
		// Delete value if $value === null
		if(is_null($value))
		{
			if($this->keyStore === false)
			{
				unset($this->value[$name]);
				return;
			}
			unset($this->value[$this->keyStore][$name]);
			return;
		}
		
		if($this->keyStore === false)
		{
			$this->value[$name] = $value;
			return;
		}
		$this->value[$this->keyStore][$name] = $value;
	}
	
	/**
	 * Returns the value defined by $name from the cookie.
	 * 
	 * @param string|integer Index name of the value to return
	 * @return mixed The value if found, false if the value is not found
	 */
	public function get( $name )
	{
		$name = self::escapeValue($name);
		if($this->keyStore === false)
		{
    		return isset($this->value[$name]) 
    					? self::escapeValue($this->value[$name]) 
    					: false;
		}
		return isset($this->value[$this->keyStore][$name])
					? self::escapeValue($this->value[$this->keyStore][$name])
					: false;
	}
	
	/**
	 * Returns an easy to read cookie dump
	 * 
	 * @return string The cookie dump
	 */
	public function __toString()
	{
		$str = 'COOKIE '.$this->name.', rows count: '.count($this->value). ', cookie size = '.strlen($this->generateContentString()).' bytes<br/>';
		$str .= var_export($this->value, $return = true);
		return $str;
	}
	
	/**
	 * Escape values from the cookie before sending them back to the client 
	 * (when using the get() method).
	 * 
	 * @return mixed The value once cleaned.
	 */
	static protected function escapeValue( $value )
	{
		return Piwik_Common::sanitizeInputValues($value);
	}	
}
