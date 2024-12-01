<?php declare( strict_types=1 );

namespace lloc\Nowpayments;

use lloc\Nowpayments\Integration\ApiStatus;
use lloc\Nowpayments\Logs\ApplicationLogs;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Service;

class Plugin {

	public const SLUG         = 'nowpayments';
	public const LANGUAGE_DIR = 'languages';

	/**
	 * @param string $file
	 */
	public function __construct(
		private readonly string $file
	) { }

	/**
	 * @param string $file
	 *
	 * @return Plugin
	 */
	public static function init( string $file ): Plugin {
		$plugin = new self( $file );

		add_action( 'plugins_loaded', array( $plugin, 'plugins_loaded' ) );
		add_action( 'admin_menu', array( OptionsPage::class, 'admin_menu' ) );
		add_action( 'admin_init', array( Settings::class, 'admin_init' ) );
		add_action( 'wp_dashboard_setup', array( $plugin, 'wp_dashboard_setup' ) );
		add_action( 'widgets_init', array( $plugin, 'widgets_init' ) );
		add_action( 'init', array( $plugin, 'block_init' ) );

		add_shortcode( 'sc_nowpayments_widget', array( __CLASS__, 'block_render' ) );

		return $plugin;
	}

	/**
	 * Loads text domain
	 *
	 * @return void
	 */
	public function plugins_loaded(): void {
		load_plugin_textdomain( 'wp-nowpayments-integration', false, $this->dirname( self::LANGUAGE_DIR ) );
	}

	/**
	 * Creates the dashboard widget
	 *
	 * @return void
	 */
	public static function wp_dashboard_setup(): void {
		$service = Service::create();
		$client  = new Client( $service );
		$status  = new ApiStatus( $client );

		AdminWidget::create( $status );
	}

	public function widgets_init(): void {
		register_widget( FrontendWidget::class );
	}

	public function block_init(): void {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		$handle = 'nowpayments-widget-block';

		wp_register_script(
			$handle,
			$this->plugins_url( 'src/widget-block.js' ),
			array( 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ),
			constant( 'NOWPAYMENTS_PLUGIN_VERSION' ),
			true
		);

		register_block_type(
			'lloc/nowpayments-widget-block',
			array(
				'attributes'      => array( 'title' => array( 'type' => 'string' ) ),
				'editor_script'   => $handle,
				'render_callback' => array( __CLASS__, 'block_render' ),
			)
		);
	}

	/**
	 * @return string
	 */
	public static function block_render(): string {
		ob_start();
		the_widget( FrontendWidget::class );
		return (string) ob_get_clean();
	}

	/**
	 * @param string $path
	 *
	 * @return string
	 */
	public function plugins_url( string $path ): string {
		return plugins_url( $path, $this->file );
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
