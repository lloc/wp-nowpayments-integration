<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

use lloc\Nowpayments\Option;
use lloc\Nowpayments\Settings;


class Endpoint {

	/**
	 * @var Client
	 */
	protected Client $client;

	/**
	 * @var string[]
	 */
	private array $header = [];

	/**
	 * @var string[]
	 */
	private array $body = [];

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
		$header =  [ 'x-api-key' => ( new Option( Settings::API_KEY_FIELD ) )->get() ];

		return array_merge( $header, $this->header );
	}

	/**
	 * @param array<string, mixed> $params
	 *
	 * @return $this
	 */
	protected function set_header( array $params ): self {
		$this->header = filter_var_array( $params, FILTER_SANITIZE_STRING );

		return $this;
	}

	/**
	 * @return string[]
	 */
	protected function get_body(): array {
		return $this->body;
	}

	/**
	 * @param array<string, mixed> $params
	 *
	 * @return $this
	 */
	protected function set_body( array $params ): self {
		$this->body = filter_var_array( $params, FILTER_SANITIZE_STRING );

		return $this;
	}

	/**
	 * @param string $name
	 * @param string[] $arguments
	 *
	 * @return mixed
	 */
	public function __call( string $name, array $arguments ) {
		throw new \BadMethodCallException( sprintf( 'Method %s::%s does not exist.', __CLASS__, $name ) );
	}

}