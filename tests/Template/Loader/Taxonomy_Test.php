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
	 * @covers ::__construct
	 * @covers \Syllables\Template\Loader::__construct
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
	 * @covers ::__construct
	 * @covers \Syllables\Template\Loader::__construct
	 * @covers \Syllables\Template\Loader::ready
	 */
	public function test_ready_priority() {
		$loader = new Loader\Taxonomy( $this->base_path, array() );
		$this->assertLoaderHooksAddedWithPriority( $loader, rand( 11, 99 ) );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers \Syllables\Template\Loader::_get_template
	 * @covers ::_prepare_filter
	 * @covers ::_should_load_template
	 * @covers ::_templates
	 */
	public function test_filter_template_not_found() {
		$loader = new Loader\Taxonomy( $this->base_path, array( 'file_not_found' ) );

		$this->mockQuery( static::QUERY_TAXONOMY );

		$this->mock_object->taxonomy = 'file_not_found';
		$this->mock_object->slug     = 'term';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if the template file is not found.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers \Syllables\Template\Loader::_get_template
	 * @covers ::_prepare_filter
	 * @covers ::_should_load_template
	 * @covers ::_templates
	 */
	public function test_filter_query_category() {
		$loader = new Loader\Taxonomy( $this->base_path, array( 'category' ) );

		$this->mock_object->taxonomy = 'category';

		$this->mockQuery( static::QUERY_CATEGORY );

		$this->mock_object->slug = 'non-existent';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if custom template not found.' );

		$this->mock_object->slug = 'term';

		$this->assertLoaderFilterChangesTemplate( $loader, 'taxonomy-category-term.php',
			'Changes the template to taxonomy-category-term.php.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers \Syllables\Template\Loader::_get_template
	 * @covers ::_prepare_filter
	 * @covers ::_should_load_template
	 * @covers ::_templates
	 */
	public function test_filter_query_post_tag() {
		$loader = new Loader\Taxonomy( $this->base_path, array( 'post_tag' ) );

		$this->mock_object->taxonomy = 'post_tag';

		$this->mockQuery( static::QUERY_POST_TAG );

		$this->mock_object->slug = 'non-existent';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if custom template not found.' );

		$this->mock_object->slug = 'term';

		$this->assertLoaderFilterChangesTemplate( $loader, 'taxonomy-post_tag-term.php',
			'Changes the template to taxonomy-post_tag-term.php.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers \Syllables\Template\Loader::_get_template
	 * @covers ::_prepare_filter
	 * @covers ::_should_load_template
	 * @covers ::_templates
	 */
	public function test_filter_query_taxonomy() {
		$loader = new Loader\Taxonomy( $this->base_path, array( 'tax' ) );

		$this->mock_object->taxonomy = 'tax';

		$this->mockQuery( static::QUERY_TAXONOMY );

		$this->mock_object->slug = 'non-existent';

		$this->assertLoaderFilterChangesTemplate( $loader, 'taxonomy-tax.php',
			'Changes the template to taxonomy-tax.php.' );

		$this->mock_object->slug = 'term';

		$this->assertLoaderFilterChangesTemplate( $loader, 'taxonomy-tax-term.php',
			'Changes the template to taxonomy-tax-term.php.' );

		$this->mock_object->taxonomy = 'other-tax';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if taxonomy does not match.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers ::_prepare_filter
	 * @covers ::_should_load_template
	 */
	public function test_filter_query_none() {
		$loader   = new Loader\Taxonomy( $this->base_path, array( 'tax' ) );

		$this->mockQuery( null );

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if taxonomy not requested.' );
	}

}
