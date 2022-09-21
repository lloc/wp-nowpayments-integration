<?php

namespace lloc\Nowpayments\Rest;

class Service {

	public const SANDBOX_SERVICE_URL = 'https://api-sandbox.nowpayments.io';
	public const PRODUCTION_SERVICE_URL = 'https://api.nowpayments.io';

	private string $environment;

	/**
	 * @param string $environment
	 */
	public function __construct( string $environment ) {
		$this->environment = $environment;
	}

	/**
	 * @return Service
	 */
	public static function create(): Service {
		return new self( wp_get_environment_type() );
	}

	/**
	 * @param string $method
	 *
	 * @return string
	 */
	public function get( string $method ): string {
		$url = 'production' === $this->environment ? static::PRODUCTION_SERVICE_URL : static::SANDBOX_SERVICE_URL;

		return esc_url( trailingslashit( $url ) . $method );
	}

	/**
	 * @return string
	 */
	public function info(): string {
		if ( $this->environment === 'production' ) {
			return __( 'Production', 'wp-nowpayments-integration' );
		}

		return __( 'Sandbox', 'wp-nowpayments-integration' );
	}

}