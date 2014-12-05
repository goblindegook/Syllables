<?php

namespace Syllables\Tests\Cache;

use Syllables\Cache\Fragment;

/**
 * @coversDefaultClass \Syllables\Cache\Fragment
 */
class Test_Fragment extends \WP_UnitTestCase {

	/**
	 * Fragment cache object.
	 * @var Fragment
	 */
	var $fragment;

	/**
	 * Setup a test method.
	 */
	public function setUp() {
		parent::setUp();

		$this->fragment = new Fragment( 'test-cache-key', 3600 );
	}

	/**
	 * Clean up after a test method.
	 */
	public function tearDown() {
		parent::tearDown();

		$this->fragment = null;
	}

	/**
	 * @covers ::cache
	 * @covers ::__construct
	 * @covers ::_output
	 * @covers ::_store
	 */
	public function test_cache() {

		$expected = date( 'c' );

		$this->expectOutputString( $expected );

		$this->fragment->cache( function () use ( &$expected ) {
			echo $expected;
		});

		// Flush output buffer.
		ob_clean();

		$this->expectOutputString( $expected );

		$this->fragment->cache( function () {
			echo 'something else';
		});
	}

}
