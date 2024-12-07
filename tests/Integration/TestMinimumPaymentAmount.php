<?php declare( strict_types=1 );

namespace lloc\NowpaymentsTests\Integration;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Integration\MinimumPaymentAmount;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\ResponseInterface;
use lloc\NowpaymentsTests\LlocTestCase;

class TestMinimumPaymentAmount extends LlocTestCase {

	public const EXPECTED = array(
		'currency_from' => 'eth',
		'currency_to'   => 'btc',
		'min_amount'    => 0.0098049,
	);

	public function test_get(): void {
		$response = \Mockery::mock( ResponseInterface::class );

		$client = \Mockery::mock( Client::class );
		$client->shouldReceive( 'get' )->once()->andReturn( $response );

		Functions\expect( 'get_option' )->once()->andReturn( 'API_KEY_FROM SETTINGS' );

		$estimates = ( new MinimumPaymentAmount( $client ) )->set( 'eth', 'btc' );

		$this->assertEquals( $response, $estimates->get() );
	}
}
