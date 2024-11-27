<?php

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\MinimumPaymentAmount;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;

class TestMinimumPaymentAmount extends LlocTestCase {

	protected $client;

	public const EXPECTED = array(
		'currency_from' => 'eth',
		'currency_to'   => 'btc',
		'min_amount'    => 0.0098049,
	);

	/**
	 * Method demonstrates how MinimumPaymentAmount works
	 *
	 * @return void
	 */
	public function test_get() {
		Functions\expect( 'get_option' )->once()->andReturn( 'API_KEY_FROM SETTINGS' );

		$estimates = ( new MinimumPaymentAmount( $this->client ) )->set(
			self::EXPECTED['currency_from'],
			self::EXPECTED['currency_to']
		);
		$this->assertEquals( self::EXPECTED, $estimates->get() );
	}

	/**
	 * Test setup
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$response = \Mockery::mock( Response::class );
		$response->shouldReceive( 'get' )->andReturn( self::EXPECTED );

		$this->client = \Mockery::mock( Client::class );
		$this->client->shouldReceive( 'get' )->andReturn( $response );
	}

	/**
	 * Endpoints are able to return their client
	 *
	 * @return void
	 */
	public function test_get_client() {
		$this->assertEquals( $this->client, ( new MinimumPaymentAmount( $this->client ) )->get_client() );
	}

	/**
	 * MinimumPaymentAmount does not have a post method
	 *
	 * @return void
	 */
	public function test_post(): void {
		$this->expectException( \BadMethodCallException::class );
		$this->assertNull( ( new MinimumPaymentAmount( $this->client ) )->post() );
	}
}
