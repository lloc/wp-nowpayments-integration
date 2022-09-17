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
		OptionsPage::render_page();

		$this->expectOutputString( '' );
	}
}