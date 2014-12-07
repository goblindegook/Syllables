<?php

use \WP_Mock;

// Mock WordPress API functions:

if ( ! function_exists( 'trailingslashit' ) ) {

	function trailingslashit( $string ) {
		return rtrim( $string, '/\\' ) . '/';
	}

}

if ( ! function_exists( 'remove_filter' ) ) {

	function remove_filter( $tag, $callable, $priority = 10, $expected_args = 1 ) {
		return;
	}

}
