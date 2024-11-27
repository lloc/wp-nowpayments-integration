<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Logs;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class LogFactory {

	const NAME = 'wp-nowpayments-integration-logs';

	/**
	 * @return Logger
	 */
	public static function get_logger(): Logger {
		$formatter = new StructuredLogsFormatter();

		$debug_handler = new StreamHandler( 'php://stdout', Logger::DEBUG );
		$debug_handler->setFormatter( $formatter );

		$error_handler = new StreamHandler( 'php://stderr', Logger::NOTICE );
		$error_handler->setFormatter( $formatter );

		$logger = new Logger( self::NAME );
		$logger->pushHandler( $debug_handler );
		$logger->pushHandler( $error_handler );

		return $logger;
	}
}
