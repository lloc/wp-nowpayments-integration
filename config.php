<?php declare( strict_types=1 );

use lloc\Nowpayments\AdminWidget;
use lloc\Nowpayments\Logs\StructuredLogsFormatter;
use lloc\Nowpayments\Rest\Api;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;

use Psr\Log\LogLevel;
use Psr\Log\LoggerInterface;
use Psr\Container\ContainerInterface;

use function DI\create;
use function DI\get;
use function DI\factory;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

return array(
	'formatter'            => create( StructuredLogsFormatter::class ),
	'debug_handler'        => create( StreamHandler::class )
		->constructor( 'php://stdout', LogLevel::DEBUG )
		->method( 'setFormatter', get( 'formatter' ) ),
	'error_handler'        => create( StreamHandler::class )
		->constructor( 'php://stderr', LogLevel::ERROR )
		->method( 'setFormatter', get( 'formatter' ) ),
	LoggerInterface::class => function ( ContainerInterface $c ) {
		$logger = new Logger( 'wp-nowpayments-integration-logs' );
		$logger->pushHandler( $c->get( 'debug_handler' ) );
		$logger->pushHandler( $c->get( 'error_handler' ) );

		return $logger;
	},
	Api::class             => factory( array( Api::class, 'create' ) ),
	AdminWidget::class     => factory( array( AdminWidget::class, 'create' ) ),
);
