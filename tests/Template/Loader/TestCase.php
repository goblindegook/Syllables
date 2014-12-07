<?php

namespace Syllables\Tests\Template\Loader;

use Syllables\Template\Loader;

/**
 * @coversDefaultClass \Syllables\Template\Loader\Taxonomy<extended>
 */
class TestCase extends \WP_Mock\Tools\TestCase {

	/**
	 * Query types.
	 */
	const QUERY_TAXONOMY = 1;
	const QUERY_CATEGORY = 2;
	const QUERY_POST_TAG = 4;

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

	/**
	 * Asserts that the template loader is hooked to template_include.
	 *
	 * @param \Syllables\Template\Loader $loader Template loader instance.
	 */
	public function assertLoaderHooksAdded( $loader ) {
		\WP_Mock::expectFilterAdded( 'template_include', array( $loader, 'filter' ) );
		$loader->ready();
		$this->assertHooksAdded();
	}

	/**
	 * Asserts that the template loader is hooked to template_include.
	 *
	 * @param \Syllables\Template\Loader $loader   Template loader instance.
	 * @param integer                    $priority Filter priority.
	 */
	public function assertLoaderHooksAddedWithPriority( $loader, $priority ) {
		\WP_Mock::expectFilterAdded( 'template_include', array( $loader, 'filter' ), $priority );
		$loader->ready( $priority );
		$this->assertHooksAdded();
	}

	/**
	 * Mocks a global taxonomy query.
	 *
	 * @param integer $query  Query type.
	 * @param object  $object Queried object.
	 *
	 * @uses ::QUERY_CATEGORY
	 * @uses ::QUERY_POST_TAG
	 * @uses ::QUERY_TAXONOMY
	 */
	public function mockQuery( $query, &$object ) {
		$this->_mockQueryFunctionReturns( array(
			'get_queried_object' => $object,
			'is_category'        => $query === static::QUERY_CATEGORY,
			'is_tag'             => $query === static::QUERY_POST_TAG,
			'is_tax'             => $query === static::QUERY_TAXONOMY,
		) );
	}

	/**
	 * Mocks functions and their returned values.
	 *
	 * @param  array  $functions Array containing the function names to mock as keys
	 *                           and their return values as values.
	 */
	protected function _mockQueryFunctionReturns( $functions ) {
		foreach ( $functions as $function => $return ) {
			\WP_Mock::wpFunction( $function, array( 'return' => $return ) );
		}
	}

}
