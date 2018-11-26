<?php
global $theme_opt;
global $navbar_head;

$_site_name_txt		=	get_bloginfo('name');
$_site_name_count	=	mb_strlen($_site_name_txt);
$_font_width = 150 / $_site_name_count / 5; //最大文字数
if( $_font_width > 1.5 ){
	$_font_width = 1.5;
}

$_super_view = ' nav-super_view';
$_nav_class = has_nav_menu('Top') ? '-has_top_nav container' : '' ;

//$_super_view = '';

echo '<nav id="header_nav" class="navbar-block">';
echo '<div class="header_logo-block onlyPC';
if( !empty( $theme_opt['base']['description'] ) && in_array('header_h1_txt',$theme_opt['base'] )){
	echo ' has_excerpt';
}
if ( !has_nav_menu('Header')) {
	echo ' none_header_nav';
}
echo '">';
	
	
	echo '<a href="'.home_url().'">';
  if( !empty(get_theme_mod( 'header_logo_url' )) ){
    echo '<img src="'.esc_url( get_theme_mod( 'header_logo_url' ) ).'" alt="'.$_site_name_txt.'" title="'.$_site_name_txt.'">';
	}else{
		echo '<span style="font-size: '.$_font_width.'vw">' . $_site_name_txt .'</span>';
	}
	
	if( !empty( $theme_opt['base']['description'] ) && in_array('header_h1_txt',$theme_opt['base'] )){
		echo '<h1 class="site-description">'.$theme_opt['base']['description'].'</h1>';
	}

  echo '</a></div>';




if( !empty($theme_opt['base']['header_type']) && $theme_opt['base']['header_type'] === 'center' ){
	echo '<div class="container">';
}


  if (has_nav_menu('Header')) {
    wp_nav_menu( array(
      'theme_location' => 'Header',
      'container_class' => 'menu-gnav-container'.$_nav_class.$_super_view,
			
      'fallback_cb' => 'nav_essence_walker_super_view::fallback',
      'walker' => new nav_essence_walker_super_view()
			/**/
			/*
			'fallback_cb' => 'nav_essence_walker::fallback',
      'walker' => new nav_essence_walker()
			*/
    ));
  }

  ?>
</nav>

<?php
if( !empty($theme_opt['base']['header_type']) && $theme_opt['base']['header_type'] === 'center' ){
	echo '</div>';
}
?>