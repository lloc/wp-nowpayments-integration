<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

use WP_Error;

class Error implements ResponseInterface {

	/**
	 * @param WP_Error $error
	 */
	public function __construct(
		protected readonly WP_Error $error
	) { }

	/**
	 * @return string[]
	 */
	public function get(): array {
		return array( 'message' => $this->error->get_error_message() );
	}
}
