<?php

namespace lloc\NowpaymentsIntegrationTests\Rest;

use lloc\NowpaymentsIntegration\Rest\Service;
use lloc\NowpaymentsIntegrationTests\LlocTestCase;
use Brain\Monkey\Functions;

class TestService extends LlocTestCase {

	public function test_add_query_arg() {
		$url      = 'https://example.org';
		$endpoint = 'test';
		$args     = [ 'foo' => 'bar' ];
		$expected = $url . '/' . $endpoint . '?' . implode( '=', $args );

		Functions\when( 'add_query_arg' )->justReturn( $expected );

		$service = new Service( $url );

		$this->assertEquals( $expected, $service->add_query_arg( $args, $endpoint ) );
	}
}