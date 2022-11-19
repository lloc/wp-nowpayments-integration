<?php

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\AvailableCurrencies;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;
use Mockery;

class TestAvailableCurrencies extends LlocTestCase {

	protected $client;

	public function setUp(): void {
		parent::setUp();

		$response = Mockery::mock( Response::class );
		$response->shouldReceive( 'get' )->andReturn( [] );

		$this->client = Mockery::mock( Client::class );
		$this->client->shouldReceive( 'get' )->andReturn( $response );
	}

	public function test_get(): void {
		Functions\expect( 'get_option' )->once()->andReturn( 'abc' );
		Functions\expect( 'wp_cache_set' )->once();

		$this->assertEquals( [], ( new AvailableCurrencies( $this->client ) )->get() );
	}

	public function test_is_valid(): void {
		Functions\expect( 'wp_cache_get' )->twice()->andReturn( [ 'currencies' => [ 'ada' ] ] );

		$this->assertFalse( ( new AvailableCurrencies( $this->client ) )->is_available( 'btc' ) );
		$this->assertTrue( ( new AvailableCurrencies( $this->client ) )->is_available( 'ada' ) );
	}

	public function test_get_client(): void {
		$this->assertEquals( $this->client, ( new AvailableCurrencies( $this->client ) )->get_client() );
	}

	public function test_post(): void {
		$this->expectException( \BadMethodCallException::class );
		$this->assertNull( ( new AvailableCurrencies( $this->client ) )->post() );
	}

}