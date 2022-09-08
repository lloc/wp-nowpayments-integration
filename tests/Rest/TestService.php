<?php

namespace lloc\NowpaymentsIntegrationTests\Rest;

use lloc\NowpaymentsIntegration\Rest\Service;
use lloc\NowpaymentsIntegrationTests\LlocTestCase;
use Brain\Monkey\Functions;

class TestService extends LlocTestCase {

	public function test_add_query_arg() {
		$url      = 'https://example.org';
		$endpoint = 'test';

		$expected = $url . '/' . $endpoint;

		$service = new Service( $url );

		$this->assertEquals( $expected, $service->get( $endpoint ) );
	}
}