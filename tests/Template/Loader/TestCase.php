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
	protected $queried_object = null;

	/**
	 * Setup a test method.
	 *
	 * Mocks WordPress APIs.
	 */
	public function setUp() {
		parent::setUp();

		$this->base_path   = __DIR__ . '/templates';

		$this->queried_object = (object) array(
			'has_archive' => false,                            // Post type archive
			'name'        => null,                             // Post type slug
			'post_type'   => (object) array( 'name' => null ), // Post type object
			'post_name'   => null,                             // Post slug
			'slug'        => null,                             // Slug
			'taxonomy'    => null,                             // Taxonomy term
			'term'        => null,                             // Taxonomy slug
		);
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
	 * @param integer|null $query Query type.
	 */
	protected function _mockQuery( $query = null ) {
		$this->_mockQueryFunctionReturns( array(
			'get_queried_object'   => $this->queried_object,
			'get_post_type_object' => $this->queried_object->post_type,
			'is_category'          => $query === static::QUERY_CATEGORY,
			'is_post_type_archive' => $query === static::QUERY_POST_TYPE_ARCHIVE,
			'is_single'            => $query === static::QUERY_SINGLE,
			'is_tag'               => $query === static::QUERY_POST_TAG,
			'is_tax'               => $query === static::QUERY_TAXONOMY,
		) );
	}

	/**
	 * Mocks functions and their return values.
	 *
	 * @param  array  $functions Array containing the function names to mock as keys
	 *                           and their returns as values.
	 */
	protected function _mockQueryFunctionReturns( $functions ) {
		foreach ( $functions as $function => $return ) {
			\WP_Mock::wpFunction( $function, array( 'return' => $return ) );
		}
	}

}
