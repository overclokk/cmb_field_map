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

$api_key = '';
$plugin_url = PW_CMB2_PLUGIN_URL;
$maps_config = array(
	'lat_base'		=> 54.800685,
	'lng_base'		=> -4.130859,
	'zoom_base'		=> 5,
	'zoom'			=> 17,
	'marker_title'	=> __( 'Drag to set the exact location', 'pw_cmb2_google_maps' )
);

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
