<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\EndpointInterface;

interface ApiStatusInterface extends EndpointInterface {


	/**
	 * @return string[]
	 */
	public function get(): array;
}
