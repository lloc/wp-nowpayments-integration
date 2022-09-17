<?php

namespace lloc\Nowpayments;


class Plugin {

	public const LANGUAGE_DIR = 'languages';

	private string $file;

	/**
	 * @param string $file
	 */
	public static function init( string $file ): void {
		$plugin = new self( $file );

		add_action( 'plugins_loaded', [ $plugin, 'plugins_loaded' ] );
		add_action( 'admin_menu', [ OptionsPage::class, 'admin_menu' ] );
		add_action( 'admin_init', [ Settings::class, 'admin_init' ] );
	}

	/**
	 * @param string $file
	 */
	public function __construct( string $file ) {
		$this->file = $file;
	}

	/**
	 * Loads text domain
	 *
	 * @return bool
	 */
	public function plugins_loaded(): bool {
		return load_plugin_textdomain( 'wp-nowpayments-integration', false, $this->dirname( self::LANGUAGE_DIR ) );
	}

	/**
	 * @param string $path
	 *
	 * @return string
	 */
	public function dirname( string $path ): string {
		return $this->path() . trailingslashit( $path );
	}

	/**
	 * @return string
	 */
	public function path(): string {
		return plugin_dir_path( $this->file );
	}

	/**
	 * @return string
	 */
	public function url(): string {
		return plugin_dir_url( $this->file );
	}

}