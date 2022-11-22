<?php

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\Payment;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;

class TestPayment extends LlocTestCase {

	protected $client;

	public const EXPECTED = [
		'payment_id' => '<your_payment_id>',
		'payment_status' => 'waiting',
		'pay_address' => '<your_pay_address>',
		'price_amount' => 3999.5,
		'price_currency' => 'usd',
		'pay_amount' => 0.8102725,
		'pay_currency' => 'btc',
		'order_id' => 'RGDBP-21314',
		'order_description' => 'Apple Macbook Pro 2019 x 1',
		'ipn_callback_url' => 'https://nowpayments.io',
		'created_at' => '2019-04-18T13:39:27.982Z',
		'updated_at' => '2019-04-18T13:39:27.982Z',
		'purchase_id' => '<your_purchase_id>'
	];

	/**
	 * Method demonstrates how Payment works
	 *
	 * @return void
	 */
	public function test_post(): void {
		Functions\expect( 'get_option' )->once()->andReturn( 'API_KEY_FROM SETTINGS' );

		$payment = ( new Payment( $this->client ) )->set(
			self::EXPECTED['price_amount'],
			self::EXPECTED['price_currency'],
			self::EXPECTED['pay_currency']
		);

		$this->assertEquals( self::EXPECTED, $payment->post() );
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
		$this->client->shouldReceive( 'post' )->andReturn( $response );
	}

	/**
	 * Endpoints are able to return their client
	 *
	 * @return void
	 */
	public function test_get_client(): void {
		$this->assertEquals( $this->client, ( new Payment( $this->client ) )->get_client() );
	}

	/**
	 * PaymentStatus does not have a get method
	 *
	 * @return void
	 */
	public function test_get(): void {
		$this->expectException( \BadMethodCallException::class );
		$this->assertNull( ( new Payment( $this->client ) )->get() );
	}

}