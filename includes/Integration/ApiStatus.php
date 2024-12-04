<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

final class ApiStatus extends Endpoint implements ApiStatusInterface {

	/**
	 * @return string[]
	 */
	public function get(): array {
		$response = $this->client->get( EndpointMethods::ApiStatus->value );

		return $response->get();
	}
}
