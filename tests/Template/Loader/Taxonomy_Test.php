<?php

namespace Syllables\Tests\Template\Loader;

use Syllables\Template\Loader;

/**
 * @coversDefaultClass \Syllables\Template\Loader\Taxonomy
 */
class Taxonomy_Test extends TestCase {

	/**
	 * @param integer $query    The query type.
	 * @param string  $taxonomy The queried taxonomy.
	 * @param string  $slug     The queried term slug.
	 * @param string  $expected The template expected to load.
	 *
	 * @covers \Syllables\Template\Loader::filter
	 *
	 * @dataProvider filter_provider
	 */
	public function test_filter( $query, $taxonomy, $slug, $expected ) {
		$this->_mockQuery( $query );

		$loader = new Loader\Taxonomy( $this->base_path, array( $taxonomy ) );

		$this->queried_object->taxonomy = $taxonomy;
		$this->queried_object->slug     = $slug;

		if ( empty( $expected ) ) {
			$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
				'Does not change the template if custom template not found.' );
			return;
		}

		$this->assertLoaderFilterChangesTemplate( $loader, $expected,
			"Changes the template to $expected." );
	}

	/**
	 * @return array
	 */
	public function filter_provider() {
		return array(
			array( static::QUERY_CATEGORY, 'category', 'term', 'taxonomy-category-term.php' ),
			array( static::QUERY_CATEGORY, 'category', 'none', null ),

			array( static::QUERY_POST_TAG, 'post_tag', 'term', 'taxonomy-post_tag-term.php' ),
			array( static::QUERY_POST_TAG, 'post_tag', 'none', null ),

			array( static::QUERY_TAXONOMY, 'tax', 'term', 'taxonomy-tax-term.php' ),
			array( static::QUERY_TAXONOMY, 'tax', 'none', 'taxonomy-tax.php' ),
			array( static::QUERY_TAXONOMY, 'only', 'term', 'taxonomy-only-term.php' ),
			array( static::QUERY_TAXONOMY, 'only', 'none', null ),
		);
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 */
	public function test_filter_query_no_match() {
		$this->_mockQuery( static::QUERY_TAXONOMY );

		$loader = new Loader\Taxonomy( $this->base_path, array( 'tax' ) );

		$this->queried_object->taxonomy = 'different-tax';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if taxonomy does not match.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 */
	public function test_filter_template_not_found() {
		$this->_mockQuery( static::QUERY_TAXONOMY );

		$loader = new Loader\Taxonomy( $this->base_path, array( 'file_not_found' ) );

		$this->queried_object->taxonomy = 'file_not_found';
		$this->queried_object->slug     = 'term';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if the template file is not found.' );
	}

}
