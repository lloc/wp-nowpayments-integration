<?php declare( strict_types=1 );

namespace lloc\Nowpayments;

class OptionsPage {

	public const PAGE       = 'nowpayments_page';
	public const PAGE_TITLE = 'Nowpayments Settings';
	public const MENU_TITLE = 'Nowpayments';
	public const CAPABILITY = 'manage_options';
	public const SETTING    = 'nowpayments_settings';

	public static function init(): void {
		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
	}

	public static function admin_menu(): void {
		add_options_page(
			self::PAGE_TITLE,
			self::MENU_TITLE,
			self::CAPABILITY,
			Plugin::SLUG,
			array(
				__CLASS__,
				'render_page',
			)
		);
	}

	public static function render_page(): void {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			return;
		}

		self::add_settings_error( $_GET );

		echo '<div class="wrap">', PHP_EOL;
		printf( '<h1>%s</h1>', esc_html( get_admin_page_title() ) );
		echo PHP_EOL, '<form action="', esc_url( admin_url( 'options.php' ) ), '" method="post">', PHP_EOL;

		settings_fields( Settings::OPTION_GROUP );
		do_settings_sections( self::PAGE );

		submit_button( __( 'Save Settings', 'wp-nowpayments-integration' ) );

		echo '</form>', PHP_EOL;
		echo '</div>', PHP_EOL;
	}

	/**
	 * @param array<string, mixed> $arr
	 *
	 * @return bool
	 */
	public static function add_settings_error( array $arr ): bool {
		if ( isset( $arr['settings-updated'] ) ) {
			$message = __( 'Settings Saved', 'wp-nowpayments-integration' );

			add_settings_error( self::SETTING, esc_attr( 'settings_updated' ), $message, 'updated' );

			return true;
		}

		return false;
	}
}
