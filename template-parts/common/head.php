<?php
global $theme_opt;


$canonical_url = (empty($_SERVER["HTTPS"]) ? "http://" : "https://").$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
?>
<meta charset="<?php bloginfo('charset'); ?>">
<link rel="canonical" href="<?php echo $canonical_url;?>" />
<title><?php wp_title(); ?></title>
<meta name="description" content="<?php echo get_bloginfo('description',false); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1.0<?php
if ( function_exists('wp_is_mobile') && wp_is_mobile() ) {
 echo ' ,minimum-scale=1.0,maximum-scale=2.0'; }
?>" />
<meta name="format-detection" content="telephone=no">
<?php
echo '<!--[if IE]>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<script src="//www.promisejs.org/polyfills/promise-6.1.0.min.js"></script>
<![endif]-->'.PHP_EOL;
if( is_singular() ){ 
	echo '<meta name="author" content="'.get_the_author_meta( 'display_name' ).'" />'.PHP_EOL;
	
	$keywords = get_post_meta($post->ID, 'keywords', true);
	
}// is_singular 
if( !empty($theme_opt['base']['keywords']) || $keywords ){ 
	echo '<meta name="keywords" content="'.  (!empty($keywords) ? esc_attr($keywords).',' : '' ) .esc_html($theme_opt['base']['keywords']).'" />'.PHP_EOL;
}// is_singular 
?>
<link rel="alternate" media="handheld" href="<?php echo $canonical_url;?>" />
<link rel="alternate" type="application/rss+xml" title="RSS" href="<?php bloginfo('rss2_url'); ?>" />
<?php
get_template_part("/template-parts/module/og-type");
get_template_part("/template-parts/module/parts/favicon");
wp_head();
?>

<?php
if( !empty($theme_opt['extention']['fb_appid']) ){
	?>

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.async = true;
  js.src = 'https://connect.facebook.net/ja_JP/sdk.js#xfbml=1&version=v2.12&appId=1031805080187421&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<?php
}
?>
