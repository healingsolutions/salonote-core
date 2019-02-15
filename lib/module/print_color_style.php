<?php
global $theme_opt;
global $color_customize_array;
global $color_set;

$color_set = '';

foreach($color_customize_array as $key => $value):
    if( !empty(get_theme_mod($key,$value['default'])) ){
      
      $color_set .= $value['target'].'{ '.$value['element'].':'.get_theme_mod($key,$value['default']) .'}'.PHP_EOL;
      
			//footer_color
      if( $key == 'footer_color' ){
        $color_set .= 'footer.site-footer-block ul.footer-sitemap > li > ul.sub-menu:before { border-left: 1px solid '.get_theme_mod($key,$value['default']).'}';
      }
      
			//bdr_color
      if( $key == 'bdr_color' && !empty(get_theme_mod($key,$value['default'])) ){
        $color_set .= '
					*[class*="heading"]{ border-left-color: '.get_theme_mod($key,$value['default']).'}
				';
        $color_set .= '
					*[class*="heading"]{ border-left-color: '.get_theme_mod($key,$value['default']).'}
					*[class*="title_bdr"]{
						border-bottom-color: '.get_theme_mod($key,$value['default']).';
						border-top-color: '.get_theme_mod($key,$value['default']).';
					}
				';
				$color_set .= '
          .headline_bdr-left::after,
          .timeline-type-group::after,
					.timeline-type-group .list_item_block::before
          {
						background-color: '.get_theme_mod($key,$value['default']).';
					}
				';

      }
      
      
      //list_bdr_color
      if( $key == 'list_bdr_color' && !empty(get_theme_mod($key,$value['default'])) ){
        $color_set .= '
          .timeline-type-group .list_item_block{
            border-color: '.get_theme_mod($key,$value['default']).';
          }
          .timeline-type-group .list_item_block::after{
            background-color: '.get_theme_mod($key,$value['default']).';
          }
        ';
      }
			
			//line_marker
			if( $key == 'line_marker'){
				$color_set .= 'span.line_marker{ background: linear-gradient(transparent 60%, '.get_theme_mod($key,$value['default']).' 60%);}';
			}
			
			//headline_bkg
			if( $key == 'headline_bkg'){
				$color_set .= '.headline_bkg, .curled_headline{
					box-shadow: 0px 0px 0px 5px '.get_theme_mod($key,$value['default']).';
				}';
			}
			
			//line_marker
			if( $key == 'list_icon_color' && !empty(get_theme_mod($key,$value['default']))){
				$color_set .= 'ol.list-flow:before{ border-left-color: '.get_theme_mod($key,$value['default']).'; }';
				$color_set .= 'ol.list-flow:after{ background-color: '.get_theme_mod($key,$value['default']).'; }';
			}
			
			
			//char_left
			if( $key == 'char_left' && !empty(get_theme_mod($key,$value['default']))){
				
				$color_code = salonote_hex2rgb( get_theme_mod($key,$value['default']) );
				$char_rgba = 'rgba('.$color_code[0].','.$color_code[1].','.$color_code[2].',0.05)';
				
				$color_set .= '.character_essence.char_position_left .char_content{ border-color: '.get_theme_mod($key,$value['default']).' !important; background-color: '.$char_rgba.'; }';
				$color_set .= '.character_essence.char_position_left .char_content::after{ border-right-color: '.get_theme_mod($key,$value['default']).' !important; }';
			}
			
			//char_left
			if( $key == 'char_right' && !empty(get_theme_mod($key,$value['default']))){
				
				$color_code = salonote_hex2rgb( get_theme_mod($key,$value['default']) );
				$char_rgba = 'rgba('.$color_code[0].','.$color_code[1].','.$color_code[2].',0.05)';
				
				$color_set .= '.character_essence.char_position_right .char_content{ border-color: '.get_theme_mod($key,$value['default']).' !important; background-color: '.$char_rgba.'; }';
				$color_set .= '.character_essence.char_position_right .char_content::after{ border-right-color: '.get_theme_mod($key,$value['default']).' !important; }';
			}
			
			

      
    }
  endforeach;


