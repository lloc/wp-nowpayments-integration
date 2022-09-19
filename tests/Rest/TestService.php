<?php

namespace lloc\NowpaymentsTests\Rest;

use lloc\Nowpayments\Rest\Service;
use lloc\NowpaymentsTests\LlocTestCase;
use Brain\Monkey\Functions;

class TestService extends LlocTestCase {

	public function test_create_staging() {
		Functions\when( 'wp_get_environment_type' )->justReturn( 'staging' );
		Functions\expect( '__' )->once()->andReturnFirstArg();

		$endpoint = 'test';
		$expected = Service::SANDBOX_SERVICE_URL . '/test';
		$service  = Service::create();

		$this->assertEquals( $expected, $service->get( $endpoint ) );
		$this->assertEquals( 'Sandbox', $service->info() );
	}

	public function test_create_production() {
		Functions\when( 'wp_get_environment_type' )->justReturn( 'production' );
		Functions\expect( '__' )->once()->andReturnFirstArg();

		$endpoint = 'test';
		$expected = Service::PRODUCTION_SERVICE_URL . '/test';
		$service  = Service::create();

		$this->assertEquals( $expected, $service->get( $endpoint ) );
		$this->assertEquals( 'Production', $service->info() );
	}

}