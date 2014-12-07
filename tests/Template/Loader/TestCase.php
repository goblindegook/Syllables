<?php

namespace Syllables\Tests\Template\Loader;

use Syllables\Template\Loader;

/**
 * @coversDefaultClass \Syllables\Template\Loader\Taxonomy<extended>
 */
class TestCase extends \WP_Mock\Tools\TestCase {

	/**
	 * Templates base directory path.
	 * @var string
	 */
	public $base_path;

	/**
	 * Setup a test method.
	 *
	 * Mocks WordPress APIs.
	 */
	public function setUp() {
		parent::setUp();

		$this->base_path = __DIR__ . '/templates';

		// Mock WordPress API functions:

		\WP_Mock::wpFunction( 'trailingslashit', array(
			'return' =>
				function ( $string ) {
					return rtrim( $string, '/\\' ) . '/';
				},
		) );

		\WP_Mock::wpFunction( 'remove_filter' );
	}

	/**
	 * Clean up after a test method.
	 */
	public function tearDown() {
		parent::tearDown();

		$this->base_path = null;
	}

}
