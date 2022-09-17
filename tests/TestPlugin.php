<?php

namespace lloc\NowpaymentsTests;

use lloc\Nowpayments\OptionsPage;
use lloc\Nowpayments\Plugin;
use Brain\Monkey\Functions;
use lloc\Nowpayments\Settings;

class TestPlugin extends LlocTestCase {

	public function test_init() {
		Plugin::init( __FILE__ );

		$this->assertEquals( 10, has_action( 'plugins_loaded', 'lloc\Nowpayments\Plugin->plugins_loaded()' ) );
		$this->assertEquals( 10, has_action( 'admin_menu', [ OptionsPage::class, 'admin_menu' ] ) );
		$this->assertEquals( 10, has_action( 'admin_init', [ Settings::class, 'admin_init' ] ) );
	}

	public function test_plugins_loaded() {
		Functions\when( 'plugin_dir_path' )->returnArg();
		Functions\when( 'load_plugin_textdomain' )->justReturn( true );

		$this->assertTrue( ( new Plugin( __FILE__ ) )->plugins_loaded() );
	}

	public function test_dirname() {
		$expected = '/wp-nowpayments-integration/tests/';

		Functions\when( 'plugin_dir_path' )->justReturn( $expected );

		$this->assertEquals( $expected . 'abc/', ( new Plugin( __FILE__ ) )->dirname( 'abc' ) );
	}

	public function test_path() {
		$expected = '/wp-nowpayments-integration/tests/';

		Functions\when( 'plugin_dir_path' )->justReturn( $expected );

		$this->assertEquals( $expected, ( new Plugin( __FILE__ ) )->path() );
	}

	public function test_url() {
		$expected = 'https://wp-nowpayments-integration/tests/';

		Functions\when( 'plugin_dir_url' )->justReturn( $expected );

		$this->assertEquals( $expected, ( new Plugin( __FILE__ ) )->url() );
	}

}