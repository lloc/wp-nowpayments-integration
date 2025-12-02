<?php

namespace lloc\NowpaymentsTests;

use Brain\Monkey\Functions;
use Brain\Monkey\Actions;
use lloc\Nowpayments\OptionsPage;

class TestOptionsPage extends LlocTestCase {

	public function test_init(): void {
		Actions\expectAdded( 'admin_menu' )->once();

		OptionsPage::init();

		$this->expectNotToPerformAssertions();
	}

	public function test_admin_menu(): void {
		Functions\expect( 'add_options_page' )->once()->andReturn( 'my_page_slug' );

		$this->expectNotToPerformAssertions();

		OptionsPage::admin_menu();
	}

	public function test_render_page(): void {
		Functions\expect( 'current_user_can' )->once()->andReturn( true );
		Functions\expect( 'get_admin_page_title' )->once()->andReturn( '--Title--' );
		Functions\expect( 'admin_url' )->once()->andReturn( 'https://example.com/wp-admin/options.php' );
		Functions\expect( 'settings_fields' )->once();
		Functions\expect( 'do_settings_sections' )->once();
		Functions\expect( 'submit_button' )->once();
		Functions\expect( 'esc_html' )->once()->andReturnFirstArg();
		Functions\expect( 'esc_url' )->once()->andReturnFirstArg();
		Functions\expect( '__' )->once()->andReturnFirstArg();

		OptionsPage::render_page();

		$expected = '<div class="wrap">' . PHP_EOL . '<h1>--Title--</h1>' . PHP_EOL . '<form action="https://example.com/wp-admin/options.php" method="post">' . PHP_EOL . '</form>' . PHP_EOL . '</div>' . PHP_EOL;

		$this->expectOutputString( $expected );
	}

	public function test_render_page_curren_user_cannot(): void {
		Functions\when( 'current_user_can' )->justReturn( false );

		OptionsPage::render_page();

		$this->expectOutputString( '' );
	}

	public function test_add_settings_error_true(): void {
		Functions\expect( 'add_settings_error' )->once();
		Functions\expect( '__' )->once()->andReturnFirstArg();
		Functions\expect( 'esc_attr' )->once()->andReturnFirstArg();

		$this->expectNotToPerformAssertions();

		OptionsPage::add_settings_error( array( 'settings-updated' => 1 ) );
	}

	public function test_add_settings_error_false(): void {
		Functions\expect( 'add_settings_error' )->never();

		$this->expectNotToPerformAssertions();

		OptionsPage::add_settings_error( array() );
	}
}
