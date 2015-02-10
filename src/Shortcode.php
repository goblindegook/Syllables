<?php
/**
 * Implements shortcode utilities.
 *
 * @since 0.1.0
 */

namespace Syllables;

/**
 * Shortcode wrapper class.
 *
 * @since 0.3.0
 */
class Shortcode {

	/**
	 * Shortcode tag.
	 * @var string
	 */
	private $tag;

	/**
	 * Shortcode callback.
	 * @var callable
	 */
	private $callback;

	/**
	 * Shortcode constructor.
	 *
	 * @param string   $tag      Shortcode tag.
	 * @param callable $callback Shortcode callback.
	 *
	 * @codeCoverageIgnore
	 */
	public function __construct( $tag, $callback ) {
		$this->tag      = $tag;
		$this->callback = $callback;
	}

	/**
	 * Registers the shortcode hook.
	 *
	 * @uses \add_shortcode()
	 */
	public function add() {
		if ( \shortcode_exists( $this->tag ) ) {
			throw new \Exception( "Shortcode `{$this->tag}` exists." );
		}

		\add_shortcode( $this->tag, array( $this, 'render' ) );
	}

	/**
	 * Deregisters the shortcode hook.
	 *
	 * @uses \remove_shortcode()
	 */
	public function remove() {
		\remove_shortcode( $this->tag );
	}

	/**
	 * Replaces the callback for this shortcode tag.
	 */
	public function replace() {
		$this->remove();
		$this->add();
	}

	/**
	 * Renders the hooked shortcode.
	 *
	 * @param  array  $atts The shortcode's attributes.
	 * @return string       The rendered shortcode.
	 *
	 * @uses \apply_filters()
	 */
	public function render( $atts ) {
		$output = call_user_func( $this->callback, $atts );

		/**
		 * Filters the shortcode output.
		 *
		 * @param  string $output This shortcode's rendered output.
		 * @param  array  $atts   The attributes used to invoke this shortcode.
		 * @param  array  $tag    This shortcode tag.
		 * @return string         This shortcode's filtered output.
		 */
		return \apply_filters( 'syllables/shortcode/render', $output, $atts, $this->tag );
	}
}
