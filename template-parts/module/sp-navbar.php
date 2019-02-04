<?php
global $theme_opt;



?>


<div class="sp-navbar-unit">
    
    <?php
    if( !empty(get_theme_mod( 'sp_header_logo_url' )) )
      $head_logo = '<img src="'.esc_url( get_theme_mod( 'sp_header_logo_url' ) ).'" alt="'.get_bloginfo('name').'" title="'.get_bloginfo('name').'">';
    else
      $head_logo = get_bloginfo('name');

    echo '<div class="navbar-logo-block"><a href="'.home_url().'">';
      echo $head_logo;
	
			if( !empty( $theme_opt['base']['description'] ) && in_array('header_h1_txt',$theme_opt['base'] )){
				echo '<p class="site-description">'.$theme_opt['base']['description'].'</p>';
			}
	
    echo '</a></div>';
    ?>

  <div id="navbar-button" class="navbar-button"><span>MENU</span></div>
  <div class="navbar-block">
    <?php
    if (has_nav_menu('Header')) {
        wp_nav_menu(array(
          'theme_location'    => 'Header',
          'depth'             => 0,
          'container'         => 'div',
        ));
    }
    if (has_nav_menu('HeaderBottom')) {
        wp_nav_menu( array(
          'theme_location' => 'HeaderBottom',
          'depth'             => 0,
          'container'         => 'div',
        ));
    }
    ?>

    <div class="navbar-info-block">
			<dl>
				<dt class="hidden">NAME</dt>
				<dd><?php echo get_bloginfo('name');?></dd>
			</dl>
      <?php
      get_template_part('template-parts/module/parts/biz_info');
      ?>
    </div>
  </div>
</div>