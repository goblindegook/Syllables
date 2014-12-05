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
	 * @var object
	 */
	protected $post_type;

	/**
	 * Custom template loader.
	 *
	 * @param string[] $post_types Post types whose templates should be overriden.
	 * @param string   $base_path  Base path for the template files.
	 */
	public function __construct( $base_path, $post_types ) {
		parent::__construct( $base_path );
		$this->post_types = (array) $post_types;
	}

	/**
	 * Prepares the object when the filter is applied.
	 *
	 * @uses get_queried_object()
	 */
	protected function _prepare_filter() {
		$this->post_type = get_queried_object();
	}

	/**
	 * Determines whether a custom template for a post type archive should be loaded.
	 *
	 * @return boolean Whether a custom template should be loaded.
	 *
	 * @uses is_post_type_archive()
	 */
	protected function _should_load_template() {
		return is_post_type_archive()
			&& ! empty( $this->post_type )
			&& in_array( $this->post_type->name, $this->post_types )
			&& $this->post_type->has_archive;
	}

	/**
	 * Returns a list of template file paths that match the request.
	 *
	 * @return string[] List with the full path for every valid template that matches the request.
	 */
	protected function _templates() {
		return array( "{$this->base_path}archive-{$this->post_type->name}.php" );
	}
}
