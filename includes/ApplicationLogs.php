<?php declare( strict_types=1 );

namespace lloc\Nowpayments;

use Monolog\Formatter\JsonFormatter;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class ApplicationLogs {

	protected Logger $logger;

	const NAME = 'wp-nowpayments-integration-logs';

	public function __construct( Logger $logger ) {
		$this->logger = $logger;
	}

	/**
	 * Factory prepares logger and adds method to filter "pre_http_request"
	 *
	 * @return ApplicationLogs
	 *
	 * @codeCoverageIgnore
	 */
	public static function init(): ApplicationLogs {
		$formatter = new JsonFormatter();

		$stream_handler = new StreamHandler( "php://stdout", Logger::DEBUG );
		$stream_handler->setFormatter( $formatter );

		$logger = new Logger( self::NAME );
		$logger->pushHandler( $stream_handler );

		$obj = new self( $logger );

		add_filter( 'pre_http_request', [ $obj, 'pre_http_request' ] , 10, 3 );

		return $obj;
	}

	/**
	 * Function for `pre_http_request` filter-hook.
	 *
	 * @param mixed                $preempt     A preemptive return value of an HTTP request.
	 * @param array<string, mixed> $parsed_args HTTP request arguments.
	 * @param mixed                $url         The request URL.
	 *
	 * @return mixed
	 */
	public function pre_http_request( $preempt, array $parsed_args, $url ) {
		$message = sprintf( 'pre_http_request-filter-debug for %s', esc_url( $url ) );

		$this->logger->debug( $message, $parsed_args );

		return $preempt;
	}

}