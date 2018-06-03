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

global $theme_opt;

$theme_opt['base']      = get_option('essence_base');
$theme_opt['extention'] = get_option('essence_extention');
$theme_mods             = get_theme_mods();

// =========================================================
// admin CSS
// ---------------------------------------------------------

add_action( 'admin_enqueue_scripts', 'essence_admin_style' );
function essence_admin_style(){
	wp_enqueue_style('essence_admin_style',get_template_directory_uri().'/statics/css/admin-style.css');
  
  //wp_enqueue_style ('bootstrap','https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css');
  //wp_enqueue_script('bootstrap','//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js', array(),'3.3.7', true);
  //wp_enqueue_script('essence_admin_scipt', get_template_directory_uri().'/statics/js/editor-script.js', array(),null, true);
}

// admin editor css
add_editor_style( get_template_directory_uri(). "/statics/css/editor-style.css");
add_editor_style( get_template_directory_uri(). "/lib/customizer/theme-colors.css");


if( !empty( $theme_opt['base'] ) && in_array('childStyles',$theme_opt['base'])  ){
  add_editor_style( get_stylesheet_directory_uri(). "/style.css");
}



/*=========================================================
// public css
----------------------------------------------------------*/
function essence_head_enqueue() {
  global $theme_opt;

  
  //jQuery
  wp_enqueue_script('jquery','//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js', array(), '3.2.1', true);
  wp_enqueue_script('ScrollToPlugin','//cdnjs.cloudflare.com/ajax/libs/gsap/1.20.2/plugins/ScrollToPlugin.min.js', array(), '1.20.2', true);
  //wp_enqueue_script('cookie','//cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js', array(), '1.20.2', true);

  
  //in head
  //wp_enqueue_style('normalize', '//cdnjs.cloudflare.com/ajax/libs/normalize/7.0.0/normalize.min.css', array(), '1.0');
  //wp_enqueue_style('yakuhanjp', '//cdn.jsdelivr.net/npm/yakuhanjp@2.0.0/dist/css/yakuhanjp.min.css', array(), '2.0.0');
	
	wp_enqueue_style('essence', get_template_directory_uri().'/style-min.css', array(), '1.0');
	wp_enqueue_script('essence', get_template_directory_uri().'/statics/js/main-min.js', array(), '1.0.0' ,true);
  
  if( !empty($theme_opt['extention']) && in_array('use_colorbox',$theme_opt['extention']) ){
    wp_enqueue_script('colorbox', '//cdnjs.cloudflare.com/ajax/libs/jquery.colorbox/1.6.4/jquery.colorbox-min.js', array(),'1.6.4' ,true);
    //wp_enqueue_style('colorbox', get_template_directory_uri().'/statics/js/colorbox/colorbox.css');
  }
  
  if( !empty($theme_opt['extention']) && in_array('use_slick',$theme_opt['extention']) ){
    wp_enqueue_script('slick', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array(), '1.6.0' ,true);
    wp_enqueue_style ('slick', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css', array(), '1.6.0');
    wp_enqueue_style ('slick-theme', get_template_directory_uri().'/statics/js/slick/slick-theme.css', array(), '1.0');
  }
	
	//wp_enqueue_style('dashicons',true);


}
add_action( 'wp_enqueue_scripts', 'essence_head_enqueue' ,1);


//async javascript
function addasync_colorbox_enqueue_script( $tag, $handle ) {
    if (
			'colorbox' !== $handle &&
			'essence' !== $handle &&
			'ScrollToPlugin' !== $handle
		)
		{
        return $tag;
    }
    return str_replace( ' src', ' async="async" src', $tag );
}
add_filter( 'script_loader_tag', 'addasync_colorbox_enqueue_script', 10, 2 );




//on-off comment-reply.min.js 
function comment_js_queue(){
  if ( (is_single() && comments_open() && get_option('thread_comments')) ){
    wp_enqueue_script( 'comment-reply' );
  }else{
    //wp_deregister_script('comment-reply');
  }
}
add_action('wp_footer','comment_js_queue');



//if use 'maru gothic' read webfonts
if(
	!empty($theme_opt['base']['headline_font']) &&
	!empty($theme_opt['base']['body_font']) &&
	(
	$theme_opt['base']['headline_font'] == 'maru-gothic' ||
	$theme_opt['base']['body_font'] == 'maru-gothic'
	)
){
	function essence_font_links() {	
		wp_enqueue_style( 'roundedmplus1c', 'https://fonts.googleapis.com/earlyaccess/roundedmplus1c.css');
	}
	add_action( 'wp_enqueue_scripts', 'essence_font_links',50 );
}



 


/*=========================================================
// theme support
----------------------------------------------------------*/
add_theme_support( 'title-tag' );
add_theme_support( 'automatic-feed-links' );

$args = array(
	'width'         => 1600,
	'height'        => 640,
	'default-image' => get_template_directory_uri() . '/statics/images/header.jpg',
);
add_theme_support( 'custom-header', $args );

// localization
load_theme_textdomain( 'salonote-essence', get_template_directory() . '/languages' );

if ( ! isset( $content_width ) ) $content_width = 1100;

/*=========================================================
// remove actions
----------------------------------------------------------*/
remove_action('wp_head',  '_wp_render_title_tag', 1);
remove_action('wp_head',  'feed_links_extra', 3);
remove_action('wp_head',  'rsd_link');
remove_action('wp_head',  'wlwmanifest_link');
remove_action('wp_head',  'wp_generator');
remove_action('wp_head',  'wp_shortlink_wp_head');
remove_action('wp_head',  'adjacent_posts_rel_link_wp_head',10);
remove_action('wp_head',  'print_emoji_detection_script', 7 );
remove_action('wp_print_styles', 'print_emoji_styles' );
//add_filter( 'use_default_gallery_style', '__return_false' );

add_action('get_header', 'remove_admin_login_header');
function remove_admin_login_header() {
	remove_action('wp_head', '_admin_bar_bump_cb');
}

function essence_dequeue_styles() {
    wp_dequeue_style( 'wp-pagenavi' );
    wp_dequeue_style( 'wordpress-popular-posts' );
    wp_dequeue_style( 'wp-social-bookmarking-light' );
    wp_dequeue_style( 'msl-main' );
    wp_dequeue_style( 'msl-custom' );
}
add_action( 'wp_print_styles', 'essence_dequeue_styles' );


//unregister_widgets
function unregister_default_widget() {
	//unregister_widget('WP_Widget_Pages');
	unregister_widget('WP_Widget_Calendar');
	//unregister_widget('WP_Widget_Archives');
	unregister_widget('WP_Widget_Meta');
	unregister_widget('WP_Widget_Categories');
	unregister_widget('WP_Nav_Menu_Widget');
}
add_action( 'widgets_init', 'unregister_default_widget' );



//user excerpt on pages
add_post_type_support( 'page', 'excerpt' );


/*-------------------------------------------*/
/*	register_nav_menus
/*-------------------------------------------*/
register_nav_menus( array( 'Header' => __('Header','salonote-essence'), ) );
register_nav_menus( array( 'FooterNavi' => __('Footer Top','salonote-essence'), ) );
register_nav_menus( array( 'FooterSiteMap' => __('Footer SiteMap','salonote-essence'), ) );

require_once( get_template_directory(). '/lib/inc/color.php' );
  
//theme activate hook
require_once( get_template_directory(). '/lib/hook/theme-activate.php' );


/*-------------------------------------------*/
/*	include theme options
/*-------------------------------------------*/
require( get_template_directory(). '/lib/customizer/theme-options.php' );


/*-------------------------------------------*/
/*	nav walker 
/*-------------------------------------------*/
require( get_template_directory(). '/lib/walker/gnav_essence_walker.php' );

/*-------------------------------------------*/
/*	widgets
/*-------------------------------------------*/
function include_library() {

  require_once( get_template_directory(). '/lib/inc/functions.php' );
	
  require_once( get_template_directory(). '/lib/module/tinymce.php' );
  require_once( get_template_directory(). '/lib/module/images.php' );
	
  require_once( get_template_directory(). '/lib/customizer/theme-customizer.php' );
  require_once( get_template_directory(). '/lib/widget/widgets.php' );
	
  require_once (get_template_directory(). '/lib/custom_fields/page_info.php' );
	require_once (get_template_directory(). '/lib/custom_fields/profile_fields.php' );
	require_once (get_template_directory(). '/lib/custom_fields/gallery_post_type.php' );


}
add_action('init', 'include_library', 10);




require_once( get_template_directory(). '/lib/widget/onePage.php' );
require_once( get_template_directory(). '/lib/widget/customList.php' );
require_once( get_template_directory(). '/lib/widget/sns_buttons.php' );

//require_once( get_template_directory(). '/lib/widget/blogRss.php' );
//require_once( get_template_directory(). '/lib/widget/extra-archive-link.php' );
//require_once( get_template_directory(). '/lib/widget/WriteBlock.php' );
//require_once (get_template_directory(). '/lib/widget/event_info.php' );




// ====================
// check login user
if(is_user_logged_in()){
	global $user_setting;
  $current_user = wp_get_current_user();
	$user_setting = [];
	$user_setting['display_shortcode'] = !empty(get_the_author_meta( 'display_shortcode', $current_user->ID)) ? true : false ;
}


if( $_SERVER["REQUEST_URI"] == '/sitemap.html' ){
	$location = get_home_url().'/sitemap.xml';
	wp_safe_redirect( $location, 301 );
	exit;
}





//read files hook directory
add_action('template_redirect','get_template_hook');
function get_template_hook(){
  
  global $theme_opt;
  global $post_type_name;
	global $post_type_tmpl;
  global $post_type_set;
	global $post_taxonomies;
  
  $theme_opt['base'] = get_option('essence_base');
  $theme_opt['post_type'] = get_option('essence_post_type');
  
  
  // read child theme styles =======================================
  if( !empty( $theme_opt['base'] ) && in_array('childStyles',$theme_opt['base'] ) ){
    function essence_child_head_enqueue() {
      wp_enqueue_style('essence-child', get_stylesheet_directory_uri().'/style.css', array(), '1.0');
    }
    add_action( 'wp_enqueue_scripts', 'essence_child_head_enqueue' ,20);
  }
  

  // setting post_type =======================================
  if( is_home()){
    $post_type_tmpl = 'front_page';
    $post_type_name  = 'post';
  }elseif( is_front_page() ){
    $post_type_tmpl = 'front_page';
    $post_type_name  = 'front_page';
  }elseif( is_singular() ){
    $post_type_tmpl = get_post_type();
    $post_type_name  = get_post_type();
		
	}elseif( is_tax() ){
		$post_type_tmpl = get_post_type();
    $post_type_name  = get_post_type();
		

	}elseif( is_archive() ){
    $post_type_tmpl = get_query_var('post_type');
    $post_type_name  = get_query_var('post_type');
  }

  //echo $post_type_name.':'.$post_type_tmpl .'<br>';
  
  if( !empty($post_type_name) )
  $post_type_set  = !empty($theme_opt['post_type'][$post_type_name]) ? $theme_opt['post_type'][$post_type_name] : null ;
	
	//post_type taxonomy
	$post_taxonomies = [];
  $post_type_taxonomies = get_object_taxonomies( $post_type_name, 'objects' );
	if ( !empty($post_type_taxonomies) ) {
		foreach( $post_type_taxonomies as $post_type_taxonomy ) {
			if( is_object($post_type_taxonomy) ){
				$post_taxonomies[] = $post_type_taxonomy->name;
			}
		}
	}
	

  
  //template hook
  $dir = get_template_directory().'/template-parts/hook/';
  if(is_dir($dir) && $handle = opendir($dir)){

      $files = array();
      while(($file = readdir($handle)) !== false){
          if(filetype($path = $dir.$file) == "file"){
            $hook = basename( $file, ".php" );
            
            if(strpos($hook,'-') !== false){
              preg_match('/(.+)\-(.+)/i', $hook, $post_type_hook, false);
 
              
              if( !empty($post_type_tmpl) && $post_type_tmpl == $post_type_hook[2] ){
                
                //echo 'only-post-type:' . $post_type_hook[2] . '<br>';
                //echo 'this-post-type:' . $post_type_tmpl . '<br>';

                
                $_post_type_hook_func   = $post_type_hook[0];
                $_post_type_hook_filter = $post_type_hook[1];
                //echo '2:'. $post_type_hook[2] .'<br>';
                //echo 'hook:'.$hook .'<br>';
                
              add_filter( $_post_type_hook_filter, function() use ($_post_type_hook_func){
                //echo 'only' . $_post_type_hook_func .'<br>';
                get_template_part('template-parts/hook/'.$_post_type_hook_func);
              });
              }
              
            }else{
              
              add_filter( $hook, function() use ($hook){
                get_template_part('template-parts/hook/'.$hook);
              });
            }
            
            
            
          }
      }//end while
  
  }
  
  
  //stylesheet hook
  $dir = get_stylesheet_directory().'/hook/';
  if(is_dir($dir) && $handle = opendir($dir)){

      $files = array();
      while(($file = readdir($handle)) !== false){
          if(filetype($path = $dir.$file) == "file"){
            $hook = basename( $file, ".php" );
            
            if(strpos($hook,'-') !== false){
              preg_match('/(.+)\-(.+)/i', $hook, $post_type_hook, false);
 
              
              if( !empty($post_type_tmpl) && $post_type_tmpl == $post_type_hook[2] ){
                
                //echo 'only-post-type:' . $post_type_hook[2] . '<br>';
                //echo 'this-post-type:' . $post_type_tmpl . '<br>';

                
                $_post_type_hook_func   = $post_type_hook[0];
                $_post_type_hook_filter = $post_type_hook[1];
                //echo '2:'. $post_type_hook[2] .'<br>';
                //echo 'hook:'.$hook .'<br>';
                
              add_filter( $_post_type_hook_filter, function() use ($_post_type_hook_func){
                //echo 'only' . $_post_type_hook_func .'<br>';
                get_template_part('hook/'.$_post_type_hook_func);
              });
              }
              
            }else{
              
              add_filter( $hook, function() use ($hook){
                get_template_part('hook/'.$hook);
              });
            }

            
          }
      }//end while
    
  }
  
}

