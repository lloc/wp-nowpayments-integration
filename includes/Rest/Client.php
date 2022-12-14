<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

class Client {

	private Service $service;

	/**
	 * @param Service $service
	 */
	public function __construct( Service $service ) {
		$this->service = $service;
	}

	/**
	 * @return Service
	 */
	public function get_service(): Service {
		return $this->service;
	}

	/**
	 * @param string $endpoint
	 * @param string[] $body
	 * @param string[] $headers
	 *
	 * @return Result
	 */
	public function get( string $endpoint, array $body = [], array $headers = [] ): Result {
		$url = add_query_arg( $body, $this->service->get( $endpoint ) );

		if ( ! empty( $headers ) ) {
			$headers = [ 'headers' => $headers ];
		}

		$response = wp_remote_get( $url, $headers );

		return is_wp_error( $response ) ? new Error( $response ) : new Response( $response );
	}

	/**
	 * @param string $endpoint
	 * @param string[] $body
	 * @param string[] $headers
	 *
	 * @return Result
	 */
	public function post( string $endpoint, array $body = [], array $headers = [] ): Result {
		$url  = $this->service->get( $endpoint );
		$args = [];

		if ( ! empty( $body ) ) {
			$args = [ 'body' => $body ];
		}

		if ( ! empty( $headers ) ) {
			$args = [ 'headers' => $headers ];
		}

		$response = wp_remote_post( $url, $args );

		return is_wp_error( $response ) ? new Error( $response ) : new Response( $response );
	}

}