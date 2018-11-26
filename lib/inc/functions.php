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
	
	if ( has_nav_menu('Header')) {
		$classes[] = 'has_header_nav';
	}else{
		$classes[] = 'no-header_nav';
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
		
		echo '<div class="prev_title float-left"><a href="'.get_the_permalink(). ($page-1) .'"><< ' .($page-1) .'.'. nl2br(esc_attr(strip_tags($prev_title))) .'</a></div>';
	}
	
	
	if( $max_page > $page && $max_page !== $page ){
		//echo 'next' . ($page + 1);
		
		$prev_num = $page;
		$prev_arr = explode("<!--nextpage-->",$post->post_content);
		preg_match( $pattern, $prev_arr[$prev_num], $match);
		
		$naxt_title = $match ? $match[2] : '' ;
		
		echo '<div class="next_title float-right"><a href="'.get_the_permalink(). ($page+1) .'">' .($page+1) .'.'. nl2br(esc_attr(strip_tags($naxt_title))) .' >></a></div>';
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




/**
* @function get_archives_array
* @param post_type(string) / period(string) / year(Y) / limit(int)
* @return array
*/
if(!function_exists('get_archives_array')){
    function get_archives_array($args = ''){
        global $wpdb, $wp_locale;

        $defaults = array(
            'post_type' => '',
            'period'  => 'monthly',
            'year' => '',
            'limit' => ''
        );
        $args = wp_parse_args($args, $defaults);
        extract($args, EXTR_SKIP);

        if($post_type == ''){
            $post_type = 'post';
        }elseif($post_type == 'any'){
            $post_types = get_post_types(array('public'=>true, '_builtin'=>false, 'show_ui'=>true));
            $post_type_ary = array();
            foreach($post_types as $post_type){
                $post_type_obj = get_post_type_object($post_type);
                if(!$post_type_obj){
                    continue;
                }

                if($post_type_obj->has_archive === true){
                    $slug = $post_type_obj->rewrite['slug'];
                }else{
                    $slug = $post_type_obj->has_archive;
                }

                array_push($post_type_ary, $slug);
            }

            $post_type = join("', '", $post_type_ary); 
        }else{
            if(!post_type_exists($post_type)){
                return false;
            }
        }
        if($period == ''){
            $period = 'monthly';
        }
        if($year != ''){
            $year = intval($year);
            $year = " AND DATE_FORMAT(post_date, '%Y') = ".$year;
        }
        if($limit != ''){
            $limit = absint($limit);
            $limit = ' LIMIT '.$limit;
        }

        $where  = "WHERE post_type IN ('".$post_type."') AND post_status = 'publish'{$year}";
        $join   = "";
        $where  = apply_filters('getarchivesary_where', $where, $args);
        $join   = apply_filters('getarchivesary_join' , $join , $args);

        if($period == 'monthly'){
                $query = "SELECT YEAR(post_date) AS 'year', MONTH(post_date) AS 'month', count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date), MONTH(post_date) ORDER BY post_date DESC $limit";
        }elseif($period == 'yearly'){
            $query = "SELECT YEAR(post_date) AS 'year', count(ID) as posts FROM $wpdb->posts $join $where GROUP BY YEAR(post_date) ORDER BY post_date DESC $limit";
        }

        $key = md5($query);
        $cache = wp_cache_get('get_archives_array', 'general');
        if(!isset($cache[$key])){
            $arcresults = $wpdb->get_results($query);
            $cache[$key] = $arcresults;
            wp_cache_set('get_archives_array', $cache, 'general');
        }else{
            $arcresults = $cache[$key];
        }
        if($arcresults){
            $output = (array)$arcresults;
        }

        if(empty($output)){
            return false;
        }

        return $output;
    }
}




function day_diff($date1, $date2) {
 
    // 日付をUNIXタイムスタンプに変換
    $timestamp1 = strtotime($date1);
    $timestamp2 = strtotime($date2);
 
    // 何秒離れているかを計算
    $seconddiff = abs($timestamp2 - $timestamp1);
 
    // 日数に変換
    $daydiff = $seconddiff / (60 * 60 * 24);
 
    // 戻り値
    return $daydiff;
 
}


function get_monthly_nav( $current_ymd = null, $post_type ){
	global $wpdb;
	global $post;
	
	//echo $current_ymd;
	//echo $post_type;
	
	$sql = $wpdb->prepare("
		SELECT DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date < '%s'
		AND post_type = '$post_type' AND post_status = 'publish'
				ORDER BY post_date DESC
				LIMIT 1",$current_ymd);

	$previous = $wpdb->get_results($sql);
	
	
	
	$sql = $wpdb->prepare("
		SELECT DISTINCT MONTH(post_date) AS month, YEAR(post_date) AS year
		FROM $wpdb->posts
		WHERE post_date > '%s'
		AND MONTH( post_date ) != MONTH( '%s' )
		AND post_type = '$post_type' AND post_status = 'publish'
				ORDER   BY post_date ASC
				LIMIT 1",array($current_ymd,$current_ymd));

	$next = $wpdb->get_results($sql);
	
	if(is_user_logged_in()){
		//echo '<pre>previous'; print_r($previous); echo '</pre>';
		//echo '<pre>next'; print_r($next); echo '</pre>';
	}
	
	$print_monthly_nav = '';
	
	$post_type_path = ($post_type !== 'post') ? $post_type .'/date' : 'date' ;
	
	if( !empty($previous) || !empty($next) ){
		
		echo '<div class="monthly_nav-unit clearfix">';

		if( !empty($previous) ){
			$print_monthly_nav .= '<a class="monthly_nav-previous float-left" href="'.str_replace('date',$post_type_path,get_month_link($previous[0]->year,zeroise($previous[0]->month,2))).'"> &lt;&lt;'.$previous[0]->year.'年'.zeroise($previous[0]->month,2).'月</a>';
		}

		if( !empty($next) ){
			$print_monthly_nav .= '<a class="monthly_nav-next float-right" href="'.str_replace('date',$post_type_path,get_month_link($next[0]->year,zeroise($next[0]->month,2))).'"> '.$next[0]->year.'年'.zeroise($next[0]->month,2).'月&gt;&gt;</a>';
		}
		
		echo '</div>';
		
	}
	
	
	return $print_monthly_nav;
}



function br2array( $value, $count = null ){
	
	if( !empty($count)){
		$br_array = preg_split("/\R{{$count},}/", esc_attr($value) ); // とりあえず行に分割
	}else{
		$br_array = explode("\n", $value); // とりあえず行に分割
	}
	
	$br_array = array_map('trim', $br_array); // 各行にtrim()をかける
	$br_array = array_filter($br_array, 'strlen'); // 文字数が0の行を取り除く
	$br_array = array_values($br_array); // これはキーを連番に振りなおしてるだけ

	return $br_array;
}




/*-------------------------------------------*/
/*	サムネイル取得
/*-------------------------------------------*/
function get_post_first_thumbnail(  $post_id = null , $thumb_size='thumbnail' , $return_parama='url' ){
	
	if( empty($post_id) ) return;

	$image_id = '';
	$image_url = '';
    
	//the_post_thumbnail( $post_id );
	if ( has_post_thumbnail( $post_id )) {
			$image_id = get_post_thumbnail_id( $post_id );
			$image_url = wp_get_attachment_image_src($image_id, $thumb_size , true);
			$image_url = $image_url[0];
	}

	
	if( strpos($image_url,'media/default.png') !== false  ){
		$image_url_tmp = catch_that_image();
		
		if( isset($image_url_tmp) ){
			$image_id = get_attachment_id($image_url_tmp);
			$image_url = wp_get_attachment_image_src($image_id, $thumb_size , true);
			$image_url = $image_url[0];
		}
	}else{
		$image_url = '';
	}
	
		
	if( $return_parama === 'url' ){
		return $image_url;
	}elseif( $return_parama === 'id' ){
		return $image_id;
	}
	
	
}



//記事の一番最初の画像をキャッチイメージに設定
function catch_that_image() {
    global $post, $posts;
    $first_img = '';
    ob_start();
    ob_end_clean();
    $output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', $post->post_content, $matches);
    if( isset($matches[1] [0]) ){
        $first_img = $matches [1] [0];
        
        //画像登録されていない場合はエラーになるので、IDを取得しない仕様に変更
        //$first_img = get_attachment_image_src( $first_img_url, 'thumbnail' );
    }
 
    if(empty($first_img)){ //Defines a default image
        $first_img = null;
    }
    
return $first_img;
}



/**
 * 画像のURLからattachemnt_idを取得する
 *
 * @param string $url 画像のURL
 * @return int attachment_id
 */
function get_attachment_id($url)
{
  global $wpdb;
  $sql = "SELECT ID FROM {$wpdb->posts} WHERE post_name = %s";
  preg_match('/([^\/]+?)(-e\d+)?(-\d+x\d+)?(\.\w+)?$/', $url, $matches);
	if( $matches ){
		$post_name = $matches[1];
		return (int)$wpdb->get_var($wpdb->prepare($sql, $post_name));
	}else{
		return;
	}
  
}


?>