<?php

namespace lloc\NowpaymentsTests\Integration;

use lloc\Nowpayments\Integration\ApiStatus;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;
use Mockery;

class TestApiStatus extends LlocTestCase {

	protected $client;

	public function setUp(): void {
		parent::setUp();

		$response = Mockery::mock( Response::class );
		$response->shouldReceive( 'get' )->andReturn( [] );

		$this->client = Mockery::mock( Client::class );
		$this->client->shouldReceive( 'get' )->andReturn( $response );
	}

	public function test_get_client() {
		$this->assertEquals( $this->client, ( new ApiStatus( $this->client ) )->get_client() );
	}

	public function test_get() {
		$this->assertEquals( [], ( new ApiStatus( $this->client ) )->get() );
	}

	public function test_post() {
		$this->expectException( \BadMethodCallException::class );
		$this->assertNull( ( new ApiStatus( $this->client ) )->post() );
	}

}