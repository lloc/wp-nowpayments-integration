<?php

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class Payment extends Endpoint {

	protected string $payment_id = '';

	/**
	 * @param string $payment_id
	 *
	 * @return Endpoint
	 */
	public function set( string $payment_id ): Endpoint {
		$this->payment_id = $payment_id;

		return $this;
	}

	/**
	 * @return string[]
	 */
	public function get(): array {
		$endpoint = sprintf( 'v1/payment/%s', $this->payment_id );

		$response = $this->client->get( $endpoint, [], $this->get_headers() );

		return $response->get();
	}
}