<?php

namespace lloc\NowpaymentsTests;

use lloc\Nowpayments\Plugin;
use Brain\Monkey\Functions;

class TestPlugin extends LlocTestCase {

	public function test_add_hooks() {
		( new Plugin() )->add_hooks();

		$this->assertEquals( 10, has_action( 'plugins_loaded', 'lloc\Nowpayments\Plugin->plugins_loaded()' ) );
	}

	public function test_plugins_loaded() {
		Functions\when( 'load_plugin_textdomain' )->justReturn( true );

		$this->assertTrue( ( new Plugin() )->plugins_loaded() );
	}

	public function test_dirname() {
		$this->assertEquals( '/abc', ( new Plugin() )->dirname( '/abc' ) );
	}

	public function test_path() {
		$this->assertEquals( '', ( new Plugin() )->path() );
	}

}