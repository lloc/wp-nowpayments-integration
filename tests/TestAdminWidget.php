<?php

namespace lloc\NowpaymentsTests;

use lloc\Nowpayments\AdminWidget;
use lloc\Nowpayments\Services\ApiStatusService;
use Brain\Monkey\Functions;

class TestAdminWidget extends LlocTestCase {

	public function test_init(): void {
		$status = \Mockery::mock( ApiStatusService::class );

		Functions\expect( 'add_action' )
			->once()
			->with( 'wp_dashboard_setup', \Mockery::type( 'array' ) );

		$this->assertInstanceOf( AdminWidget::class, AdminWidget::init( $status ) );
	}

	public function test_add_dashboard_widget(): void {
		$status = \Mockery::mock( ApiStatusService::class );

		Functions\expect( 'wp_add_dashboard_widget' )->once();

		$this->expectNotToPerformAssertions();

		( new AdminWidget( $status ) )->add_dashboard_widget();
	}

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
