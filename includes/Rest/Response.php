<?php

namespace lloc\Nowpayments\Rest;

use WP_Error;

class Response {

	protected array $response = [];
	protected $error = null;

	/**
	 * @param WP_Error|array $response
	 */
	public function __construct( $response ) {
		if ( ! is_wp_error( $response ) ) {
			$this->response = $response;
		} else {
			$this->error = $response;
		}
	}

	/**
	 * @return bool
	 */
	public function has_error(): bool {
		return ! is_null( $this->error );
	}

	/**
	 * @return WP_Error|null
	 */
	public function get_error() {
		return $this->error;
	}

	/**
	 * @return string
	 */
	public function get(): string {
		return $this->response['body'] ?? '';
	}

}