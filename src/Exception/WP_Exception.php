<?php
/**
 * @since 0.1.0
 */

namespace Syllables\Exception;

/**
 * Allows throwing a `WP_Error` object as an an exception.
 *
 * `WP_Error` sucks. Errors are meant to be thrown, not returned by methods like they
 * were valid results. This extends the default `Exception` class to allow converting
 * exceptions to and from `WP_Error` objects.
 *
 * Unfortunately, because a `WP_Error` object may contain multiple messages and error
 * codes, only the first message for the first error code in the instance will be
 * accessible through the exception's methods.
 *
 * @since 0.1.0
 */
class WP_Exception extends \Exception {

	/**
	 * WordPress handles string error codes.
	 * @var string
	 */
	protected $code;

	/**
	 * Error instance.
	 * @var \WP_Error
	 */
	protected $wp_error;

	/**
	 * WordPress exception constructor.
	 *
	 * The class constructor accepts either the traditional `\Exception` creation
	 * parameters or a `\WP_Error` instance in place of the previous exception.
	 *
	 * If a `\WP_Error` instance is given in this way, the `$message` and `$code`
	 * parameters are ignored in favour of the message and code provided by the
	 * `\WP_Error` instance.
	 *
	 * Depending on whether a `\WP_Error` instance was received, the instance is kept
	 * or a new one is created from the provided parameters.
	 *
	 * @param string               $message  Exception message (optional, defaults to empty).
	 * @param string               $code     Exception code (optional, defaults to empty).
	 * @param \Exception|\WP_Error $previous Previous exception or error (optional).
	 *
	 * @uses \WP_Error
	 * @uses \WP_Error::get_error_code()
	 * @uses \WP_Error::get_error_message()
	 *
	 * @codeCoverageIgnore
	 */
	public function __construct( $message = '', $code = '', $previous = null ) {
		$exception   = $previous;
		$is_wp_error = $previous instanceof \WP_Error;

		if ( $is_wp_error ) {
			$code      = $previous->get_error_code();
			$message   = $previous->get_error_message( $code );
			$exception = null;
		}

		parent::__construct( $message, null, $exception );

		$this->code     = $code;
		$this->wp_error = $is_wp_error ? $previous : null;
	}

	/**
	 * Obtain the exception's `\WP_Error` object.
	 *
	 * @return \WP_Error WordPress error.
	 */
	public function get_wp_error() {
		return $this->wp_error ? $this->wp_error : new \WP_Error( $this->code, $this->message, $this );
	}

}
