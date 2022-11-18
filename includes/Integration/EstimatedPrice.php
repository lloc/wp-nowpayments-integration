<?php

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class EstimatedPrice extends Endpoint {

	/**
	 * @param string $amount
	 * @param string $currency_from
	 * @param string $currency_to
	 *
	 * @return Endpoint
	 */
	public function set( string $amount, string $currency_from, string $currency_to ): Endpoint {
		$args = [
			'amount'        => $amount,
			'currency_from' => $currency_from,
			'currency_to'   => $currency_to,
		];

		return $this->set_body( $args );
	}

	/**
	 * @todo Check if all mandatory vars are set in the body
	 *
	 * @return string[]
	 */
	public function get(): array {
		$response = $this->client->get( 'v1/estimate', $this->body, $this->get_headers() );

		return $response->get();
	}
}