<?php
// staff
if (!function_exists('staff_custom_post_type')) {
function staff_custom_post_type()
{
    $labels = array(
        'name' => __('staff','salonote-essence'),
        'singular_name' => __('staff','salonote-essence'),
        'add_new' => __('add staff','salonote-essence'),
        'add_new_item' => __('add new staff','salonote-essence'),
        'edit_item' => __('edit staff','salonote-essence'),
        'new_item' => __('new staff','salonote-essence'),
        'view_item' => __('show staff','salonote-essence'),
        'search_items' => __('search staff','salonote-essence'),
        'not_found' => __('no staff','salonote-essence'),
        'not_found_in_trash' => __('no staff in trash','salonote-essence'),
        'parent_item_colon' => ''
    );
    $args = array(
        'labels' => $labels,
        'public' => true,
        'publicly_queryable' => true,
        'show_ui' => true,
				'show_in_rest' => true,
        'query_var' => true,
        'rewrite' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'menu_position' => 50,
        'menu_icon' => 'dashicons-groups',
        'has_archive' => true,
        'supports' => array('title','editor','excerpt','thumbnail','author','page-attributes'),
        'exclude_from_search' => false
    );
    register_post_type('staff',$args);
	
	
		$args = array(
        'label' => '店舗',
        'public' => true,
        'show_ui' => true,
        'hierarchical' => true
    );
    register_taxonomy('shop','staff',$args);
}
add_action('init', 'staff_custom_post_type',40);
	
}


//custom fields column


//投稿一覧画面にカスタムフィールドの表示カラムを追加
function salonote_staff_posts_columns( $defaults ) {
	$defaults['subTitle'] = '肩書き';
	$defaults['shop'] = '店舗';
	return $defaults;
}
add_filter( 'manage_staff_posts_columns', 'salonote_staff_posts_columns' );
function salonote_staff_posts_custom_column( $column, $post_id ) {
	
    switch ( $column ) {
        case 'subTitle':
            $post_meta = get_post_meta( $post_id, 'subTitle', true );
            if ( $post_meta ) {
                echo $post_meta;
            } else {
                echo '';
            }
        break;
				
				case 'shop':
            echo get_the_term_list($post_id, 'shop', '', ', ');
        break;
    }
}
add_action( 'manage_staff_posts_custom_column' , 'salonote_staff_posts_custom_column', 10, 2 );



//クイック編集にカスタムフィールド(年度)の入力欄を表示
function display_salonote_staff_quickmenu( $column_name, $post_type ) {
    static $print_nonce = TRUE;
    if ( $print_nonce ) {
        $print_nonce = FALSE;
        wp_nonce_field( 'quick_edit_action', $post_type . '_edit_nonce' ); //CSRF対策
    }
    ?>
<fieldset class="inline-edit-col-right inline-custom-meta">
<div class="inline-edit-col column-<?php echo $column_name ?>">
            <label class="inline-edit-group"></p>
              <?php
                switch ( $column_name ) {
                    case 'subTitle':
                        ?><span class="title">肩書き</span><input name="subTitle" /><?php
                        break;
                }
                ?>
           </label>
        </div>
</fieldset>
<?php
}
add_action( 'quick_edit_custom_box', 'display_salonote_staff_quickmenu', 10, 2 );




function save_custom_meta( $post_id ) {
    $slug = 'staff';
    if ( $slug !== get_post_type( $post_id ) ) {
        return;
    }
    if ( !current_user_can( 'edit_post', $post_id ) ) {
        return;
    }
    $_POST += array("{$slug}_edit_nonce" => '');
    if ( !wp_verify_nonce( $_POST["{$slug}_edit_nonce"], 'quick_edit_action' ) ) {
        return;
    }
    if ( isset( $_REQUEST['subTitle'] ) ) {
        update_post_meta( $post_id, 'subTitle', $_REQUEST['subTitle'] );
    }
}
add_action( 'save_post', 'save_custom_meta' );

?>