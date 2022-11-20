<?php

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\PaymentStatus;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;
use Mockery;

class TestPaymentStatus extends LlocTestCase {

	protected $client;

	/**
	 * Method demonstrates how PaymentStatus works
	 *
	 * @return void
	 */
	public function test_get(): void {
		Functions\expect( 'get_option' )->once()->andReturn( 'abc' );

		$payment_status = ( new PaymentStatus( $this->client ) )->set( '123456789' );
		$this->assertEquals( [], $payment_status->get() );
	}

	/**
	 * Test setup
	 *
	 * @return void
	 */
	public function setUp(): void {
		parent::setUp();

		$response = Mockery::mock( Response::class );
		$response->shouldReceive( 'get' )->andReturn( [] );

		$this->client = Mockery::mock( Client::class );
		$this->client->shouldReceive( 'get' )->andReturn( $response );
	}

	/**
	 * Endpoints are able to return their client
	 *
	 * @return void
	 */
	public function test_get_client(): void {
		$this->assertEquals( $this->client, ( new PaymentStatus( $this->client ) )->get_client() );
	}

	/**
	 * PaymentStatus does not have a post method
	 *
	 * @return void
	 */
	public function test_post(): void {
		$this->expectException( \BadMethodCallException::class );
		$this->assertNull( ( new PaymentStatus( $this->client ) )->post() );
	}

}