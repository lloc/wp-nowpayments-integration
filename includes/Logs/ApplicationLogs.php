<?php declare( strict_types=1 );

namespace lloc\Nowpayments\Logs;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;

class ApplicationLogs {

	/**
	 * @param LoggerInterface $logger
	 */
	private function __construct(
		protected readonly LoggerInterface $logger
	) { }

	/**
	 * Adds filter "pre_http_request" to ApplicationLogs-object
	 *
	 * @param LoggerInterface $logger
	 *
	 * @return ApplicationLogs
	 */
	public static function init( LoggerInterface $logger ): ApplicationLogs {
		$obj = new self( $logger );

		/**
		 * Fires after an HTTP API response is received and before the response is returned.
		 */
		add_action( 'http_api_debug', array( $obj, 'http_api_debug' ), 10, 5 );

		return $obj;
	}

	/**
	 * Callback for `http_api_debug`-action
	 *
	 * @param mixed    $response    HTTP response or WP_Error object.
	 * @param string   $context     Context under which the hook is fired.
	 * @param string   $transport   HTTP transport used.
	 * @param string[] $parsed_args HTTP request arguments.
	 * @param string   $url         The request URL.
	 *
	 * @return void
	 */
	public function http_api_debug( $response, string $context, string $transport, array $parsed_args, string $url ): void {
		if ( is_wp_error( $response ) ) {
			$log_level = LogLevel::NOTICE;
			$message   = $response->get_error_message();
		} else {
			$log_level = LogLevel::DEBUG;
			$message   = sprintf( '%s-debug for %s', __FUNCTION__, esc_url( $url ) );
		}

		$this->logger->log( $log_level, $message, $parsed_args );
	}
}
