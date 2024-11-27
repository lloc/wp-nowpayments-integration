<?php

namespace lloc\NowpaymentsTests;

use Brain\Monkey\Functions;
use lloc\Nowpayments\OptionsPage;

class TestOptionsPage extends LlocTestCase {

	public function test_admin_menu() {
		$expected = 'my_page_slug';

		Functions\when( 'add_options_page' )->justReturn( $expected );

		$this->assertEquals( $expected, OptionsPage::admin_menu() );
	}

	public function test_render_page() {
		Functions\when( 'current_user_can' )->justReturn( true );
		Functions\when( 'get_admin_page_title' )->justReturn( '--Title--' );
		Functions\when( 'admin_url' )->justReturn( 'https://example.com/wp-admin/options.php' );

		Functions\expect( 'settings_fields' )->once();
		Functions\expect( 'do_settings_sections' )->once();
		Functions\expect( 'submit_button' )->once();

		OptionsPage::render_page();

		$expected = '<div class="wrap">' . PHP_EOL . '<h1>--Title--</h1>' . PHP_EOL . '<form action="https://example.com/wp-admin/options.php" method="post">' . PHP_EOL . '</form>' . PHP_EOL . '</div>' . PHP_EOL;

		$this->expectOutputString( $expected );
	}

	public function test_render_page_curren_user_cannot() {
		Functions\when( 'current_user_can' )->justReturn( false );

		OptionsPage::render_page();

		$this->expectOutputString( '' );
	}

	public function test_add_settings_error_true() {
		Functions\expect( 'add_settings_error' )->once();

		$this->assertTrue( OptionsPage::add_settings_error( array( 'settings-updated' => 1 ) ) );
	}

	public function test_add_settings_error_false() {
		$this->assertFalse( OptionsPage::add_settings_error( array() ) );
	}
}
