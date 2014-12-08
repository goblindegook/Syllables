<?php

namespace Syllables\Tests\Exception;

use WP_Mock;
use WP_Mock\Tools\TestCase;
use Syllables\Exception\WP_Exception;

/**
 * @coversDefaultClass \Syllables\Exception\WP_Exception
 *
 */
class WP_Exception_Test extends TestCase {

	/**
	 * Test error code.
	 * @var string
	 */
	protected $code    = 'test';

	/**
	 * Test error message.
	 * @var string
	 */
	protected $message = 'Testing WP_Exception';

	/**
	 * @expectedException \Syllables\Exception\WP_Exception
	 */
	public function test_exception() {
		throw new WP_Exception();
	}

	/**
	 * Checks that `\WP_Error` objects are correctly passed inside `WP_Exception`.
	 *
	 * @covers ::get_wp_error
	 *
	 * @uses \WP_Error
	 */
	public function test_get_wp_error_previous() {
		$expected_wp_error = new \WP_Error( $this->code, $this->message );
		$exception         = new WP_Exception( null, null, $expected_wp_error );

		$wp_error = $exception->get_wp_error();

		$this->assertSame( $expected_wp_error, $wp_error,
			'WP_Error is passed inside the exception.' );

		$code = $wp_error->get_error_code();

		$this->assertEquals( $exception->getCode(), $code,
			'Exception has the same code as WP_Error.' );

		$message = $wp_error->get_error_message( $code );

		$this->assertEquals( $exception->getMessage(), $message,
			'Exception has the same message as WP_Error.' );

		$actual_exception = $wp_error->get_error_data( $code );

		$this->assertNotSame( $exception, $actual_exception,
			'WP_Error data does not contain the thrown exception' );
	}

	/**
	 * Checks that new `\WP_Error` objects can be created from a `WP_Exception`.
	 *
	 * @covers ::get_wp_error
	 *
	 * @uses \WP_Error
	 */
	public function test_get_wp_error_new() {
		$exception = new WP_Exception( $this->message, $this->code );

		$wp_error = $exception->get_wp_error();

		$this->assertInstanceOf( '\WP_Error', $wp_error,
			'WP_Error created from exception is an instance of \WP_Error.' );

		$code = $wp_error->get_error_code();

		$this->assertEquals( $this->code, $code,
			'WP_Error created from exception has the same code.' );

		$message = $wp_error->get_error_message( $code );

		$this->assertEquals( $this->message, $message,
			'WP_Error created from exception has the same message.' );

		$actual_exception = $wp_error->get_error_data( $code );

		$this->assertSame( $exception, $actual_exception,
			'WP_Error data contains the thrown exception' );
	}

}
