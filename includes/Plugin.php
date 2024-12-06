<?php declare( strict_types=1 );

namespace lloc\Nowpayments;

class Plugin {

	public const SLUG         = 'nowpayments';
	public const LANGUAGE_DIR = 'languages';

	/**
	 * @param string $file
	 */
	private function __construct(
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
		add_action( 'init', array( $plugin, 'block_init' ) );

		return $plugin;
	}

	/**
	 * @return void
	 */
	public function plugins_loaded(): void {
		load_plugin_textdomain( 'wp-nowpayments-integration', false, $this->dirname( self::LANGUAGE_DIR ) );
	}

	public function block_init(): void {
		if ( ! function_exists( 'register_block_type' ) ) {
			return;
		}

		$path = $this->dirname( 'js/wp-nowpayments-integration-block' );

		register_block_type( $path );
	}

	/**
	 * @param string $path
	 *
	 * @return string
	 */
	public function dirname( string $path ): string {
		return plugin_dir_path( $this->file ) . trailingslashit( $path );
	}

	/**
	 * @return string
	 */
	public function plugin_dir_url(): string {
		return plugin_dir_url( $this->file );
	}
}
