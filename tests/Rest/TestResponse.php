<?php

namespace lloc\NowpaymentsTests\Rest;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;

class TestResponse extends LlocTestCase {

	public function test_get_response() {
		$response = new Response( [ 'body' => '{ "message": "abc" }' ] );

		$this->assertEquals( [ 'message' => 'abc' ], $response->get() );
	}

	public function test_get_empty() {
		Functions\expect( '__' )->andReturnFirstArg();

		$response = new Response( [] );

		$this->assertEquals( [ 'message' => 'Object has no body property!' ], $response->get() );
	}

}