<?php declare( strict_types=1 );

namespace lloc\NowpaymentsTests\Integration;

use lloc\Nowpayments\Integration\ApiStatus;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\ResponseInterface;
use lloc\NowpaymentsTests\LlocTestCase;

class TestApiStatus extends LlocTestCase {

	public function test_get(): void {
		$response = \Mockery::mock( ResponseInterface::class );

		$client = \Mockery::mock( Client::class );
		$client->shouldReceive( 'get' )->once()->andReturn( $response );

		$this->assertEquals( $response, ( new ApiStatus( $client ) )->get() );
	}

	public function test_get_client(): void {
		$client = \Mockery::mock( Client::class );

		$this->assertEquals( $client, ( new ApiStatus( $client ) )->get_client() );
	}
}
