<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

abstract class Endpoint {

	protected Client $client;

	/**
	 * @param Client $client
	 */
	public function __construct( Client $client ) {
		$this->client = $client;
	}


	public function get_client(): Client {
		return $this->client;
	}

	/**
	 * @return string[]
	 */
	abstract public function request(): array;

}