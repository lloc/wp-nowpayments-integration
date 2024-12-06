<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;
use lloc\Nowpayments\Rest\EndpointGetInterface;
use lloc\Nowpayments\Rest\ResponseInterface;

final class ApiStatus extends Endpoint implements EndpointGetInterface {

	/**
	 * @return ResponseInterface
	 */
	public function get(): ResponseInterface {
		return $this->client->get( EndpointMethods::ApiStatus->value );
	}
}
