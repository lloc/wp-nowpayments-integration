<?php

namespace lloc\Nowpayments\Services;

use lloc\Nowpayments\Integration\AvailableCurrencies;

class AvailableCurrenciesService {

	public function __construct(
		private AvailableCurrencies $available_currencies
	) { }

	/**
	 * @return array<string, string[]>
	 */
	public function get_data(): array {
		$response = wp_cache_get( __METHOD__ );

		if ( false === $response ) {
			$result   = $this->available_currencies->get();
			$response = $result->get()['currencies'] ?? array();

			wp_cache_set( __METHOD__, $response );
		}

		return $response;
	}

	/**
	 * @param string $currency
	 *
	 * @return bool
	 */
	public function is_available( string $currency ): bool {
		return in_array( $currency, $this->get_data() );
	}
}
