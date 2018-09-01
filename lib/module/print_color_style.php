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
        $color_set .= 'footer.site-footer-block ul.footer-sitemap > li > ul:before { border-left: 1px solid '.get_theme_mod($key,$value['default']).'}';
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
			
			

      
    }
  endforeach;


$font_set = [];
$font_set['mincho']      = __('"HiraMinProN-W3","MS PMincho", serif !important;','salonote-essence');
$font_set['gothic'] 		 = __('"Yu Gothic", YuGothic, "Hiragino Kaku Gothic Pro", Meiryo, Osaka, "MS PGothic", sans-serif;','salonote-essence');
$font_set['maru-gothic'] = __('"Rounded Mplus 1c", "Hiragino Kaku Gothic Pro", Meiryo, Osaka, "MS PGothic", sans-serif;','salonote-essence');
$font_set['meiryo'] = '"メイリオ", Meiryo, "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro",Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif';

//body font
//$color_set .= 'body{ font-family: '. __('YakuHanJP Meiryo, sans-serif;','salonote-essence') .'}';



//headline_font
if( !empty($theme_opt['base']['headline_font']) ){	
	$color_set .= '
	h1,.h1,h2,.h2,h3,.h3,h4,.h4,h5,.h5,h6,.h6
	{ font-family: '.$font_set[$theme_opt['base']['headline_font']].'}';
}

//body_font
if( !empty($theme_opt['base']['body_font']) ){	
	
	$font_set = preg_replace('/(’|”|‘|“)/', '"', $font_set[$theme_opt['base']['body_font']]);
	
	$color_set .= '
	#body-wrap{ font-family: '.$font_set.'}';
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