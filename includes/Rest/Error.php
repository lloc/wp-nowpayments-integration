<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

use WP_Error;

class Error implements Result {

	protected WP_Error $error;

	/**
	 * @param WP_Error $error
	 */
	public function __construct( WP_Error $error ) {
		$this->error = $error;
	}

	/**
	 * @return string[]
	 */
	public function get(): array {
		return array( 'message' => $this->error->get_error_message() );
	}
}
