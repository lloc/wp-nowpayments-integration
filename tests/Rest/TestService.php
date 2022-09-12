<?php

namespace lloc\NowpaymentsTests\Rest;

use lloc\Nowpayments\Rest\Service;
use lloc\NowpaymentsTests\LlocTestCase;
use Brain\Monkey\Functions;

class TestService extends LlocTestCase {

	public function test_add_query_arg() {
		$url      = 'https://example.org';
		$endpoint = 'test';
		$expected = $url . '/' . $endpoint;
		$service  = new Service( $url );

		$this->assertEquals( $expected, $service->get( $endpoint ) );
	}

	public function test_create_staging() {
		Functions\when( 'wp_get_environment_type' )->justReturn( 'staging' );

		$endpoint = 'test';
		$expected = 'https://api-sandbox.nowpayments.io/test';
		$service  = Service::create();

		$this->assertEquals( $expected, $service->get( $endpoint ) );
	}

	public function test_create_production() {
		Functions\when( 'wp_get_environment_type' )->justReturn( 'production' );

		$endpoint = 'test';
		$expected = 'https://api.nowpayments.io/test';
		$service  = Service::create();

		$this->assertEquals( $expected, $service->get( $endpoint ) );
	}

}