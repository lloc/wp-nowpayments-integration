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
	protected function get_data(): array {
		$response = wp_cache_get( __METHOD__ );

		if ( false === $response ) {
			$result   = $this->available_currencies->get();
			$response = $result->get();

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
		$currencies = $this->get_data()['currencies'] ?? array();

		return in_array( $currency, $currencies );
	}
}
