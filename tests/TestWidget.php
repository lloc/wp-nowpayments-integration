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
		$arr = array(
			'before_widget' => '',
			'after_widget'  => '',
			'before_title'  => '',
			'after_title'   => '',
		);

		Functions\expect( 'wp_parse_args' )->once()->andReturn( $arr );

		$obj = $this->get_sut();

		$this->expectOutputString( '-Good news, everyone! There\'s a report on TV with some very bad news!' );
		$obj->widget( array(), array( 'title' => '-' ) );
	}

	public function test_update_method(): void {
		$obj = $this->get_sut();

		$result = $obj->update( array(), array() );
		$this->assertEquals( array(), $result );

		$result = $obj->update( array( 'title' => 'abc' ), array() );
		$this->assertEquals( array( 'title' => 'abc' ), $result );

		$result = $obj->update( array( 'title' => 'xyz' ), array( 'title' => 'abc' ) );
		$this->assertEquals( array( 'title' => 'xyz' ), $result );
	}

	public function test_form(): void {
		$expected = '<p><label for="widget-field_id">Title:</label> <input class="widefat" id="widget-field_id" name="field_name" type="text" value="" /></p>';

		$obj = $this->get_sut();
		$obj->shouldReceive( 'get_field_id' )->andReturn( 'widget-field_id' );
		$obj->shouldReceive( 'get_field_name' )->andReturn( 'field_name' );


		$this->expectOutputString( $expected );
		$this->assertEquals( 'noform', $obj->form( array() ) );
	}
}
