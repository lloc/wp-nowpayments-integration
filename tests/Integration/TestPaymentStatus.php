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

	public function setUp(): void {
		parent::setUp();

		$response = Mockery::mock( Response::class );
		$response->shouldReceive( 'get' )->andReturn( [] );

		$this->client = Mockery::mock( Client::class );
		$this->client->shouldReceive( 'get' )->andReturn( $response );
	}

	public function test_get_client() {
		$this->assertEquals( $this->client, ( new PaymentStatus( $this->client ) )->get_client() );
	}

	public function test_get() {
		Functions\expect( 'get_option' )->once()->andReturn( 'abc' );

		$payment_status = ( new PaymentStatus( $this->client ) )->set( '123456789' );
		$this->assertEquals( [], $payment_status->get() );
	}


	public function test_post() {
		$this->expectException( \BadMethodCallException::class );
		$this->assertNull( ( new PaymentStatus( $this->client ) )->post() );
	}

}