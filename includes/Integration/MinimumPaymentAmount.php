<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class MinimumPaymentAmount extends Endpoint {

	/**
	 * @param string $currency_from
	 * @param string $currency_to
	 *
	 * @return Endpoint
	 */
	public function set( string $currency_from, string $currency_to ): Endpoint {
		$args = array(
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
			EndpointMethods::MinimumPaymentAmount->value,
			$this->get_body(),
			$this->get_headers()
		);

		return $response->get();
	}
}
