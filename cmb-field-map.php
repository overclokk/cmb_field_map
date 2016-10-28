<?php
/**
 * Plugin Name: CMB2 Field Type: Google Maps
 * Plugin URI: https://github.com/mustardBees/cmb_field_map
 * GitHub Plugin URI: https://github.com/mustardBees/cmb_field_map
 * Description: Google Maps field type for CMB2.
 * Version: 2.1.2
 * Author: Phil Wylie
 * Author URI: http://www.philwylie.co.uk/
 * License: GPLv2+
 */

if ( ! defined( 'PW_CMB2_PLUGIN_PATH' ) ) {
	define( 'PW_CMB2_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
}

/**
 * Example: 'http://192.168.1.10/italystrap/wp-content/plugins/italystrap-extended/'
 */
if ( ! defined( 'PW_CMB2_PLUGIN_URL' ) ) {
	define( 'PW_CMB2_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * Example = italystrap-extended/italystrap.php
 */
if ( ! defined( 'PW_CMB2_BASENAME' ) ) {
	define( 'PW_CMB2_BASENAME', plugin_basename( __FILE__ ) );
}

require( PW_CMB2_PLUGIN_PATH . 'bootstrap.php' );
