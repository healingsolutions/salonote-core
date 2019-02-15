<?php
/*  Copyright 2016 Healing Solutions (email : info@healing-solutions.jp)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
     published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}




function slider_essence_admin_style($hook){
	if ( 'post.php' != $hook && 'post-new.php' != $hook ) {
			return;
	}
	wp_enqueue_script('slide_essence', SLIDER_ESSENCE_PLUGIN_URI . '/statics/js/main.js', array(), '1.0.0' ,true);
	wp_enqueue_style ('slide_essence', SLIDER_ESSENCE_PLUGIN_URI . '/statics/css/style.css');
}
add_action( 'admin_enqueue_scripts', 'slider_essence_admin_style' ); //管理画面用のCSS



function slider_essence_public_style(){
	
	if( !is_singular() ) return;
	
	global $post;
	$sliders = get_post_meta( $post->ID, 'es_slider_upload_images', true );
	$header_images = get_uploaded_header_images();
	
	if( empty($sliders) && empty($header_images) ) return;
	
	wp_enqueue_script('slick', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js', array(), '1.6.0' ,true);
	wp_enqueue_style ('slick', '//cdn.jsdelivr.net/jquery.slick/1.6.0/slick.css', array(), '1.6.0');
	wp_enqueue_style ('slick-theme', '//cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.min.css', array(), '1.9.0');
}
add_action( 'wp_enqueue_scripts', 'slider_essence_public_style' ); //公開用のCSS



function slider_essence(){
	if( !is_singular() ) return;
	
	global $post;
	$sliders = get_post_meta( $post->ID, 'es_slider_upload_images', true );
	if( empty($sliders) ) return;
	
	
	$slider_essence_opt = get_option('slider_essence_options');
	$opt['place'] = !empty($slider_essence_opt['place']) ? $slider_essence_opt['place'] : '#header' ;
	$opt['height'] = !empty($slider_essence_opt['height']) ? $slider_essence_opt['height'] : 'auto' ;
	$opt['sp_height'] = !empty($slider_essence_opt['sp_height']) ? $slider_essence_opt['sp_height'] : '' ;
	$opt['sp_right'] = !empty($slider_essence_opt['sp_right']) ? $slider_essence_opt['sp_right'] : 0 ;
	$opt['speed'] = !empty($slider_essence_opt['speed']) ? $slider_essence_opt['speed'] : 8 ;
  $opt['font_size']   = !empty($slider_essence_opt['font_size'])    ? $slider_essence_opt['font_size'] : 2.2;
	$opt['size'] = !empty($slider_essence_opt['size']) ? $slider_essence_opt['size'] : 'large';
	$opt['zoom'] = !empty($slider_essence_opt['zoom']) ? $slider_essence_opt['zoom'] : false;
  
  $opt['title_class'] = !empty($slider_essence_opt['title_class'])  ? ' class="'.$slider_essence_opt['title_class'].'"' : '';
  $opt['body_class']  = !empty($slider_essence_opt['body_class'])   ? ' '.$slider_essence_opt['body_class'] : '';
	$opt['center_mode'] = !empty($slider_essence_opt['center_mode'])  ? $slider_essence_opt['center_mode'] : false;
	global $user_setting;
	
	$es_slider_info = get_post_meta( $post->ID, 'es_slider_info',true );
	$_content = !empty( $es_slider_info['content'] ) ? $es_slider_info['content'] : '' ;
	$_height  = !empty( $es_slider_info['height'] )  ? $es_slider_info['height']  : $opt['height'] ;
	
	$_sp_height =  preg_replace('/[^0-9]/', '', $opt['sp_height']);

	?>
	<style>
	.slick-block-essence .slick-item,
  .slick-block-essence .slick-text{
		height: <?php echo $_height; ?>;
		overflow: hidden;
	}
	@media screen and (max-width: 768px) {
		.slick-block-essence .slick-item,
    .slick-block-essence .slick-text
    {
			height: <?php echo $opt['sp_height']; ?>;
		}
	}
		
	<?php
	/**/
	if( !empty($_sp_height) && $_sp_height > 60 ){
		
	echo '
		@media screen and (max-width: 768px) {
				#slider-essence .slick-block-essence .slick-item img{
					left: '. (60 - $_sp_height) * 0.8 .'%;
				}
		}';

	echo '
		@media screen and (max-width: 600px) {
				#slider-essence .slick-block-essence .slick-item img{
					left: '. ((60 - $_sp_height) * 1.4 - $opt['sp_right']) .'%;
				}
		}';
	
	}
	
	
		

	$mods = get_theme_mods();	
	if( !empty($mods['slide_text']) ){
		echo '.slick-text{
			color: '.$mods['slide_text'].';
		}';
	}
	if( !empty($mods['slide_shadow']) ){
		echo '.slick-text{
			text-shadow: 1px 1px 7px '.$mods['slide_shadow'].';
		}';
	}
  if( !empty($mods['slide_bkg']) ){
		echo '.slick-block-essence {
			background-color:'.$mods['slide_bkg'].';
		}';
	}

	if( !empty($opt['zoom']) ){
		?>
		.slick-item img{
			animation: keyvisual_zoom_in <?php echo $opt['speed'] + 2; ?>s ease 0s forwards;
		}
		<?php
	}
  
  if( $opt['center_mode'] ){
		?>
		.slick-item{
			filter:alpha(opacity=30);
      -moz-opacity: 0.3;
      opacity: 0.3;
		}
    .slick-item.slick-active{
			filter:alpha(opacity=100);
      -moz-opacity: 1;
      opacity: 1;
		}
		<?php
	}
	?>
	
	</style>

	<script>
	jQuery(document).ready(function ($) {
		function sliderSetting(){
			var width = $(window).width();
			if(width > 600){
				$('.slick-block-essence').not('.slick-initialized').slick({
					autoplay: true,
					arrows: true,
					dots: true,
					infinite: true,
					speed: 500,
          centerMode: true,
          centerPadding: '15%',
					autoplaySpeed: <?php echo ($opt['speed'] * 1000); ?>,
					slidesToShow: 1,
					<?php if( $opt['center_mode'] ){
                  //echo 'fade: true,';
                }else{
                  echo 'fade: true,';
                } ?>
					responsive: [<?php
  if( $opt['center_mode'] ){
          ?>
              {
                breakpoint: 1200,
                settings: {centerPadding: 0,fade: true}
              },
<?php 
  }
   ?>
						{
							breakpoint: 600,
							settings: {
					<?php
					if( !empty($opt['sp_height']) ){
						echo 'arrows: false,dots: false,';
					}else{
						echo 'unslick: true';
					}
					?>
							}
						}
					]
				});
			 }
				<?php
				if( empty($opt['sp_height']) ){
					echo "else{
					$('.slick-block-essence.slick-initialized').slick('unslick');
					}";
				}else{
					?>
					$('.slick-block-essence').not('.slick-initialized').slick({
					autoplay: true,
					arrows: true,
					dots: true,
					infinite: true,
					speed: 500,
					autoplaySpeed: <?php echo ($opt['speed'] * 1000); ?>,
					slidesToShow: 1,
					fade: true,
					responsive: [
						{
							breakpoint: 600,
							settings: {
					<?php
					if( !empty($opt['sp_height']) ){
						echo 'arrows: false,dots: false,';
					}else{
						echo 'unslick: true';
					}
					?>
							}
						}
					]
				});
			
			<?php
				}
				 ?>
			 
		}

		// 初期表示時の実行
		sliderSetting();

		// リサイズ時の実行
		$(window).resize( function() {
			sliderSetting();
		});
		
		
  });
	jQuery( function($){
		$("#slider-essence").insertAfter("<?php echo $opt['place']; ?>");
		
		if($("#essence_slider-video").length ){
			$(".slider-wrap #essence_slider-video").get(0).play();
		}
		
	});
