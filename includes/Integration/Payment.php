<?php

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class Payment extends Endpoint {
	
	/**
	 * @param array<string, string|int> $args
	 *
	 * @return Endpoint
	 */
	public function set( array $args ): Endpoint {
		$args = array_filter( [
			'payment_id' => $args['payment_id'] ?? null,
			'limit'      => isset( $args['limit'] ) ? intval( $args['limit'] ) : null,
			'page'       => isset( $args['page'] ) ? intval( $args['page'] ) : null,
			'sortBy'     => $args['sortBy'] ?? null,
			'orderBy'    => $args['orderBy'] ?? null,
			'dateFrom'   => $args['dateFrom'] ?? null,
			'dateTo'     => $args['dateTo'] ?? null,
		] );

		return $this->set_body( $args );
	}

	/**
	 * @return string[]
	 */
	public function get(): array {
		$endpoint = sprintf( 'v1/payment/%s', $this->body['payment_id'] );

		$response = $this->client->get( $endpoint, [], $this->get_headers() );

		return $response->get();
	}

	/**
	 * @return string[]
	 */
	public function list(): array {
		$response = $this->client->get( 'v1/payment', $this->body, $this->get_headers() );

		return $response->get();
	}
}