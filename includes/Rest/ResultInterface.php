<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Rest;

interface ResultInterface {

	/**
	 * @return string[]
	 */
	public function get(): array;
}
