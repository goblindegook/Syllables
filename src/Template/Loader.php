<?php
/**
 * @since 0.1.0
 */

namespace Syllables\Template;

/**
 * Abstract class that implements a custom template loader in a plugin.
 *
 * @since 0.1.0
 */
abstract class Loader {

	/**
	 * Path to the template file directory.
	 * @var string
	 */
	protected $base_path;

	/**
	 * Custom template loader.
	 *
	 * @param string $base_path  Base path for the template files.
	 *
	 * @uses \trailingslashit()
	 *
	 * @codeCoverageIgnore
	 */
	public function __construct( $base_path ) {
		$this->base_path = \trailingslashit( $base_path );
	}

	/**
	 * Schedules the template loader for execution.
	 *
	 * @param  integer $priority Execution priority, lower means earlier. Default is 10.
	 *
	 * @uses \add_filter()
	 * @uses \remove_filter()
	 */
	public function ready( $priority = 10 ) {
		\remove_filter( 'template_include', array( $this, 'filter' ) );
		\add_filter( 'template_include', array( $this, 'filter' ), $priority );
	}

	/**
	 * Filters a template file path and replaces it with a template provided by the
	 * plugin.
	 *
	 * @param  string $template Full path to the default template file.
	 * @return string           Filtered full path to template file
	 *
	 * @access public
	 * @see http://codex.wordpress.org/Plugin_API/Filter_Reference/template_include
	 */
	public function filter( $template ) {
		$this->_prepare_filter();
		return $this->_should_load_template() ? $this->_get_template( $template ) : $template;
	}

	/**
	 * Returns the first valid template out of a list of candidates, otherwise
	 * picks the fallback provided (if any).
	 *
	 * @param  string $fallback Fallback template (defaults to empty).
	 * @return string           Valid template or empty string.
	 *
	 * @codeCoverageIgnore
	 */
	private function _get_template( $fallback = '' ) {
		$templates = $this->_templates();

		foreach ( $templates as $template ) {
			if ( file_exists( $template ) ) {
				return $template;
			}
		}

		return $fallback;
	}

	/**
	 * Prepares the object when the filter is applied.
	 *
	 * @return null
	 */
	abstract protected function _prepare_filter();

	/**
	 * Determines whether a custom template should be loaded.
	 *
	 * @return boolean Whether a custom template should be loaded.
	 */
	abstract protected function _should_load_template();

	/**
	 * Returns a list of template file paths that match the request.
	 *
	 * @return array List with the full path for every valid template that match the request.
	 */
	abstract protected function _templates();
}
