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
class Post_Type_Archive extends \Syllables\Template\Loader {

	/**
	 * Post types whose templates should be overridden.
	 * @var string[]
	 */
	protected $post_types = array();

	/**
	 * Queried post type slug.
	 * @var string
	 */
	protected $post_type = '';

	/**
	 * Custom template loader.
	 *
	 * @param string[] $post_types Post types whose templates should be overriden.
	 * @param string   $base_path  Base path for the template files.
	 *
	 * @codeCoverageIgnore
	 */
	public function __construct( $base_path, $post_types ) {
		parent::__construct( $base_path );
		$this->post_types = (array) $post_types;
	}

	/**
	 * Prepares the object when the filter is applied.
	 *
	 * @uses \get_queried_object()
	 *
	 * @codeCoverageIgnore
	 */
	protected function _prepare_filter() {
		$post_type = \get_queried_object();

		if ( ! empty( $post_type->name ) && ! empty( $post_type->has_archive ) ) {
			$this->post_type = $post_type->name;
		}
	}

	/**
	 * Determines whether a custom template for a post type archive should be loaded.
	 *
	 * @return boolean Whether a custom template should be loaded.
	 *
	 * @uses \is_post_type_archive()
	 *
	 * @codeCoverageIgnore
	 */
	protected function _should_load_template() {
		return \is_post_type_archive()
			&& in_array( $this->post_type, $this->post_types );
	}

	/**
	 * Returns a list of template file paths that match the request.
	 *
	 * @return string[] List with the full path for every valid template that matches the request.
	 *
	 * @codeCoverageIgnore
	 */
	protected function _templates() {
		return array( "{$this->base_path}archive-{$this->post_type}.php" );
	}
}
