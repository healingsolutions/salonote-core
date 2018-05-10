
<nav id="header_nav" class="navbar-block">
  <?php
  if( !empty(get_theme_mod( 'header_logo_url' )) )
    $head_logo = '<img src="'.esc_url( get_theme_mod( 'header_logo_url' ) ).'" alt="'.get_bloginfo('name').'" title="'.get_bloginfo('name').'">';
  else
    $head_logo = get_bloginfo('name');
  
  echo '<h1 class="header_logo-block"><a href="'.home_url().'">';
    echo $head_logo;
  echo '</a></h1>';
  ?>
  <?php
  if (has_nav_menu('Header')) {
    wp_nav_menu( array(
      'theme_location' => 'Header',
      'container_class' => 'menu-gnav-container',
      'fallback_cb' => 'nav_essence_walker::fallback',
      'walker' => new nav_essence_walker()
    ));
  }
  ?>
</nav>