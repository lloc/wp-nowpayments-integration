<?php

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class Estimate extends Endpoint {

	public function request(): array {
		$response = $this->client->get( 'v1/estimate', $this->body, $this->get_headers() );

		return $response->get();
	}
}