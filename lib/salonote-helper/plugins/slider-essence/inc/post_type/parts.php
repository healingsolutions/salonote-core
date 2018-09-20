<?php
// パーツ
if( !function_exists( 'parts_custom_post_type' )){
	function parts_custom_post_type()
	{
			$labels = array(
					'name' => _x('パーツ', 'post type general name'),
					'singular_name' => _x('パーツ', 'post type singular name'),
					'add_new' => _x('パーツを追加', 'parts'),
					'add_new_item' => __('新しいパーツを追加'),
					'edit_item' => __('パーツを編集'),
					'new_item' => __('新しいパーツ'),
					'view_item' => __('パーツを表示'),
					'search_items' => __('パーツを探す'),
					'not_found' => __('パーツはありません'),
					'not_found_in_trash' => __('ゴミ箱にパーツはありません'),
					'parent_item_colon' => ''
			);
			$args = array(
					'labels' => $labels,
					'public' => false,
					'publicly_queryable' => false,
					'show_ui' => true,
					'query_var' => true,
					'rewrite' => false,
					'capability_type' => 'post',
					'hierarchical' => true,
					'menu_position' => 50,
					'menu_icon' => 'dashicons-tagcloud',
					'has_archive' => true,
					'supports' => array('title','editor','custom-fields'),
					'exclude_from_search' => true
			);
			register_post_type('parts',$args);
	}
	add_action('init', 'parts_custom_post_type',20);




	function slider_essence_manage_shortcode_columns($columns) {
			unset($columns['thumbnail']);
			unset($columns['date']);
			$columns['shortcode'] = 'ショートコード';
			return $columns;
	}
	add_filter('manage_edit-parts_columns', 'slider_essence_manage_shortcode_columns');


	function slider_essence_add_shortcode_column($column_name) {

			$thum = '';
			if ( 'shortcode' == $column_name) {
					$post_id = isset( $post_id) ? $post_id : null;
					$post_type_name = get_post_type($post_id);
					if($post_type_name == 'shortcode' || $post_type_name == 'parts'){
						$thum .= '[essence-parts id=' . get_the_ID() . ']';
					}
			}
			if ( isset($thum) && $thum ) {
					echo $thum;
			}
	}
	add_action('manage_pages_custom_column', 'slider_essence_add_shortcode_column');



	//パーツ 挿入
	if( !function_exists( 'print_parts_func' )){
	function print_parts_func($atts) {
		extract(shortcode_atts(array(
			'id'      => false,
		), $atts));
		ob_start();
		if ( !empty($id) ){
				//global $post_id;

				$place = 'parts-content';
				$post = get_post( $id );

				$_one_page_content = apply_filters('the_contrent', $post->post_content);
				echo do_shortcode(edit_content_hook($_one_page_content));

				do_action( 'essence_onepage_content' );
				do_action( 'essence_onepage_content_only_' . $id ); //１つだけに絞る場合

		};

		return ob_get_clean();
	}
	add_shortcode('essence-parts', 'print_parts_func');
	}

	
}