<?php declare( strict_types=1 );

namespace lloc\Nowpayments;

use lloc\Nowpayments\Integration\ApiStatus;
use lloc\Nowpayments\Rest\Client;
use lloc\Nowpayments\Rest\Service;
use lloc\Nowpayments\ApplicationLogs;

class Plugin {

	public const SLUG = 'nowpayments';
	public const LANGUAGE_DIR = 'languages';

	private string $file;
	private ApplicationLogs $logs;

	/**
	 * @param string $file
	 *
	 * @return Plugin
	 */
	public static function init( string $file ): Plugin {
		$logs   = new ApplicationLogs();
		$plugin = new self( $file, $logs );

		add_action( 'plugins_loaded', [ $plugin, 'plugins_loaded' ] );
		add_action( 'admin_menu', [ OptionsPage::class, 'admin_menu' ] );
		add_action( 'admin_init', [ Settings::class, 'admin_init' ] );
		add_action( 'wp_dashboard_setup', [ $plugin, 'wp_dashboard_setup' ] );
		add_action( 'widgets_init', [ $plugin, 'widgets_init' ] );
		add_action( 'init', [ $plugin, 'block_init' ] );

		add_filter( 'pre_http_request', [ $plugin, 'pre_http_request' ] , 10, 3 );

		add_shortcode( 'sc_nowpayments_widget', [ __CLASS__, 'block_render' ] );

		return $plugin;
	}

	/**
	 * @param string $file
	 */
	public function __construct( string $file, ApplicationLogs $logs ) {
		$this->file = $file;
		$this->logs = $logs;
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
		$status  = new ApiStatus( $client );

		return AdminWidget::create( $status );
	}

	/**
	 * @return int
	 */
	public function widgets_init(): int {
		register_widget( Widget::class );

		return 1;
	}

	/**
	 * @return bool
	 */
	public function block_init(): bool {
		if ( ! function_exists( 'register_block_type' ) ) {
			return false;
		}

		$handle = 'nowpayments-widget-block';

		wp_register_script(
			$handle,
			$this->plugins_url( 'js/widget-block.js' ),
			[ 'wp-blocks', 'wp-element', 'wp-components', 'wp-editor' ]
		);

		register_block_type( 'lloc/nowpayments-widget-block', [
			'attributes'      => [ 'title' => [ 'type' => 'string' ] ],
			'editor_script'   => $handle,
			'render_callback' => [__CLASS__, 'block_render' ],
		] );

		return true;
	}

	/**
	 * @return string
	 */
	public static function block_render(): string {
		ob_start();
		the_widget( Widget::class );
		return ob_get_clean();
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
	function pre_http_request( $preempt, $parsed_args, $url ) {
		$this->logs->pre_http_filter_debug( $url, $parsed_args );

		return $preempt;
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