</script>	


<?php

	if( empty($sliders) )
		return;

	foreach( $sliders as $key => $value ){
		
		$thumb_src = wp_get_attachment_image_src ($value['image'],$opt['size']);
		if ( empty ($thumb_src) ){ //画像が存在しない空IDを強制的に取り除く
			$thumb_src[0] = wp_get_attachment_url($value['image']);
		}
		
		
		
		if ($value === reset($sliders)) {
			echo '<div id="slider-essence';
			if(strpos($thumb_src[0],'mp4') !== false){
				//echo '-none_slick';
			}
			echo '" class="slider-wrap main-content-wrap">';
			echo '<div class="slick-block-essence">';
			
			// action essence_slider_before =============================
			if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_slider_before]</span>';}
			do_action( 'essence_slider_before' );
			// ^action =============================
		}
		
		
		
		if( empty($thumb_src[0]) ) continue;

		
		echo '<div class="slick-item"';
		
		if(strpos($thumb_src[0],'mp4') === false){
			//echo ' style="background-image:url('.$thumb_src[0].')"';
		}else{
			echo ' style="position:relative; overflow:hidden; z-index: 10;"';
		}
		echo '>';
		
		echo '<img src="'.$thumb_src[0].'">';
		
		
		if(strpos($thumb_src[0],'mp4') !== false){
			echo '
			<video id="essence_slider-video" autoplay loop muted style="width:auto; min-width:100%; min-height: '. $_height .'; position:fixed; top:0; left:0; right:0; bottom:0; z-index:0; display: block;">
			<source src="'.$thumb_src[0].'" type="video/mp4">
			</video>
			';
		}
		

		if(preg_match('/\[|\]/',$value['text'])){
			echo '<div class="slick-text"><div class="slick-text-inner">'.apply_filters('the_content', do_shortcode($value['text'])).'</div></div>';
			
			if(!empty($value['textarea'])){
				echo '<div class="slick-textarea'.$opt['body_class'].'">'.apply_filters('the_content', do_shortcode($value['textarea'])).'</div>';
			}
			
		}else{
      if( $value['text'] ){
        echo '<div class="slick-text"><div class="slick-text-inner"><h2'.$opt['title_class'].'>'.nl2br(esc_html($value['text'])).'</h2></div></div>';
      }
			if(!empty($value['textarea'])){
				echo '<div class="slick-textarea'.$opt['body_class'].'">'.apply_filters('the_content', do_shortcode($value['textarea'])).'</div>';
			}

		}
		

		
		if ($value === end($sliders)) {
			// action essence_slider_before =============================
			if ( current_user_can( 'administrator' ) && $user_setting['display_shortcode'] ) { echo '<span class="do_action">do_action: [essence_slider_after]</span>';}
			do_action( 'essence_slider_after' );
			// ^action =============================
		}
		
		echo '</div>';
		
	}
	
	
	echo '</div>';
	
	
	if( !empty( $_content ) ){
		echo '<div class="slick-fixed-text">';
    

		
		if(preg_match('/\[|\]/',$_content)){
			echo '<div class="slick-text"><div class="slick-text-inner'.$opt['body_class'].'">'.wpautop(do_shortcode($_content)).'</div></div>';
		}else{
			echo '<div class="slick-text"><div class="slick-text-inner'.$opt['body_class'].'"><h2'.$opt['title_class'].' style="font-size:'.$opt['font_size'].'em;">'.nl2br(esc_html($_content)).'</h2></div></div>';
		}
		
		echo '</div>';

	}
	echo '</div>';

	echo '</div>';
	
}
add_action('wp_footer','slider_essence',999);



