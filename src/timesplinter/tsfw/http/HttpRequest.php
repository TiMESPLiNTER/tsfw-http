<?php

namespace timesplinter\tsfw\http;

use timesplinter\tsfw\common\StringUtils;

/**
 * @author Pascal Muenst <dev@timesplinter.ch>
 * @copyright Copyright (c) 2014, TiMESPLiNTER Webdevelopment
 */
class HttpRequest {
	const PROTOCOL_HTTP = 'http';
	const PROTOCOL_HTTPS = 'https';

	protected $protocol;
	protected $host;
	protected $port;
	protected $path;
	protected $query;
	protected $uri;

	protected $requestMethod;
	protected $requestTime;
	protected $acceptedLanguages;
	protected $acceptedEncodings;
	protected $userAgent;
	protected $remoteAddress;

	protected $requestVars;
	protected $cookies;
	protected $files;

	public function __construct()
	{
		$this->requestVars = array_merge($_GET, $_POST);
		$this->cookies = $_COOKIE;
		$this->files = $_FILES;
		
		$this->requestTime = new \DateTime();
		
		$this->acceptedEncodings = array();
		$this->acceptedLanguages = array();
	}

	/**
	 * Returns the current HTTP request
	 * @return HttpRequest|null The current HTTP request made by the client or null if it's not a "real" HTTP request
	 * (for example if php is called by the CLI)
	 */
	public static function currentRequest()
	{
		if(isset($_SERVER['REQUEST_METHOD']) === false || $_SERVER['REQUEST_METHOD'] === null)
			return null;

		return self::create($_SERVER);
	}

	/**
	 * Creates a new HttpRequest object based on the given data
	 * @param array $requestData Data of the HTTP request
	 * @return HttpRequest
	 */
	public static function create(array $requestData)
	{
		$defaultValues = array(
			'REQUEST_TIME' => time(),
			'SERVER_PORT' => null,
			'SERVER_NAME' => null,
			'QUERY_STRING' => null,
			'REMOTE_ADDR' => null,
			'HTTP_USER_AGENT' => null,
			'HTTPS' => null,
			'REQUEST_URI' => null,
			'HTTP_ACCEPT_LANGUAGE' => null,
			'HTTP_ACCEPT_ENCODING' => null,
			'REQUEST_METHOD' => null
		);
		
		$requestData = array_merge($defaultValues, $requestData);
		
		$httpRequest = new HttpRequest();

		$protocol = null;
		
		if($requestData['HTTPS'] !== null)
			$protocol = ($requestData['HTTPS'] === 'on')?self::PROTOCOL_HTTPS:self::PROTOCOL_HTTP;
		
		$uri = StringUtils::startsWith($requestData['REQUEST_URI'], '/index.php')?StringUtils::afterFirst($requestData['REQUEST_URI'], '/index.php'):$requestData['REQUEST_URI'];
		$path = StringUtils::beforeLast($uri, '?');

		$languages = array();
		$langRates = array_filter(explode(',', $requestData['HTTP_ACCEPT_LANGUAGE']));

		foreach($langRates as $lr) {
			list($langCode, $importance) = array_pad(preg_split('/;(?:q=)?/', $lr), 2, 1.0);

			$languages[$langCode] = (float)$importance;
		}
		
		$acceptedEncoding = array_filter(array_map('trim', explode(',', $requestData['HTTP_ACCEPT_ENCODING'])));

		$requestTime = new \DateTime();
		$requestTime->setTimestamp($requestData['REQUEST_TIME']);

		$httpRequest->setHost($requestData['SERVER_NAME']);
		$httpRequest->setPath($path);
		$httpRequest->setPort($requestData['SERVER_PORT']);
		$httpRequest->setProtocol($protocol);
		$httpRequest->setQuery($requestData['QUERY_STRING']);
		$httpRequest->setURI($uri);
		$httpRequest->setRequestTime($requestTime);
		$httpRequest->setAcceptedEncodings($acceptedEncoding);
		$httpRequest->setRequestMethod($requestData['REQUEST_METHOD']);
		$httpRequest->setUserAgent($requestData['HTTP_USER_AGENT']);
		$httpRequest->setAcceptedLanguages($languages);
		$httpRequest->setRemoteAddress($requestData['REMOTE_ADDR']);

		return $httpRequest;
	}

	/**
	 * @param string $protocol
	 */
	public function setProtocol($protocol)
	{
		$this->protocol = $protocol;
	}

	/**
	 * @return string
	 */
	public function getProtocol()
	{
		return $this->protocol;
	}

	/**
	 * Get this requests host
	 * @return string
	 */
	public function getHost()
	{
		return $this->host;
	}

	/**
	 * Set this requests host
	 * @param string $host
	 */
	public function setHost($host)
	{
		$this->host = $host;
	}

