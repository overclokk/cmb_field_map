<?php
/**
 * PW_CMB2_FieldGoogleMaps Class API
 *
 * Class for extending the CMB2 with Google Maps.
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
	 * Init the constructor
	 *
	 * @param string $api_key     The google maps API key.
	 * @param string $plugin_url  The plugin url for script and css.
	 * @param array  $maps_config Google Maps config array for javascript.
	 */
	public function __construct( $api_key = null, $plugin_url = null, array $maps_config = array() ) {

		$this->api_url = '//maps.googleapis.com/maps/api/js?libraries=places';
		$this->api_key = isset( $api_key ) ? '&key=' . $api_key : '';
		$this->plugin_url = $plugin_url;

		$this->maps_config = $maps_config;
	}

	/**
	 * Render field
	 *
	 * @param array  $field              The passed in `CMB2_Field` object.
	 * @param mixed  $escaped_value      The value of this field escaped.
	 *                                   It defaults to `sanitize_text_field`.
	 *                                   If you need the unescaped value,
	 *                                   you can access it via `$field->value()`.
	 * @param int    $object_id          The ID of the current object.
	 * @param string $object_type        The type of object you are working with.
	 *                                   Most commonly, `post`
	 *                                   (this applies to all post-types), but could
	 *                                   also be `comment`, `user` or `options-page`.
	 * @param object $field_type_object  This `CMB2_Types` object.
	 */
	public function render( $field, $escaped_value, $object_id, $object_type, $field_type_object ) {

		$this->setup_admin_scripts();

		$output = '';

		$output .= sprintf(
			'<input type="text" class="large-text pw-map-search" id="%s" />',
			$field->args( 'id' )
		);

		$output .= '<div class="pw-map"></div>';

		$output .= $field_type_object->input( array( // XSS ok.
			'type'       => 'text',
			'name'       => $field->args( '_name' ) . '[latitude]',
			'value'      => isset( $escaped_value['latitude'] ) ? floatval( $escaped_value['latitude'] ) : '',
			'class'      => 'pw-map-latitude',
			'desc'       => '',
			)
		);
		$output .= $field_type_object->input( array( // XSS ok.
			'type'       => 'text',
			'name'       => $field->args( '_name' ) . '[longitude]',
			'value'      => isset( $escaped_value['longitude'] ) ? floatval( $escaped_value['longitude'] ) : '',
			'class'      => 'pw-map-longitude',
			'desc'       => '',
			)
		);

		echo $output; // XSS ok.
		$field_type_object->_desc( true, true );
	}

	/**
	 *  Optionally save the latitude/longitude values into two custom fields
	 *
	 * @param bool|mixed $override_value Sanitization/Validation override value
	 *                                   to return.
	 * @param mixed      $value          The value to be saved to this field.
	 * @param int        $object_id      The ID of the object where the value
	 *                                   will be saved.
	 * @param array      $field_args     The current field's arguments.
	 * @param object     $sanitizer      This `CMB2_Sanitize` object.
	 *
	 * @return mixed                     Possibly sanitized meta value.
	 */
	public function sanitize( $override_value, $value, $object_id, $field_args, $sanitizer ) {

		if ( empty( $field_args['split_values'] ) ) {
			return $value;
		}

		if ( ! empty( $value['latitude'] ) ) {
			update_post_meta( $object_id, $field_args['id'] . '_latitude', $value['latitude'] );
		}

		if ( ! empty( $value['longitude'] ) ) {
			update_post_meta( $object_id, $field_args['id'] . '_longitude', $value['longitude'] );
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

		if ( ! array( $this->maps_config ) ) {
			return;
		}

		if ( empty( $this->maps_config ) ) {
			return;
		}

		wp_localize_script( 'pw-google-maps-api', 'maps_config', $this->maps_config );

		wp_enqueue_script( 'pw-google-maps', $this->plugin_url . '/js/script.js', array( 'pw-google-maps-api' ), self::VERSION );
		wp_enqueue_style( 'pw-google-maps', $this->plugin_url . '/css/style.css', array(), self::VERSION );
	}
}
