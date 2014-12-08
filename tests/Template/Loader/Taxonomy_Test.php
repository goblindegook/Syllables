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
	 *
	 * @dataProvider filter_provider
	 */
	public function test_filter( $taxonomy, $invalid_slug, $slug, $expected ) {
		$loader = new Loader\Taxonomy( $this->base_path, array( $taxonomy ) );

		$this->mock_object->taxonomy = $taxonomy;
		$this->mock_object->slug     = $invalid_slug;

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if custom template not found.' );

		$this->mock_object->slug = $slug;

		$this->assertLoaderFilterChangesTemplate( $loader, $expected,
			"Changes the template to $expected." );
	}

	/**
	 * @return array
	 */
	public function filter_provider() {
		return array(
			array( 'category', 'no-term', 'term', 'taxonomy-category-term.php' ),
			array( 'post_tag', 'no-term', 'term', 'taxonomy-post_tag-term.php' ),
			array( 'custom', 'no-term', 'term', 'taxonomy-custom-term.php' ),
		);
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
