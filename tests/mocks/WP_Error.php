<?php

/**
 * Mocks the WP_Error object for testing.
 */
class WP_Error {

	protected $code;
	protected $message;
	protected $data;

	public function __construct( $code, $message = '', $data = null ) {
		$this->code    = $code;
		$this->message = $message;
		$this->data    = $data;
	}

	public function get_error_code() {
		return $this->code;
	}

	public function get_error_message( $code ) {
		return $this->message;
	}

	public function get_error_data( $code ) {
		return $this->data;
	}

}
