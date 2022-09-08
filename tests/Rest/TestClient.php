<?php

namespace lloc\NowpaymentsIntegrationTests\Rest;

use Brain\Monkey\Functions;
use lloc\NowpaymentsIntegration\Rest\Client;
use lloc\NowpaymentsIntegration\Rest\Response;
use lloc\NowpaymentsIntegration\Rest\Service;
use lloc\NowpaymentsIntegrationTests\LlocTestCase;

class TestClient extends LlocTestCase {

	protected $service;

	public function setUp(): void {
		parent::setUp();

		$this->service = \Mockery::mock( Service::class );
		$this->service->shouldReceive( 'get' )->andReturn( 'https://example.org/test' );

		Functions\when( 'add_query_arg' )->justReturn( 'https://example.org/test?foo=bar' );
	}

	public function test_get() {
		Functions\expect( 'wp_remote_get' )->once()->andReturn( [ 'body' => 'ok' ] );

		$this->assertInstanceOf( Response::class, ( new Client( $this->service ) )->get( 'test' ) );
	}

	public function test_post() {
		Functions\expect( 'wp_remote_post' )->once()->andReturn( [ 'body' => 'ok' ] );

		$this->assertInstanceOf( Response::class, ( new Client( $this->service ) )->post( 'test' ) );
	}
}