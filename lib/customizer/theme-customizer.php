<?php
/*-------------------------------------------*/
/*	color setting
/*-------------------------------------------*/


add_theme_support( 'custom-background', array(
  'default-color' => 'FFFFFF',
) );

class Essence_Theme_Customize
   {

    public static function essence_customize_register($wp_customize) {
      
      global $color_customize_array;
				foreach($color_customize_array as $key => $value):
					//setting
					$wp_customize->add_setting( $key, array( 'default' => $value['default'],'sanitize_callback' => 'sanitize_hex_color' ) );
					$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, $key , array(
							'label' => $value['label_jp'],
							'section' => $value['section'],
							'settings' => $key,
					) ) );
				
					//realtime
					$wp_customize->get_setting( $key )->transport = 'postMessage';
				
				endforeach;
 
    }

}//Essence_Theme_Customize
add_action( 'customize_register' , array( 'Essence_Theme_Customize' , 'essence_customize_register' ) );



///////////////////////////////////////
// images
///////////////////////////////////////


function save_theme_css_from_theme_option( $color_set = null ){

	global $wp_filesystem;

		add_filter('request_filesystem_credentials', '__return_true' );

		$method = '';
		$url 	= 'customize.php';

		$creds = request_filesystem_credentials($url, $method, false, false, null);

		if ( ! WP_Filesystem($creds) ) {
			// our credentials were no good, ask the user for them again
			request_filesystem_credentials($url, $method, true, false, null);
			return false;
		}

		if ( ! $wp_filesystem->put_contents( DYNAMIC_CSS , $color_set, FS_CHMOD_FILE) ) {
			echo "error saving file!";
			return false;
		}
	return true;
}


function essence_theme_customizer( $wp_customize ) {
  

    
 $wp_customize->add_section( 'menu_section' , array(
     'title' => __('Image Setting','salonote-essence'),
     'priority' => 50,
     'description' => __('Theme Image Setting','salonote-essence'),
 ) );
 
 $wp_customize->add_setting( 'header_logo_url',array(
   'sanitize_callback' => 'sanitize_text_field'
 ));
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_logo_url', array(
     'label' => __('Header Logo','salonote-essence'),
     'section' => 'menu_section',
     'settings' => 'header_logo_url',
 ) ) );
 
 $wp_customize->add_setting( 'sp_header_logo_url',array(
   'sanitize_callback' => 'sanitize_text_field'
 ));
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'sp_header_logo_url', array(
     'label' => __('SP Header Logo','salonote-essence'),
     'section' => 'menu_section',
     'settings' => 'sp_header_logo_url',
     'description' => __('SmartPhone Header Logo','salonote-essence'),
 ) ) );
 
 $wp_customize->add_setting( 'footer_logo_url',array(
   'sanitize_callback' => 'sanitize_text_field'
 ));
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_logo_url', array(
     'label' => __('Footer Logo','salonote-essence'),
     'section' => 'menu_section',
     'settings' => 'footer_logo_url',
 ) ) );
 
 
 $wp_customize->add_setting( 'facebook_logo_url',array(
   'sanitize_callback' => 'sanitize_text_field'
 ));
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'facebook_logo_url', array(
     'label' => __('og:image','salonote-essence'),
     'section' => 'menu_section',
     'settings' => 'facebook_logo_url',
		 'description' => __('When Facebook share , show default images','salonote-essence'),
 ) ) );
 
 $wp_customize->add_setting( 'header_image_url',array(
   'sanitize_callback' => 'sanitize_text_field'
 ));
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'header_image_url', array(
     'label' =>  __('Header Background Image','salonote-essence'),
     'section' => 'menu_section',
     'settings' => 'header_image_url',
 ) ) );
 
 
 $wp_customize->add_setting( 'menu_image_url',array(
   'sanitize_callback' => 'sanitize_text_field'
 ));
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'menu_image_url', array(
     'label' => __('Menu Background Image','salonote-essence'),
     'section' => 'menu_section',
     'settings' => 'menu_image_url',
 ) ) );
 
 $wp_customize->add_setting( 'footer_image_url',array(
   'sanitize_callback' => 'sanitize_text_field'
 ));
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'footer_image_url', array(
     'label' => __('Footer Background Image','salonote-essence'),
     'section' => 'menu_section',
     'settings' => 'footer_image_url',
 ) ) );
 
  //NO IMAGE画像
 $wp_customize->add_setting( 'default_image',array(
   'sanitize_callback' => 'sanitize_text_field'
 ));
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'default_image', array(
     'label' => __('"NO Image" default Image','salonote-essence'),
     'section' => 'menu_section',
     'settings' => 'default_image',
 ) ) );
 
 
 //png形式のファビコン
 $wp_customize->add_setting( 'favicon_image',array(
   'sanitize_callback' => 'sanitize_text_field'
 ));
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'favicon_image', array(
     'label' => 'favicon',
     'section' => 'menu_section',
     'settings' => 'favicon_image',
 ) ) );
 
 //png形式のホームアイコン
 $wp_customize->add_setting( 'home_btn_image',array(
   'sanitize_callback' => 'sanitize_text_field'
 ));
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'home_btn_image', array(
     'label' => __('Home Icon Image','salonote-essence'),
     'section' => 'menu_section',
     'settings' => 'home_btn_image',
 ) ) );
 
 
 //ログイン画面のロゴ
 $wp_customize->add_setting( 'login_logo',array(
   'sanitize_callback' => 'sanitize_text_field'
 ));
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'login_logo', array(
     'label' => __('WordPress login Image','salonote-essence'),
     'section' => 'menu_section',
     'settings' => 'login_logo',
 ) ) );
 
 //ログイン画面の背景
 $wp_customize->add_setting( 'login_bkg',array(
   'sanitize_callback' => 'sanitize_text_field'
 ));
 $wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'login_bkg', array(
     'label' => __('WordPress login Background Image','salonote-essence'),
     'section' => 'menu_section',
     'settings' => 'login_bkg',
 ) ) );
 

}
add_action( 'customize_register', 'essence_theme_customizer' );



// ====================================
// customize_preview_init
function essence_customizer_live_preview()
{
	wp_enqueue_script( 
		  'essence-themecustomizer',			//Give the script an ID
		  get_template_directory_uri().'/lib/customizer/theme-customizer.js',//Point to file
		  array( 'jquery','customize-preview' ),	//Define dependencies
		  '',						//Define a version (optional) 
		  true						//Put script in footer?
	);
}
add_action( 'customize_preview_init', 'essence_customizer_live_preview' );



// ====================================
// customize_save
function action_customize_save( $instance ) { 

  global $wp_filesystem;
  global $color_customize_array;
  global $color_set;

  
  require_once(ABSPATH . 'wp-admin/includes/file.php');//WP_Filesystem
  get_template_part('lib/module/print_color_style');
	
	define( 'DYNAMIC_CSS' , get_template_directory() . "/lib/customizer/theme-colors.css" );
	save_theme_css_from_theme_option( $color_set );
  //file_put_contents( get_template_directory() . "/lib/customizer/theme-colors.css",$color_set);
}; 
add_action( 'customize_save', 'action_customize_save', 10, 1 ); 
?>
