<?php

namespace lloc\NowpaymentsTests\Rest;

use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;
use Mockery;

class TestResponse extends LlocTestCase {

	public function test_get_response() {
		$response = new Response( [ 'body' => 'abc' ] );

		$this->assertEquals( 'abc', $response->get() );
		$this->assertFalse( $response->has_error() );
		$this->assertNull( $response->get_error() );
	}

	public function test_get_empty() {
		$response = new Response( [] );

		$this->assertEquals( '', $response->get() );
		$this->assertFalse( $response->has_error() );
		$this->assertNull( $response->get_error() );
	}

	public function test_get_error() {
		$error = Mockery::mock( '\WP_Error' );

		$response = new Response( $error );

		$this->assertEquals( '', $response->get() );
		$this->assertTrue( $response->has_error() );
		$this->assertInstanceOf( '\WP_Error', $response->get_error() );
	}

}