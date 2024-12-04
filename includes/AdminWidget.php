<?php declare( strict_types=1 );

namespace lloc\Nowpayments;

use lloc\Nowpayments\Integration\ApiStatusInterface;

class AdminWidget {

	public const WIDGET_ID = 'nowpayments_status_widget';

	public function __construct(
		protected readonly ApiStatusInterface $status
	) { }

	public static function create( ApiStatusInterface $status ): AdminWidget {
		$obj = new self( $status );

		$widget_name = __( 'Nowpayments Status', 'wp-nowpayments-integration' );

		wp_add_dashboard_widget( self::WIDGET_ID, $widget_name, array( $obj, 'render' ) );

		return $obj;
	}

	public function render(): void {
		$message = $this->status->get()['message'] ?? '';
		$service = sprintf( '<strong>%s</strong>', $this->status->get_client()->get_service()->info() );

		/* translators: 1: service name, 2: message */
		$format = __( '%1$s responds with "%2$s".', 'wp-nowpayments-integration' );

		echo wp_kses_post( '<div>' . sprintf( $format, $service, $message ) . '</div>' );
	}
}
