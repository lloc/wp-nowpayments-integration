<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Logs;

use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\JsonFormatter;
use Monolog\LogRecord;

class StructuredLogsFormatter extends JsonFormatter implements FormatterInterface {

	/**
	 * @param LogRecord $record
	 *
	 * @return string
	 */
	public function format( LogRecord $record ): string {
		$record->extra['site_url'] = site_url();
		$record->extra['user_id']  = get_current_user_id();

		return parent::format( $record );
	}
}
