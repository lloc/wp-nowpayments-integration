<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

interface EndpointGetInterface extends EndpointInterface {


	/**
	 * @return ResponseInterface
	 */
	public function get(): ResponseInterface;
}
