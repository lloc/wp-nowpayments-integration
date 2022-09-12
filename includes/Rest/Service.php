<?php

namespace lloc\Nowpayments\Rest;

class Service {

	public const SANDBOX_SERVICE_URL = 'https://api-sandbox.nowpayments.io';
	public const PRODUCTION_SERVICE_URL = 'https://api.nowpayments.io';

	private string $url;

	/**
	 * @param string $url
	 */
	public function __construct( string $url ) {
		$this->url = $url;
	}

	/**
	 * @return Service
	 */
	public static function create(): Service {
		if ( 'production' !== wp_get_environment_type() ) {
			return new self( static::SANDBOX_SERVICE_URL );
		}

		return new self( static::PRODUCTION_SERVICE_URL );
	}

	/**
	 * @param string $endpoint
	 *
	 * @return string
	 */
	public function get( string $endpoint ): string {
		return esc_url( trailingslashit( $this->url ) . $endpoint );
	}

}