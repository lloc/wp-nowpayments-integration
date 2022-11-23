<?php

namespace lloc\NowpaymentsTests\Logs;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Logs\ApplicationLogs;
use lloc\NowpaymentsTests\LlocTestCase;
use Monolog\Logger;

class TestApplicationLogs extends LlocTestCase {


	public function test_debug() {
		$logger = \Mockery::mock( Logger::class );
		$logger->shouldReceive( 'log' )->twice();

		$error = \Mockery::mock( \WP_Error::class );
		$error->shouldReceive( 'get_error_message' )->andReturn( 'Yeah, this is a meaningful error-message!' );

		$obj = new ApplicationLogs( $logger );

		$parsed_args = [ 'random' => 'stuff' ];

		/**
		 * This message will be logged as debug
		 */
		$obj->http_api_debug( [], 'Test', __CLASS__, $parsed_args, 'https://example.org/wp-json/some-endpoint' );

		/**
		 * This message should be logged as notice
		 */
		$obj->http_api_debug( $error, 'Test', __CLASS__, $parsed_args, 'https://example.com/wp-json/some-endpoint' );

		/**
		 * This is for suppress the risky tests complain
		 */
		$this->expectOutputString( '' );
	}
}
