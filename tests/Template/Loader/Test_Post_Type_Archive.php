<?php

namespace Syllables\Tests\Template\Loader;

use Syllables\Tests\UnitTestCase;
use Syllables\Template\Loader;

/**
 * @coversDefaultClass \Syllables\Template\Loader\Post_Type_Archive<extended>
 */
class Test_Post_Type_Archive extends UnitTestCase {

	/**
	 * Templates base directory path.
	 * @var string
	 */
	public $base_path;

	/**
	 * Setup a test method.
	 */
	public function setUp() {
		parent::setUp();

		$this->base_path = trailingslashit( dirname( __FILE__ ) ) . 'templates';
	}

	/**
	 * Clean up after a test method.
	 */
	public function tearDown() {
		parent::tearDown();

		$this->base_path = null;
	}

	/**
	 * Tests hooking the template loader to the WordPress template loading filters.
	 *
	 * @covers ::__construct()
	 * @covers ::ready
	 */
	public function test_ready() {
		$loader   = new Loader\Single( $this->base_path, array() );
		$priority = rand( 11, 99 );
		$loader->ready( $priority );

		$this->assertHookAdded( 'template_include', array( $loader, 'filter' ), $priority,
			'Hooks a filter method to template_include with a custom priority.' );

		$loader->ready();

		$this->assertHookAdded( 'template_include', array( $loader, 'filter' ), null,
			'Hooks a filter method to template_include with the default priority.' );
	}

	/**
	 * @covers ::filter
	 */
	public function test_filter() {
		$this->markTestIncomplete();
	}

}
