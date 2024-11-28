<?php

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class PaymentStatus extends Endpoint {

	public const ENDPOINT = 'v1/payment';

	/**
	 * @param string $payment_id
	 *
	 * @return Endpoint
	 */
	public function set( string $payment_id ): Endpoint {
		return $this->set_body( array( 'payment_id' => $payment_id ) );
	}

	/**
	 * @return string[]
	 */
	public function get(): array {
		$body     = $this->get_body();
		$endpoint = sprintf( EndpointMethods::PaymentStatus->value, $body['payment_id'] );
		$response = $this->client->get( $endpoint, $this->get_body(), $this->get_headers() );

		return $response->get();
	}
}
