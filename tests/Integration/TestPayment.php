<?php declare( strict_types=1 );

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\Payment;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\ResponseInterface;
use lloc\NowpaymentsTests\LlocTestCase;

class TestPayment extends LlocTestCase {

	public const ADDITIONAL_PARAMETERS = array(
		'payment_id'        => '<your_payment_id>',
		'payment_status'    => 'waiting',
		'pay_address'       => '<your_pay_address>',
		'pay_amount'        => 0.8102725,
		'order_id'          => 'RGDBP-21314',
		'order_description' => 'Apple Macbook Pro 2019 x 1',
		'ipn_callback_url'  => 'https://nowpayments.io',
		'created_at'        => '2019-04-18T13:39:27.982Z',
		'updated_at'        => '2019-04-18T13:39:27.982Z',
		'purchase_id'       => '<your_purchase_id>',
	);

	public function test_post(): void {
		$response = \Mockery::mock( ResponseInterface::class );

		$client = \Mockery::mock( Client::class );
		$client->shouldReceive( 'post' )->once()->andReturn( $response );

		Functions\expect( 'get_option' )->once()->andReturn( 'API_KEY_FROM SETTINGS' );

		$payment = ( new Payment( $client ) )->set(
			3999.5,
			'usd',
			'btc',
			self::ADDITIONAL_PARAMETERS
		);

		$this->assertEquals( $response, $payment->post() );
	}
}
