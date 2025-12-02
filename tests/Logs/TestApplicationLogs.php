<?php declare( strict_types=1 );

namespace lloc\NowpaymentsTests\Logs;

use Brain\Monkey\Actions;
use Brain\Monkey\Functions;
use lloc\Nowpayments\Logs\ApplicationLogs;
use lloc\NowpaymentsTests\LlocTestCase;
use Monolog\Logger;

class TestApplicationLogs extends LlocTestCase {

	public function test_init(): void {
		Actions\expectAdded( 'http_api_debug' );
		Functions\expect( 'esc_url' )->once()->andReturnFirstArg();

		$logger = \Mockery::mock( Logger::class );
		$logger->shouldReceive( 'log' )->twice();

		$error = \Mockery::mock( \WP_Error::class );
		$error->shouldReceive( 'get_error_message' )->once()->andReturn( 'Yeah, this is a meaningful error-message!' );

		$obj = ApplicationLogs::init( $logger );

		$parsed_args = array( 'random' => 'stuff' );

		/**
		 * This message will be logged as debug
		 */
		$obj->http_api_debug( array(), 'Test', __CLASS__, $parsed_args, 'https://example.org/wp-json/some-endpoint' );

		/**
		 * This message should be logged as notice
		 */
		$obj->http_api_debug( $error, 'Test', __CLASS__, $parsed_args, 'https://example.com/wp-json/some-endpoint' );

		$this->expectNotToPerformAssertions();
	}
}
