<?php
/**
 * @package \Syllable\Tests
 */

$require = array(
	'../syllables.php',

	// Test cases
	'Template/Loader/TestCase.php',

	// Mocks
	'mocks/functions.php',
	'mocks/WP_Error.php',
);

// Deactivates the circular reference collector for improved performance:
gc_disable();

foreach ( $require as $require_file ) {
	require_once __DIR__ . '/' . $require_file;
}
