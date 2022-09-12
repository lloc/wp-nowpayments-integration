<?php

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
	 * @param string $endpoint
	 * @param array $body
	 * @param array $headers
	 *
	 * @return Response
	 */
	public function get( string $endpoint, array $body = [], array $headers = [] ): Response {
		$url = add_query_arg( $body, $this->service->get( $endpoint ) );

		if ( ! empty( $headers ) ) {
			$headers = [ 'headers' => $headers ];
		}

		return new Response( wp_remote_get( $url, $headers ) );
	}

	/**
	 * @param string $endpoint
	 * @param array $body
	 * @param array $headers
	 *
	 * @return Response
	 */
	public function post( string $endpoint, array $body = [], array $headers = [] ): Response {
		$url  = $this->service->get( $endpoint );
		$args = [];


		if ( ! empty( $body ) ) {
			$args = [ 'body' => $body ];
		}

		if ( ! empty( $headers ) ) {
			$args = [ 'headers' => $headers ];
		}

		return new Response( wp_remote_post( $url, $args ) );
	}

}