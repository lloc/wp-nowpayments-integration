<?php
/**
 * WP Nowpayments Integration
 *
 * @copyright Copyright (C) 2022, Dennis Ploetner, re@lloc.de
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 or later
 * @wordpress-plugin
 *
 * Plugin Name: WP Nowpayments Integration
 * Version: 1.0.0
 * Requires at least: 6.6
 * Plugin URI: https://github.com/lloc/wp-nowpayments-itegration
 * Description: Cryptocurrency Payment integration using the NOWPayments API for WordPress.
 * Author: Dennis Ploetner
 * Author URI: https://ploetner.io/
 * Text Domain: wp-nowpayments-integration
 * Domain Path: /languages/
 * License: GPLv2 or later
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License, version 2, as
 * published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

declare( strict_types=1 );

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require __DIR__ . '/vendor/autoload.php';

defined( 'NOWPAYMENTS_PLUGIN_VERSION' ) || define( 'NOWPAYMENTS_PLUGIN_VERSION', '1.0.0' );

add_action(
	'plugins_loaded',
	function () {
		$builder = new DI\ContainerBuilder();
		$builder->addDefinitions( require __DIR__ . '/config.php' );
		$container = $builder->build();

		lloc\Nowpayments\Plugin::init( __FILE__ );
		lloc\Nowpayments\OptionsPage::init();
		lloc\Nowpayments\Settings::init();
		lloc\Nowpayments\AdminWidget::init( $container->get( lloc\Nowpayments\Services\ApiStatusService::class ) );
		lloc\Nowpayments\Logs\ApplicationLogs::init( $container->get( Psr\Log\LoggerInterface::class ) );
	}
);

add_filter( 'use_block_editor_for_post', '__return_true', 99 );
add_filter( 'use_block_editor_for_post_type', '__return_true', 99 );
