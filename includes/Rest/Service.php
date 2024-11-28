<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

class Service {

	public const SANDBOX_SERVICE_URL    = 'https://api-sandbox.nowpayments.io';
	public const PRODUCTION_SERVICE_URL = 'https://api.nowpayments.io';

	/**
	 * @param string $environment
	 */
	public function __construct(
		private readonly string $environment
	) { }

	/**
	 * @return Service
	 */
	public static function create(): Service {
		return new self( wp_get_environment_type() );
	}

	/**
	 * @return string
	 */
	public function get_service_url(): string {
		return 'production' === $this->environment ? static::PRODUCTION_SERVICE_URL : static::SANDBOX_SERVICE_URL;
	}

	/**
	 * @param string $method
	 *
	 * @return string
	 */
	public function get( string $method ): string {
		return esc_url( trailingslashit( $this->get_service_url() ) . $method );
	}

	/**
	 * @return string
	 */
	public function info(): string {
		if ( 'production' === $this->environment ) {
			return __( 'Production', 'wp-nowpayments-integration' );
		}

		return __( 'Sandbox', 'wp-nowpayments-integration' );
	}
}
