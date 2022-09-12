<?php

namespace lloc\NowpaymentsTests\Integration;

use lloc\Nowpayments\Integration\Status;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;
use Mockery;

class TestStatus extends LlocTestCase {

	public function test_request() {
		$response = Mockery::mock( Response::class );

		$client   = Mockery::mock( Client::class );
		$client->shouldReceive( 'get' )->andReturn( $response );

		$this->assertInstanceOf( Response::class, ( new Status( $client ) )->request() );
	}

}