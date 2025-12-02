<?php declare( strict_types=1 );

namespace lloc\Nowpayments;

class Plugin {

	public const SLUG         = 'nowpayments';

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

		add_action( 'init', array( $plugin, 'block_init' ) );

		return $plugin;
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
