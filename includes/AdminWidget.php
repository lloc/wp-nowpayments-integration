<?php

namespace lloc\Nowpayments;

use lloc\Nowpayments\Integration\Status;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Service;

class AdminWidget {

	public const WIDGET_ID = 'nowpayments_status_widget';

	public static function init() {
		$widget_name = __( 'Nowpayments Status', 'wp-nowpayments-integration' );

		wp_add_dashboard_widget(self::WIDGET_ID, $widget_name, [ __CLASS__, 'render' ] );
	}

	public static function render(): void {
		$service = Service::create();
		$client = new Client( $service );
		$status = new Status( $client );

		$response = $status->request();
		if ( $response->has_error() ) {
			$message = $response->get_error()->get_error_message();
		}
		else {
			$obj = json_decode( $response->get() );
			$message = $obj->message ?? __( 'Object has no message property!', 'wp-nowpayments-integration' );
		}

		$format = __( '<div><strong>%s</strong> responds with "%s".</div>', 'wp-nowpayments-integration' );

		printf( $format, $service->info(), $message );
	}

}