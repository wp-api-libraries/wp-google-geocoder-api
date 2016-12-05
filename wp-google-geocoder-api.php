<?php
/**
 * WP Google GeoCoder API (https://developers.google.com/maps/web/)
 *
 * @package WP-GoogleGeoCoder-API
 */

/*
* Plugin Name: WP GoogleGeoCoder API
* Plugin URI: https://github.com/wp-api-libraries/wp-google-geocoder-api
* Description: Perform API requests toGoogleGeoCoder in WordPress.
* Author: WP API Libraries
* Version: 1.0.0
* Author URI: https://wp-api-libraries.com
* GitHub Plugin URI: https://github.com/wp-api-libraries/wp-google-geocoder-api
* GitHub Branch: master
*/

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) { exit; }

if ( ! class_exists( 'GoogleMapsGeocoderAPI' ) ) {

	/**
	 * GoogleMapsGeocoderAPI class.
	 */
	class GoogleMapsGeocoderAPI {

		 /**
		 * API Key.
		 *
		 * @var mixed
		 * @access private
		 * @static
		 */
		static private $api_key;

		/**
		 * Return format. XML or JSON.
		 *
		 * @var [string
		 */
	 	static private $output;

		/**
		 * Google GeoCode Base URI.
		 *
		 * @var string
		 * @access protected
		 */
		protected $base_uri = 'https://maps.googleapis.com/maps/api/geocode/';

		/**
		 * Construct.
		 *
		 * @access public
		 * @param mixed $apikey API Key.
		 * @param mixed $output Output.
		 * @return void
		 */
		public function __construct( $api_key, $output = 'json' ) {

			static::$api_key = $api_key;
			static::$output = $output;

		}

		/**
		 * Fetch the request from the API.
		 *
		 * @access private
		 * @param mixed $request Request URL.
		 * @return $body Body.
		 */
		private function fetch( $request ) {

			$response = wp_remote_get( $request );
			$code = wp_remote_retrieve_response_code( $response );

			if ( 200 !== $code ) {
				return new WP_Error( 'response-error', sprintf( __( 'Server response code: %d', 'text-domain' ), $code ) );
			}

			$body = wp_remote_retrieve_body( $response );

			return json_decode( $body );

		}

		/**
		 * get_lat_long function.
		 *
		 * @access public
		 * @param string $address (default: '')
		 * @param string $bounds (default: '')
		 * @param string $language (default: '')
		 * @param string $region (default: '')
		 * @param string $components (default: '')
		 * @return void
		 */
		function geocode( $address = '', $bounds = '', $language = '', $region = '', $components = '' ) {

			$request = $this->base_uri . static::$output . '?address=' . $address . '&key=' . static::$api_key;

			echo $request;

			return $this->fetch( $request );

		}

		/**
		 * reverse_geocode function.
		 *
		 * @access public
		 * @param mixed $latlng
		 * @param mixed $place_id
		 * @param mixed $language
		 * @param mixed $results_type
		 * @param mixed $street_address
		 * @param mixed $postal_code
		 * @param mixed $location_type
		 * @return void
		 */
		function reverse_geocode( $latlng, $place_id, $language, $results_type, $street_address, $postal_code, $location_type ) {

			$request = $this->base_uri . static::$output .'?address=' . $address . '&components=' . $components . '&key=' . static::$api_key;

			return $this->fetch( $request );

		}


	}
}
