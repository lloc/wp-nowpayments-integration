<?php

namespace lloc\NowpaymentsTests\Rest;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\Nowpayments\Rest\Service;
use lloc\NowpaymentsTests\LlocTestCase;
use Mockery;

class TestClient extends LlocTestCase {

	protected $service;

	public function setUp(): void {
		parent::setUp();

		$this->service = Mockery::mock( Service::class );
		$this->service->shouldReceive( 'get' )->andReturn( 'https://example.org/test' );

		Functions\when( 'add_query_arg' )->justReturn( 'https://example.org/test?foo=bar' );
	}

	public function test_get_service() {
		$this->assertInstanceOf( Service::class, ( new Client( $this->service ) )->get_service() );
	}

	public function test_get_empty() {
		Functions\expect( 'wp_remote_get' )->once()->andReturn( [ 'body' => 'ok' ] );

		$this->assertInstanceOf( Response::class, ( new Client( $this->service ) )->get( 'test' ) );
	}

	public function test_get() {
		Functions\expect( 'wp_remote_get' )->once()->andReturn( [ 'body' => 'ok' ] );

		$this->assertInstanceOf( Response::class, ( new Client( $this->service ) )->get( 'test', [ 'abc' => 'def' ], [ 'ghi' => 'jkl' ] ) );
	}

	public function test_post_empty() {
		Functions\expect( 'wp_remote_post' )->once()->andReturn( [ 'body' => 'ok' ] );

		$this->assertInstanceOf( Response::class, ( new Client( $this->service ) )->post( 'test' ) );
	}

	public function test_post() {
		Functions\expect( 'wp_remote_post' )->once()->andReturn( [ 'body' => 'ok' ] );

		$this->assertInstanceOf( Response::class, ( new Client( $this->service ) )->post( 'test', [ 'abc' => 'def' ], [ 'ghi' => 'jkl' ] ) );
	}
}