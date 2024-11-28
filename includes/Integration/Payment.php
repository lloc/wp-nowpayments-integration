<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class Payment extends Endpoint {

	public const ADDITIONAL_PARAMS = array(
		'pay_amount',
		'ipn_callback_url',
		'order_id',
		'order_description',
		'purchase_id',
		'payout_address',
		'payout_currency',
		'payout_extra_id',
		'case',
	);

	/**
	 * @param float                $price_amount
	 * @param string               $price_currency
	 * @param string               $pay_currency
	 * @param array<string, mixed> $optional_params
	 *
	 * @return Endpoint
	 */
	public function set( float $price_amount, string $price_currency, string $pay_currency, array $optional_params = array() ): Endpoint {
		$this->set_header( array( 'Content-Type' => 'application/json' ) );

		$args = array(
			'amount'        => $price_amount,
			'currency_from' => $price_currency,
			'currency_to'   => $pay_currency,
		);

		foreach ( $optional_params as $key => $value ) {
			if ( 'pay_amount' === $key ) {
				$args['pay_amount'] = filter_var( $optional_params['pay_amount'], FILTER_SANITIZE_NUMBER_FLOAT );
			} elseif ( 'ipn_callback_url' === $key ) {
				$args['ipn_callback_url'] = filter_var( $optional_params['ipn_callback_url'], FILTER_SANITIZE_URL );
			} elseif ( in_array( $key, self::ADDITIONAL_PARAMS ) ) {
				$args[ $key ] = filter_var( $value, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
			}
		}

		return $this->set_body( $args );
	}

	/**
	 * @return string[]
	 */
	public function post(): array {
		$response = $this->client->post(
			EndpointMethods::Payment->value,
			$this->get_body(),
			$this->get_headers()
		);

		return $response->get();
	}
}
