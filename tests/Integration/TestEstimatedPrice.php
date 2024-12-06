<?php declare( strict_types=1 );

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\EstimatedPrice;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\ResponseInterface;
use lloc\NowpaymentsTests\LlocTestCase;

class TestEstimatedPrice extends LlocTestCase {

	public function test_get(): void {
		$response = \Mockery::mock( ResponseInterface::class );

		$client = \Mockery::mock( Client::class );
		$client->shouldReceive( 'get' )->once()->andReturn( $response );

		Functions\expect( 'get_option' )->once()->andReturn( 'API_KEY_FROM SETTINGS' );

		$estimates = ( new EstimatedPrice( $client ) )->set( 3999.5, 'usd', 'btc' );

		$this->assertEquals( $response, $estimates->get() );
	}
}
