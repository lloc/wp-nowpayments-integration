<?php

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\AvailableCurrencies;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;

class TestAvailableCurrencies extends LlocTestCase {

	protected $client;

	public const EXPECTED = array( 'currencies' => array( 'ada', 'btc', 'eur' ) );

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
	 * Data provider for is_available method
	 *
	 * @return array<int, array<int, string|bool>>
	 */
	public static function provide_data_for_is_available(): array {
		return array(
			array( 'bch', false ),
			array( 'ada', true ),
			array( 'btc', true ),
			array( 'eur', true ),
		);
	}
	/**
	 * The is_available method looks a currency in the cached result-set up
	 *
	 * @dataProvider provide_data_for_is_available
	 */
	public function test_is_available( string $currency, bool $expected ): void {
		Functions\expect( 'wp_cache_get' )->atLeast()->once()->andReturn( self::EXPECTED );

		$this->assertEquals( $expected, ( new AvailableCurrencies( $this->client ) )->is_available( $currency ) );
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
