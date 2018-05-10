<?php
global $theme_opt;



?>


<div class="sp-navbar-unit">
    
    <?php
    if( !empty(get_theme_mod( 'header_logo_url' )) )
      $head_logo = '<img src="'.esc_url( get_theme_mod( 'header_logo_url' ) ).'" alt="'.get_bloginfo('name').'" title="'.get_bloginfo('name').'">';
    else
      $head_logo = get_bloginfo('name');

    echo '<h1 class="navbar-logo-block"><a href="'.home_url().'">';
      echo $head_logo;
    echo '</a></h1>';
    ?>

  <div id="navbar-button" class="navbar-button"><span>MENU</span></div>
  <div class="navbar-block">
    <?php
        wp_nav_menu(array(
          'theme_location'    => 'Header',
          'depth'             => 0,
          'container'         => 'div',
        ));
    ?>

    <div class="navbar-info-block">


      <dl>
        <dd><?php echo get_bloginfo('name');?></dd>
      </dl>

      
      <?php
      if( !empty($theme_opt['base']['tel_number']) )
        echo '
        <dl>
          <dt>TEL</dt>
          <dd><a href="tel:'.$theme_opt['base']['tel_number'].'">'.$theme_opt['base']['tel_number'].'</a></dd>
        </dl>
        ';
      
      
      if( !empty($theme_opt['base']['zip_code']) || !empty($theme_opt['base']['contact_address']) )
        echo '
        <dl>
          <dd class="text-left">';
          echo $theme_opt['base']['zip_code'].'<br>';
          echo $theme_opt['base']['contact_address'];
        echo '</dd>
        </dl>
        ';
      ?>
      
    </div>
  </div>
</div>