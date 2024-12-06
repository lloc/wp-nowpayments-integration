<?php declare( strict_types=1 );

namespace lloc\Nowpayments;

use lloc\Nowpayments\Services\ApiStatusService;

class AdminWidget {

	public const WIDGET_ID = 'nowpayments_status_widget';

	public function __construct(
		protected readonly ApiStatusService $api_status_service
	) { }

	public static function init( ApiStatusService $api_status_service ): AdminWidget {
		$obj = new self( $api_status_service );

		add_action( 'wp_dashboard_setup', array( $obj, 'add_dashboard_widget' ) );

		return $obj;
	}

	public function add_dashboard_widget(): void {
		$widget_name = __( 'Nowpayments Status', 'wp-nowpayments-integration' );

		wp_add_dashboard_widget( self::WIDGET_ID, $widget_name, array( $this, 'render' ) );
	}

	public function render(): void {
		$data = $this->api_status_service->get_data();

		/* translators: 1: service name, 2: message */
		$format = __( '%1$s responds with "%2$s".', 'wp-nowpayments-integration' );

		echo wp_kses_post(
			'<div>' .
			sprintf( $format, '<strong>' . $data['info'] . '</strong>', $data['status'] ) .
			'</div>'
		);
	}
}
