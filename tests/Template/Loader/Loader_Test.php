<?php

namespace Syllables\Tests\Template\Loader;

use Syllables\Template\Loader;

class Loader_Test extends TestCase {

	/**
	 * Template loader instances to check.
	 * @var array
	 */
	public $loaders;

	/**
	 * Set up tests.
	 */
	public function setUp() {
		parent::setUp();

		$this->loaders = array(
			new Loader\Post_Type_Archive( $this->base_path, array() ),
			new Loader\Single( $this->base_path, array() ),
			new Loader\Taxonomy( $this->base_path, array() ),
		);
	}

	/**
	 * Tests hooking the template loader to the WordPress template loading filters.
	 *
	 * @covers \Syllables\Template\Loader::ready
	 */
	public function test_ready() {
		foreach ( $this->loaders as $loader ) {
			\WP_Mock::expectFilterAdded( 'template_include', array( $loader, 'filter' ) );
			$loader->ready();
			$this->assertHooksAdded();
		}
	}

	/**
	 * Tests hooking the template loader to the WordPress template loading filters
	 * with a priority.
	 *
	 * @covers \Syllables\Template\Loader::ready
	 */
	public function test_ready_priority() {
		$priority = rand( 11, 99 );

		foreach ( $this->loaders as $loader ) {
			\WP_Mock::expectFilterAdded( 'template_include', array( $loader, 'filter' ), $priority );
			$loader->ready( $priority );
			$this->assertHooksAdded();
		}
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 */
	public function test_filter_query_none() {

		$this->_mockQuery();

		foreach ( $this->loaders as $loader ) {
			$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
				'Does not change the template if taxonomy not requested.' );
		}
	}

}
