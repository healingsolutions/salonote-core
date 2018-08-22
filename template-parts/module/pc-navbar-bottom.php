<?php
if( is_singular() ){
	$sliders = get_post_meta( $post->ID, 'es_slider_upload_images', true );
	if (has_nav_menu('HeaderBottom') && !empty($sliders)) {

	echo '<nav id="header_nav" class="navbar-block">';
			wp_nav_menu( array(
				'theme_location' => 'HeaderBottom',
				'container_class' => 'menu-gnav-container',
				'fallback_cb' => 'nav_essence_walker::fallback',
				'walker' => new nav_essence_walker()
			));
	echo '</nav>';

	};
}
?>