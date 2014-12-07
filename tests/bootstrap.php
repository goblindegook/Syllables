<?php
/**
 * @package \Syllable\Tests
 */

$require = array(
	// Test cases
	'Template/Loader/TestCase.php',

	// Mocks
	'mocks/WP_Error.php',
	'mocks/functions.php',
);

// Deactivates the circular reference collector for improved performance:
gc_disable();

require_once __DIR__ . '/../syllables.php';

\WP_Mock::bootstrap();

foreach ( $require as $require_file ) {
	require_once __DIR__ . '/' . $require_file;
}
