<?php

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\Currencies;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;
use Mockery;

class TestCurrencies extends LlocTestCase {

	protected $client;

	public function setUp(): void {
		parent::setUp();

		$response = Mockery::mock( Response::class );
		$response->shouldReceive( 'get' )->andReturn( [] );

		$this->client = Mockery::mock( Client::class );
		$this->client->shouldReceive( 'get' )->andReturn( $response );
	}

	public function test_get_client() {
		$this->assertEquals( $this->client, ( new Currencies( $this->client ) )->get_client() );
	}

	public function test_get() {
		Functions\expect( 'get_option' )->once()->andReturn( 'abc' );

		$this->assertEquals( [], ( new Currencies( $this->client ) )->get() );
	}

	public function test_post() {
		$this->expectException( \BadMethodCallException::class );
		$this->assertNull( ( new Currencies( $this->client ) )->post() );
	}

}