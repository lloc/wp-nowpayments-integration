<?php

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class EstimatedPrice extends Endpoint {

	/**
	 * @param float  $amount
	 * @param string $currency_from
	 * @param string $currency_to
	 *
	 * @return Endpoint
	 */
	public function set( float $amount, string $currency_from, string $currency_to ): Endpoint {
		$args = array(
			'amount'        => $amount,
			'currency_from' => $currency_from,
			'currency_to'   => $currency_to,
		);

		return $this->set_body( $args );
	}

	/**
	 * @return string[]
	 */
	public function get(): array {
		$response = $this->client->get(
			EndpointMethods::EstimatedPrice->value,
			$this->get_body(),
			$this->get_headers()
		);

		return $response->get();
	}
}
