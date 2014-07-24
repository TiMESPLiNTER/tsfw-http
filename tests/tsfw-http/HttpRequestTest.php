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
	
	public function testCreateEmptyHttpRequest() {
		$actualRequest = HttpRequest::create(array());
		
		$expectedRequest = new HttpRequest();
		$expectedRequest->setRequestTime($actualRequest->getRequestTime());
		
		$this->assertEquals($expectedRequest, $actualRequest, 'Create request without data');
	}
}

/* EOF */