<?php
global $theme_opt;
global $post_type_set;
global $page_info;
global $user_setting;
global $hide_footer;
$hide_footer = isset($hide_footer) ? $hide_footer : false;

if( is_singular() ){
	$page_info = get_post_meta($post->ID,'page_info',true);
}

// =============================
// check display footer
if(
	!empty( $post_type_set ) &&
	in_array('hide_footer',$post_type_set)
){
	$hide_footer = true;
}

if(
	is_singular() &&
	!empty( $page_info['hide_footer'] )
){
	$hide_footer = true;
}
		





//display Google Map
if( !empty($theme_opt['base']['google_map']) && !$hide_footer ){
  echo '<div class="mod-footer_map onlyPC" style="margin-bottom: -15px; position:relative; z-index:20;background-color:white;">';
  echo do_shortcode('[GoogleMap width="100%" height="250"]');
  echo '</div>';
};
?>

<footer class="site-footer-block footer<?php if (has_nav_menu('sp_display_nav') && wp_is_mobile() ) echo ' has_sp_display_nav' ?>">
  <a class="footer_for_top footer_bkg smoothscroll" href="#body-wrap">TOP</a>
  
  <?php
	echo '<div class="container">';

  
  // action essence_before_footer_content =============================
  if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_before_footer_content]</span>';}
  do_action( 'essence_before_footer_content' );
  // ^action =============================
	
	
	

	if (has_nav_menu('FooterNavi')) {
		wp_nav_menu( array(
					'theme_location' => 'FooterNavi',
					'container'       => 'ul',
					'menu_id'      => '',
					'menu_class'      => 'footer-sitemap nav-font',
					'depth' => 3,
					'echo'            => true,
		) );
	}



  // action essence_after_footer_content =============================
  if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_after_footer_content]</span>';}
  do_action( 'essence_after_footer_content' );
  // ^action =============================

	echo '<br class="clear" />';

	//if display footer
	if( !$hide_footer ){
		if (has_nav_menu('FooterSiteMap')) {
			wp_nav_menu( array(
						'theme_location' => 'FooterSiteMap',
						'container'       => 'ul',
						'menu_id'      => '',
						'menu_class'      => 'footer-sitemap footer-depth-nav nav-font',
						'depth' => 3,
						'echo'            => true,
			) );
		}
		
		//footer widget
		if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('footer')):
			//footer
		endif;

		
		if( !empty($theme_opt['base']['tel_number']) || !empty($theme_opt['base']['zip_code']) || !empty($theme_opt['base']['contact_address']) ){
			echo '<div class="footer-info-block col-12">';
				get_template_part('template-parts/module/parts/biz_info');
			echo '</div>';
		}
		
		
		if( !empty(get_theme_mod( 'footer_logo_url' )) ){
			$footer_logo = '<img class="img-responsive" src="'.esc_url( get_theme_mod( 'footer_logo_url' ) ).'" alt="'.get_bloginfo('name').'-footer-logo" title="'.get_bloginfo('name').'">';
		}else{
			$footer_logo = get_bloginfo('name');
		}
		echo '<p class="footer_logo-block"><a href="'.home_url().'">';
			echo $footer_logo;
		echo '</a></p>';
		
  
  }//^ if display footer
				
  
  
  echo '</div>'; //container
  ?>


	<div class="copyright text-center"><p>Copyright <?php _e('(c)','salonote-essence');?><?php $year = date('Y');echo $year; ?> <?php bloginfo( $name ); ?> .All rights reserved.</p></div>
</footer>






<?php
  wp_footer();

  // action essence_after_footer =============================
  if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_after_footer]</span>';}
  do_action( 'essence_after_footer' );
  // ^action =============================



?>
</div><!-- /body-wrap -->



<?php
    if (has_nav_menu('sp_display_nav') && wp_is_mobile() ) {
        wp_nav_menu(array(
          'theme_location'    => 'sp_display_nav',
          'depth'             => 0,
          'container'         => 'div',
					'container_class' => 'sp_display_nav-container',
        ));
    }
    ?>

<noscript id="deferred-styles">
	<link rel="stylesheet" id="colorbox-css" href="<?php echo get_template_directory_uri();?>/statics/js/colorbox/colorbox.css?ver=4.9.5" type="text/css" media="all" />
</noscript>
<script>
	jQuery(document).ready(function($){
		

		
		if($('.carousel-type-group').length ){
		// slick box ====================================================
			$('.carousel-type-group').slick({
				infinite: true,
				dots: true,
				arrows: true,
				autoplay: true,
				responsive: [
							{
								breakpoint: 2400,
								settings: {
									dots: false,
									arrows: false,
									autoplaySpeed: 0,
									cssEase: 'linear',
									speed: 8500,
									slidesToShow: 4,
								}
							},
							{
								breakpoint: 600,
								settings: {
									dots: true,
									arrows: true,
									autoplaySpeed: 4000,
									//speed: 1000,
									//cssEase: false,
									slidesToShow: 2,
								}
							},
						]
			});
		}
	});
	
	
	var loadDeferredStyles = function() {
		var addStylesNode = document.getElementById("deferred-styles");
		var replacement = document.createElement("div");
		replacement.innerHTML = addStylesNode.textContent;
		document.body.appendChild(replacement)
		addStylesNode.parentElement.removeChild(addStylesNode);
	};
	var raf = window.requestAnimationFrame || window.mozRequestAnimationFrame ||
			window.webkitRequestAnimationFrame || window.msRequestAnimationFrame;
	if (raf) raf(function() { window.setTimeout(loadDeferredStyles, 0); });
	else window.addEventListener('load', loadDeferredStyles);
</script>
</body>
</html>