<?php

namespace lloc\NowpaymentsTests;

use lloc\Nowpayments\Settings;
use Brain\Monkey\Functions;

class TestSettings extends LlocTestCase {

	public function test_admin_init() {
		Functions\expect( 'register_setting' )->once();
		Functions\expect( 'add_settings_section' )->once();
		Functions\expect( 'add_settings_field' )->once();
		Functions\expect( '__' )->times( 4 );

		Settings::admin_init();

		$this->assertSame( 1, did_action( 'nowpayments_settings_admin_init' ) );
	}

	public function test_render_section() {
		Functions\when( '__' )->justReturn( 'def' );

		Settings::render_section( [ 'id' => 'abc' ] );
		$this->expectOutputString( '<p id="abc">def</p>' );
	}

	public function test_render_fields() {
		Functions\expect( 'get_option' )->andReturn( [ 'abc' => 'def' ] );

		Settings::render_fields( [ 'label_for' => 'abc' ] );
		$this->expectOutputString( '<input id="abc" name="nowpayments_option[abc]" value="def" class="regular-text code" />' );
	}

	public function test_render_fields_description() {
		Functions\expect( 'get_option' )->andReturn( [ 'abc' => 'def' ] );

		Settings::render_fields( [ 'label_for' => 'abc', 'description' => 'ghi' ] );
		$this->expectOutputString( '<input id="abc" name="nowpayments_option[abc]" value="def" class="regular-text code" /><p class="description">ghi</p>' );
	}

	public function test_sanitize_text_field() {
		$this->assertEquals( [ 'api_key' => '' ], Settings::sanitize_text_field( [] ) );
		$this->assertEquals( [ 'api_key' => 'ABC0123' ], Settings::sanitize_text_field( [ 'api_key' => 'ABC0123abc' ] ) );
	}

}