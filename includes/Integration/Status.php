<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class Status extends Endpoint {

	public function request(): array {
		$response = $this->client->get( 'v1/status' );

		return $response->get();
	}
}