<?php

namespace lloc\NowpaymentsIntegrationTests;

use PHPUnit\Framework\TestCase;
use Brain\Monkey;

class LlocTestCase extends TestCase {

	protected function setUp(): void {
		parent::setUp();
		Monkey\setUp();
	}

	protected function tearDown(): void {
		Monkey\tearDown();
		parent::tearDown();
	}

}
