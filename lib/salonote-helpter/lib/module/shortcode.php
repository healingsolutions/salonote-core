<?php



//YouTube list
function youtubeListFunc($atts) {
    extract(shortcode_atts(array(
        'cid' => null,
        'col' => 4
    ), $atts));
    
    ob_start();

    global $short_cid,$grid_col;
    if( isset( $cid ) ){
        $short_cid = $cid;
    };
    $grid_col = isset($col) ? $col : 4 ;
    get_template_part('template-parts/module/tools/youtubeList');
        
    return ob_get_clean();
}
add_shortcode('youtubeList', 'youtubeListFunc');



//YouTube item
function youtub_item_func($atts) {
    extract(shortcode_atts(array(
        'id' => null,
    ), $atts));
    
    ob_start();

    if ( isset($id) ){
    echo '<div class="text-center">';
      echo '<a href="https://www.youtube.com/embed/'.$id.'" rel="iframe" class="colorbox movie-block">';
      echo '<img class="youtube-item img-responsive" src="'.(empty($_SERVER["HTTPS"]) ? "http://" : "https://").'img.youtube.com/vi/'.$id.'/0.jpg" alt="YouTube Movie" />';
      echo '</a>';
    echo '</div>';
    };
        
    return ob_get_clean();
}
add_shortcode('youtube', 'youtub_item_func');



//Google adsence
function GoogleADsFunc() {
	global $theme_opt;
	
	if( !empty($theme_opt['extention']['google_ad']) ){
			 $google_ad = '<div class="mgtb20 googleAD">'. $theme_opt['extention']['google_ad']. '</div>';
	}
	return $google_ad;
}
add_shortcode('GoogleAD', 'GoogleADsFunc');




//GoogleMap
function GoogleMapCode($atts) {
  extract(shortcode_atts(array(
      'width' => '600', 
      'height' => '450',
  ), $atts));
  ob_start();

  global $theme_opt;
  if( !empty($theme_opt['base']['google_map'])){
    
    if(strpos($theme_opt['base']['google_map'],'iframe') !== false){
      preg_match('/\<iframe src=\"(.+?)\"(.+?)/', $theme_opt['base']['google_map'], $google_map_arr);
      $google_map = $google_map_arr[1];
    }else{
      $google_map = $theme_opt['base']['google_map'];
    }

    echo '<iframe src="'.$google_map.'" width="'. $width .'" height="'. $height .'" frameborder="0" style="border:0" allowfullscreen></iframe>';
  }

  return ob_get_clean();
}
add_shortcode('GoogleMap', 'GoogleMapCode');



//section
function section_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
        'bkg'         => null,
        'attachment'  => null,
        'color'       => null,
        'style'       => null,
        'class'       => null
    ), $atts ) );
  
    global $main_unit;
  
    $_section_class = [];
    $_section_class[] = container_class();

  
    if( !empty($class) ){
      $_section_class[] = $class;
    }
  
    $_section  = '</div></div></div></div>';
    $_section .= '<section class="content-section" style="';
    if( !empty($bkg) ){
      $_section .= ' background-image:url(' . $bkg . ');';
    }
    if( !empty($attachment) ){
      $_section .= ' background-attachment:' . $attachment . ';';
    }
    if( !empty($color) ){
      $_section .= ' color:' . $color . ';';
    }
    if( !empty($style) ){
      $_section .= ' '.esc_html($style);
    }
    $_section .= '"><div class="'.implode(' ',$_section_class).'">' . $content . '</div></section>';
    $_section .= '<div class="'.implode(' ',$main_unit).'">';
    $_section .= '<div class="row"><div class="main-content-block">';
  
    return $_section;
}
add_shortcode('section', 'section_shortcode');


//twitter
function twitter_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
      'id'         => null,
			'height' => 500
    ), $atts ) );

	if( !empty($id) ){
		$twitter_tag = '<div class="sns-wrap loader"></div><div class="sns-block"><a class="twitter-timeline" data-height="'.$height.'" href="https://twitter.com/'.$id.'?ref_src=twsrc%5Etfw">Tweets by '.$id.'</a>
		<script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script></div>';
	}

	return $twitter_tag;
}
add_shortcode('twitter', 'twitter_shortcode');


//facebook
function facebook_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
      'url'    => null,
			'height' => 500
    ), $atts ) );
  $facebook_tag = '';
	if( !empty($url) ){
		$facebook_tag = '<div class="sns-wrap loader"></div><div class="sns-block"><div class="fb-page" data-href="'.$url.'" data-tabs="timeline" data-height="'.$height.'" data-width="500" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/nagoyajkf/" class="fb-xfbml-parse-ignore"><a href="'.$url.'">'.get_bloginfo('name',true).'</a></blockquote></div></div>';
	}
	return $facebook_tag;
}
add_shortcode('facebook', 'facebook_shortcode');



//instagrum
function instagram_shortcode( $atts, $content = null ) {
    extract( shortcode_atts( array(
      'id'         => null,
			'height' => 500
    ), $atts ) );
  $instagram_tag = '';
	if( !empty($id) ){
		$instagram_tag = '<div class="sns-wrap loader"></div><div class="sns-block loader"><!-- InstaWidget -->
<a href="https://instawidget.net/v/user/'.$id.'" id="link-6a11a9490ee07ca2e73e1d0dc65ac10bda98ca759322e73904a30161abb825b6">@'.$id.'</a>
<script src="https://instawidget.net/js/instawidget.js?u=6a11a9490ee07ca2e73e1d0dc65ac10bda98ca759322e73904a30161abb825b6&width='.$height.'px"></script></div>';
	};

	return $instagram_tag;
}
//add_shortcode('instagram', 'instagram_shortcode');




//Business Info
function biz_info_Func() {
	ob_start();
	get_template_part('template-parts/module/parts/biz_info');
	return ob_get_clean();
}
add_shortcode('salonote_biz_info', 'biz_info_Func');

?>