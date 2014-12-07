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
	 * @covers ::__construct()
	 * @covers \Syllables\Template\Loader::__construct()
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
	 * @covers ::__construct()
	 * @covers \Syllables\Template\Loader::__construct()
	 * @covers \Syllables\Template\Loader::ready
	 */
	public function test_ready_priority() {
		$loader = new Loader\Single( $this->base_path, array() );
		$this->assertLoaderHooksAddedWithPriority( $loader, rand( 11, 99 ) );
	}

	/**
	 * @covers \Syllables\Template\Loader::filter
	 * @covers ::_prepare_filter()
	 * @covers ::_should_load_template()
	 * @covers ::_templates()
	 */
	public function test_filter() {
		$this->markTestIncomplete();
	}

}
