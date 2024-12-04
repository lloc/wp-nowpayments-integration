<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

class Client {

	/**
	 * @param Service $service
	 */
	public function __construct(
		private readonly Service $service
	) { }

	/**
	 * @return Service
	 */
	public function get_service(): Service {
		return $this->service;
	}

	/**
	 * @param string   $endpoint
	 * @param string[] $body
	 * @param string[] $headers
	 *
	 * @return ResultInterface
	 */
	public function get( string $endpoint, array $body = array(), array $headers = array() ): ResultInterface {
		$url = add_query_arg( $body, $this->service->get( $endpoint ) );

		if ( ! empty( $headers ) ) {
			$headers = array( 'headers' => $headers );
		}

		$response = wp_remote_get( $url, $headers );

		return is_wp_error( $response ) ? new Error( $response ) : new Response( $response );
	}

	/**
	 * @param string   $endpoint
	 * @param string[] $body
	 * @param string[] $headers
	 *
	 * @return ResultInterface
	 */
	public function post( string $endpoint, array $body = array(), array $headers = array() ): ResultInterface {
		$url  = $this->service->get( $endpoint );
		$args = array();

		if ( ! empty( $body ) ) {
			$args = array( 'body' => $body );
		}

		if ( ! empty( $headers ) ) {
			$args = array( 'headers' => $headers );
		}

		$response = wp_remote_post( $url, $args );

		return is_wp_error( $response ) ? new Error( $response ) : new Response( $response );
	}
}
