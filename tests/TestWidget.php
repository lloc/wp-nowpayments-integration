<?php

namespace lloc\NowpaymentsTests;

use Brain\Monkey\Functions;
use lloc\Nowpayments\Widget;

class TestWidget extends LlocTestCase {

	public function get_sut() {
		\Mockery::mock( '\WP_Widget' );

		return \Mockery::mock( Widget::class )->makePartial();
	}

	function test_widget_method(): void {
		$arr = [
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		];

		Functions\expect( 'wp_parse_args' )->once()->andReturn( $arr );
		Functions\expect( '__' )->once()->andReturnFirstArg();

		$obj = $this->get_sut();

		$this->expectOutputString( '-Good news, everyone! There\'s a report on TV with some very bad news!' );
		$obj->widget( [], [ 'title' => '-' ] );
	}

	public function test_update_method(): void {
		$obj = $this->get_sut();

		$result = $obj->update( [], [] );
		$this->assertEquals( [], $result );

		$result = $obj->update( [ 'title' => 'abc' ], [] );
		$this->assertEquals( [ 'title' => 'abc' ], $result );

		$result = $obj->update( [ 'title' => 'xyz' ], [ 'title' => 'abc' ] );
		$this->assertEquals( [ 'title' => 'xyz' ], $result );
	}

	public function test_form(): void {
		$expected = '<p><label for="widget-field_id">Title:</label> <input class="widefat" id="widget-field_id" name="field_name" type="text" value="" /></p>';

		$obj = $this->get_sut();
		$obj->shouldReceive( 'get_field_id' )->andReturn( 'widget-field_id' );
		$obj->shouldReceive( 'get_field_name' )->andReturn( 'field_name' );

		Functions\expect( '__' )->once()->andReturnFirstArg();

		$this->expectOutputString( $expected );
		$this->assertEquals( 'noform', $obj->form( [] ) );
	}

}