<?php

namespace lloc\NowpaymentsTests\Rest;

use lloc\Nowpayments\Rest\Api;
use lloc\NowpaymentsTests\LlocTestCase;
use Brain\Monkey\Functions;

class TestService extends LlocTestCase {

	public function test_create_staging(): void {
		Functions\when( 'wp_get_environment_type' )->justReturn( 'staging' );
		Functions\expect( 'esc_url' )->once()->andReturnFirstArg();
		Functions\expect( '__' )->once()->andReturnFirstArg();

		$endpoint = 'test';
		$expected = Api::SANDBOX_SERVICE_URL . '/test';
		$service  = Api::create();

		$this->assertEquals( $expected, $service->get( $endpoint ) );
		$this->assertEquals( 'Sandbox', $service->info() );
	}

	public function test_create_production(): void {
		Functions\when( 'wp_get_environment_type' )->justReturn( 'production' );
		Functions\expect( 'esc_url' )->once()->andReturnFirstArg();
		Functions\expect( '__' )->once()->andReturnFirstArg();

		$endpoint = 'test';
		$expected = Api::PRODUCTION_SERVICE_URL . '/test';
		$service  = Api::create();

		$this->assertEquals( $expected, $service->get( $endpoint ) );
		$this->assertEquals( 'Production', $service->info() );
	}
}
