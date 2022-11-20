<?php

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\PaymentStatus;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;

class TestPaymentStatus extends LlocTestCase {

	protected $client;

	const EXPECTED = [
		'payment_id'       => '123456789',
		'payment_status'   => 'waiting',
		'pay_address'      => '<your_payment_address>',
		'price_amount'     => 3999.5,
		'price_currency'   => 'usd',
		'pay_amount'       => 0.8102725,
		'actually_paid'    => 0,
		'pay_currency'     => 'btc',
		'created_at'       => '2019-04-18T13:39:27.982Z',
		'updated_at'       => '2019-04-18T13:40:16.512Z',
		'purchase_id'      => '<your_purchase_id',
		'outcome_currency' => 'eth',
		'outcome_amount'   => 31.28
	];

	/**
	 * Method demonstrates how PaymentStatus works
	 *
	 * @return void
	 */
	public function test_get(): void {
		Functions\expect( 'get_option' )->once()->andReturn( 'API_KEY_FROM SETTINGS' );

		$payment_status = ( new PaymentStatus( $this->client ) )->set( self::EXPECTED['payment_id'] );
		$this->assertEquals( self::EXPECTED, $payment_status->get() );
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