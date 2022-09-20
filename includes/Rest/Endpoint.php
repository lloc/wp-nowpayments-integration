<?php

namespace lloc\Nowpayments\Rest;

abstract class Endpoint {

	protected Client $client;

	/**
	 * @param Client $client
	 */
	public function __construct( Client $client ) {
		$this->client = $client;
	}

	/**
	 * @return string[]
	 */
	abstract public function request(): array;

}