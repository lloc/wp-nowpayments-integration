<?php

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\AvailableCurrencies;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;

class TestAvailableCurrencies extends LlocTestCase {

	protected $client;

	public const EXPECTED = [ 'currencies' => [ 'ada', 'btc', 'eur' ] ];

	/**
	 * Method demonstrates how AvailableCurrencies works
	 *
	 * @return void
	 */
	public function test_get(): void {
		Functions\expect( 'wp_cache_get' )->once()->andReturn( false );
		Functions\expect( 'get_option' )->once()->andReturn( 'API_KEY_FROM SETTINGS' );
		Functions\expect( 'wp_cache_set' )->once();

		$this->assertEquals( self::EXPECTED, ( new AvailableCurrencies( $this->client ) )->get() );
	}

	/**
	 * The is_available method looks a currency in the cached result-set up
	 *
	 * @return void
	 */
	public function test_is_available(): void {
		Functions\expect( 'wp_cache_get' )->atLeast()->once()->andReturn( self::EXPECTED );

		$this->assertFalse( ( new AvailableCurrencies( $this->client ) )->is_available( 'bch' ) );
		$this->assertTrue( ( new AvailableCurrencies( $this->client ) )->is_available( 'ada' ) );
		$this->assertTrue( ( new AvailableCurrencies( $this->client ) )->is_available( 'btc' ) );
		$this->assertTrue( ( new AvailableCurrencies( $this->client ) )->is_available( 'eur' ) );
	}

	/**
	 * Test Setup
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
		$this->assertEquals( $this->client, ( new AvailableCurrencies( $this->client ) )->get_client() );
	}

	/**
	 * AvailableCurrencies does not implement a post method
	 *
	 * @return void
	 */
	public function test_post(): void {
		$this->expectException( \BadMethodCallException::class );
		$this->assertNull( ( new AvailableCurrencies( $this->client ) )->post() );
	}

}