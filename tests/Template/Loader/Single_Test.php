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
	 * @covers \Syllables\Template\Loader::filter
	 * @covers \Syllables\Template\Loader::_get_template
	 * @covers ::_prepare_filter
	 * @covers ::_should_load_template
	 * @covers ::_templates
	 */
	public function test_filter() {
		$loader = new Loader\Single( $this->base_path, array( 'post_type' ) );

		$this->mock_object->post_type->name = 'post_type';

		$this->assertLoaderFilterChangesTemplate( $loader, 'single-post_type.php',
			'Changes the template to single-post_type.php.' );

		$this->mock_object->post_type->name = 'test';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if post type does not match.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers \Syllables\Template\Loader::_get_template
	 * @covers ::_prepare_filter
	 * @covers ::_should_load_template
	 * @covers ::_templates
	 */
	public function test_filter_template_not_found() {
		$loader = new Loader\Single( $this->base_path, array( 'file_not_found' ) );

		$this->mock_object->post_type->name = 'file_not_found';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if the template file is not found.' );
	}

}
