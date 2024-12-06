<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

interface EndpointPostInterface extends EndpointInterface {

	/**
	 * @return ResponseInterface
	 */
	public function post(): ResponseInterface;
}
