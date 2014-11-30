<?php

namespace Syllables\Tests\Exception;

use Syllables\Exception\WP_Exception;

/**
 * @coversDefaultClass \Syllables\Tests\Exception\WP_Exception
 */
class Test_WP_Exception extends \WP_UnitTestCase {

	/**
	 * Setup a test method.
	 */
	public function setUp() {
		parent::setUp();
	}

	/**
	 * Clean up after a test method.
	 */
	public function tearDown() {
		parent::tearDown();
	}

	/**
	 * Checks that `\WP_Error` objects are correctly passed inside `WP_Exception`.
	 *
	 * @covers ::get_wp_error
	 */
	public function test_get_wp_error_previous() {
		$code    = 'test';
		$message = 'Testing WP_UnitTestCase';

		$wp_error = new \WP_Error( $code, $message );

		try {
			throw new WP_Exception( null, null, $wp_error );

		} catch ( WP_Exception $e ) {
			$actual_wp_error = $e->get_wp_error();

			$this->assertSame( $wp_error, $actual_wp_error,
				'WP_Error is passed inside the exception.' );

			$actual_code = $actual_wp_error->get_error_code();

			$this->assertEquals( $e->getCode(), $actual_code,
				'Exception has the same code as WP_Error.' );

			$actual_message = $actual_wp_error->get_error_message( $actual_code );

			$this->assertEquals( $e->getMessage(), $actual_message,
				'Exception has the same message as WP_Error.' );

			$actual_exception = $actual_wp_error->get_error_data( $actual_code );

			$this->assertNotSame( $e, $actual_exception,
				'WP_Error data does not contain the thrown exception' );
		}
	}

	/**
	 * Checks that new `\WP_Error` objects can be created from a `WP_Exception`.
	 *
	 * @covers ::get_wp_error
	 */
	public function test_get_wp_error_new() {
		$code    = 'test';
		$message = 'Testing WP_UnitTestCase';

		try {
			throw new WP_Exception( $message, $code );

		} catch ( WP_Exception $e ) {
			$actual_wp_error = $e->get_wp_error();

			$this->assertInstanceOf( '\WP_Error', $actual_wp_error,
				'WP_Error created from exception is an instance of \WP_Error.' );

			$actual_code = $actual_wp_error->get_error_code();

			$this->assertEquals( $code, $actual_code,
				'WP_Error created from exception has the same code.' );

			$actual_message = $actual_wp_error->get_error_message( $actual_code );

			$this->assertEquals( $message, $actual_message,
				'WP_Error created from exception has the same message.' );

			$actual_exception = $actual_wp_error->get_error_data( $actual_code );

			$this->assertSame( $e, $actual_exception,
				'WP_Error data contains the thrown exception' );
		}
	}

}
