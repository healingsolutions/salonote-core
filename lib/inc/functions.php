<?php



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
          $title = $post->post_excerpt;

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
      $title =  max( $paged, $page ) . __(' page','salonote-essence') . $title;
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
      $description =  max( $paged, $page ) . __('page','salonote-essence') . $description;
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
	
	
  return $classes;
}


// ====================
// container class
function container_class(){
  global $theme_opt;
  global $post_type_set;
  
  if( !empty( $theme_opt['base'] ) && in_array('container',$theme_opt['base'] ) ){

    if( is_singular() ){
      $container_check = 'none_page_container';
    }else{
      $container_check = 'none_archive_container'; 
    }

    if(
      !empty( $post_type_set ) &&
      !in_array($container_check,$post_type_set)
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

