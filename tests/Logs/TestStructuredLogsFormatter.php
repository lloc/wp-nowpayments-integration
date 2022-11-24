<?php

namespace lloc\NowpaymentsTests\Logs;

use lloc\Nowpayments\Logs\StructuredLogsFormatter;
use lloc\NowpaymentsTests\LlocTestCase;
use Brain\Monkey\Functions;

class TestStructuredLogsFormatter extends LlocTestCase {

	public function test_format() {
		$site_id = 42;
		$user_id = 17;

		Functions\expect( 'site_url' )->once()->andReturn( $site_id );
		Functions\expect( 'get_current_user_id' )->once()->andReturn( $user_id );

		$obj = new StructuredLogsFormatter();

		$record = [ 'field' => 'some value' ];
		$expected = json_encode( array_merge( $record, [ 'site_url' => $site_id, 'user_id' => $user_id ] ) ) . PHP_EOL;

		$this->assertEquals( $expected, $obj->format( $record ) );
	}
}