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
 * Filter the Google API Key
 * @example add_filter( 'pw_cmb2_google_maps_api_key', function () { return 'my_api_key'; } );
 *
 * @var string
 */
$api_key = apply_filters( 'pw_cmb2_google_maps_api_key', '' );

$plugin_url = PW_CMB2_PLUGIN_URL;

$default_maps_config = array(
	'lat_base'		=> 0,
	'lng_base'		=> 0,
	'zoom_base'		=> 5,
	'zoom'			=> 17,
	'marker_title'	=> __( 'Drag to set the exact location', 'pw_cmb2_google_maps' )
);

$maps_config = wp_parse_args( apply_filters( 'pw_cmb2_google_maps_config', array() ), $default_maps_config );

/**
 * Instance of new Google Maps Field
 *
 * @var PW_CMB2_FieldGoogleMaps
 */
$pw_cmb2_field_google_maps = new PW_CMB2_FieldGoogleMaps( $api_key, PW_CMB2_PLUGIN_URL, $maps_config );
add_action( 'cmb2_render_pw_map',
	array( $pw_cmb2_field_google_maps, 'render' ), 10, 5 );
add_filter( 'cmb2_sanitize_pw_map',
	array( $pw_cmb2_field_google_maps, 'sanitize' ), 10, 5 );
