<?php

namespace lloc\NowpaymentsTests\Rest;

use lloc\Nowpayments\Rest\Error;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;
use Mockery;

class TestError extends LlocTestCase {

	public function test_get() {
		$error = Mockery::mock( '\WP_Error' );
		$error->shouldReceive( 'get_error_message' )->once()->andReturn( 'abc' );

		$response = new Error( $error );

		$this->assertEquals( [ 'message' => 'abc' ], $response->get() );
	}

}