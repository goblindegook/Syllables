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
	const QUERY_TAXONOMY          = 1;
	const QUERY_CATEGORY          = 2;
	const QUERY_POST_TAG          = 4;
	const QUERY_POST_TYPE_ARCHIVE = 8;
	const QUERY_SINGLE            = 16;

	/**
	 * Templates base directory path.
	 * @var string
	 */
	public $base_path;

	/**
	 * Default template.
	 * @var string
	 */
	protected $default_template = 'test.php';

	/**
	 * Queried object mock.
	 * @var object
	 */
	protected $mock_object = null;

	/**
	 * Setup a test method.
	 *
	 * Mocks WordPress APIs.
	 */
	public function setUp() {
		parent::setUp();

		$this->base_path      = __DIR__ . '/templates';
		$this->mock_object = new \stdClass;

		$post_type       = new \stdClass;
		$post_type->name = null;

		$this->mock_object->slug        = null;       // Slug
		$this->mock_object->name        = null;       // Post type slug
		$this->mock_object->has_archive = null;       // Post type archive
		$this->mock_object->post_type   = $post_type; // Post type object
		$this->mock_object->term        = null;       // Taxonomy term
		$this->mock_object->taxonomy    = null;       // Taxonomy slug

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

		$this->base_path      = null;
		$this->mock_object = null;
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
	 * Asserts that the loader filter changes the template.
	 *
	 * @param \Syllables\Template\Loader $loader   Template loader instance.
	 * @param string                     $template Filtered template.
	 * @param string                     $message  Assertion message.
	 */
	public function assertLoaderFilterChangesTemplate( $loader, $template, $message = '' ) {
		$this->assertStringEndsWith( $template, $loader->filter( $this->default_template ), $message );
	}

	/**
	 * Asserts that the loader filter does not change the template.
	 *
	 * @param \Syllables\Template\Loader $loader  Template loader instance.
	 * @param string                     $message Assertion message.
	 */
	public function assertLoaderFilterDoesNotChangeTemplate( $loader, $message = '' ) {
		$this->assertEquals( $this->default_template, $loader->filter( $this->default_template ), $message );
	}

	/**
	 * Mocks a global taxonomy query.
	 *
	 * @param integer $query  Query type.
	 *
	 * @uses ::QUERY_CATEGORY
	 * @uses ::QUERY_POST_TAG
	 * @uses ::QUERY_TAXONOMY
	 */
	public function mockQuery( $query ) {
		$this->_mockQueryFunctionReturns( array(
			'get_queried_object'   => $this->mock_object,
			'get_post_type_object' => $this->mock_object->post_type,
			'is_category'          => $query === static::QUERY_CATEGORY,
			'is_post_type_archive' => $query === static::QUERY_POST_TYPE_ARCHIVE,
			'is_single'            => $query === static::QUERY_SINGLE,
			'is_tag'               => $query === static::QUERY_POST_TAG,
			'is_tax'               => $query === static::QUERY_TAXONOMY,
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
