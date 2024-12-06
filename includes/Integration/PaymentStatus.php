<?php

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;
use lloc\Nowpayments\Rest\EndpointGetInterface;
use lloc\Nowpayments\Rest\ResponseInterface;

final class PaymentStatus extends Endpoint implements EndpointGetInterface {

	/**
	 * @param string $payment_id
	 *
	 * @return EndpointGetInterface
	 */
	public function set( string $payment_id ): EndpointGetInterface {
		return $this->set_body( array( 'payment_id' => $payment_id ) );
	}

	/**
	 * @return ResponseInterface
	 */
	public function get(): ResponseInterface {
		$body     = $this->get_body();
		$endpoint = sprintf( EndpointMethods::PaymentStatus->value, $body['payment_id'] );

		return $this->client->get( $endpoint, $this->get_body(), $this->get_headers() );
	}
}
