<?php

namespace lloc\NowpaymentsTests;

use lloc\Nowpayments\Plugin;
use Brain\Monkey\Functions;
use Brain\Monkey\Actions;

class TestPlugin extends LlocTestCase {

	protected Plugin $plugin;

	public function setUp(): void {
		parent::setUp();

		$this->plugin = new Plugin( __FILE__ );
	}

	public function test_init(): void {
		Functions\expect( 'add_shortcode' )->once();

		Actions\expectAdded( 'plugins_loaded' );
		Actions\expectAdded( 'admin_menu' );
		Actions\expectAdded( 'admin_init' );
		Actions\expectAdded( 'wp_dashboard_setup' );
		Actions\expectAdded( 'widgets_init' );
		Actions\expectAdded( 'init' );

		$this->assertInstanceOf( Plugin::class, Plugin::init( __FILE__ ) );
	}

	public function test_plugins_loaded(): void {
		Functions\expect( 'plugin_dir_path' )->once()->andReturn( '/wp-nowpayments-integration/tests/' );
		Functions\expect( 'load_plugin_textdomain' )->once()->andReturn( true );

		$this->expectNotToPerformAssertions();

		$this->plugin->plugins_loaded();
	}

	public function test_wp_dashboard_setup(): void {
		Functions\expect( 'wp_get_environment_type' )->once()->andReturn( 'staging' );
		Functions\expect( 'wp_add_dashboard_widget' )->once()->andReturnNull();

		$this->expectNotToPerformAssertions();

		$this->plugin->wp_dashboard_setup();
	}

	public function test_widgets_init(): void {
		Functions\expect( 'register_widget' )->once();

		$this->expectNotToPerformAssertions();

		$this->plugin->widgets_init();
	}

	public function test_block_init_false(): void {
		Functions\expect( 'function_exists' )->once()->andReturn( false );

		$this->expectNotToPerformAssertions();

		$this->plugin->block_init();
	}

	public function test_block_init_true(): void {
		$expected = '/wp-nowpayments-integration/tests/abc';

		Functions\expect( 'register_block_type' )->once();
		Functions\expect( 'wp_register_script' )->once();
		Functions\expect( 'plugins_url' )->once()->andReturn( $expected );

		$this->expectNotToPerformAssertions();

		$this->plugin->block_init();
	}

	public function test_block_render(): void {
		$expected = 'widget_class';

		Functions\when( 'the_widget' )->justEcho( $expected );

		$this->assertEquals( $expected, Plugin::block_render() );
	}

	public function test_plugins_url(): void {
		$path     = 'abc';
		$expected = '/wp-nowpayments-integration/tests/abc';

		Functions\expect( 'plugins_url' )->once()->andReturn( $expected );

		$this->assertEquals( $expected, $this->plugin->plugins_url( $path ) );
	}

	public function test_dirname(): void {
		$expected = '/wp-nowpayments-integration/tests/';

		Functions\when( 'plugin_dir_path' )->justReturn( $expected );

		$this->assertEquals( $expected . 'abc/', $this->plugin->dirname( 'abc' ) );
	}

	public function test_path(): void {
		$expected = '/wp-nowpayments-integration/tests/';

		Functions\when( 'plugin_dir_path' )->justReturn( $expected );

		$this->assertEquals( $expected, $this->plugin->path() );
	}

	public function test_url(): void {
		$expected = 'https://wp-nowpayments-integration/tests/';

		Functions\when( 'plugin_dir_url' )->justReturn( $expected );

		$this->assertEquals( $expected, $this->plugin->url() );
	}
}
