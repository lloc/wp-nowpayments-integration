<?php

namespace lloc\NowpaymentsTests;

use lloc\Nowpayments\AdminWidget;
use lloc\Nowpayments\Plugin;
use Brain\Monkey\Functions;
use function Brain\Monkey\Actions\expectAdded;

class TestPlugin extends LlocTestCase {

	public function test_init(): void {
		Functions\expect( 'add_shortcode' )->once();

		expectAdded( 'plugins_loaded' );
		expectAdded( 'admin_menu' );
		expectAdded( 'admin_init' );
		expectAdded( 'wp_dashboard_setup' );

		$this->assertInstanceOf( Plugin::class, Plugin::init( __FILE__ ) );
	}

	public function test_plugins_loaded(): void {
		Functions\when( 'plugin_dir_path' )->returnArg();
		Functions\when( 'load_plugin_textdomain' )->justReturn( true );

		$this->assertTrue( ( new Plugin( __FILE__ ) )->plugins_loaded() );
	}

	public function test_wp_dashboard_setup(): void {
		Functions\expect( 'wp_get_environment_type' )->once()->andReturn( 'staging' );
		Functions\expect( '__' )->once()->andReturn( 'test' );
		Functions\expect( 'wp_add_dashboard_widget' )->once()->andReturnNull();

		$this->assertInstanceOf( AdminWidget::class, ( new Plugin( __FILE__ ) )->wp_dashboard_setup() );
	}

	public function test_widgets_init(): void {
		Functions\expect( 'register_widget' )->once();

		$this->assertEquals( 1, ( new Plugin( __FILE__ ) )->widgets_init() );
	}

	public function test_block_init_false(): void {
		$this->assertFalse( ( new Plugin( __FILE__ ) )->block_init() );
	}

	public function test_block_init_true(): void {
		$expected = '/wp-nowpayments-integration/tests/abc';

		Functions\expect( 'register_block_type' )->once();
		Functions\expect( 'wp_register_script' )->once();
		Functions\expect( 'plugins_url' )->once()->andReturn( $expected );

		$this->assertTrue( ( new Plugin( __FILE__ ) )->block_init() );
	}

	public function test_block_render(): void {
		$expected = 'widget_class';

		Functions\when( 'the_widget' )->justEcho( $expected );

		$this->assertEquals( $expected, Plugin::block_render() );
	}

	public function test_plugins_url(): void {
		$path = 'abc';
		$expected = '/wp-nowpayments-integration/tests/abc';

		Functions\expect( 'plugins_url' )->once()->andReturn( $expected );

		$this->assertEquals( $expected, ( new Plugin( __FILE__ ) )->plugins_url( $path ) );
	}

	public function test_dirname(): void {
		$expected = '/wp-nowpayments-integration/tests/';

		Functions\when( 'plugin_dir_path' )->justReturn( $expected );

		$this->assertEquals( $expected . 'abc/', ( new Plugin( __FILE__ ) )->dirname( 'abc' ) );
	}

	public function test_path(): void {
		$expected = '/wp-nowpayments-integration/tests/';

		Functions\when( 'plugin_dir_path' )->justReturn( $expected );

		$this->assertEquals( $expected, ( new Plugin( __FILE__ ) )->path() );
	}

	public function test_url(): void {
		$expected = 'https://wp-nowpayments-integration/tests/';

		Functions\when( 'plugin_dir_url' )->justReturn( $expected );

		$this->assertEquals( $expected, ( new Plugin( __FILE__ ) )->url() );
	}

}