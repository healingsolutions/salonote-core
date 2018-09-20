<?php
global $color_customize_array;

$color_customize_array = array(

  'text_color' => array(
    'target'   => 'body',
    'element'  => 'color',
    'default'  => '#101010',
    'label_jp' => __('font-color','salonote-essence'),
    'section'  => 'colors',
  ),


  'link_color' => array(
    'target'   => 'a, .link-color',
    'element'  => 'color',
    'default'  => '#1f8dd6',
    'label_jp' => __('link color','salonote-essence'),
    'section'  => 'colors',
  ),


  'navbar_bkg' => array(
    'target'   => '.navbar-block, .sp-navbar-unit ,header ul.sub-menu, .pagination > *, .list-icon li::before, .list-taxonomy-block span a, .label-block, .sp_display_nav-container',
    'element'  => 'background-color',
    'default'  => '#333333',
    'label_jp' => __('nav background-color','salonote-essence'),
    'section'  => 'colors',
  ),


  'navbar_color' => array(
    'target'   => '.header_logo-block a, .navbar-block, .navbar-block a, .sp-navbar-unit, .sp-navbar-unit a, .open-nav-button::before, .pagination > *, .list-icon li::before, .list-taxonomy-block span a, .label-block, .label-block a, sp_display_nav-container, .sp_display_nav-container a, .sp_display_nav-container li:before',
    'element'  => 'color',
    'default'  => '#FFFFFF',
    'label_jp' => __('nav font-color','salonote-essence'),
    'section'  => 'colors',
  ),


  'navbar_bkg_hover' => array(
    'target'   => '.navbar-block ul li:hover, #header_nav li.current-menu-item, .pagination a:hover, .pagination > *.current',
    'element'  => 'background-color',
    'default'  => null,
    'label_jp' => __('nav background-color(:hover)','salonote-essence'),
    'section'  => 'colors',
  ),


  'navbar_color_hover' => array(
    'target'   => '.navbar-block li:hover, .navbar-block li a:hover,  .pagination > *:hover',
    'element'  => 'color',
    'default'  => null,
    'label_jp' => __('nav font-color(:hover)','salonote-essence'),
    'section'  => 'colors',
  ),


  'header_bkg' => array(
    'target'   => 'header.site-header-block, .header_bkg',
    'element'  => 'background-color',
    'default'  => null,
    'label_jp' => __('header background-color','salonote-essence'),
    'section'  => 'colors',
  ),


  'footer_bkg' => array(
    'target'   => 'footer.site-footer-block , .footer_bkg',
    'element'  => 'background-color',
    'default'  => null,
    'label_jp' => __('footer background-color','salonote-essence'),
    'section'  => 'colors',
  ),


  'footer_color' => array(
    'target'   => 'footer.site-footer-block, footer.site-footer-block a, footer.site-footer-block li::before',
    'element'  => 'color',
    'default'  => null,
    'label_jp' => __('footer font-color','salonote-essence'),
    'section'  => 'colors',
  ),
	
	
	'headline_bkg' => array(
    'target'   => '.headline_bkg',
    'element'  => 'background-color',
    'default'  => null,
    'label_jp' => __('headline background-color','salonote-essence'),
    'section'  => 'colors',
  ),


  'bdr_color' => array(
    'target'   => '.bdr_color',
    'element'  => 'color',
    'default'  => null,
    'label_jp' => __('border-color','salonote-essence'),
    'section'  => 'colors',
  ),
  
  'list_bdr_color' => array(
    'target'   => '.list-type-group .has_list_bdr.list_item_block',
    'element'  => 'border-bottom-color',
    'default'  => null,
    'label_jp' => __('list border-color','salonote-essence'),
    'section'  => 'colors',
  ),
	
	'list_icon_color' => array(
    'target'   => 'ul.list-icon li::before, ol.list-numbering>li:before, ol.list-flow>li:before, ol.list-root>li:before, dl.question-dl dt::before',
    'element'  => 'background-color',
    'default'  => null,
    'label_jp' => __('list icon color','salonote-essence'),
    'section'  => 'colors',
  ),
	
	'horizon_bdr_bkg' => array(
    'target'   => 'hr',
    'element'  => 'background-color',
    'default'  => null,
    'label_jp' => __('horizon color','salonote-essence'),
    'section'  => 'colors',
  ),


  'band_bkg' => array(
    'target'   => '.band_bkg',
    'element'  => 'background-color',
    'default'  => null,
    'label_jp' => __('band-block background-color','salonote-essence'),
    'section'  => 'colors',
  ),


  'line_marker' => array(
    'target'   => 'span.line_marker',
    'element'  => 'background-color',
    'default'  => '#ffff66',
    'label_jp' => __('marker background-color','salonote-essence'),
    'section'  => 'colors',
  ),


  'content' => array(
    'target'   => '.main-content-wrap',
    'element'  => 'background-color',
    'default'  => '#FFFFFF',
    'label_jp' => __('content background-color','salonote-essence'),
    'section'  => 'colors',
  ),


  'article' => array(
    'target'   => '.main-content-block',
    'element'  => 'background-color',
    'default'  => null,
    'label_jp' => __('mainblock background-color','salonote-essence'),
    'section'  => 'colors',
  ),


  'sidebar' => array(
    'target'   => '.sidebar_inner',
    'element'  => 'background-color',
    'default'  => null,
    'label_jp' => __('sidebar background-color','salonote-essence'),
    'section'  => 'colors',
  ),


  'grid' => array(
    'target'   => '.grid-inner, .grid-type-group .list_item_block > a',
    'element'  => 'background-color',
    'default'  => null,
    'label_jp' => __('grid background-color','salonote-essence'),
    'section'  => 'colors',
  ),


  'btn_bkg' => array(
    'target'   => '.btn-primary, .btn-color, .btn-item',
    'element'  => 'background-color',
    'default'  => null,
    'label_jp' => __('button background-color','salonote-essence'),
    'section'  => 'colors',
  ),
	
	'btn_color' => array(
    'target'   => '.btn-primary, .btn-color, .btn-item, .btn-item a, .btn-item a:hover',
    'element'  => 'color',
    'default'  => null,
    'label_jp' => __('button font-color','salonote-essence'),
    'section'  => 'colors',
  ),
	
	'horizon_block_bkg' => array(
    'target'   => '.horizon-block',
    'element'  => 'background-color',
    'default'  => '#F3F3F3',
    'label_jp' => __('horizon_block background-color','salonote-essence'),
    'section'  => 'colors',
  ),
	
	'horizon_block_color' => array(
    'target'   => '.horizon-block',
    'element'  => 'color',
    'default'  => null,
    'label_jp' => __('horizon_block font-color','salonote-essence'),
    'section'  => 'colors',
  ),
	

);

add_action('wp_print_styles','print_style_head', 10,2);
function print_style_head(){
  global $color_customize_array;
  global $color_set;

  get_template_part('lib/module/print_color_style');
	$color_set = preg_replace('/\n|\r|\r\n|\s(?=\s)/', '', $color_set );
	echo '<style>'.$color_set.'</style>';
}

?>