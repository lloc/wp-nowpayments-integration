<?php

namespace lloc\NowpaymentsTests\Rest;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\Nowpayments\Rest\Api;
use lloc\NowpaymentsTests\LlocTestCase;

class TestClient extends LlocTestCase {

	public function test_get_service(): void {
		$service = \Mockery::mock( Api::class );

		$this->assertInstanceOf( Api::class, ( new Client( $service ) )->get_service() );
	}

	public function test_get_empty(): void {
		$service = \Mockery::mock( Api::class );
		$service->shouldReceive( 'get' )->andReturn( 'https://example.org/test' );

		Functions\expect( 'add_query_arg' )->once()->andReturn( 'https://example.org/test?foo=bar' );
		Functions\expect( 'wp_remote_get' )->once()->andReturn( array( 'body' => 'ok' ) );

		$this->assertInstanceOf( Response::class, ( new Client( $service ) )->get( 'test' ) );
	}

	public function test_get(): void {
		$service = \Mockery::mock( Api::class );
		$service->shouldReceive( 'get' )->andReturn( 'https://example.org/test' );

		Functions\expect( 'add_query_arg' )->once()->andReturn( 'https://example.org/test?foo=bar' );
		Functions\expect( 'wp_remote_get' )->once()->andReturn( array( 'body' => 'ok' ) );

		$this->assertInstanceOf( Response::class, ( new Client( $service ) )->get( 'test', array( 'abc' => 'def' ), array( 'ghi' => 'jkl' ) ) );
	}

	public function test_post_empty(): void {
		$service = \Mockery::mock( Api::class );
		$service->shouldReceive( 'get' )->andReturn( 'https://example.org/test' );

		Functions\expect( 'wp_remote_post' )->once()->andReturn( array( 'body' => 'ok' ) );

		$this->assertInstanceOf( Response::class, ( new Client( $service ) )->post( 'test' ) );
	}

	public function test_post(): void {
		$service = \Mockery::mock( Api::class );
		$service->shouldReceive( 'get' )->andReturn( 'https://example.org/test' );

		Functions\expect( 'wp_remote_post' )->once()->andReturn( array( 'body' => 'ok' ) );

		$this->assertInstanceOf( Response::class, ( new Client( $service ) )->post( 'test', array( 'abc' => 'def' ), array( 'ghi' => 'jkl' ) ) );
	}
}
