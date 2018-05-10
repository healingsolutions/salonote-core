<?php
//header
global $post_type_name;
global $user_setting;

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
			echo '<div class="header-image" style="background-image: url('.get_header_image().'); height:'.get_custom_header()->height.'px;">
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