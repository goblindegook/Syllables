<?php

namespace Syllables\Tests;

/**
 * Extends WordPress' default unit test case class with additional assertion methods.
 */
class UnitTestCase extends \WP_UnitTestCase {

	/**
	 * Asserts that a filter or action has been added.
	 *
	 * @param  string            $tag       The name of the action or filter hooked.
	 * @param  callable|\Closure $callable  Callback function, method or closure.
	 * @param  integer           $priority  Hook execution priority (defaults to 10).
	 * @param  string            $message   Assertion message (defaults to empty).
	 *
	 * @global wp_filter
	 *
	 * @uses \_wp_filter_build_unique_id()
	 */
	public function assertHookAdded( $tag, $callable, $priority = 10, $message = '' ) {

		if ( ! is_string( $tag ) ) {
			throw PHPUnit_Util_InvalidArgumentHelper::factory( 1, 'string' );
		}

		if ( ! is_callable( $callable ) || $callable instanceof \Closure ) {
			throw PHPUnit_Util_InvalidArgumentHelper::factory( 2, 'callable or Closure' );
		}

		$hooks    = $GLOBALS['wp_filter'];
		$priority = $priority === null ? 10 : $priority;
		$idx      = _wp_filter_build_unique_id( $tag, $callable, $priority );

		$this->assertTrue( isset( $hooks[ $tag ][ $priority ][ $idx ] ), $message );
	}

}
