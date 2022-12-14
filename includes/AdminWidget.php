<?php declare( strict_types=1 );

namespace lloc\Nowpayments;

use lloc\Nowpayments\Integration\ApiStatus;

class AdminWidget {

	protected ApiStatus $status;

	public const WIDGET_ID = 'nowpayments_status_widget';

	public function __construct( ApiStatus $status ) {
		$this->status = $status;
	}

	public static function create( ApiStatus $status ): AdminWidget {
		$obj = new self( $status );

		$widget_name = __( 'Nowpayments Status', 'wp-nowpayments-integration' );

		wp_add_dashboard_widget(self::WIDGET_ID, $widget_name, [ $obj, 'render' ] );

		return $obj;
	}

	public function render(): void {
		$arr     = $this->status->get();
		$service = sprintf( '<strong>%s</strong>', $this->status->get_client()->get_service()->info() );
		$format  = __( '%s responds with "%s".', 'wp-nowpayments-integration' );

		echo '<div>', sprintf( $format, $service, $arr['message'] ), '</div>';
	}

}