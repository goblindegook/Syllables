<?php

namespace Syllables\Tests\Template\Loader;

use Syllables\Template\Loader;

/**
 * @coversDefaultClass \Syllables\Template\Loader\Taxonomy
 */
class Taxonomy_Test extends TestCase {

	/**
	 * Tests hooking the template loader to the WordPress template loading filters.
	 *
	 * @covers ::__construct()
	 * @covers \Syllables\Template\Loader::__construct()
	 * @covers \Syllables\Template\Loader::ready
	 */
	public function test_ready() {
		$loader = new Loader\Taxonomy( $this->base_path, array() );
		$this->assertLoaderHooksAdded( $loader );
	}

	/**
	 * Tests hooking the template loader to the WordPress template loading filters
	 * with a priority.
	 *
	 * @covers ::__construct()
	 * @covers \Syllables\Template\Loader::__construct()
	 * @covers \Syllables\Template\Loader::ready
	 */
	public function test_ready_priority() {
		$loader = new Loader\Taxonomy( $this->base_path, array() );
		$this->assertLoaderHooksAddedWithPriority( $loader, rand( 11, 99 ) );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers ::_prepare_filter()
	 * @covers ::_should_load_template()
	 */
	public function test_filter_query_none() {
		$loader   = new Loader\Taxonomy( $this->base_path, array( 'tax' ) );
		$template = 'test.php';

		$this->mockQuery( null, $term );

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

		$this->mockQuery( static::QUERY_CATEGORY, $term );

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

		$this->mockQuery( static::QUERY_POST_TAG, $term );

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

		$this->mockQuery( static::QUERY_TAXONOMY, $term );

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
