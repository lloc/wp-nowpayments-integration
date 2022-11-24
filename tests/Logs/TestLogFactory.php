<?php

namespace lloc\NowpaymentsTests\Logs;

use lloc\Nowpayments\Logs\LogFactory;
use lloc\NowpaymentsTests\LlocTestCase;
use Monolog\Logger;

class TestLogFactory extends LlocTestCase {

	public function test_get_logger() {
		$this->assertInstanceOf( Logger::class, LogFactory::get_logger() );
	}
}