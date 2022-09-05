<?php

/**
 * WordPress nowpayments.io integration
 *
 * @copyright Copyright (C) 2022, Dennis Ploetner, re@lloc.de
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU General Public License, version 2 or later
 * @wordpress-plugin
 *
 * Plugin Name: WordPress nowpayments.io integration
 * Version: 1.0
 * Plugin URI: https://github.com/lloc/wp-nowpayments-itegration
 * Description: Cryptocurrency Payment integration using the NOWPayments API
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

// @codeCoverageIgnoreStart
if ( function_exists( 'add_action' ) && ! defined( 'WP_NOWPAYMENTS_INTEGRATION_PATH' ) ) {
	 define( 'WP_NOWPAYMENTS_INTEGRATION_PATH', plugin_dir_path( __FILE__ ) );

	add_action( 'plugins_loaded', function () {
		( new lloc\NowpaymentsIntegration\Plugin() )->add_hooks();
	} );
}
// @codeCoverageIgnoreEnd
