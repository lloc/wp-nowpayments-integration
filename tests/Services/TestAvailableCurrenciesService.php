<?php

namespace lloc\NowpaymentsTests\Services;

use lloc\Nowpayments\Integration\AvailableCurrencies;
use lloc\Nowpayments\Rest\ResponseInterface;
use lloc\Nowpayments\Services\AvailableCurrenciesService;
use lloc\NowpaymentsTests\LlocTestCase;
use Brain\Monkey\Functions;

class TestAvailableCurrenciesService extends LlocTestCase {

	private AvailableCurrenciesService $test;

	const RESULT = array( 'currencies' => array( 'BTC', 'ETH' ) );

	protected function setUp(): void {
		parent::setUp();

		$response = \Mockery::mock( ResponseInterface::class );
		$response->shouldReceive( 'get' )->atLeast()->once()->andReturn( self::RESULT );

		$available_currencies = \Mockery::mock( AvailableCurrencies::class );
		$available_currencies->shouldReceive( 'get' )->atLeast()->once()->andReturn( $response );

		Functions\expect( 'wp_cache_get' )->atLeast()->once()->andReturn( false );
		Functions\expect( 'wp_cache_set' )->atLeast()->once();

		$this->test = new AvailableCurrenciesService( $available_currencies );
	}

	public function test_get_data() {
		$this->assertEquals( self::RESULT['currencies'], $this->test->get_data() );
	}

	public function test_is_available(): void {
		$this->assertTrue( $this->test->is_available( 'BTC' ) );
		$this->assertTrue( $this->test->is_available( 'ETH' ) );
		$this->assertFalse( $this->test->is_available( 'LTC' ) );
	}
}
