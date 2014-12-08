<?php

if ( ! class_exists( 'WP_Error' ) ) {

	/**
	 * Mocks the WP_Error object for testing.
	 */
	class WP_Error {

		/**
		 * @var string
		 */
		protected $code;

		/**
		 * @var array
		 */
		protected $error = array();

		/**
		 * @param string     $code
		 * @param string     $message
		 * @param mixed|null $data
		 */
		public function __construct( $code, $message = '', $data = null ) {
			$this->code = $code;

			$this->error[ $code ]['message'] = $message;
			$this->error[ $code ]['data']    = $data;
		}

		/**
		 * @return string
		 */
		public function get_error_code() {
			return $this->code;
		}

		/**
		 * @return string
		 */
		public function get_error_message( $code ) {
			return $this->error[ $code ]['message'];
		}

		/**
		 * @return mixed
		 */
		public function get_error_data( $code ) {
			return $this->error[ $code ]['data'];
		}

	}

}
