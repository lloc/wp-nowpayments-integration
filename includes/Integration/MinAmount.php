<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class MinAmount extends Endpoint {

	/**
	 * @param string $currency_from
	 * @param string $currency_to
	 *
	 * @return Endpoint
	 */
	public function set( string $currency_from, string $currency_to ): Endpoint {
		return $this->set_body( [ 'currency_from' => $currency_from, 'currency_to' => $currency_to ] );
	}

	/**
	 * @return string[]
	 */
	public function get(): array {
		$response = $this->client->get( 'v1/min-amount', $this->body, $this->get_headers() );

		return $response->get();
	}
}