<?php
/*  Copyright 2016 Healing Solutions (email : info@healing-solutions.jp)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
     published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}


/*-------------------------------------------*/
/*	weekday function
/*-------------------------------------------*/
function tag_weekday_japanese_convert( $date ){
 global $weekday;
 $weekday = array(
	 __('Sunday','salonote-essence'),
	 __('Monday','salonote-essence'),
	 __('Tuesday','salonote-essence'),
	 __('Wednesday','salonote-essence'),
	 __('Thursday','salonote-essence'),
	 __('Friday','salonote-essence'),
	 __('Saturday','salonote-essence'),
 );
 return '('.$weekday[date( 'w',strtotime($date))].')';
}


/*-------------------------------------------*/
/*	title
/*-------------------------------------------*/
add_filter('wp_title','getHeadTitle');
function getHeadTitle($title) {
  
  global $theme_opt;

  $title = '';
  $_sub_title = !empty( $theme_opt['base']['title'] ) ? $theme_opt['base']['title'] : get_bloginfo( 'name' );

  // home
  if (is_home() || is_page('home') || is_front_page()) {
		$title = $_sub_title;
  // cat
  } else if (is_category() ) {
          $title = single_cat_title('',false)." - ".$_sub_title;
  } else if (is_tax()) {
          $title = single_cat_title('',false)." - ".$_sub_title;
  
  // archive
  } else if (is_archive()) {
      if (is_year()){
          $title = get_the_time('Y').__('year posts','salonote-essence').$_sub_title;
      } else if (is_month()){
          $title = get_the_date('Y'.__('year','salonote-essence').'M').__(' posts','salonote-essence').$_sub_title;
      } else if (is_category()){
          $title = single_cat_title().$_sub_title;
      } else if (is_tag()){
          $title = single_tag_title('',false).$_sub_title; 
      } else if (is_author()) {
          $userObj = get_queried_object();
          $title = esc_html($userObj->display_name).__(' posts','salonote-essence').$_sub_title;
      } else if (get_post_type()) {
          $userObj = "";
          $title = post_type_archive_title('',false)." | ".$_sub_title;
  }

  // singular
  } else if (is_singular()) {
    global $post;
      $metaExcerpt = $post->post_excerpt;
      if ($metaExcerpt) {
					$title = $post->post_excerpt." | ".get_the_title()." ".$_sub_title;;

      //post_type
       }else if (get_post_type()) {
          $userObj = "";
          $title = get_the_title()." | ".$_sub_title;

      } else {
          $title = mb_substr( strip_tags($post->post_content), 0, 240 );
          $title = str_replace(array("\r\n","\r","\n"), ' ', $title);
      }

  // other
  }


  global $page, $paged;
  //paged
  if( $paged >= 2 || $page >= 2 ){
      $title =  max( $paged, $page ) . __(' page','salonote-essence').' - ' . $title;
  }

  return strip_tags($title);
}



/*-------------------------------------------*/
/*	head_description
/*-------------------------------------------*/
add_filter( 'option_blogdescription', 'essence_option_description' );
function essence_option_description($description) {
  
  global $theme_opt;
  $description = '';
  $_sub_description = !empty( $theme_opt['base']['description'] ) ? $theme_opt['base']['description'] : get_bloginfo( 'name',false );


  // home
  if (is_home() || is_page('home') || is_front_page()) {
					$description = $_sub_description;

  // cat
  } else if (is_category() ) {
          $description = single_cat_title()." - ".$_sub_description;
  } else if (is_tax()) {

  // tags */
  } else if (is_tag()) {
      $description = strip_tags(tag_description());
      $description = str_replace(array("\r\n","\r","\n"), '', $description);
      if ( ! $description ) {
          $description = single_tag_title('',false)." - ".$_sub_description;
  }

  // archive
  } else if (is_archive()) {
      if (is_year()){
          $description = get_the_time('Y').__('year posts','salonote-essence').$_sub_description;
      } else if (is_month()){
          $description = get_the_date('Y'.__('year','salonote-essence').'M').__(' posts','salonote-essence').$_sub_description;
      } else if (is_category()){
          $description = single_cat_title().$_sub_description;
      } else if (is_tag()){
          $description = single_tag_title('',false).$_sub_description;
      } else if (is_author()) {
          $userObj = get_queried_object();
          $description = esc_html($userObj->display_name).__(' posts','salonote-essence').$_sub_description;
      } else if (get_post_type()) {
          $userObj = "";
          $description = post_type_archive_title('',false)." | ".$_sub_description;
  }

  // singular
  } else if ( is_singular() ) {
    global $post;
      $metaExcerpt = $post->post_excerpt;
      if ($metaExcerpt) {
          $description = $post->post_excerpt;

      //post_type
       }else if (get_post_type()) {
          $userObj = "";
          $description = get_the_title()." | ".$_sub_description;

      } else {
          $description = mb_substr( strip_tags($post->post_content), 0, 240 );
          $description = str_replace(array("\r\n","\r","\n"), ' ', $description);
      }

  // other
  }

  global $page, $paged;
  //paged
  if( $paged >= 2 || $page >= 2 ){
      $description =  max( $paged, $page ) . __('page','salonote-essence').' - ' . $description;
  }

  return strip_tags($description);
}

