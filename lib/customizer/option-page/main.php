<?php

$field_key = 'essence_base';
$field_arr = array(
  'title' => array(
      'label'       => __('Title','salonote-essence'),
      'description' => __('If only change default WordPress Title','salonote-essence'),
      'type'        => 'text',
  ),
  'description' => array(
      'label'       => __('Description','salonote-essence'),
      'description' => __('If only change default WordPress Description','salonote-essence'),
      'type'        => 'textarea',
  ),
  'keywords' => array(
      'label'       => __('Keywords','salonote-essence'),
      'description' => __('sepalate words (,)','salonote-essence'),
      'type'        => 'text'
  ),
  'google_analytics' => array(
      'label'       => 'GoogleAnalytics',
      'description' => __('GoogleAnalytics Tracking ID','salonote-essence'),
      'type'        => 'text'
  ),
	/*
  'schema_json' => array(
      'label'       => __('Schema','salonote-essence'),
      'description' => __('Schema JSON-LD','salonote-essence'),
      'type'        => 'checkbox'
  ),
	*/
  'google_map' => array(
      'label'       => 'GoogleMap',
      'description' => __('You can use shortcode [GoogleMap]','salonote-essence'),
      'type'        => 'textarea'
  ),
  'tel_number' => array(
      'label'       => __('Phone Number','salonote-essence'),
      'type'        => 'text'
  ),
  'fax_number' => array(
      'label'       => __('FAX Number','salonote-essence'),
      'type'        => 'text'
  ),
  'zip_code' => array(
      'label'       => __('ZipCode','salonote-essence'),
      'type'        => 'text'
  ),
  'contact_address' => array(
      'label'       => __('Address','salonote-essence'),
      'type'        => 'text'
  ),
	'biz_time' => array(
      'label'       => __('Business Time','salonote-essence'),
      'type'        => 'textarea'
  ),
	'biz_holiday' => array(
      'label'       => __('Business Holiday','salonote-essence'),
      'type'        => 'textarea'
  ),
	'biz_parking' => array(
      'label'       => __('Business Parking','salonote-essence'),
      'type'        => 'textarea'
  ),
	'biz_message' => array(
      'label'       => __('Business Message','salonote-essence'),
      'type'        => 'textarea'
  ),
  'sideMenu' => array(
      'label' => __('Side Menu Postion','salonote-essence'),
      'type'  => 'select',
      'selecter' => array(
              'right' => __('right','salonote-essence'),
              'left'  => __('left','salonote-essence'),
      )
  ),
	'side_width' => array(
      'label' => __('Side Menu Width','salonote-essence'),
      'type'  => 'select',
      'selecter' => array(
							'4' => 'col-sm-4',
              '3' => 'col-sm-3',
              '2' => 'col-sm-2',
							'1' => 'col-sm-1',
      )
  ),
  'container' => array(
      'label' =>  __('Use Container','salonote-essence'),
      'type'  => 'checkbox',
  ),
	
	
	'header_h1_txt' => array(
      'label' =>  __('Show header Headline 1 text','salonote-essence'),
      'type'  => 'checkbox',
			'description' =>  __('Show Headline 1 text in header logo space.But when too long description words, sometime break layout.','salonote-essence'),
  ),
	
  'BreadCrumb' => array(
      'label' =>  __('Show BreadCrumb','salonote-essence'),
      'type'  => 'checkbox',
  ),
  'hrLine' => array(
      'label' =>  __('Hide Horizon','salonote-essence'),
      'type'  => 'checkbox',
  ),
  'fitSidebar' => array(
      'label' =>  __('Fit Sidebar','salonote-essence'),
      'type'  => 'checkbox',
  ),
  'break_title' => array(
      'label' =>  __('break title (,)','salonote-essence'),
      'type'  => 'checkbox',
  ),
	'sp_none_float_img' => array(
      'label' =>  __('no float sp device','salonote-essence'),
      'type'  => 'checkbox',
			'description' =>  __('If float image on SmartPhone, sometime break text trouble','salonote-essence'),
  ),
  'childStyles' => array(
      'label'       =>  __('Child StyleSheet','salonote-essence'),
      'description' =>  __('use child theme stylesheet','salonote-essence'),
      'type'        => 'checkbox',
  ),
  'enable_parts' => array(
      'label' =>  __('Parts PostType','salonote-essence'),
      'type'  => 'checkbox',
  ),
	'enable_staff' => array(
      'label' =>  __('Staff PostType','salonote-essence'),
      'type'  => 'checkbox',
  ),
	'enable_style' => array(
      'label' =>  __('Style PostType','salonote-essence'),
      'type'  => 'checkbox',
  ),
	'enable_shop_menu' => array(
      'label' =>  __('ShopMenu PostType','salonote-essence'),
      'type'  => 'checkbox',
  ),
	'enable_character' => array(
      'label' =>  __('Character PostType','salonote-essence'),
      'type'  => 'checkbox',
  ),

	
	'header_type' => array(
      'label' =>  __('Header Type','salonote-essence'),
      'type'  => 'select',
      'selecter' => array(
							'normal'  =>  __('normal','salonote-essence'),
			        'right_nav' 	=>  __('right nav','salonote-essence'),
							'center'  =>  __('center','salonote-essence'),
      )
  ),
	
	'logo_font' => array(
      'label' =>  __('Logo Font','salonote-essence'),
      'type'  => 'select',
      'selecter' => array(
							'gothic'  =>  __('gothic','salonote-essence'),
			        'mincho' 	=>  __('mincho','salonote-essence'),
							'meiryo'  =>  __('Meiryo','salonote-essence'),
              'maru-gothic'  =>  __('maru-gothic','salonote-essence'),
      )
  ),
	
	'nav_font' => array(
      'label' =>  __('Navi Font','salonote-essence'),
      'type'  => 'select',
      'selecter' => array(
							'gothic'  =>  __('gothic','salonote-essence'),
			        'mincho' 	=>  __('mincho','salonote-essence'),
							'meiryo'  =>  __('Meiryo','salonote-essence'),
              'maru-gothic'  =>  __('maru-gothic','salonote-essence'),
      )
  ),
  
  
  'headline_font' => array(
      'label' =>  __('Headline Font','salonote-essence'),
      'type'  => 'select',
      'selecter' => array(
							'gothic'  =>  __('gothic','salonote-essence'),
			        'mincho' 	=>  __('mincho','salonote-essence'),
							'meiryo'  =>  __('Meiryo','salonote-essence'),
              'maru-gothic'  =>  __('maru-gothic','salonote-essence'),
      )
  ),
	
	'body_font' => array(
      'label' =>  __('Body Font','salonote-essence'),
      'type'  => 'select',
      'selecter' => array(
							'gothic'  =>  __('gothic','salonote-essence'),
							'mincho' 	=>  __('mincho','salonote-essence'),
							'meiryo'  =>  __('Meiryo','salonote-essence'),
              'maru-gothic'  =>  __('maru-gothic','salonote-essence'),
      )
  ),
	
	'entry_title' => array(
      'label' => __('Entry Title Class','salonote-essence'),
      'type'  => 'select',
      'selecter' => array(
							'title_bdr_btm' 		=> 'title_bdr_btm',
              'title_bdr_tbtm' 		=> 'title_bdr_tbtm',
              'heading' 					=> 'heading',
							'headline_bdr-left' => 'headline_bdr',
      )
  ),
	
	'headline_1' => array(
      'label' => __('Headline 1 Class','salonote-essence'),
      'type'  => 'select',
      'selecter' => array(
							'title_bdr_btm' 		=> 'title_bdr_btm',
              'title_bdr_tbtm' 		=> 'title_bdr_tbtm',
              'heading' 					=> 'heading',
							'headline_bdr-left' => 'headline_bdr',
      )
  ),
	'headline_2' => array(
      'label' => __('Headline 2 Class','salonote-essence'),
      'type'  => 'select',
      'selecter' => array(
							'title_bdr_btm' 		=> 'title_bdr_btm',
              'title_bdr_tbtm' 		=> 'title_bdr_tbtm',
              'heading' 					=> 'heading',
							'headline_bdr-left' => 'headline_bdr',
      )
  ),
	'headline_3' => array(
      'label' => __('Headline 3 Class','salonote-essence'),
      'type'  => 'select',
      'selecter' => array(
							'title_bdr_btm' 		=> 'title_bdr_btm',
              'title_bdr_tbtm' 		=> 'title_bdr_tbtm',
              'heading' 					=> 'heading',
							'headline_bdr-left' => 'headline_bdr',
      )
  ),
	'headline_4' => array(
      'label' => __('Headline 4 Class','salonote-essence'),
      'type'  => 'select',
      'selecter' => array(
							'title_bdr_btm' 		=> 'title_bdr_btm',
              'title_bdr_tbtm' 		=> 'title_bdr_tbtm',
              'heading' 					=> 'heading',
							'headline_bdr-left' => 'headline_bdr',
      )
  ),
	'widget_title' => array(
      'label' => __('Widget Title Class','salonote-essence'),
      'type'  => 'select',
      'selecter' => array(
							'title_bdr_btm' 		=> 'title_bdr_btm',
              'title_bdr_tbtm' 		=> 'title_bdr_tbtm',
              'heading' 					=> 'heading',
							'headline_bdr-left' => 'headline_bdr',
      )
  ),
);
?>

<div class="wrap">
<h1><?php _e('Theme Setting','salonote-essence');?></h1>
  

<form method="post" action="options.php">
    <?php settings_fields( 'essence-theme-option-base' ); ?>
    <?php do_settings_sections( 'essence-theme-option-base' ); ?>
    <table class="form-table">
      <?php
      $_options_value = !empty(get_option($field_key)) ? get_option($field_key) : '' ;
      //echo '<pre>'; print_r($_base_fields); echo '</pre>';
      essence_theme_opiton_form($field_key,$field_arr,$_options_value);
      ?>
    </table>
    
    <?php submit_button(); ?>

</form>
</div>

<?php
// ==============================
  get_template_part( 'lib/customizer/option-page/post-type');
  get_template_part( 'lib/customizer/option-page/extention');
?>