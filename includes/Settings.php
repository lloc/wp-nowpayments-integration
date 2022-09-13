<?php

namespace lloc\Nowpayments;

use TDP\OptionsKit;

class Settings {

	public const SLUG = 'nowpayments';

	public function __construct() {
		$panel  = new OptionsKit( self::SLUG );
		$panel->set_page_title( __( 'Nowpayments Settings', 'wp-nowpayments-integration' ) );
	}

	public function add_hooks(): void {
		add_filter( 'nowpayments_menu', [ $this, 'setup_menu' ] );
		add_filter( 'nowpayments_settings_tabs', [ $this, 'register_settings_tabs' ] );
		add_filter( 'nowpayments_registered_settings', [ $this, 'register_settings' ] );
	}

	/**
	 * @param array $menu
	 *
	 * @return array
	 */
	function setup_menu( array $menu ): array {
		$menu['page_title'] = __( 'Nowpayments', 'wp-nowpayments-integration' );
		$menu['menu_title'] = $menu['page_title'];

		return $menu;
	}

	/**
	 * @param array $tabs
	 *
	 * @return array
	 */
	function register_settings_tabs( array $tabs ): array {
		return [
			'general' => __( 'General', 'wp-nowpayments-integration' ),
		];
	}

	/**
	 * @param array $settings
	 *
	 * @return array
	 */
	function register_settings( array $settings ): array {
		return [
			'general' => [
				[
					'id'   => 'api_key',
					'name' => __( 'API Key', 'wp-nowpayments-integration' ),
					'desc' => __( 'Add your API key to get started', 'wp-nowpayments-integration' ),
					'type' => 'text',
				],
			]
		];
	}

}