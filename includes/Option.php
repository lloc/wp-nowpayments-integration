<?php declare( strict_types=1 );

namespace lloc\Nowpayments;

class Option {

	public string $value;

	public const OPTION_NAME = 'nowpayments_option';

	/**
	 * @param string $key
	 */
	public function __construct( string $key ) {
		$options = get_option( self::OPTION_NAME );

		$this->value = $options[ $key ] ?? '';
	}

	/**
	 * @return string
	 */
	public function get(): string {
		return $this->value;
	}

}