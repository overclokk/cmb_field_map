<?php
/**
 * Bootstrap file for cmb_field_map
 *
 * [Long Description.]
 *
 * @link [URL]
 * @since [x.x.x (if available)]
 *
 * @package [Plugin/Theme/Etc]
 */

/**
 * Require PHP autoload
 */
require( PW_CMB2_PLUGIN_PATH . 'vendor/autoload_52.php' );


/**
 * Instance of new Google Maps Field
 *
 * @var PW_CMB2_FieldGoogleMaps
 */
$pw_cmb2_field_google_maps = new PW_CMB2_FieldGoogleMaps( 'AIzaSyAukcQy3eDah9zhEKEwdBKnMbB1egGVpuM', PW_CMB2_PLUGIN_URL );
add_filter( 'cmb2_render_pw_map',
	array( $pw_cmb2_field_google_maps, 'render' ), 10, 5 );
add_filter( 'cmb2_sanitize_pw_map',
	array( $pw_cmb2_field_google_maps, 'sanitize' ), 10, 4 );
