<?php
/**
 * @package \Syllable\Tests
 */

// Deactivates the circular reference collector for improved performance:
gc_disable();

$_tests_dir = getenv( 'WP_TESTS_DIR' );

if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

require_once $_tests_dir . '/includes/functions.php';

function _manually_load_plugin() {
	require_once dirname( __FILE__ ) . '/../syllables.php';
}

tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

$GLOBALS['wp_tests_options']['active_plugins'][] = 'syllables/syllables.php';

require $_tests_dir . '/includes/bootstrap.php';
