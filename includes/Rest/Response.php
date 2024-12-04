<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

class Response implements ResultInterface {

	/**
	 * @var string[]
	 */
	protected array $response = array();

	/**
	 * @param mixed $response
	 */
	public function __construct( $response ) {
		if ( is_array( $response ) ) {
			$this->response = $response;
		}
	}

	/**
	 * @return string[]
	 */
	public function get(): array {
		if ( isset( $this->response['body'] ) ) {
			return json_decode( $this->response['body'], true );
		}

		return array( 'message' => __( 'Object has no body property!', 'wp-nowpayments-integration' ) );
	}
}
