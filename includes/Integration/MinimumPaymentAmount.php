<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;
use lloc\Nowpayments\Rest\EndpointGetInterface;
use lloc\Nowpayments\Rest\ResponseInterface;

class MinimumPaymentAmount extends Endpoint implements EndpointGetInterface {

	/**
	 * @param string $currency_from
	 * @param string $currency_to
	 *
	 * @return EndpointGetInterface
	 */
	public function set( string $currency_from, string $currency_to ): EndpointGetInterface {
		$args = array(
			'currency_from' => $currency_from,
			'currency_to'   => $currency_to,
		);

		return $this->set_body( $args );
	}

	/**
	 * @return ResponseInterface
	 */
	public function get(): ResponseInterface {
		return $this->client->get(
			EndpointMethods::MinimumPaymentAmount->value,
			$this->get_body(),
			$this->get_headers()
		);
	}
}