// ====================
// list thumbnail size
function get_all_image_sizes() {
    global $_wp_additional_image_sizes;

    $default_image_sizes = get_intermediate_image_sizes();

    foreach ( $default_image_sizes as $size ) {
        $image_sizes[ $size ][ 'width' ] = intval( get_option( "{$size}_size_w" ) );
        $image_sizes[ $size ][ 'height' ] = intval( get_option( "{$size}_size_h" ) );
        $image_sizes[ $size ][ 'crop' ] = get_option( "{$size}_crop" ) ? get_option( "{$size}_crop" ) : false;
    }

    if ( isset( $_wp_additional_image_sizes ) && count( $_wp_additional_image_sizes ) ) {
        $image_sizes = array_merge( $image_sizes, $_wp_additional_image_sizes );
    }
  
    $thumbnail_sizes = [];
    foreach($image_sizes as $key => $thumb_size){
      $thumbnail_sizes[$key] = $key;
    }

    return $thumbnail_sizes;
}


// ====================
// add body class
add_filter( 'body_class', 'essence_class_names' );
function essence_class_names( $classes ) {
  global $theme_opt;
  
  if( !empty($theme_opt['extention']) ){		
		$_body_class = [];
		foreach( $theme_opt['extention'] as $key => $value ){
			if (is_numeric($key)) {
				$_body_class[] = $value;
			}
		}
		
		$classes = array_merge($classes,$_body_class);
	}
	
	$classes[] = 'no-scroll';

	
	if( is_singular()  ){
		global $post;
		$classes[] = empty(get_post_meta( $post->ID, 'es_slider_upload_images', true )) ? 'no-slider' : null ;
	}
	
	
	
  return $classes;
}


// ====================
// container class
function container_class(){
  global $theme_opt;
  global $post_type_set;
	global $page_info;
  
  if( !empty( $theme_opt['base'] ) && in_array('container',$theme_opt['base'] ) ){

    if( is_singular() ){
      $container_check = 'none_page_container';
    }else{
      $container_check = 'none_archive_container'; 
    }

    if(
      !empty( $post_type_set ) &&
      !in_array($container_check,$post_type_set) &&
			empty($page_info['full_size'] )
    ){
      $container_class    = 'container';
    }else{
      $container_class    = 'none_container';
    }

  }else{
    $container_class    = 'none_container';
  }
  
  return $container_class;
}



// ==================
// set post_type list
function get_post_type_list($post_types = null){
	
	$post_types_list = [];
	
	foreach( $post_types as $post_type_item ){
		if( $post_type_item == 'post' ){
			$post_types_list['post'] = __('posts','salonote-essence');
		}else{
			$post_type_obj = get_post_type_object($post_type_item);
			$post_types_list[$post_type_item] = $post_type_obj->label;
		}
	}
	
	return $post_types_list;
}


// ==================
// pagenation
function essence_pagination($pages = '', $range = 4)
{  
	if( $range == -1 ) return;
		
     $showitems = ($range * 2)+1;  

     global $paged;
     if(empty($paged)) $paged = 1;
 
     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }   
 
     if(1 != $pages)
     {
         echo "<div class='pagination'>";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
 
         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<a href='".get_pagenum_link($i)."' class='current'>".$i."</a>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
             }
         }
 
         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div>\n";
     }
}




//===============================================
//public future post
add_action('save_post', 'futuretopublish', 99);
add_action('edit_post', 'futuretopublish', 99);
function futuretopublish(){
  global $wpdb;
  $sql = 'UPDATE `'.$wpdb->prefix.'posts` ';
  $sql .= 'SET post_status = "publish" ';
  $sql .= 'WHERE post_status = "future"';
  $wpdb->get_results($sql);
}




//===============================================
//get_next_page title
function get_paged_nav_title( $post =null ){
	
	if( empty($post) ) return;
	
	global $page;
	
	$max_page = mb_substr_count($post->post_content, '<!--nextpage-->') + 1;
	$pattern= '/\<h\d{1}(.+?)?\>(.+?)\<\/h\d{1}>/s';
	
	
	
	if( $max_page >= $page && $page !== 1 ){
		//echo 'prev' . ($page - 1);
		
		$prev_num = $page - 2;
		$prev_arr = explode("<!--nextpage-->",$post->post_content);
		preg_match( $pattern, $prev_arr[$prev_num], $match);
		$prev_title = $match ? $match[2] : get_the_title() ;
		$prev_title = strip_tags($prev_title,'<br>');
		
		echo '<div class="prev_title float-left"><a href="'.get_the_permalink(). ($page-1) .'">&lt;&lt; ' .($page-1) .'.'. nl2br(esc_attr($prev_title)) .'</a></div>';
	}
	
	
	if( $max_page > $page && $max_page !== $page ){
		//echo 'next' . ($page + 1);
		
		$prev_num = $page;
		$prev_arr = explode("<!--nextpage-->",$post->post_content);
		preg_match( $pattern, $prev_arr[$prev_num], $match);
		
		$naxt_title = $match ? $match[2] : '' ;
		
		echo '<div class="next_title float-right"><a href="'.get_the_permalink(). ($page+1) .'">' .($page+1) .'.'. nl2br(esc_attr($naxt_title)) .' &gt;&gt;</a></div>';
	}
	
	return;
}