	/**
	 * Get the port through which this request was sent
	 * @return int The port number
	 */
	public function getPort()
	{
		return $this->port;
	}

	/**
	 * Set the port through which this request will be sent
	 * @param int $port The port number
	 */
	public function setPort($port)
	{
		$this->port = $port;
	}

	/**
	 * @return string
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * @param string $path
	 */
	public function setPath($path)
	{
		$this->path = $path;
	}

	/**
	 * @return string
	 */
	public function getQuery()
	{
		return $this->query;
	}

	/**
	 * @param string $query
	 */
	public function setQuery($query)
	{
		$this->query = $query;
	}

	/**
	 * @param string $uri
	 */
	public function setURI($uri)
	{
		$this->uri = $uri;
	}

	/**
	 * @return string
	 */
	public function getURI()
	{
		return $this->uri;
	}

	/**
	 * Set current requests user agent
	 * @param string $userAgent
	 */
	public function setUserAgent($userAgent)
	{
		$this->userAgent = $userAgent;
	}

	/**
	 * Get current requests user agent
	 * @return string
	 */
	public function getUserAgent()
	{
		return $this->userAgent;
	}

	/**
	 * Set current requests accepted languages
	 * @param array $languages Supported languages where key is the language ISO code and the value its weight
	 */
	public function setAcceptedLanguages(array $languages)
	{
		$this->acceptedLanguages = $languages;
	}

	/**
	 * Get current requests accepted languages
	 * @return array Supported languages
	 */
	public function getAcceptedLanguages()
	{
		return $this->acceptedLanguages;
	}

	/**
	 * 
	 * @param \DateTime $requestTime
	 */
	public function setRequestTime(\DateTime $requestTime)
	{
		$this->requestTime = $requestTime;
	}

	/**
	 * Get the time when the current request has been fetched by the server
	 * @return \DateTime
	 */
	public function getRequestTime()
	{
		return $this->requestTime;
	}

	/**
	 * @param string $requestMethod
	 */
	public function setRequestMethod($requestMethod)
	{
		$this->requestMethod = $requestMethod;
	}

	/**
	 * @return string
	 */
	public function getRequestMethod()
	{
		return $this->requestMethod;
	}

	/**
	 * Get current requests remote address
	 * @return string
	 */
	public function getRemoteAddress()
	{
		return $this->remoteAddress;
	}

	/**
	 * Set current requests remote address
	 * @param string $remoteAddress
	 */
	public function setRemoteAddress($remoteAddress) {
		$this->remoteAddress = $remoteAddress;
	}

	/**
	 * @param array $acceptedEncodings
	 */
	public function setAcceptedEncodings(array $acceptedEncodings)
	{
		$this->acceptedEncodings = $acceptedEncodings;
	}

	/**
	 * @return array
	 */
	public function getAcceptedEncodings()
	{
		return $this->acceptedEncodings;
	}

	/**
	 * Create an URL based on the current request and the given protocol
	 * @param string $protocol
	 * @return string
	 */
	public function createURL($protocol)
	{
		return $protocol . '://' . $this->host . $this->uri;
	}

	/**
	 * Returns the value of a variable with key $name from either $_GET or $_POST
	 * @param string $name The name of the GET or POST variable
	 * @return mixed|null Returns the value of the variable or null if it does not exist
	 */
	public function getVar($name)
	{
		if(isset($this->requestVars[$name]) === false)
			return null;

		return $this->requestVars[$name];
	}

	/**
	 * Returns the value of a cookie with key $name
	 * @param string $name The name of the cookie
	 * @return mixed|null Returns the value of the cookie or null if it does not exist
	 */
	public function getCookieValue($name)
	{
		if(isset($this->cookies[$name]) === false)
			return null;

		return $this->cookies[$name];
	}

	/**
	 * Returns the informations about a file
	 * @param string $name The name of the file field
	 * @return array|null Returns the information about the file or null if it does not exist
	 */
	public function getFile($name)
	{
		if(isset($this->files[$name]) === false)
			return null;

		return $this->files[$name];
	}

	/**
	 * Returns a normalized array with file information where each entry of the array
	 * is a set of all information known about one file if the FILES field has an array markup
	 * like field_name[]
	 * @param string $name The name of the file field
	 * @return array Returns an array with the information about the files
	 */
	public function getFiles($name)
	{
		$filesArr = $this->getFile($name);

		$files = array();
		$filesCount = count($filesArr['name']);

		for($i = 0; $i < $filesCount; ++$i) {
			$file = array(
				'name' => $filesArr['name'][$i],
				'type' => $filesArr['type'][$i],
				'tmp_name' => $filesArr['tmp_name'][$i],
				'error' => $filesArr['error'][$i],
				'size' => $filesArr['size'][$i],
			);

			$files[] = $file;
		}

		return $files;
	}
}

/* EOF */