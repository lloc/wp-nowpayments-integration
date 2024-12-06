<?php

namespace lloc\NowpaymentsTests\Logs;

use lloc\Nowpayments\Logs\StructuredLogsFormatter;
use lloc\NowpaymentsTests\LlocTestCase;
use Brain\Monkey\Functions;
use Monolog\Level;
use Monolog\LogRecord;

class TestStructuredLogsFormatter extends LlocTestCase {

	public function testFormat(): void {
		$site_id = 42;
		$user_id = 17;

		Functions\expect( 'site_url' )->once()->andReturn( $site_id );
		Functions\expect( 'get_current_user_id' )->once()->andReturn( $user_id );

		$obj = new StructuredLogsFormatter();

		$record = new LogRecord(
			new \DateTimeImmutable( '2024-11-27 11:47:41' ),
			'channel',
			Level::Debug,
			'message'
		);

		$expected = '{"message":"message","context":{},"level":100,"level_name":"DEBUG","channel":"channel","datetime":"2024-11-27T11:47:41+00:00","extra":{"site_url":42,"user_id":17}}' . PHP_EOL;

		$this->assertEquals( $expected, $obj->format( $record ) );
	}
}
