<?php
/**
 * Implements fragment caching.
 *
 * @since 0.1.0
 */

namespace Syllables\Cache;

/**
 * Class that implements fragment caching.
 *
 * Uses code taken from Mark Jaquith's `CWS_Fragment_Cache` class.
 *
 * Usage:
 *
 * ```php
 * $fragment = new \Syllables\Cache\Fragment( 'unique-key', 3600 );
 *
 * if ( ! $fragment->output() ) {
 *     // Your code goes here.
 *
 *     // IMPORTANT! DO NOT FORGET THIS:
 *     $fragment->store();
 * }
 * ```
 *
 * @since 0.1.0
 *
 * @see http://markjaquith.wordpress.com/2013/04/26/fragment-caching-in-wordpress/
 */
class Fragment {

	/**
	 * Cache group.
	 */
	protected $group = 'syllables-cache-fragments';

	/**
	 * Cache key used to reference cached data.
	 * @var string
	 */
	protected $key;

	/**
	 * Cached data's time-to-live, in seconds.
	 * @var integer
	 */
	protected $ttl;

	/**
	 * Fragment cache constructor.
	 *
	 * @param string  $key Key used to reference cached data.
	 * @param integer $ttl Time-to-live (in seconds).
	 */
	public function __construct( $key, $ttl ) {
		$this->key = $key;
		$this->ttl = $ttl;
	}

	/**
	 * Outputs cached content, if available, otherwise begins capturing output
	 * for caching.
	 *
	 * @return boolean Whether content was found in the cache.
	 */
	public function output() {
		$output    = wp_cache_get( $this->key, $this->group );
		$is_cached = ! empty( $output );

		echo $is_cached ? $output : '';

		if ( ! $is_cached ) {
			ob_start();
		}

		return $is_cached;
	}

	/**
	 * Stores the rendered snippet in the object cache.
	 */
	public function store() {
		// Flushes the buffers
		$output = ob_get_flush();
		wp_cache_add( $this->key, $output, $this->group, $this->ttl );
	}
}
