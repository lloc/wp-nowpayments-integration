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
		$record['site_url'] = site_url();
		$record['user_id']  = get_current_user_id();

		return parent::format( $record );
	}

}
