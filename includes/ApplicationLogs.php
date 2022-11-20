<?php declare( strict_types=1 );

namespace lloc\Nowpayments;

use Monolog\Formatter\JsonFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ApplicationLogs {

	protected Logger $logger;

	const NAME = 'wp-nowpayments-integration-logs';

	public function __construct() {
		$formatter = new JsonFormatter();

		$stream_handler = new StreamHandler( "php://stdout", Logger::DEBUG );
		$stream_handler->setFormatter( $formatter );

		$this->logger = new Logger( self::NAME );
		$this->logger->pushHandler( $stream_handler );
	}

	/**
	 * @param string $url
	 * @param array<string, mixed> $arguments
	 *
	 * @return void
	 */
	public function pre_http_filter_debug( string $url, array $arguments ): void {
		$message = sprintf( 'pre_http_request-filter-debug for %s', esc_url( $url ) );

		$this->logger->info( $message, $arguments );
	}

}