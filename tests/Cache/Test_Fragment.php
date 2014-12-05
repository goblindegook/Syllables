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
	protected $fragment;

	/**
	 * Cache key.
	 * @var string
	 */
	protected $cache_key = 'test-cache-key';

	/**
	 * Setup a test method.
	 */
	public function setUp() {
		parent::setUp();

		$this->fragment = new Fragment( $this->cache_key, 3600 );
	}

	/**
	 * Clean up after a test method.
	 */
	public function tearDown() {
		parent::tearDown();

		wp_cache_delete( $this->cache_key, 'syllables-cache-fragments' );

		$this->fragment = null;
	}

	/**
	 * @covers ::cache
	 * @covers ::__construct
	 * @covers ::_output
	 * @covers ::_store
	 */
	public function test_cache() {

		$expected = microtime();

		$this->fragment->cache( function () use ( &$expected ) {
			echo $expected;
		});

		ob_clean();

		$this->expectOutputString( $expected );

		$this->fragment->cache( function () {
			echo 'something else';
		});
	}

}
