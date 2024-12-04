<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

interface MethodGetInterface {


	/**
	 * @return string[]
	 */
	public function get(): array;
}
