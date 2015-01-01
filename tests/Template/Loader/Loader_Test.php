<?php

namespace Syllables\Tests\Template\Loader;

use Syllables\Template\Loader;

class Loader_Test extends TestCase {

	/**
	 * Tests hooking the template loader to the WordPress template loading filters.
	 *
	 * @covers \Syllables\Template\Loader::ready
	 *
	 * @dataProvider loader_provider
	 */
	public function test_ready( Loader $loader ) {
		\WP_Mock::expectFilterAdded( 'template_include', array( $loader, 'filter' ) );
		$loader->ready();
		$this->assertHooksAdded();
	}

	/**
	 * Tests hooking the template loader to the WordPress template loading filters
	 * with a priority.
	 *
	 * @covers \Syllables\Template\Loader::ready
	 *
	 * @dataProvider loader_provider
	 */
	public function test_ready_priority( Loader $loader ) {
		$priority = rand( 11, 99 );
		\WP_Mock::expectFilterAdded( 'template_include', array( $loader, 'filter' ), $priority );
		$loader->ready( $priority );
		$this->assertHooksAdded();
	}

	/**
	 * @param \Syllables\Template\Loader $loader Template loader instance.
	 *
	 * @covers \Syllables\Template\Loader::filter
	 *
	 * @dataProvider loader_provider
	 */
	public function test_filter_query_none( Loader $loader ) {
		$this->_mockQuery();
		$this->assertLoaderFilterDoesNotChangeTemplate( $loader,
			'Does not change the template if taxonomy not requested.' );
	}

	/**
	 * @return array Loader instances.
	 */
	public function loader_provider() {
		return array(
			array( new Loader\Post_Type_Archive( $this->base_path, array() ) ),
			array( new Loader\Single( $this->base_path, array() ) ),
			array( new Loader\Taxonomy( $this->base_path, array() ) ),
		);
	}

}
