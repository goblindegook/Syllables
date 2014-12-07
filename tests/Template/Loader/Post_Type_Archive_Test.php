<?php

namespace Syllables\Tests\Template\Loader;

use Syllables\Template\Loader;

/**
 * @coversDefaultClass \Syllables\Template\Loader\Post_Type_Archive
 */
class Post_Type_Archive_Test extends TestCase {

	/**
	 * Tests hooking the template loader to the WordPress template loading filters.
	 *
	 * @covers ::__construct
	 * @covers \Syllables\Template\Loader::__construct
	 * @covers \Syllables\Template\Loader::ready
	 */
	public function test_ready() {
		$loader = new Loader\Post_Type_Archive( $this->base_path, array() );
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
		$loader = new Loader\Post_Type_Archive( $this->base_path, array() );
		$this->assertLoaderHooksAddedWithPriority( $loader, rand( 11, 99 ) );
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

		$this->mockQuery( static::QUERY_POST_TYPE_ARCHIVE );

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

		$this->mockQuery( static::QUERY_POST_TYPE_ARCHIVE );

		$this->mock_object->name        = 'file_not_found';
		$this->mock_object->has_archive = true;

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if the template file is not found.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers ::_prepare_filter
	 * @covers ::_should_load_template
	 */
	public function test_filter_query_none() {
		$loader = new Loader\Post_Type_Archive( $this->base_path, array( 'post_type' ) );

		$this->mockQuery( null );

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if post type archive not requested.' );
	}

}
