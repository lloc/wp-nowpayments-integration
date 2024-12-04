<?php

namespace lloc\NowpaymentsTests;

use lloc\Nowpayments\AdminWidget;
use lloc\Nowpayments\Integration\ApiStatus;
use lloc\Nowpayments\Integration\ApiStatusInterface;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Service;
use Brain\Monkey\Functions;

class TestAdminWidget extends LlocTestCase {

	public function test_render() {

		$service = \Mockery::mock( Service::class );
		$service->shouldReceive( 'info' )->once()->andReturn( 'abc' );

		$client = \Mockery::mock( Client::class );
		$client->shouldReceive( 'get_service' )->once()->andReturn( $service );

		$status = \Mockery::mock( ApiStatusInterface::class );
		$status->shouldReceive( 'get' )->once()->andReturn( array( 'message' => 'def' ) );
		$status->shouldReceive( 'get_client' )->once()->andReturn( $client );

		Functions\expect( 'wp_kses_post' )->once()->andReturnFirstArg();

		( new AdminWidget( $status ) )->render();

		$this->expectOutputString( '<div><strong>abc</strong> responds with "def".</div>' );
	}
}
