<?php

namespace lloc\NowpaymentsTests\Services;

use lloc\Nowpayments\Integration\ApiStatus;
use lloc\Nowpayments\Rest\Api;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\EndpointGetInterface;
use lloc\Nowpayments\Rest\ResponseInterface;
use lloc\Nowpayments\Services\ApiStatusService;
use lloc\NowpaymentsTests\LlocTestCase;

class TestApiStatusService extends LlocTestCase {

	public function test_get_data(): void {
		$service = \Mockery::mock( Api::class );
		$service->shouldReceive( 'info' )->once()->andReturn( 'Sandbox' );

		$client = \Mockery::mock( Client::class );
		$client->shouldReceive( 'get_service' )->once()->andReturn( $service );

		$response = \Mockery::mock( ResponseInterface::class );
		$response->shouldReceive( 'get' )->once()->andReturn( array( 'message' => 'OK' ) );

		$api_status = \Mockery::mock( ApiStatus::class );
		$api_status->shouldReceive( 'get' )->once()->andReturn( $response );
		$api_status->shouldReceive( 'get_client' )->once()->andReturn( $client );

		$expected = array(
			'status' => 'OK',
			'info'   => 'Sandbox',
		);

		$test = new ApiStatusService( $api_status );

		$this->assertEquals( $expected, $test->get_data() );
	}
}
