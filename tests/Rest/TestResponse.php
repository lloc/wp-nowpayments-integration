<?php

namespace lloc\NowpaymentsTests\Rest;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;

class TestResponse extends LlocTestCase {

	public function test_get_response(): void {
		$response = new Response( array( 'body' => '{ "message": "abc" }' ) );

		$this->assertEquals( array( 'message' => 'abc' ), $response->get() );
	}

	public function test_get_empty(): void {
		Functions\expect( '__' )->once()->andReturnFirstArg();

		$response = new Response( array() );

		$this->assertEquals( array( 'message' => 'Object has no body property!' ), $response->get() );
	}
}
