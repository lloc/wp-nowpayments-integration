<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Option;
use lloc\Nowpayments\Rest\Endpoint;
use lloc\Nowpayments\Settings;

class Currencies extends Endpoint {

	public function request(): array {
		$headers = [ 'x-api-key' => ( new Option( Settings::API_KEY_FIELD ) )->get() ];

		$response = $this->client->get( 'v1/currencies', $headers );

		return $response->get();
	}
}