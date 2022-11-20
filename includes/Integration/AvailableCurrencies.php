<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class AvailableCurrencies extends Endpoint {

	/**
	 * @return string[]
	 */
	public function get(): array {
		$result = wp_cache_get( __METHOD__ );

		if ( false === $result ) {
			$response = $this->client->get( 'v1/currencies', [], $this->get_headers() );

			$result = $response->get();
			wp_cache_set( __METHOD__, $result );
		}

		return $result;
	}

	/**
	 * @param string $currency
	 *
	 * @return bool
	 */
	public function is_available( string $currency ): bool {
		$result     = $this->get();
		$currencies = $result[ 'currencies' ] ?? [];

		return in_array( $currency, $currencies );
	}

}