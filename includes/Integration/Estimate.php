<?php

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class Estimate extends Endpoint {

	/**
	 * @param string $amount
	 * @param string $currency_from
	 * @param string $currency_to
	 *
	 * @return Endpoint
	 */
	public function set( string $amount, string $currency_from, string $currency_to ): Endpoint {
		return $this->set_body( [ 'amount' => $amount, 'currency_from' => $currency_from, 'currency_to' => $currency_to ] );
	}

	/**
	 * @return string[]
	 */
	public function get(): array {
		$response = $this->client->get( 'v1/estimate', $this->body, $this->get_headers() );

		return $response->get();
	}
}