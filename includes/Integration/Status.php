<?php

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;
use lloc\Nowpayments\Rest\Response;

class Status extends Endpoint {

	public function request(): Response {
		return $this->client->get( 'v1/status' );
	}
}