<?php
$og_type  = '';
$og_image = '';

if (is_home() || is_page('home') || is_front_page()) {
  $og_type = 'website';
}else{
  $og_type = 'blog';
};


$canonical_url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

echo '<meta name="og:title" property="og:title" content="'.wp_title('',false).'" />'.PHP_EOL;
echo '<meta name="twitter:title" content="'.wp_title('',false).'">'.PHP_EOL;
echo '<meta name="og:site_name" property="og:site_name" content="'.get_bloginfo('name',false).'" />'.PHP_EOL;
echo '<meta name="og:type" property="og:type" content="'.$og_type.'" />'.PHP_EOL;
echo '<meta name="og:url" property="og:url" content="'. $canonical_url.'" />'.PHP_EOL;
echo '<meta name="og:description" property="og:description" content="'; echo get_bloginfo('description',true); echo '" />'.PHP_EOL;
echo '<meta name="twitter:description" content="'; echo get_bloginfo('description',true); echo '">'.PHP_EOL;

if ( is_singular() && has_post_thumbnail()){
  //get thumbnail id
  $image_id = get_post_thumbnail_id();
  $image_url = wp_get_attachment_image_src($image_id, true);
  $og_image = $image_url[0];
  
}elseif( is_home() || is_page('home') || is_front_page() ){
  $og_image = esc_url( get_theme_mod( 'facebook_logo_url' ));
}

if( !empty($og_image) ){
  echo '<meta property="og:image" content="'.$og_image.'" />'.PHP_EOL;
  echo '<meta name="twitter:image:src" content="'.$og_image.'">'.PHP_EOL;
}

/*
<!-- twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:creator" content="@">
<meta name="twitter:site" content="@" />
*/

?>