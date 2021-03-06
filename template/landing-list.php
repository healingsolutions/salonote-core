<?php
/*
Template Name: Landing Page
*/

global $theme_opt;
global $post_type_name;
global $post_type_set;
global $page_info;
global $main_unit;
global $user_setting;

global $hide_header;
global $hide_footer;

$args = array(
		'post_type' 			=> 'page',
		'post_parent'			=> $post->ID,
		'post_status' => array( 'publish', 'private' ),
		'posts_per_page' 	=> -1,
		'order'          	=> 'ASC',
		'orderby'        	=> 'menu_order',
);
$query = new WP_Query( $args );

$page_info = !empty( get_post_meta($post->ID,'page_info',true) ) ? get_post_meta($post->ID,'page_info',true) : array();
$landing_page_info = !empty( get_post_meta($post->ID,'landing_page_info',true) ) ? get_post_meta($post->ID,'landing_page_info',true) : array();


if( !empty($landing_page_info['none_header']) && $landing_page_info['none_header'] ){
	$hide_header = true;
	$main_content[] = 'none_header';
}
if( !empty($landing_page_info['none_header']) && $landing_page_info['none_footer'] ){
	$hide_footer = true;
	$main_content[] = 'none_footer';
}

$landing_page_item_inner = array('landing-page-item-inner');



if( !empty($landing_page_info['use_container']) && $landing_page_info['use_container'] ){
	$landing_page_item_inner[] = 'container';
}

$gallery_post_type_value = !empty(get_post_meta($post->ID,'gallery_post_type',true)) ? get_post_meta($post->ID,'gallery_post_type',true) : 'post' ;

// =============================
// initialize
$main_unit   = array('main-content-unit');
$main_unit[] = container_class();

$main_content[] = 'main-content-block';

$_main_width = !empty($theme_opt['base']['side_width']) ? (12 - $theme_opt['base']['side_width']) : 9 ;


$row_class = 'row';

// =============================
// if has sidebar
if(
	(
		!empty( $post_type_set ) &&
		!in_array('full_pages',$post_type_set)
	)||
	!empty($page_info['has_sidebar'] )
){
	
  if(
      empty($page_info['none_sidebar']) &&
			empty($page_info['full_size'] )
    ){
    $main_unit[]    = 'has_sidebar';
    $main_content[] = 'col-12';
		if( $_main_width >= 10 ) $main_content[] = 'col-md-'.($_main_width-1);
    $main_content[] = 'col-lg-'.$_main_width;
  }
	if(
      !empty($page_info['full_size'] )
    ){
		$main_unit = array_diff($main_unit, array('container'));
		$main_content[] = 'col-12';
  }
}else{
    $main_unit[]    = 'none_sidebar';
    $main_content[] = 'col-xs-12';
    $main_content[] = 'col-sm-12';
		$row_class .= '-block';
}


if((
		!empty( $post_type_set ) &&
		in_array('hide_header',$post_type_set)
	)){
	$main_unit[]    = 'hide_header';
}
if((
		!empty( $post_type_set ) &&
		in_array('hide_footer',$post_type_set)
	)){
	$main_unit[]    = 'hide_footer';
}


if( !empty( $page_info ) ) {
  foreach( $page_info as $info_key => $value){
    $main_unit[] = $info_key;
  }
}



get_header();



