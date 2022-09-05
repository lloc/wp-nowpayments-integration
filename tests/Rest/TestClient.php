<?php

namespace lloc\NowpaymentsIntegrationTests\Rest;

use Brain\Monkey\Functions;
use lloc\NowpaymentsIntegration\Rest\Client;
use lloc\NowpaymentsIntegration\Rest\Response;
use lloc\NowpaymentsIntegration\Rest\Service;
use lloc\NowpaymentsIntegrationTests\LlocTestCase;

class TestClient extends LlocTestCase {

	public function get_service() {
		$service = \Mockery::mock( Service::class );
		$service->shouldReceive( 'add_query_arg' )->andReturn( 'ok' );

		return $service;
	}

	public function test_get() {
		Functions\when( 'wp_remote_get' )->justReturn( [ 'body' => 'ok' ] );

		$client = new Client( $this->get_service() );

		$this->assertInstanceOf( Response::class, $client->get( 'test' ) );
	}

	public function test_post() {
		Functions\when( 'wp_remote_post' )->justReturn( [ 'body' => 'ok' ] );

		$client = new Client( $this->get_service() );

		$this->assertInstanceOf( Response::class, $client->post( 'test' ) );
	}
}