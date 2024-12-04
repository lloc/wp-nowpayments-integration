<?php

namespace lloc\Nowpayments\Rest;

interface EndpointInterface {


	/**
	 * @return Client
	 */
	public function get_client(): Client;
}
