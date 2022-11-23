<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Logs;

use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\JsonFormatter;

class StructuredLogsFormatter extends JsonFormatter implements FormatterInterface {

	/**
	 * @param array<string, mixed> $record
	 *
	 * @return string
	 */
	public function format( array $record ): string {
		$record['siteUrl'] = site_url();
		$record['userId']  = function_exists( 'wp_get_current_user' ) ? wp_get_current_user()->ID : 0;

		return parent::format( $record );
	}

}
