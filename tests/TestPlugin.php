<?php

namespace lloc\NowpaymentsTests;

use lloc\Nowpayments\AdminWidget;
use lloc\Nowpayments\Plugin;
use Brain\Monkey\Functions;
use function Brain\Monkey\Actions\expectAdded;

class TestPlugin extends LlocTestCase {

	public function test_init() {
		expectAdded( 'plugins_loaded' );
		expectAdded( 'admin_menu' );
		expectAdded( 'admin_init' );
		expectAdded( 'wp_dashboard_setup' );

		$this->assertInstanceOf( Plugin::class, Plugin::init( __FILE__ ) );
	}

	public function test_wp_dashboard_setup() {
		Functions\expect( 'wp_get_environment_type' )->once()->andReturn( 'staging' );
		Functions\expect( '__' )->once()->andReturn( 'test' );
		Functions\expect( 'wp_add_dashboard_widget' )->once()->andReturnNull();

		$this->assertInstanceOf( AdminWidget::class, ( new Plugin( __FILE__ ) )->wp_dashboard_setup() );
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