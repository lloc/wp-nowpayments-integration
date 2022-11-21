<?php

namespace lloc\NowpaymentsTests;

use lloc\Nowpayments\ApplicationLogs;
use Brain\Monkey\Functions;
use lloc\Nowpayments\Rest\Service;
use Monolog\Logger;

class TestApplicationLogs extends LlocTestCase {

	public function test_plugins_url(): void {
		Functions\when( 'wp_get_environment_type' )->justReturn( 'production' );

		$logger = \Mockery::mock( Logger::class );
		$logger->shouldReceive( 'debug' )->once();

		$obj = new ApplicationLogs( $logger );

		$this->assertEquals( [], $obj->pre_http_request( [], [ 'header' => 'HEADER_VAR' ], Service::PRODUCTION_SERVICE_URL ) );
		$this->assertEquals( [], $obj->pre_http_request( [], [ 'header' => 'HEADER_VAR' ], 'http://example.org' ) );
		$this->assertNull( $obj->pre_http_request( null, [ 'header' => 'HEADER_VAR' ], 'http://example.org' ) );
	}

}