<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

use lloc\Nowpayments\Option;
use lloc\Nowpayments\Settings;

abstract class Endpoint {

	/**
	 * @var Client
	 */
	protected Client $client;

	/**
	 * @var string[]
	 */
	protected array $body = [];

	/**
	 * @param Client $client
	 */
	public function __construct( Client $client ) {
		$this->client = $client;
	}

	/**
	 * @return Client
	 */
	public function get_client(): Client {
		return $this->client;
	}

	/**
	 * @return string[]
	 */
	protected function get_headers(): array {
		return [ 'x-api-key' => ( new Option( Settings::API_KEY_FIELD ) )->get() ];
	}

	/**
	 * @param string[] $body
	 *
	 * @return Endpoint
	 */
	public function set_body( array $body ): Endpoint {
		$this->body = $body;

		return $this;
	}

	/**
	 * @return string[]
	 */
	abstract public function request(): array;

}