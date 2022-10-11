<?php

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class PaymentStatus extends Endpoint {
	
	/**
	 * @param array<string, string|int> $args
	 *
	 * @return Endpoint
	 */
	public function set( string $payment_id ): Endpoint {
		return $this->set_body( [ 'payment_id' => $payment_id ] );
	}

	/**
	 * @return string[]
	 */
	public function get(): array {
		$endpoint = sprintf( 'v1/payment/%s', $this->body['payment_id'] );

		$response = $this->client->get( $endpoint, [], $this->get_headers() );

		return $response->get();
	}

}