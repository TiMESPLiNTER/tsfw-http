<?php

namespace timesplinter\tsfw\http\tests;

use timesplinter\tsfw\http\HttpRequest;

/**
 * @author Pascal Muenst <dev@timesplinter.ch>
 * @copyright Copyright (c) 2014, TiMESPLiNTER Webdevelopment
 */
class HttpRequestTest extends \PHPUnit_Framework_TestCase {
	public function testCurrentRequest()
	{
		$this->assertEquals(null, HttpRequest::currentRequest(), 'Current request (should be NULL on CLI)');
	}
	
	public function testCreateEmptyHttpRequest()
	{
		$actualRequest = HttpRequest::create(array());
		
		$expectedRequest = new HttpRequest();
		$expectedRequest->setRequestTime($actualRequest->getRequestTime());
		
		$this->assertEquals($expectedRequest, $actualRequest, 'Create request without data');
	}
	
	public function testBasePath()
	{
		HttpRequest::setBasePath('/foo/bar.php');

		$request = HttpRequest::create(array(
			'REQUEST_URI' => '/foo/bar.php/test/path?foo=bar'
		));
		
		$this->assertEquals('/test/path?foo=bar', $request->getURI(), 'Automatic URI rebase');
		$this->assertEquals('/test/path', $request->getPath(), 'Automatic path rebase');
	}
}

/* EOF */