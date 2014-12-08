<?php

namespace Syllables\Tests\Cache;

use WP_Mock\Tools\TestCase;
use Syllables\Cache\Fragment;

/**
 * @coversDefaultClass \Syllables\Cache\Fragment
 */
class Fragment_Test extends TestCase {

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
	 * Cache expiration.
	 * @var integer
	 */
	protected $cache_expires = 3600;

	/**
	 * Cache group.
	 * @var string
	 */
	protected $cache_group = 'syllables-cache-fragments';

	/**
	 * Setup a test method.
	 */
	public function setUp() {
		parent::setUp();

		$this->fragment = new Fragment( $this->cache_key, $this->cache_expires );
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
	 */
	public function test_cache_add() {
		$expected = microtime();

		\WP_Mock::wpFunction( 'wp_cache_get', array(
			'times'  => 1,
			'args'   => array( $this->cache_key, $this->cache_group ),
			'return' => false,
		) );

		\WP_Mock::wpFunction( 'wp_cache_add', array(
			'times' => 1,
			'args'  => array( $this->cache_key, $expected, $this->cache_group, $this->cache_expires ),
		) );

		$this->expectOutputString( $expected );

		$this->fragment->cache( function () use ( &$expected ) {
			echo $expected;
		});

		$this->assertConditionsMet();
	}

	/**
	 * @covers ::cache
	 */
	public function test_cache_get() {
		$expected = microtime();

		\WP_Mock::wpFunction( 'wp_cache_get', array(
			'times'  => 1,
			'args'   => array( $this->cache_key, $this->cache_group ),
			'return' => $expected,
		) );

		\WP_Mock::wpFunction( 'wp_cache_add', array( 'times' => 0 ) );

		$this->expectOutputString( $expected );

		$this->fragment->cache( function () {
			echo 'something else';
		});

		$this->assertConditionsMet();
	}

	/**
	 * Caching and returning the value 0 should not be interpreted as a cache miss.
	 *
	 * @covers ::cache
	 */
	public function test_cache_get_zero() {
		\WP_Mock::wpFunction( 'wp_cache_get', array( 'times'  => 1, 'return' => '0' ) );
		\WP_Mock::wpFunction( 'wp_cache_add', array( 'times' => 0 ) );

		$this->expectOutputString( '0' );

		$this->fragment->cache( function () {
			echo 'test-cache-zero';
		});

		$this->assertConditionsMet( 'Caching the value 0 should not be considered a miss.' );
	}

	/**
	 * Caching and returning an empty string should not be interpreted as a cache
	 * miss.
	 *
	 * @covers ::cache
	 */
	public function test_cache_get_empty_string() {
		\WP_Mock::wpFunction( 'wp_cache_get', array( 'times'  => 1, 'return' => '' ) );
		\WP_Mock::wpFunction( 'wp_cache_add', array( 'times' => 0 ) );

		$this->expectOutputString( '' );

		$this->fragment->cache( function () {
			echo 'test-cache-empty-string';
		});

		$this->assertConditionsMet( 'Caching an empty string should not be considered a miss.' );
	}

	/**
	 * @covers ::flush
	 */
	public function test_cache_delete() {
		\WP_Mock::wpFunction( 'wp_cache_delete', array(
			'times'  => 1,
			'args'   => array( $this->cache_key, $this->cache_group ),
		) );

		$this->fragment->flush();

		$this->assertConditionsMet( 'Flushing should delete the fragment cache.' );
	}

}
