<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

interface ResponseInterface {

	/**
	 * @return string[]
	 */
	public function get(): array;
}
