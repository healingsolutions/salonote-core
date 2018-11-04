<?php
//header
global $post_type_name;
global $user_setting;
global $theme_opt;
global $post_type_set;
global $page_info;


echo '<div class="';
echo !empty($theme_opt['base']['header_type']) ? 'header_type-'. $theme_opt['base']['header_type']  : 'header_type-normal' ;
echo '">';


	
//header_top_widgets widget
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('header_top_widgets')):
	//header_top_widgets
endif;




$header_class = array('site-header-block');
if (has_nav_menu('Top')) {
	$header_class[] = 'has_top_nav';
}else{
	$header_class[] = 'none_top_nav';
}


if (has_nav_menu('HeaderBottom')) {
	$header_class[] = 'has_header_bottom_nav';
}else{
	$header_class[] = 'none_header_bottom_nav';
}

?>
<header id="header" class="check <?php echo implode(' ',$header_class);?>">
  <?php
    // action essence_before_header =============================
    if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_before_header]</span>';}
    do_action( 'essence_before_header' );
    // ^action =============================
	
	
		if (has_nav_menu('Top')) {
			echo '<div id="super-top-nav" class="super-top-block">';
			wp_nav_menu( array(
				'theme_location' => 'Top',
				'container_class' => 'super-top-container',
				'depth' => 0,
				'fallback_cb' => 'nav_essence_walker_super_top::fallback',
				'walker' => new nav_essence_walker_super_top()
			));
			echo '</div>';
		}
  
  
    get_template_part('template-parts/module/pc-navbar');
    get_template_part('template-parts/module/sp-navbar');
  
    // action essence_before_carousel_block =============================
		if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_before_carousel_block]</span>';}
		do_action( 'essence_before_carousel_block' );
		// ^action =============================
	

		// action essence_after_carousel_block =============================
		if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_after_carousel_block]</span>';}
		do_action( 'essence_after_carousel_block' );
		// ^action =============================
  
  
    // action essence_after_header =============================
    if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_after_header]</span>';}
    do_action( 'essence_after_header' );
    // ^action =============================
  ?>
</header>

<?php

if ( has_header_image() && $post_type_name == 'front_page' ) {
	
	$header_images = get_uploaded_header_images();
	
	if (!empty($header_images) && count($header_images) > 1 ){
		echo '<div class="slick-unit-1">';
				foreach ($header_images as $header_image) {
					echo '<img src="' . $header_image['url'] . '" />';
				}
		echo '</div>';
	}else{
		echo '<div class="header-image" style="background-image: url('.get_header_image().'); ">
		<img src="'.get_header_image().'" />
		</div>';
	}

	
}


if(	is_singular() && has_excerpt()){
	if(
		!empty( $post_type_set ) &&
		in_array('show_description',$post_type_set) &&
		empty($page_info['hide_header_description'] )
	){
		echo '<section><h1 class="header-description">'.get_bloginfo('description',false).'</h1></section>';
	}
};


get_template_part('template-parts/module/pc-navbar-bottom');



//ヘッダーウィジェット
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('content_top')): 
	//dynamic_sidebar( 'content_top');
endif;
?>

