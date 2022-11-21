<?php

namespace lloc\NowpaymentsTests;

use lloc\Nowpayments\ApplicationLogs;
use Brain\Monkey\Functions;
use Monolog\Logger;

class TestApplicationLogs extends LlocTestCase {

	public function test_plugins_url(): void {
		$logger = \Mockery::mock( Logger::class );
		$logger->shouldReceive( 'debug' )->atLeast()->once();

		$obj = new ApplicationLogs( $logger );

		$this->assertEquals( [], $obj->pre_http_request( [], [ 'header' => 'HEADER_VAR' ], 'http://example.org' ) );
		$this->assertNull( $obj->pre_http_request( null, [ 'header' => 'HEADER_VAR' ], 'http://example.org' ) );
	}

}