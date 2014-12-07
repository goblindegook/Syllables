<?php

namespace Syllables\Tests\Template\Loader;

use Syllables\Template\Loader;

/**
 * @coversDefaultClass \Syllables\Template\Loader\Post_Type_Archive
 */
class Post_Type_Archive_Test extends TestCase {

	/**
	 * Set up tests.
	 */
	public function setUp() {
		parent::setUp();

		$this->_mockQuery( static::QUERY_POST_TYPE_ARCHIVE );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers \Syllables\Template\Loader::_get_template
	 * @covers ::_prepare_filter
	 * @covers ::_should_load_template
	 * @covers ::_templates
	 */
	public function test_filter() {
		$loader = new Loader\Post_Type_Archive( $this->base_path, array( 'post_type' ) );

		$this->mock_object->name        = 'post_type';
		$this->mock_object->has_archive = true;

		$this->assertLoaderFilterChangesTemplate( $loader, 'archive-post_type.php',
			'Changes the template to single-post_type.php.' );

		$this->mock_object->has_archive = false;

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if post type does not support archives.' );

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
		$loader = new Loader\Post_Type_Archive( $this->base_path, array( 'file_not_found' ) );

		$this->mock_object->name        = 'file_not_found';
		$this->mock_object->has_archive = true;

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if the template file is not found.' );
	}

}
