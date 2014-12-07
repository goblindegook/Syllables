<?php

namespace Syllables\Tests\Template\Loader;

use Syllables\Template\Loader;

/**
 * @coversDefaultClass \Syllables\Template\Loader\Taxonomy<extended>
 */
class Taxonomy_Test extends TestCase {

	/**
	 * Tests hooking the template loader to the WordPress template loading filters.
	 *
	 * @covers \Syllables\Template\Loader::__construct()
	 * @covers \Syllables\Template\Loader::ready
	 */
	public function test_ready() {
		$loader = new Loader\Taxonomy( $this->base_path, array() );

		\WP_Mock::expectFilterAdded( 'template_include', array( $loader, 'filter' ) );

		$loader->ready();

		$this->assertHooksAdded();
	}

	/**
	 * Tests hooking the template loader to the WordPress template loading filters
	 * with a priority.
	 *
	 * @covers ::__construct()
	 * @covers \Syllables\Template\Loader::ready
	 */
	public function test_ready_priority() {
		$priority = rand( 11, 99 );
		$loader   = new Loader\Taxonomy( $this->base_path, array() );

		\WP_Mock::expectFilterAdded( 'template_include', array( $loader, 'filter' ), $priority );

		$loader->ready( $priority );

		$this->assertHooksAdded();
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers ::_prepare_filter()
	 * @covers ::_should_load_template()
	 */
	public function test_filter_query_none() {
		$loader   = new Loader\Taxonomy( $this->base_path, array( 'tax' ) );
		$template = 'test.php';

		\WP_Mock::wpFunction( 'get_queried_object', array( 'return' => null ) );
		\WP_Mock::wpFunction( 'is_category', array( 'return' => false ) );
		\WP_Mock::wpFunction( 'is_tag', array( 'return' => false ) );
		\WP_Mock::wpFunction( 'is_tax', array( 'return' => false ) );

		$this->assertEquals( $template, $loader->filter( $template ),
			'Does not change the template if taxonomy not requested.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers ::_prepare_filter()
	 * @covers ::_should_load_template()
	 * @covers ::_templates()
	 */
	public function test_filter_query_category() {
		$loader         = new Loader\Taxonomy( $this->base_path, array( 'category' ) );
		$template       = 'test.php';
		$term           = new \stdClass;
		$term->taxonomy = 'category';

		\WP_Mock::wpFunction( 'get_queried_object', array( 'return' => $term ) );
		\WP_Mock::wpFunction( 'is_category', array( 'return' => true ) );
		\WP_Mock::wpFunction( 'is_tag', array( 'return' => false ) );
		\WP_Mock::wpFunction( 'is_tax', array( 'return' => false ) );

		$term->slug = 'non-existent';

		$this->assertEquals( $template, $loader->filter( $template ),
			'Does not change the template if custom template not found.' );

		$term->slug = 'term';

		$this->assertStringEndsWith( 'taxonomy-category-term.php', $loader->filter( $template ),
			'Changes the template to taxonomy-category-term.php.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers ::_prepare_filter()
	 * @covers ::_should_load_template()
	 * @covers ::_templates()
	 */
	public function test_filter_query_post_tag() {
		$loader         = new Loader\Taxonomy( $this->base_path, array( 'post_tag' ) );
		$template       = 'test.php';
		$term           = new \stdClass;
		$term->taxonomy = 'post_tag';

		\WP_Mock::wpFunction( 'get_queried_object', array( 'return' => $term ) );
		\WP_Mock::wpFunction( 'is_category', array( 'return' => false ) );
		\WP_Mock::wpFunction( 'is_tag', array( 'return' => true ) );
		\WP_Mock::wpFunction( 'is_tax', array( 'return' => false ) );

		$term->slug = 'non-existent';

		$this->assertEquals( $template, $loader->filter( $template ),
			'Does not change the template if custom template not found.' );

		$term->slug = 'term';

		$this->assertStringEndsWith( 'taxonomy-post_tag-term.php', $loader->filter( $template ),
			'Changes the template to taxonomy-post_tag-term.php.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers ::_prepare_filter()
	 * @covers ::_should_load_template()
	 * @covers ::_templates()
	 */
	public function test_filter_query_taxonomy() {
		$loader         = new Loader\Taxonomy( $this->base_path, array( 'tax' ) );
		$template       = 'test.php';
		$term           = new \stdClass;
		$term->taxonomy = 'tax';

		\WP_Mock::wpFunction( 'get_queried_object', array( 'return' => $term ) );
		\WP_Mock::wpFunction( 'is_category', array( 'return' => false ) );
		\WP_Mock::wpFunction( 'is_tag', array( 'return' => false ) );
		\WP_Mock::wpFunction( 'is_tax', array( 'return' => true ) );

		$term->slug = 'non-existent';

		$this->assertStringEndsWith( 'taxonomy-tax.php', $loader->filter( $template ),
			'Changes the template to taxonomy-tax.php.' );

		$term->slug = 'term';

		$this->assertStringEndsWith( 'taxonomy-tax-term.php', $loader->filter( $template ),
			'Changes the template to taxonomy-tax-term.php.' );

		$term->taxonomy = 'other-tax';

		$this->assertEquals( $template, $loader->filter( $template ),
			'Does not change the template if taxonomy does not match.' );
	}

}
