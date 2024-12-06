<?php

namespace lloc\NowpaymentsTests;

use lloc\Nowpayments\Plugin;
use Brain\Monkey\Functions;
use Brain\Monkey\Actions;

class TestPlugin extends LlocTestCase {

	protected Plugin $plugin;

	public function setUp(): void {
		parent::setUp();

		Actions\expectAdded( 'plugins_loaded' )->once();
		Actions\expectAdded( 'init' )->once();

		$this->plugin = Plugin::init( __FILE__ );
	}

	public function test_plugins_loaded(): void {
		Functions\expect( 'plugin_dir_path' )->once()->andReturn( '/wp-nowpayments-integration/tests/' );
		Functions\expect( 'load_plugin_textdomain' )->once()->andReturn( true );

		$this->expectNotToPerformAssertions();

		$this->plugin->plugins_loaded();
	}

	public function test_block_init_false(): void {
		Functions\expect( 'function_exists' )->once()->andReturn( false );

		$this->expectNotToPerformAssertions();

		$this->plugin->block_init();
	}

	public function test_block_init_true(): void {
		$expected = '/wp-nowpayments-integration/tests/abc/';

		Functions\expect( 'register_block_type' )->once();
		Functions\expect( 'plugin_dir_path' )->once()->andReturn( $expected );

		$this->expectNotToPerformAssertions();

		$this->plugin->block_init();
	}

	public function test_dirname(): void {
		$expected = '/wp-nowpayments-integration/tests/';

		Functions\expect( 'plugin_dir_path' )->once()->andReturn( $expected );

		$this->assertEquals( $expected . 'abc/', $this->plugin->dirname( 'abc' ) );
	}

	public function test_plugin_dir_url(): void {
		$expected = 'https://wp-nowpayments-integration/tests/';

		Functions\expect( 'plugin_dir_url' )->once()->andReturn( $expected );

		$this->assertEquals( $expected, $this->plugin->plugin_dir_url() );
	}
}