//===============================================
//is_child
function is_child( $slug = "" ) {
  if(is_singular()):
    global $post;
    if ( $post->post_parent ) {
      $post_data = get_post($post->post_parent);
      if($slug != "") {
        if(is_array($slug)) {
          for($i = 0 ; $i <= count($slug); $i++) {
            if($slug[$i] == $post_data->post_name || $slug[$i] == $post_data->ID || $slug[$i] == $post_data->post_title) {
              return true;
            }
          }
        } elseif($slug == $post_data->post_name || $slug == $post_data->ID || $slug == $post_data->post_title) {
          return true;
        } else {
          return false;
        }
      } else {
        return true;
      }
    }else {
      return false;
    }
  endif;
}


//===============================================
//has_children
function has_children($post_ID = null) {
    if ($post_ID === null) {
        global $post;
        $post_ID = $post->ID;
    }
    $query = new WP_Query(array('post_parent' => $post_ID, 'post_type' => 'any'));

    return $query->have_posts();
}

//===============================================
//toplevel_page
function get_top_parent_page_id($post_ID = null) {
	
	if( !$post_ID ) return;

	$post_ancestors = array_reverse( get_post_ancestors($post_ID) );	
	return $post_ancestors[0];
}


//===============================================
//custom search form
function essence_search_form( $form ) {
	
	$args = array(
		'public'   => true,
		'_builtin' => false
	);
	$post_types = get_post_types( $args, 'names' );


	//array_unshift($post_types, "page");
	array_unshift($post_types, "post");
	
	
	$form = '
	<div class="search-block">
	<form role="search" method="get" id="searchform" class="searchform" action="' . home_url( '/' ) . '" >
	
	<div class="form-group">
		<input class="form-control" type="text" value="' . get_search_query() . '" name="s" id="s" placeholder="検索ワード" />
	</div>
	';
	
	$form .= '<div class="form-group">';
	
	foreach($post_types as $post_type){
      $obj = get_post_type_object($post_type);
			$form .= '<div class="form-check form-check-inline">';
			$form .= '<input id="'.$post_type.'-check" type="checkbox" class="form-check-input" name="search_post_type[]" value="'.$post_type.'"';
			if( !empty($_GET['search_post_type']) && in_array('post_type',$_GET['search_post_type']) ){
				$form .= ' checked';
			}
			$form .= '>';
			$form .= '<label class="form-check-label" for="'.$post_type.'-check">'.$obj->label.'</label>';
			$form .= '</div>';

	}
	$form .= '
	</div>';
	
	$form .= '
	
	<div class="text-center">
		<input type="submit" id="searchsubmit" class="text-center btn btn-primary" value="'. esc_attr__( 'Search','salonote-essence') .'" />
	</div>
	</form>
	</div>';

	return $form;
}

add_filter( 'get_search_form', 'essence_search_form' );



/**
 * ユーザー一覧の名前を表示名に変更します。(列の内部名)
 */
function display_name_users_column( $columns ) {
	$new_columns = array();
	foreach ( $columns as $k => $v ) {
		if ( 'name' == $k ) $new_columns['display_name'] = $v;
		else $new_columns[$k] = $v;
	}
	return $new_columns;
}
add_filter( 'manage_users_columns', 'display_name_users_column' );
/**
 * ユーザー一覧の名前を表示名に変更します。(値)
 */
function display_name_users_custom_column( $output, $column_name, $user_id ) {
	if ( 'display_name' == $column_name ) {
		$user = get_userdata($user_id);
		return $user->display_name;
	}
}
add_filter( 'manage_users_custom_column', 'display_name_users_custom_column', 10, 3 );
/**
 * ユーザー一覧の名前のソートを元のものと同じにします。
 */
function display_name_users_sortable_column( $columns ) {
	$columns['display_name'] = 'name';
	return $columns;
}
add_filter( 'manage_users_sortable_columns', 'display_name_users_sortable_column' );




//hex2rgb 色変換
function salonote_hex2rgb ( $hex ) {
	if ( substr( $hex, 0, 1 ) == "#" ) $hex = substr( $hex, 1 ) ;
	if ( strlen( $hex ) == 3 ) $hex = substr( $hex, 0, 1 ) . substr( $hex, 0, 1 ) . substr( $hex, 1, 1 ) . substr( $hex, 1, 1 ) . substr( $hex, 2, 1 ) . substr( $hex, 2, 1 ) ;

	return array_map( "hexdec", [ substr( $hex, 0, 2 ), substr( $hex, 2, 2 ), substr( $hex, 4, 2 ) ] ) ;
}
