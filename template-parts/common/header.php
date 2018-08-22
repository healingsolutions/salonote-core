<?php
//header
global $post_type_name;
global $user_setting;
global $theme_opt;

$_site_name_txt		=	get_bloginfo('name');
$_site_name_count	=	mb_strlen($_site_name_txt);
$_font_width = 150 / $_site_name_count / 5; //最大文字数
if( $_font_width > 1.5 ){
	$_font_width = 1.5;
}

if( !wp_is_mobile() ){
	echo '<div class="header_logo-block onlyPC"><a href="'.home_url().'">';
  if( !empty(get_theme_mod( 'header_logo_url' )) ){
    echo '<img src="'.esc_url( get_theme_mod( 'header_logo_url' ) ).'" alt="'.$_site_name_txt.'" title="'.$_site_name_txt.'">';
	}else{
		echo '<span style="font-size: '.$_font_width.'vw">' . $_site_name_txt .'</span>';
	}
	
	if( !empty( $theme_opt['base']['description'] ) && in_array('header_h1_txt',$theme_opt['base'] )){
		echo '<h1 class="header-description">'.get_bloginfo('description',false).'</h1>';
	}
		
	
  echo '</a></div>';
}


		
//header_top_widgets widget
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('header_top_widgets')):
	//header_top_widgets
endif;

?>
<header id="header">
  <?php
    // action essence_before_header =============================
    if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_before_header]</span>';}
    do_action( 'essence_before_header' );
    // ^action =============================
  
  
    get_template_part('template-parts/module/pc-navbar');
    get_template_part('template-parts/module/sp-navbar');
  
    // action essence_before_carousel_block =============================
		if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_before_carousel_block]</span>';}
		do_action( 'essence_before_carousel_block' );
		// ^action =============================
	
		
		if ( has_header_image() && $post_type_name == 'front_page' ) {
			echo '<div class="header-image" style="background-image: url('.get_header_image().'); ">
			<img src="'.get_header_image().'" />
			</div>';
		}

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
get_template_part('template-parts/module/pc-navbar-bottom');
?>