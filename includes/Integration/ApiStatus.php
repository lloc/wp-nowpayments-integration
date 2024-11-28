<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class ApiStatus extends Endpoint {

	/**
	 * @return string[]
	 */
	public function get(): array {
		$response = $this->client->get( EndpointMethods::ApiStatus->value );

		return $response->get();
	}
}
