<?php
// イベント

	function event_manager_custom_post_type()
	{
			$labels = array(
					'name' => _x('イベント', 'post type general name'),
					'singular_name' => _x('イベント', 'post type singular name'),
					'add_new' => _x('イベントを追加', 'event_manager'),
					'add_new_item' => __('新しいイベントを追加'),
					'edit_item' => __('イベントを編集'),
					'new_item' => __('新しいイベント'),
					'view_item' => __('イベントを表示'),
					'search_items' => __('イベントを探す'),
					'not_found' => __('イベントはありません'),
					'not_found_in_trash' => __('ゴミ箱にイベントはありません'),
					'parent_item_colon' => ''
			);
			$args = array(
					'labels'              => $labels,
					'public'              => true,
					'publicly_queryable'  => true,
					'show_ui'             => true,
					'query_var'           => true,
					'rewrite'             => true,
					'capability_type'     => 'post',
					'hierarchical'        => false,
					'menu_position'       => 52,
					'menu_icon'           => 'dashicons-store',
					'has_archive'         => true,
					'supports'            => array('title','editor','thumbnail'),
					'exclude_from_search' => true,
					'show_in_rest'			  => true,
					'rest_base'   				=> 'events'
			);
			register_post_type('events',$args);
		
		
			// カスタムタクソノミーを作成
			$args = array(
					'label' => 'イベントカテゴリ',
					'public' => true,
					'show_ui' => true,
					'hierarchical' => true
			);
			register_taxonomy('event_category','events',$args);
		
			// カスタムタクソノミーを作成
			$args = array(
					'label' => 'エリア',
					'public' => true,
					'show_ui' => true,
					'hierarchical' => true
			);
			register_taxonomy('event_area','events',$args);
		
		
			add_rewrite_rule('events/date/([0-9])/?$' , 'index.php?m=$matches[1]?post_type=events','top');
	}
	add_action('init', 'event_manager_custom_post_type');
