<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Integration;

use lloc\Nowpayments\Rest\Endpoint;

class Payment extends Endpoint {

	/**
	 * @param float $price_amount
	 * @param string $price_currency
	 * @param string $pay_currency
	 *
	 * @return Endpoint
	 */
	public function set( float $price_amount, string $price_currency, string $pay_currency ): Endpoint {
		$this->set_header( [ 'Content-Type' => 'application/json' ] );

		/**
		pay_amount (optional) - price in cryptocurrency
		ipn_callback_url (optional) - url to receive callbacks, should contain "http" or "https", eg. "https://nowpayments.io"
		order_id (optional) - inner store order ID, e.g. "RGDBP-21314"
		order_description (optional) - inner store order description, e.g. "Apple Macbook Pro 2019 x 1"
		purchase_id (optional) - id of purchase for which you want to create aother payment, only used for several payments for one order
		payout_address (optional) - in case you want to receive funds on an external address, you can specify it in this parameter
		payout_currency (optional) - currency of your external payout_address, required when payout_adress is specified.
		payout_extra_id(optional) - extra id or memo or tag for external payout_address.
		case(optional) - case which you want to test.
		*/

		$args = [
			'amount'        => $price_amount,
			'currency_from' => $price_currency,
			'currency_to'   => $pay_currency,
		];

		return $this->set_body( $args );
	}

	/**
	 * @return string[]
	 */
	public function post(): array {
		$response = $this->client->post( 'v1/payment', $this->get_body(), $this->get_headers() );

		return $response->get();
	}
}