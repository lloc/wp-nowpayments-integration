<?php declare( strict_types=1 );

namespace lloc\Nowpayments;

use lloc\Nowpayments\Integration\Status;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Service;

class Plugin {

	public const SLUG = 'nowpayments';
	public const LANGUAGE_DIR = 'languages';

	private string $file;

	/**
	 * @param string $file
	 *
	 * @return Plugin
	 */
	public static function init( string $file ): Plugin {
		$plugin = new self( $file );

		add_action( 'plugins_loaded', [ $plugin, 'plugins_loaded' ] );
		add_action( 'admin_menu', [ OptionsPage::class, 'admin_menu' ] );
		add_action( 'admin_init', [ Settings::class, 'admin_init' ] );
		add_action( 'wp_dashboard_setup', [ $plugin, 'wp_dashboard_setup' ] );

		return $plugin;
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
	 * @return AdminWidget
	 */
	public static function wp_dashboard_setup(): AdminWidget {
		$service = Service::create();
		$client  = new Client( $service );
		$status  = new Status( $client );

		return AdminWidget::create( $status );
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