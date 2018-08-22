<?php


function essence_theme_activate() {
    global $pagenow;
    if(is_admin() && $pagenow == "themes.php" && isset($_GET["activated"]))
        do_action("essence_theme_activate");
}
add_action("init", "essence_theme_activate");


function save_theme_js_from_theme_option( $theme_customizer = null ){

	global $wp_filesystem;

		add_filter('request_filesystem_credentials', '__return_true' );

		$method = '';
		$url 	= 'themes.php';

		$creds = request_filesystem_credentials($url, $method, false, false, null);

		if ( ! WP_Filesystem($creds) ) {
			// our credentials were no good, ask the user for them again
			request_filesystem_credentials($url, $method, true, false, null);
			return false;
		}

		if ( ! $wp_filesystem->put_contents( DYNAMIC_JS , $theme_customizer, FS_CHMOD_FILE) ) {
			echo "error saving file!";
			return false;
		}
	return true;
}


function esence_theme_activated() {
  
  // =========================================
  global $color_customize_array;
  global $wp_filesystem;
  require_once(ABSPATH . 'wp-admin/includes/file.php');//WP_Filesystem
  
  $theme_customizer = '
      ( function( $ ) {
		 
			var css_set = [';

        foreach($color_customize_array as $key => $value):
          $theme_customizer .= '
            { name: "'.$key.'",
              target: "'.str_replace(":", "\:", $value['target']).'",
              css: "'.str_replace(":", "\:", $value['element']).'"
            },'.PHP_EOL.'
          '.PHP_EOL;
				endforeach;

		$theme_customizer .=	'];

			jQuery.each(css_set,
				function(index, elem) {
				
					wp.customize( elem.name, function( value ) {
						 value.bind( function( newval ) {
								 $( elem.target ).css( elem.css , newval );
						 } );
					});
				
			});
		 
   } )( jQuery );
  ';
  


	define( 'DYNAMIC_JS' , get_template_directory() . "/lib/customizer/theme-customizer.js" );
	save_theme_js_from_theme_option( $theme_customizer );

	//send activation mail
	$to = 'activation@salonote.com';
	$admin_email = get_option('admin_email');
  $subject = get_option('blogname');
	$siteurl = get_option('siteurl');
	
	$message = 'salonoteがアクティベーションされました。'.PHP_EOL;
	$message .= 'URL:　'.$siteurl.PHP_EOL;
	$message .= 'タイトル:　'.$subject.PHP_EOL;
	$message .= 'mail:　'.$admin_email.PHP_EOL;

  $headers = 'From: '.get_option('blogname').' <'.$admin_email.'>' . "\r\n";
	wp_mail( $to, $subject, strip_tags($message), $headers);

  //file_put_contents( get_template_directory() . "/lib/customizer/theme-customizer.js",$theme_customizer);

  
}
add_action("essence_theme_activate", "esence_theme_activated");

?>