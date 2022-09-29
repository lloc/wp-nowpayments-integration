<?php

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\Currencies;
use lloc\Nowpayments\Integration\Estimate;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Response;
use lloc\NowpaymentsTests\LlocTestCase;
use Mockery;

class TestEstimate extends LlocTestCase {

	public function test_get_client() {
		$client = Mockery::mock( Client::class );

		$this->assertEquals( $client, ( new Estimate( $client ) )->get_client() );
	}

	public function test_request() {
		Functions\expect( 'get_option' )->once()->andReturn( 'abc' );

		$response = Mockery::mock( Response::class );
		$response->shouldReceive( 'get' )->andReturn( [] );

		$client   = Mockery::mock( Client::class );
		$client->shouldReceive( 'get' )->andReturn( $response );

		$estimates = ( new Estimate( $client ) )->set( '3999.5000', 'usd', 'btc' );
		$this->assertEquals( [], $estimates->request() );
	}

}