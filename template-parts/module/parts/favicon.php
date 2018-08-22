<?php

//png形式のホームアイコン
$home_btn_img = esc_url( get_theme_mod( 'home_btn_image'));
$favicon_img = esc_url( get_theme_mod( 'favicon_image' ));

  if( !empty($home_btn_img) || !empty($favicon_img) ){
    if( $home_btn_img){ 
    //<!-- iOS Safari --> 
        echo '<link rel="apple-touch-icon" sizes="180x180" href="' .$home_btn_img. '">';
    //<!-- iOS Safari(旧) / Android標準ブラウザ(一部) -->
        echo '<link rel="apple-touch-icon-precomposed" href="'.$home_btn_img.'">';
    } else { 
        // echo '<link rel="shortcut icon" href="' .get_template_directory_uri(). '/ico/favicon.ico">';
    }; 

    if( $favicon_img ){ 
    //<!-- Android標準ブラウザ(一部) -->
        echo '<link rel="shortcut icon" href="' .$favicon_img.'">';
    //<!-- Android Chrome -->
        echo '<link rel="icon" sizes="192x192" href="'.$favicon_img. '">';
    } else {
        //echo '<link rel="icon" href="' .get_template_directory_uri(). '/ico/favicon.ico">';
     }; 
  };
?>