$font_set = [];
$font_set['mincho']      	= '"Times New Roman", "游明朝", "Yu Mincho", "游明朝体", "YuMincho", "ヒラギノ明朝 Pro W3", "Hiragino Mincho Pro", "HiraMinProN-W3", "HGS明朝E", "ＭＳ Ｐ明朝", "MS PMincho", serif;';
$font_set['gothic'] 		 	= '"Segoe UI", Verdana, 游ゴシック, "Yu Gothic", YuGothic, "ヒラギノ角ゴシック Pro", "Hiragino Kaku Gothic Pro", メイリオ, Meiryo, Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;';
$font_set['maru-gothic'] 	= '"ヒラギノ丸ゴ Pro W4","ヒラギノ丸ゴ Pro","Hiragino Maru Gothic Pro","ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","HG丸ｺﾞｼｯｸM-PRO","HGMaruGothicMPRO";';
$font_set['meiryo'] 			= '"メイリオ", Meiryo, "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro",Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;';

//body font
//$color_set .= 'body{ font-family: '. __('YakuHanJP Meiryo, sans-serif;','salonote-essence') .'}';


//logo_font
if( !empty($theme_opt['base']['logo_font']) ){	
	$color_set .= '
	.header_logo-block span,
	.navbar-logo-block
	{ font-family: '.$font_set[$theme_opt['base']['logo_font']].'}';
}

//nav_font
if( !empty($theme_opt['base']['nav_font']) ){	
	$color_set .= '
	.nav_font,
	.navbar-block span.main_nav
	{ font-family: '.$font_set[$theme_opt['base']['nav_font']].'}';
}

//headline_font
if( !empty($theme_opt['base']['headline_font']) ){	
	$color_set .= '
	.main-content-wrap .h1,
	.main-content-wrap h1,
	.main-content-wrap .h2,
	.main-content-wrap h2,
	.main-content-wrap .h3,
	.main-content-wrap h3,
	.main-content-wrap .h4,
	.main-content-wrap h4,
	.main-content-wrap .h5,
	.main-content-wrap h5,
	.main-content-wrap .h6,
	.main-content-wrap h6
	{ font-family: '.$font_set[$theme_opt['base']['headline_font']].'}';
}

//body_font
if( !empty($theme_opt['base']['body_font']) ){	
	
	$font_set = preg_replace('/(’|”|‘|“)/', '"', $font_set[$theme_opt['base']['body_font']]);
	
	$color_set .= '
	#body-wrap,
	.body_font,
	.main-content-wrap .body_font,
	.header_logo-block h1.site-description,
	.navbar-block a span.sub_nav
	{ font-family: '.$font_set.'}';
}



//if navbar_gradient_bkg  color
if( !empty(get_theme_mod('navbar_bkg')) && !empty(get_theme_mod('navbar_gradient_bkg')) ){
  
    $rgb_start = implode(',', (salonote_hex2rgb(get_theme_mod('navbar_bkg'))) );
    $rgb_end   = implode(',', (salonote_hex2rgb(get_theme_mod('navbar_gradient_bkg'))) );
    
  
		$color_set .= '.navbar-block, .sp-navbar-unit ,header ul.sub-menu, .pagination > *, .list-icon li::before, .list-taxonomy-block span a, .label-block, .sp_display_nav-container{
      background: '.get_theme_mod('navbar_bkg').';
      background: -moz-linear-gradient(top,rgba('. $rgb_start .',1),rgba('. $rgb_end .',1));
      background: -o-linear-gradient(rgba('. $rgb_start .',1),rgba('. $rgb_end .',1));
      background: -webkit-gradient(linear,left top,left bottom,from(rgba('. $rgb_start .',1)),to(rgba('. $rgb_end .',1)));
      background: linear-gradient(top,rgba('. $rgb_start .',1),rgba('. $rgb_end .',1));
      background: linear-gradient(to bottom, rgba('. $rgb_start .',1), rgba('. $rgb_end .',1));
    }
		';
}


//if sidebar color
if( !empty(get_theme_mod('sidebar')) ){
		$color_set .= '
		.sidebar_inner{
			padding: 25px 15px;
		}
		';
}

//if sidebar position
if( !empty($theme_opt['base']['sideMenu']) ){
	if( $theme_opt['base']['sideMenu'] == 'left' ){
		$color_set .= '
			.main-content-block{ float:right; }
			.sidebar{ float:left; }
		';
	}
}



//none hr
if( !empty( $theme_opt['base'] ) && in_array('hrLine',$theme_opt['base']) ){
		$color_set .= '
			.hr{ display:none; }
		';
}


//sp_none_float_img
if( !empty( $theme_opt['base'] ) && in_array('sp_none_float_img',$theme_opt['base']) ){
		$color_set .= '
@media screen and (max-width: 420px) {
	body img.alignleft,
	body img.alignright {
		display: block;
		float: none;
		clear: both;
		margin-left: auto;
		margin-right: auto;
		max-width: 100%;
	}
}
';
}



?>