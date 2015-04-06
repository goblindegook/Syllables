<?php
/**
 * Implements fragment caching using a set of keys and multisite ready.
 *
 * @since 0.4.0
 */

namespace Syllables\Cache;

/**
 * Class that implements fragment caching using a set of keys and that is multisite ready.
 *
 * @since 0.4.0
 */
class Sentence extends Fragment {

	/**
	 * Fragment cache constructor.
	 *
	 * @param array   $keys    Set of keys used to uniquely reference cached data.
	 * @param integer $expires Cache expiration or TTL, in seconds.
	 */
	public function __construct( $keys = array(), $expires ) {

		if ( \is_multisite() ) {
			array_push( $keys, \get_current_blog_id() );
		}

		if ( empty( $keys ) ) {
			throw new \Exception( "Cache key not provided." );
		}

		parent::__construct( implode( '-', $keys ), $expires );
	}

}
