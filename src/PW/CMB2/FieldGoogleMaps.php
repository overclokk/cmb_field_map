<?php
/**
 * [Short Description (no period for file headers)]
 *
 * [Long Description.]
 *
 * @link [URL]
 * @since [x.x.x (if available)]
 *
 * @package [Plugin/Theme/Etc]
 */

/**
 * Class PW_CMB2_Field_Google_Maps
 */
class PW_CMB2_FieldGoogleMaps {

	/**
	 * Current version number
	 */
	const VERSION = '2.1.1';

	/**
	 * Google API key
	 *
	 * @var string
	 */
	private $api_key = '';

	/**
	 * Google maps API URL
	 *
	 * @var string
	 */
	private $api_url = '';

	/**
	 * Initialize the plugin by hooking into CMB2
	 */
	/**
	 * Init the constructor
	 *
	 * @param string $api_key The google maps API key
	 */
	public function __construct( $api_key = null, $plugin_url = null ) {

		$this->api_url = '//maps.googleapis.com/maps/api/js?libraries=places';
		$this->api_key = isset( $api_key ) ? '&key=' . $api_key : '';
		$this->plugin_url = $plugin_url;
	}

	/**
	 * Render field
	 *
	 * @param  [type] $field               [description]
	 * @param  [type] $field_escaped_value [description]
	 * @param  [type] $field_object_id     [description]
	 * @param  [type] $field_object_type   [description]
	 * @param  [type] $field_type_object   [description]
	 *
	 * @return [type]                      [description]
	 */
	public function render( $field, $field_escaped_value, $field_object_id, $field_object_type, $field_type_object ) {

		$this->setup_admin_scripts();

		$output = '';

		$output .= sprintf(
			'<input type="text" class="large-text pw-map-search" id="%s" />',
			$field->args( 'id' )
			);

		$output .= '<div class="pw-map"></div>';

		$output .= $field_type_object->input( array( // XSS ok.
			'type'       => 'hidden',
			'name'       => $field->args( '_name' ) . '[latitude]',
			'value'      => isset( $field_escaped_value['latitude'] ) ? $field_escaped_value['latitude'] : '',
			'class'      => 'pw-map-latitude',
			'desc'       => '',
			)
		);
		$output .= $field_type_object->input( array( // XSS ok.
			'type'       => 'hidden',
			'name'       => $field->args( '_name' ) . '[longitude]',
			'value'      => isset( $field_escaped_value['longitude'] ) ? $field_escaped_value['longitude'] : '',
			'class'      => 'pw-map-longitude',
			'desc'       => '',
			)
		);

		echo $output;
		$field_type_object->_desc( true, true );
	}

	/**
	 *  Optionally save the latitude/longitude values into two custom fields
	 *
	 * @param  [type] $override_value [description]
	 * @param  [type] $value          [description]
	 * @param  [type] $object_id      [description]
	 * @param  [type] $field_args     [description]
	 *
	 * @return [type]                 [description]
	 */
	public function sanitize( $override_value, $value, $object_id, $field_args ) {

		if ( isset( $field_args['split_values'] ) && $field_args['split_values'] ) {
			if ( ! empty( $value['latitude'] ) ) {
				update_post_meta( $object_id, $field_args['id'] . '_latitude', $value['latitude'] );
			}

			if ( ! empty( $value['longitude'] ) ) {
				update_post_meta( $object_id, $field_args['id'] . '_longitude', $value['longitude'] );
			}
		}

		return $value;
	}

	/**
	 * Enqueue scripts and styles
	 */
	public function setup_admin_scripts() {
		wp_register_script(
			'pw-google-maps-api',
			$this->api_url . $this->api_key,
			null,
			null
		);
		// wp_enqueue_script( 'pw-google-maps', plugins_url( 'js/script.js', __FILE__ ), array( 'pw-google-maps-api' ), self::VERSION );
		// wp_enqueue_style( 'pw-google-maps', plugins_url( 'css/style.css', __FILE__ ), array(), self::VERSION );

		// $plugin_url = wp_normalize_path( __DIR__ );
		// $this->plugin_url = wp_normalize_path( __DIR__ );

		// wp_register_script( 'pw-google-maps-api', '//maps.googleapis.com/maps/api/js?libraries=places', null, null );
		wp_enqueue_script( 'pw-google-maps', $this->plugin_url . '/js/script.js', array( 'pw-google-maps-api' ), self::VERSION );
		wp_enqueue_style( 'pw-google-maps', $this->plugin_url . '/css/style.css', array(), self::VERSION );
	}
}
