<?php declare( strict_types=1 );

namespace lloc\Nowpayments;

class Settings {

	public const OPTION_GROUP   = 'nowpayments_group';
	public const API_SECTION_ID = 'api_section_id';
	public const API_KEY_FIELD  = 'api_key';

	public static function init(): void {
		add_action( 'admin_init', array( __CLASS__, 'admin_init' ) );
	}

	public static function admin_init(): void {
		register_setting(
			self::OPTION_GROUP,
			Option::OPTION_NAME,
			array( 'sanitize_callback' => array( __CLASS__, 'sanitize_text_field' ) )
		);

		add_settings_section(
			self::API_SECTION_ID,
			__( 'API settings', 'wp-nowpayments-integration' ),
			array( __CLASS__, 'render_section' ),
			OptionsPage::PAGE
		);

		$cta  = __( 'Sign up at nowpayments.io', 'wp-nowpayments-integration' );
		$link = sprintf( '<a href="https://nowpayments.io/?link_id=3530618365">%s</a>', $cta );

		/* translators: %s: link */
		$format = __( '%s, specify your outcome wallet, generate an API key and insert it in the above field.', 'wp-nowpayments-integration' );

		add_settings_field(
			self::API_KEY_FIELD,
			__( 'API key', 'wp-nowpayments-integration' ),
			array( __CLASS__, 'render_fields' ),
			OptionsPage::PAGE,
			self::API_SECTION_ID,
			array(
				'label_for'   => self::API_KEY_FIELD,
				'description' => sprintf( $format, $link ),
			)
		);

		do_action( 'nowpayments_settings_admin_init', OptionsPage::PAGE );
	}

	/**
	 * @param string[] $args
	 */
	public static function render_section( array $args ): void {
		$description = __( "Set here the API parameters for the site's connection to the Nowpayments API.", 'wp-nowpayments-integration' );

		printf(
			'<p id="%s">%s</p>',
			esc_attr( $args['id'] ), // 'id' is mandatory or 'add_settings_section'
			esc_html( $description )
		);
	}

	/**
	 * @param string[] $args
	 */
	public static function render_fields( array $args ): void {
		printf(
			'<input id="%1$s" name="%2$s[%1$s]" value="%3$s" class="regular-text code" />',
			esc_attr( $args['label_for'] ),
			esc_attr( Option::OPTION_NAME ),
			esc_attr( ( new Option( $args['label_for'] ) )->get() )
		);

		if ( isset( $args['description'] ) ) {
			printf( '<p class="description">%s</p>', wp_kses_post( $args['description'] ) );
		}
	}

	/**
	 * @param array<string, string|null> $fields
	 *
	 * @return array<string, string|null>
	 */
	public static function sanitize_text_field( array $fields ): array {
		$value = $fields[ self::API_KEY_FIELD ] ?? '';

		return array( self::API_KEY_FIELD => preg_replace( '/[^A-Z0-9-]/', '', $value ) );
	}
}
