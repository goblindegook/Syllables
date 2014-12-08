<?php

namespace Syllables\Tests\Template\Loader;

use Syllables\Template\Loader;

/**
 * @coversDefaultClass \Syllables\Template\Loader\Single
 */
class Single_Test extends TestCase {

	/**
	 * Set up tests.
	 */
	public function setUp() {
		parent::setUp();

		$this->_mockQuery( static::QUERY_SINGLE );
	}

	/**
	 * @param string $post_type The queried post type.
	 * @param string $post_name The queried post slug.
	 * @param string $expected  The template expected to load.
	 *
	 * @covers \Syllables\Template\Loader::filter
	 *
	 * @dataProvider filter_provider
	 */
	public function test_filter( $post_type, $post_name, $expected ) {
		$loader = new Loader\Single( $this->base_path, array( $post_type ) );

		$this->queried_object->post_type->name = $post_type;
		$this->queried_object->post_name = $post_name;

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
			array( 'type', 'name', 'single-type-name.php' ),
			array( 'type', 'none', 'single-type.php' ),
			array( 'only', 'name', 'single-only-name.php' ),
			array( 'only', 'none', null ),
		);
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 */
	public function test_filter_query_no_match() {
		$loader = new Loader\Single( $this->base_path, array( 'post_type' ) );

		$this->queried_object->post_type->name = 'test';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if post type does not match.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 */
	public function test_filter_template_not_found() {
		$loader = new Loader\Single( $this->base_path, array( 'file_not_found' ) );

		$this->queried_object->post_type->name = 'file_not_found';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if the template file is not found.' );
	}

}
