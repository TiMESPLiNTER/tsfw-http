<?php

namespace timesplinter\tsfw\http;

/**
 * @author Pascal Muenst <dev@timesplinter.ch>
 * @copyright Copyright (c) 2014, TiMESPLiNTER Webdevelopment
 */
class Cookie {
	protected $name;
	protected $value;
	protected $expire;
	protected $path;
	protected $domain;
	protected $secure;
	protected $httpOnly;

	/**
	 * @param $name
	 * @param $value
	 * @param int $expire
	 * @param null $path
	 * @param null $domain
	 * @param bool $secure
	 * @param bool $httpOnly
	 */
	public function __construct($name, $value, $expire = 0, $path = null, $domain = null, $secure = false, $httpOnly = false)
	{
		$this->name = $name;
		$this->value = $value;
		$this->expire = $expire;
		$this->path = $path;
		$this->domain = $domain;
		$this->secure = $secure;
		$this->httpOnly = $httpOnly;
	}

	/**
	 * @param string|null $domain
	 */
	public function setDomain($domain)
	{
		$this->domain = $domain;
	}

	/**
	 * @return string|null
	 */
	public function getDomain()
	{
		return $this->domain;
	}

	/**
	 * @param int $expire
	 */
	public function setExpire($expire)
	{
		$this->expire = $expire;
	}

	/**
	 * @return int
	 */
	public function getExpire()
	{
		return $this->expire;
	}

	/**
	 * @param boolean $httpOnly
	 */
	public function setHttpOnly($httpOnly)
	{
		$this->httpOnly = $httpOnly;
	}

	/**
	 * @return boolean
	 */
	public function getHttpOnly()
	{
		return $this->httpOnly;
	}

	/**
	 * @param string $name
	 */
	public function setName($name)
	{
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string|null $path
	 */
	public function setPath($path)
	{
		$this->path = $path;
	}

	/**
	 * @return string|null
	 */
	public function getPath()
	{
		return $this->path;
	}

	/**
	 * @param boolean $secure
	 */
	public function setSecure($secure)
	{
		$this->secure = $secure;
	}

	/**
	 * @return boolean
	 */
	public function getSecure()
	{
		return $this->secure;
	}

	/**
	 * @param mixed $value The value of the cookie
	 */
	public function setValue($value)
	{
		$this->value = $value;
	}

	/**
	 * @return mixed The value of the cookie
	 */
	public function getValue()
	{
		return $this->value;
	}
}

/* EOF */