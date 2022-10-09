<?php

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\Payment;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;
use Mockery;

class TestPayment extends LlocTestCase {

	protected $client;

	public function setUp(): void {
		parent::setUp();

		$response = Mockery::mock( Response::class );
		$response->shouldReceive( 'get' )->andReturn( [] );

		$this->client = Mockery::mock( Client::class );
		$this->client->shouldReceive( 'get' )->andReturn( $response );
	}

	public function test_get_client() {
		$this->assertEquals( $this->client, ( new Payment( $this->client ) )->get_client() );
	}

	public function test_get() {
		Functions\expect( 'get_option' )->once()->andReturn( 'abc' );

		$payment_status = ( new Payment( $this->client ) )->set( [ 'payment_id' => '123456789' ] );
		$this->assertEquals( [], $payment_status->get() );
	}

	public function test_list() {
		Functions\expect( 'get_option' )->once()->andReturn( 'abc' );

		$args           = [
			'limit'    => 10,
			'page'     => 0,
			'sortBy'   => 'created_at',
			'orderBy'  => 'asc',
			'dateFrom' => '2020-10-01',
			'dateTo'   => '2022-10-31',
		];
		$payment_status = ( new Payment( $this->client ) )->set( $args );
		$this->assertEquals( [], $payment_status->list() );
	}

	public function test_post() {
		$this->expectException( \BadMethodCallException::class );
		$this->assertNull( ( new Payment( $this->client ) )->post() );
	}

}