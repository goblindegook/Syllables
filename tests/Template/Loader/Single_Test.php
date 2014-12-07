<?php

namespace Syllables\Tests\Template\Loader;

use Syllables\Template\Loader;

/**
 * @coversDefaultClass \Syllables\Template\Loader\Single
 */
class Test_Single extends TestCase {

	/**
	 * Tests hooking the template loader to the WordPress template loading filters.
	 *
	 * @covers ::__construct
	 * @covers \Syllables\Template\Loader::__construct
	 * @covers \Syllables\Template\Loader::ready
	 */
	public function test_ready() {
		$loader = new Loader\Single( $this->base_path, array() );
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
		$loader = new Loader\Single( $this->base_path, array() );
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
		$loader = new Loader\Single( $this->base_path, array( 'post_type' ) );

		$this->mockQuery( static::QUERY_SINGLE );

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

		$this->mockQuery( static::QUERY_SINGLE );

		$this->mock_object->post_type->name = 'file_not_found';

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if the template file is not found.' );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers ::_prepare_filter
	 * @covers ::_should_load_template
	 */
	public function test_filter_query_none() {
		$loader = new Loader\Single( $this->base_path, array( 'post_type' ) );

		$this->mockQuery( null );

		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if single post not requested.' );
	}

}