class Slide_Essence_Theme_Customize
   {

    //管理画面のカスタマイズにテーマカラーの設定セクションを追加
    public static function slide_essence_customize_register($wp_customize) {

			$wp_customize->add_setting( 'slide_text', array( 'default' => '#FFFFFF','sanitize_callback' => 'sanitize_hex_color' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'slide_text' , array(
					'label' => 'スライド上のテキスト色',
					'section' => 'colors',
					'settings' => 'slide_text',
			) ) );
			
			$wp_customize->add_setting( 'slide_shadow', array( 'default' => null,'sanitize_callback' => 'sanitize_hex_color' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'slide_shadow' , array(
					'label' => 'スライドテキストの影',
					'section' => 'colors',
					'settings' => 'slide_shadow',
			) ) );
      
      $wp_customize->add_setting( 'slide_bkg', array( 'default' => null,'sanitize_callback' => 'sanitize_hex_color' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'slide_bkg' , array(
					'label' => 'スライドの背景',
					'section' => 'colors',
					'settings' => 'slide_bkg',
			) ) );

			//リアルタイム反映
			$wp_customize->get_setting('slide_text')->transport = 'postMessage';
			$wp_customize->get_setting('slide_shadow')->transport = 'postMessage';
      $wp_customize->get_setting('slide_bkg')->transport = 'postMessage';
			
    }

}//Slide_Essence_Theme_Customize

// テーマ設定やコントロールをセットアップします。
add_action( 'customize_register' , array( 'Slide_Essence_Theme_Customize' , 'slide_essence_customize_register' ),20 );

?>