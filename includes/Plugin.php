<?php

namespace lloc\Nowpayments;


class Plugin {

	public const LANGUAGE_DIR = '/languages/';

	/**
	 * Provides the plugin's entry point
	 */
	public function add_hooks(): void {
		add_action( 'plugins_loaded', [ $this, 'plugins_loaded' ] );
	}

	/**
	 * Loads text domain
	 * @return bool
	 */
	public static function plugins_loaded(): bool {
		return load_plugin_textdomain( 'wp-nowpayments-integration', false, self::dirname( self::LANGUAGE_DIR ) );
	}

	/**
	 * @param string $path
	 *
	 * @return string
	 */
	public static function dirname( string $path ): string {
		return dirname( self::path() ) . $path;
	}

	/**
	 * @return string
	 */
	public static function path(): string {
		return defined( 'WP_NOWPAYMENTS_INTEGRATION_PATH' ) ? constant( 'WP_NOWPAYMENTS_INTEGRATION_PATH' ) : '';
	}

	/**
	 * @return string
	 */
	public static function url(): string {
		return defined( 'WP_NOWPAYMENTS_INTEGRATION_URL' ) ? constant( 'WP_NOWPAYMENTS_INTEGRATION_URL' ) : '';
	}

}