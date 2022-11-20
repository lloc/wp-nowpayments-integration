<?php

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\EstimatedPrice;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;

class TestEstimatedPrice extends LlocTestCase {

	protected $client;

	const EXPECTED = [
		'currency_from'    => 'usd',
		'amount_from'      => 3999.5,
		'currency_to'      => 'btc',
		'estimated_amount' => 0.7566495,
	];

	public function test_get(): void {
		Functions\expect( 'get_option' )->once()->andReturn( 'abc' );

		$estimates = ( new EstimatedPrice( $this->client ) )->set( '3999.5000', 'usd', 'btc' );
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
	public function test_get_client(): void {
		$this->assertEquals( $this->client, ( new EstimatedPrice( $this->client ) )->get_client() );
	}

	/**
	 * EstimatedPrice does not have a post method
	 *
	 * @return void
	 */
	public function test_post(): void {
		$this->expectException( \BadMethodCallException::class );
		$this->assertNull( ( new EstimatedPrice( $this->client ) )->post() );
	}


}