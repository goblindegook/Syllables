<?php
/**
 * @since 0.1.0
 */

namespace Syllables\Template\Loader;

/**
 * Class that implements a single custom template loader in a plugin.
 *
 * @since 0.1.0
 */
class Taxonomy extends \Syllables\Template\Loader {

	/**
	 * Taxonomies whose templates should be overridden.
	 * @var string[]
	 */
	protected $taxonomies = array();

	/**
	 * Queried term.
	 * @var object
	 */
	protected $term;

	/**
	 * Custom template loader.
	 *
	 * @param string[] $taxonomies Taxonomies whose templates should be overriden.
	 * @param string   $base_path  Base path for the template files.
	 */
	public function __construct( $base_path, $taxonomies ) {
		parent::__construct( $base_path );
		$this->taxonomies = (array) $taxonomies;
	}

	/**
	 * Prepares the object when the filter is applied.
	 *
	 * @uses \get_queried_object()
	 */
	protected function _prepare_filter() {
		$this->term = \get_queried_object();
	}

	/**
	 * Determines whether a custom template for a taxonomy term should be loaded.
	 *
	 * @return boolean Whether a custom template should be loaded.
	 *
	 * @uses \is_category()
	 * @uses \is_tag()
	 * @uses \is_tax()
	 */
	protected function _should_load_template() {
		return ( \is_tax() || \is_category() || \is_tag() )
			&& ! empty( $this->term->slug )
			&& in_array( $this->term->taxonomy, $this->taxonomies );
	}

	/**
	 * Returns a list of template file paths that match the request.
	 *
	 * @return string[] List with the full path for every valid template that matches the request.
	 */
	protected function _templates() {
		return array(
			"{$this->base_path}taxonomy-{$this->term->taxonomy}-{$this->term->slug}.php",
			"{$this->base_path}taxonomy-{$this->term->taxonomy}.php",
		);
	}
}
