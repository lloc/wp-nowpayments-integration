<?php

namespace lloc\NowpaymentsTests\Integration;

use lloc\Nowpayments\Integration\ApiStatus;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;

class TestApiStatus extends LlocTestCase {

	protected $client;

	const EXPECTED = [ 'message' => 'ok' ];

	/**
	 * Method demonstrates how ApiStatus works
	 *
	 * @return void
	 */
	public function test_get(): void {
		$this->assertEquals( self::EXPECTED, ( new ApiStatus( $this->client ) )->get() );
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
		$this->client->shouldReceive( 'get' )->andReturn( $response );
	}

	/**
	 * Endpoints are able to return their client
	 *
	 * @return void
	 */
	public function test_get_client(): void {
		$this->assertEquals( $this->client, ( new ApiStatus( $this->client ) )->get_client() );
	}

	/**
	 * ApiStatus does not have a post method
	 *
	 * @return void
	 */
	public function test_post(): void {
		$this->expectException( \BadMethodCallException::class );
		$this->assertNull( ( new ApiStatus( $this->client ) )->post() );
	}

}