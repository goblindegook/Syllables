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
	 * @covers ::__construct()
	 * @covers \Syllables\Template\Loader::__construct()
	 * @covers \Syllables\Template\Loader::ready
	 */
	public function test_ready() {
		$this->markTestIncomplete();
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
