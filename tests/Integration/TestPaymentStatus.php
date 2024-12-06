<?php declare( strict_types=1 );

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\PaymentStatus;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\ResponseInterface;
use lloc\NowpaymentsTests\LlocTestCase;

class TestPaymentStatus extends LlocTestCase {

	public function test_get(): void {
		$response = \Mockery::mock( ResponseInterface::class );

		$client = \Mockery::mock( Client::class );
		$client->shouldReceive( 'get' )->once()->andReturn( $response );

		Functions\expect( 'get_option' )->once()->andReturn( 'API_KEY_FROM SETTINGS' );

		$payment_status = ( new PaymentStatus( $client ) )->set( 'payment_id' );

		$this->assertEquals( $response, $payment_status->get() );
	}
}
