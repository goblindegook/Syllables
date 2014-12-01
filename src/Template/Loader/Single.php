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
class Single extends Post_Type_Archive {

	/**
	 * Prepares the object when the filter is applied.
	 *
	 * @uses get_queried_object()
	 */
	protected function _prepare_filter() {
		$post = get_queried_object();

		if ( ! empty( $post->post_type ) ) {
			$this->post_type = get_post_type_object( $post->post_type );
		}
	}

	/**
	 * Determines whether a custom template for a single post should be loaded.
	 *
	 * @return boolean Whether a custom template should be loaded.
	 *
	 * @uses is_single()
	 */
	protected function _should_load_template() {
		return is_single()
			&& ! empty( $this->post_type )
			&& in_array( $this->post_type->name, $this->post_types );
	}

	/**
	 * Returns a list of template file paths that match the request.
	 *
	 * @return array List with the full path for every valid template that matches the request.
	 */
	protected function _templates() {
		return array( "{$this->base_path}single-{$this->post_type->name}.php" );
	}
}
