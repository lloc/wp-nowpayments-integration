<?php

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\Estimate;
use lloc\Nowpayments\Integration\PaymentStatus;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;
use Mockery;

class TestPaymentStatus extends LlocTestCase {

	public function test_get_client() {
		$client = Mockery::mock( Client::class );

		$this->assertEquals( $client, ( new PaymentStatus( $client ) )->get_client() );
	}

	public function test_request() {
		Functions\expect( 'get_option' )->once()->andReturn( 'abc' );

		$response = Mockery::mock( Response::class );
		$response->shouldReceive( 'get' )->andReturn( [] );

		$client   = Mockery::mock( Client::class );
		$client->shouldReceive( 'get' )->andReturn( $response );

		$payment_status = ( new PaymentStatus( $client ) )->set( '123456789' );
		$this->assertEquals( [], $payment_status->request() );
	}

}