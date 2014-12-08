<?php

namespace Syllables\Tests\Template\Loader;

use Syllables\Template\Loader;

/**
 * @coversDefaultClass \Syllables\Template\Loader\Taxonomy
 */
class Taxonomy_Test extends TestCase {

	/**
	 * Set up tests.
	 */
	public function setUp() {
		parent::setUp();

		$this->_mockQuery( static::QUERY_TAXONOMY );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 */
	public function test_filter_template_not_found() {
		$loader = new Loader\Taxonomy( $this->base_path, array( 'file_not_found' ) );

		$this->mock_object->taxonomy = 'file_not_found';
		$this->mock_object->slug     = 'term';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if the template file is not found.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 */
	public function test_filter_query_category() {
		$loader = new Loader\Taxonomy( $this->base_path, array( 'category' ) );

		$this->mock_object->taxonomy = 'category';
		$this->mock_object->slug     = 'no-such-category';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if custom template not found.' );

		$this->mock_object->slug = 'term';

		$this->assertLoaderFilterChangesTemplate( $loader, 'taxonomy-category-term.php',
			'Changes the template to taxonomy-category-term.php.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 */
	public function test_filter_query_post_tag() {
		$loader = new Loader\Taxonomy( $this->base_path, array( 'post_tag' ) );

		$this->mock_object->taxonomy = 'post_tag';
		$this->mock_object->slug     = 'no-such-tag';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if custom template not found.' );

		$this->mock_object->slug = 'term';

		$this->assertLoaderFilterChangesTemplate( $loader, 'taxonomy-post_tag-term.php',
			'Changes the template to taxonomy-post_tag-term.php.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 */
	public function test_filter_query_taxonomy() {
		$loader = new Loader\Taxonomy( $this->base_path, array( 'tax' ) );

		$this->mock_object->taxonomy = 'tax';
		$this->mock_object->slug     = 'no-term-template';

		$this->assertLoaderFilterChangesTemplate( $loader, 'taxonomy-tax.php',
			'Changes the template to taxonomy-tax.php.' );

		$this->mock_object->slug = 'term';

		$this->assertLoaderFilterChangesTemplate( $loader, 'taxonomy-tax-term.php',
			'Changes the template to taxonomy-tax-term.php.' );

		$this->mock_object->taxonomy = 'other-tax';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if taxonomy does not match.' );
	}

}
