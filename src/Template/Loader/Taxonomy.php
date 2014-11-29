<?php
namespace Syllables\Template\Loader;

/**
 * Class that implements a single custom template loader in a plugin.
 */
class Taxonomy extends \Syllables\Template\Loader {

	/**
	 * Taxonomies whose templates should be overridden.
	 * @var array
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
	 * @param array  $taxonomies Taxonomies whose templates should be overriden.
	 * @param string $base_path  Base path for the template files.
	 */
	public function __construct( $base_path, $taxonomies ) {
		parent::__construct( $base_path );
		$this->taxonomies = (array) $taxonomies;
	}

	/**
	 * Prepares the object when the filter is applied.
	 */
	protected function _prepare_filter() {
		$this->term = get_queried_object();
	}

	/**
	 * Determines whether a custom template for a taxonomy term should be loaded.
	 *
	 * @return boolean Whether a custom template should be loaded.
	 */
	protected function _should_load_template() {
		return is_tax() && ! empty( $this->term->slug ) && in_array( $this->term->taxonomy, $this->taxonomies );
	}

	/**
	 * Returns a list of template file paths that match the request.
	 *
	 * @return array List with the full path for every valid template that matches the request.
	 */
	protected function _templates() {
		return array(
			"{$this->base_path}taxonomy-{$this->term->taxonomy}-{$this->term->slug}.php",
			"{$this->base_path}taxonomy-{$this->term->taxonomy}.php",
		);
	}
}
