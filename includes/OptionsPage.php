<?php

namespace lloc\Nowpayments;

class OptionsPage {

	public const PAGE = 'nowpayments_page';
	public const PAGE_TITLE = 'Nowpayments Settings';
	public const MENU_TITLE = 'Nowpayments';
	public const CAPABILITY = 'manage_options';
	public const MENU_SLUG = 'nowpayments_settings';
	public const SETTING = 'nowpayments_settings';
	public const CODE = 'nowpayments_code';


	/**
	 * Callback entry-point
	 *
	 * @return string|false
	 */
	public static function admin_menu() {
		return add_options_page( self::PAGE_TITLE, self::MENU_TITLE, self::CAPABILITY, self::MENU_SLUG, [
			__CLASS__,
			'render_page'
		] );
	}

	public static function render_page(): void {
		if ( ! current_user_can( self::CAPABILITY ) ) {
			return;
		}

		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( '', esc_attr( 'settings_updated' ), __( 'Settings Saved', 'wp-nowpayments-integration' ), 'updated' );
		}

		//settings_errors( 'wporg_messages' );

		echo '<div class="wrap">', PHP_EOL;
		printf( '<h1>%s</h1>', esc_html( get_admin_page_title() ) );
		echo PHP_EOL, '<form action="', admin_url( 'options.php' ), '" method="post">', PHP_EOL;

		settings_fields( Settings::OPTION_GROUP );
		do_settings_sections( self::PAGE );
		submit_button( 'Save Settings' );

		echo '</form>', PHP_EOL;
		echo '</div>', PHP_EOL;
	}

}