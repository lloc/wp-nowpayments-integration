<?php

namespace lloc\Nowpayments;

use lloc\Nowpayments\Integration\Status;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Error;
use lloc\Nowpayments\Rest\Service;

class AdminWidget {

	public const WIDGET_ID = 'nowpayments_status_widget';

	public static function init(): void {
		$widget_name = __( 'Nowpayments Status', 'wp-nowpayments-integration' );

		wp_add_dashboard_widget(self::WIDGET_ID, $widget_name, [ __CLASS__, 'render' ] );
	}

	public static function render(): void {
		$service = Service::create();
		$client = new Client( $service );
		$status = new Status( $client );
		$arr = $status->request();

		$format = __( '<div><strong>%s</strong> responds with "%s".</div>', 'wp-nowpayments-integration' );

		printf( $format, $service->info(), $arr['message'] );
	}

}