<?php

use \WP_Mock;

// Mock WordPress API functions:

if ( ! function_exists( 'trailingslashit' ) ) {

	function trailingslashit( $string ) {
		return rtrim( $string, '/\\' ) . '/';
	}

}

if ( ! function_exists( 'remove_filter' ) ) {
	\WP_Mock::wpFunction( 'remove_filter' );
}
