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
 * Uses code taken from Mark Jaquith's `CWS_Fragment_Cache` class. The `cache()`
 * method improves upon Jaquith's original interface because it removes the risk of
 * a developer forgetting to call the `_store()` method and breaking the site.
 *
 * Usage:
 *
 * ```php
 * $fragment = new \Syllables\Cache\Fragment( 'unique-key', 3600 );
 *
 * $fragment->cache( function () {
 *
 *     expensive_code_that_outputs_something();
 * } );
 * ```
 *
 * Usage with variables from the parent scope:
 *
 * ```php
 * $fragment = new \Syllables\Cache\Fragment( 'unique-key', 3600 );
 *
 * $param = 'something';
 *
 * $fragment->cache( function () use ( &$param ) {
 *
 *     expensive_code_that_outputs_something( $param );
 * } );
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
	protected $expires;

	/**
	 * Fragment cache constructor.
	 *
	 * @param string  $key     Key used to uniquely reference cached data.
	 * @param integer $expires Cache expiration or TTL, in seconds.
	 */
	public function __construct( $key, $expires = 0 ) {
		$this->key     = $key;
		$this->expires = $expires;
	}

	/**
	 * Outputs cached content, if available, otherwise begins capturing output
	 * for caching.
	 *
	 * @return boolean Whether content was found in the cache.
	 */
	protected function _output() {
		$output = wp_cache_get( $this->key, $this->group );

		if ( ! empty( $output ) ) {
			echo $output;
			return true;
		}

		ob_start();

		return false;
	}

	/**
	 * Stores the rendered snippet in the object cache.
	 */
	protected function _store() {
		// Flushes the buffers
		$output = ob_get_flush();

		wp_cache_add( $this->key, $output, $this->group, $this->expires );
	}

	/**
	 * Caches the output of a callable.
	 *
	 * @param callable $callable Code whose output should be cached.
	 */
	public function cache( callable $callable ) {
		if ( ! $this->_output() ) {
			call_user_func( $callable );
			$this->_store();
		}
	}
}
