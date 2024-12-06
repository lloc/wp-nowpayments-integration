<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;
use lloc\Nowpayments\Rest\EndpointGetInterface;
use lloc\Nowpayments\Rest\ResponseInterface;

final class EstimatedPrice extends Endpoint implements EndpointGetInterface {

	/**
	 * @param float  $amount
	 * @param string $currency_from
	 * @param string $currency_to
	 *
	 * @return EndpointGetInterface
	 */
	public function set( float $amount, string $currency_from, string $currency_to ): EndpointGetInterface {
		$args = array(
			'amount'        => $amount,
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
			EndpointMethods::EstimatedPrice->value,
			$this->get_body(),
			$this->get_headers()
		);
	}
}