echo '<div class="'.implode(' ',$main_unit).'">';
echo '<div class="'.$row_class.'">';

  // main =======================
  echo '<div class="'.implode(' ',$main_content).'">';
	echo '<div class="landing-page-block main-content-wrap">';
	

	$page_info['disable_title'] = true;

	if(have_posts()): while(have_posts()): the_post();

		$page_bkg	= get_post_meta(get_the_ID(),'page_bkg_upload_images', true );

		if( !empty($page_bkg) ){
			$thumb_src = wp_get_attachment_image_src ($page_bkg,'large');
			if( empty($thumb_src[0]) ){
				$thumb_src = wp_get_attachment_image_src ($page_bkg,'full');
			}
			if ( empty ($thumb_src[0]) ){
					//delete_post_meta( $post_id, 'page_bkg_upload_images', $img_id );
				$thumb_src[0] = wp_get_attachment_url($page_bkg);
			}
		}

		//echo '<div id="landing-'.get_the_ID().'" name="landing-'.get_the_ID().'" class="ancor"></div>';
		echo '<div class="landing-page-item" style="';
		if( !empty($page_bkg) && !empty($thumb_src[0]) ){
			 echo ' background-image: url('.$thumb_src[0].'); padding-top: 2em; padding-bottom: 2em;';
		}
		if( !empty($landing_page_info['bkg_color'] ) ){
			 echo ' background-color: '. $landing_page_info['bkg_color'].';';
		}
		if( !empty($landing_page_info['txt_color'] ) ){
			 echo ' color: '. $landing_page_info['txt_color'].' !important;';
		}
		echo '">';
		echo '<div class="'.implode(' ',$landing_page_item_inner).'">';
			get_template_part('template-parts/module/single-content');
			edit_post_link( get_the_title() . 'を編集', '<div class="entry_block_content"><div class="btn btn-primary randing_page_edit">', '</div></div>');
		echo '</div>';
		echo '</div>';

  endwhile; endif;

	if($query->have_posts()){
		while($query->have_posts()): $query->the_post();
		
		$pageTemplate = get_post_meta(get_the_ID(), '_wp_page_template', true);
		
		$page_bkg = !empty( get_post_meta(get_the_ID(),'page_bkg_upload_images',true) ) ? get_post_meta(get_the_ID(),'page_bkg_upload_images',true) : null;
		$page_info = !empty( get_post_meta(get_the_ID(),'page_info',true) ) ? get_post_meta(get_the_ID(),'page_info',true) : array();
		
		$landing_page_info = get_post_meta(get_the_ID(),'landing_page_info',true);
		
		if( !empty($page_bkg) ){
			$thumb_src = wp_get_attachment_image_src ($page_bkg,'large');
			if( empty($thumb_src[0]) ){
				$thumb_src = wp_get_attachment_image_src ($page_bkg,'full');
			}
			if ( empty ($thumb_src[0]) ){
					//delete_post_meta( $post_id, 'page_bkg_upload_images', $img_id );
				$thumb_src[0] = wp_get_attachment_url($page_bkg);
			}
		}


		
		
		
		$post = get_post();
		echo '<div id="landing-'.get_the_ID().'" name="landing-'.get_the_ID().'" class="ancor"></div>';
		
		echo '<div class="landing-page-item" style="';
		if( !empty($page_bkg) && !empty($thumb_src[0]) && $pageTemplate !== 'template/keyv-landing.php'){
			echo ' background-image: url('.$thumb_src[0].'); padding-top: 2em; padding-bottom: 2em;';
			
		}
		if( !empty($landing_page_info['bkg_color'] )  ){
			 echo ' background-color: '. $landing_page_info['bkg_color'].'; padding: 5em 0; margin-bottom: 3em;';
		}
		if( !empty($landing_page_info['txt_color'] ) ){
			 echo ' color: '. $landing_page_info['txt_color'].' !important;';
		}
		echo '">';
		

		
		echo '<div class="'.implode(' ',$landing_page_item_inner);
		if($pageTemplate == 'template/keyv-landing.php' ){
			echo ' row';
		}
		if( !empty($page_info['super_container']) && $page_info['super_container'] ){
			echo ' super_container';
		}
		if( !empty($landing_page_info['use_container']) && $landing_page_info['use_container'] ){
			echo ' container';
		}
		echo '">';
		

		$page_info['disable_title'] = true;
		
			
			if($pageTemplate == 'template/keyv-landing.php' ){
				
				if( !empty($page_bkg) ){
					$thumb_src = wp_get_attachment_image_src ($page_bkg,'full');
					if( empty($thumb_src[0]) ){
						$thumb_src = wp_get_attachment_image_src ($page_bkg,'full');
					}
					if ( empty ($thumb_src[0]) ){
							//delete_post_meta( $post_id, 'page_bkg_upload_images', $img_id );
						$thumb_src[0] = wp_get_attachment_url($page_bkg);
					}
					$key_image = $thumb_src[0];
				}else{

					$attachment_images = get_attached_media( 'image', get_the_ID() );

					if( !empty($attachment_images) ){
						$attachment_id = $attachment_images->ID;
						$key_image_arr = wp_get_attachment_image_src ($attachment_id,'full');
						$key_image = $key_image_arr[0];
					}
				}

				
				if( !empty($key_image) ){
				
				$keyv_content = '
					<figure id="keyv-figure" class="col-12 col-md-7">
						<picture>
							<img class="img-fit wp-image-'.$page_bkg.'" src="'. $key_image .'" alt="'.get_the_title().' - メインビジュアル">
						</picture>';

					if( has_excerpt() ){
						$keyv_content .= '<div class="figure-text">
						<div class="figure-text-inner">
						<h1>'. get_the_title() .'</h1>
						<p class="figure-text-inner-excerpt">';

						$keyv_content .= nl2br(get_the_excerpt());

						$keyv_content .= '</p>
						</div>
						</div>';
					}
					$keyv_content .= '</figure>';
				
					echo apply_filters('the_content',$keyv_content);
				
					echo '<div id="keyv-content" class="col-12 col-md-5">';
						get_template_part('template-parts/module/single-content');
					echo '</div>';
					
				}else{
					get_template_part('template-parts/module/single-content');
				}

			}else{
				get_template_part('template-parts/module/single-content');
			}
			
			
			
		
			edit_post_link($post->post_title . 'を編集', '<div class="entry_block_content"><div class="btn btn-primary randing_page_edit">', '</div></div>');
		echo '</div>';
		echo '</div>';
		endwhile;
	} //endif;


echo '</div>';
echo '</div>';
echo '</div>';
echo '</div>';


get_footer();
?>