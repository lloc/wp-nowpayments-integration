<?php

namespace lloc\NowpaymentsTests;

use lloc\Nowpayments\AdminWidget;
use lloc\Nowpayments\Services\ApiStatusService;
use Brain\Monkey\Functions;

class TestAdminWidget extends LlocTestCase {

	public function test_render(): void {
		$data = array(
			'info'   => 'abc',
			'status' => 'def',
		);

		$status = \Mockery::mock( ApiStatusService::class );
		$status->shouldReceive( 'get_data' )->once()->andReturn( $data );

		Functions\expect( 'wp_kses_post' )->once()->andReturnFirstArg();

		( new AdminWidget( $status ) )->render();

		$this->expectOutputString( '<div><strong>abc</strong> responds with "def".</div>' );
	}
}
