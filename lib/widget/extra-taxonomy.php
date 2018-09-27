<?php
class extra_Widget_Tag_Cloud extends WP_Widget_Tag_Cloud{

	public function widget( $args, $instance ) {
		$current_taxonomy = $this->_get_current_taxonomy( $instance );
		
		
	

		if ( ! empty( $instance['title'] ) ) {
			$title = $instance['title'];
		} else {
			if ( 'post_tag' === $current_taxonomy ) {
				$title = __( 'Tags' );
			} else {
				$tax = get_taxonomy( $current_taxonomy );
				$title = $tax->labels->name;
			}
		}

		$show_count = ! empty( $instance['count'] );

		/**
		 * Filters the taxonomy used in the Tag Cloud widget.
		 *
		 * @since 2.8.0
		 * @since 3.0.0 Added taxonomy drop-down.
		 * @since 4.9.0 Added the `$instance` parameter.
		 *
		 * @see wp_tag_cloud()
		 *
		 * @param array $args     Args used for the tag cloud widget.
		 * @param array $instance Array of settings for the current widget.
		 */
		$tag_cloud = wp_tag_cloud( apply_filters( 'widget_tag_cloud_args', array(
			'taxonomy'   => $current_taxonomy,
			'echo'       => false,
			'show_count' => $show_count,
		), $instance ) );

		if ( empty( $tag_cloud ) ) {
			return;
		}

		/** This filter is documented in wp-includes/widgets/class-wp-widget-pages.php */
		$title = apply_filters( 'widget_title', $title, $instance, $this->id_base );

		echo $args['before_widget'];
		if ( $title ) {
			echo $args['before_title'] . $title . $args['after_title'];
		}

		
		if ( 'post_tag' !== $current_taxonomy ){
			echo '<div class="tagcloud side_list">';
			echo '<ul class="list-bordered">';
			$tag_cloud = preg_replace('/<a/', '<li class="parent-list-item"><a', $tag_cloud);
			$tag_cloud = preg_replace('/<\/a>/', '</a></li>', $tag_cloud);
			$tag_cloud = preg_replace('/<span class="tag-link-count"> \(([0-9]*)\)<\/span>/', ' <span class="list-item-count icon-color">${1}</span>', $tag_cloud);
			echo $tag_cloud;
			echo '</ul>';
			echo "</div>\n";
		}else{
			echo '<div class="tagcloud side_list">';
			
			$tag_cloud = str_replace("tag-cloud-link", "tag-cloud-link nav_hover-item", $tag_cloud);
			echo $tag_cloud;
			echo "</div>\n";
		}
		echo $args['after_widget'];
	}

	
}

add_action( 'widgets_init', function () {
    register_widget( 'extra_Widget_Tag_Cloud' );
} );