<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class Currencies extends Endpoint {

	/**
	 * @return string[]
	 */
	public function get(): array {
		$response = $this->client->get( 'v1/currencies', [], $this->get_headers() );

		return $response->get();
	}
}