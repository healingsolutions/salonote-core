<?php
/**
 * TinyMCE initialize
 * @param array $initArray
 * @return array
 */




if ( !function_exists( 'essence_tinymce' ) ):
function essence_tinymce($initArray) {
  
  global $theme_opt;
  
  $parent_formats = array(
    
    //=======================================
    array(
      'title' => __('headline','salonote-essence'),
      'items' => array(
        array(
            'title' => __('border bottom','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'title_bdr_btm'
        ),
            array(
            'title' => __('border top and bottom','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'title_bdr_tbtm'
        ),
        array(
            'title' => __('left border headline','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'heading'
        ),
        array(
            'title' => __('left border headline large','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'heading_md'
        ),
        array(
            'title' => __('headline border bottom','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'headline_bdr-left'
        ),

				
				
				//----------------------------
				array(
            'title' => __('dash headline','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'dash_btm_headline'
        ),
				
				array(
            'title' => __('double headline','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'double_btm_headline'
        ),
				
				array(
            'title' => __('double headline','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'double_btm_headline'
        ),
				
				array(
            'title' => __('round headline','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'round_headline'
        ),
				
				array(
            'title' => __('stitch headline','salonote-essence'),
						'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'stitch_headline headline_bkg'
        ),
				
				array(
            'title' => __('curled headline','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'curled_headline headline_bkg'
        ),
				
				array(
            'title' => __('ribbon headline','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'ribbon_headline headline_bkg'
        ),
				
				array(
            'title' => __('side border headline','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'side_bdr_headline'
        ),
				array(
            'title' => __('headline animation-style 01','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'animation-style_01'
        ),
				
				
				array(
            'title' => __('headline ribbon_type_01','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'ribbon_type_01'
        ),
				
				array(
            'title' => __('headline ribbon_type_02','salonote-essence'),
            'selector' => 'h1, h2, h3, h4, h5, h6, p',
            'classes' => 'ribbon_type_02',
					'block' => 'div',
						'wrapper' => 'true',
        ),
				
				
				
				
				//------------
				
				array(
          'title' => __('headline style 01','salonote-essence'),
          'inline' => 'span',
          'classes' => 'style_hd_1'
				),
				array(
						'title' => __('headline style 02','salonote-essence'),
						'inline' => 'span',
						'classes' => 'style_hd_2'
				),
				
        array(
            'title' => __('unit headline H3','salonote-essence'),
            'block' => 'h3',
            'classes' => 'unit_headline'
        ),
        array(
            'title' => __('inline headline H2','salonote-essence'),
            'block' => 'h2',
            'classes' => 'headline_nav'
        ),
        array(
            'title' => __('inline headline','salonote-essence'),
            'inline' => 'span',
            'classes' => 'inline_title'
        ),
				
      ),

    ),

    //=======================================
    array(
      'title' => __('blocks','salonote-essence'),
      'items' => array(

        array(
            'title' => __('memo','salonote-essence'),
            'block' => 'div',
						'wrapper' => 'true',
            'classes' => 'memo_block'
        ),
        array(
            'title' => __('tips','salonote-essence'),
            'block' => 'div',
						'wrapper' => 'true',
            'classes' => 'tips_block'
        ),
        array(
            'title' => __('attention','salonote-essence'),
            'block' => 'div',
						'wrapper' => 'true',
            'classes' => 'alert_block-attention'
        ),
        array(
            'title' => __('news','salonote-essence'),
            'block' => 'div',
						'wrapper' => 'true',
            'classes' => 'alert_block-news'
        ),
        array(
            'title' => __('band block','salonote-essence'),
            'block' => 'div',
						'wrapper' => 'true',
            'classes' => 'band_bkg'
        ),
				array(
            'title' => __('circled block','salonote-essence'),
            'block' => 'div',
						'wrapper' => 'true',
            'classes' => 'circled_block'
        ),
        
      ),

    ),// block
    //=======================================
    // table
    array(
      'title' => __('table','salonote-essence'),
      'items' => array(
        array(
            'title' => __('normal table','salonote-essence'),
            'selector' => 'table',
            'classes' => 'table table-bordered'
        ),

        array(
            'title' => __('table striped','salonote-essence'),
            'selector' => 'table',
            'classes' => 'table table-bordered table-striped'
        ),
        array(
            'title' => __('table horizon','salonote-essence'),
            'selector' => 'table',
            'classes' => 'table table-first-horizon'
        ),
				array(
            'title' => __('table sp_block','salonote-essence'),
            'selector' => 'table',
            'classes' => 'table table-sp-block'
        ),
      ),
    ), //table
		
		
		//=======================================
    // object
    array(
      'title' => __('object','salonote-essence'),
      'items' => array(
        array(
            'title' => __('text align left','salonote-essence'),
            'selector' => 'iframe, div ,img',
            'classes' => 'text-left'
        ),
				array(
            'title' => __('text align right','salonote-essence'),
            'selector' => 'iframe, div ,img',
            'classes' => 'text-right'
        ),
				array(
            'title' => __('text align center','salonote-essence'),
            'selector' => 'iframe, div ,img',
            'classes' => 'text-center'
        ),
				
				array(
            'title' => __('float left','salonote-essence'),
            'selector' => 'iframe, div ,img',
            'classes' => 'float-left'
        ),
				array(
            'title' => __('float right','salonote-essence'),
            'selector' => 'iframe, div ,img',
            'classes' => 'float-right'
        ),
				
				array(
						'title' => 'div',
						'block' => 'div',
				),
				
				array(
						'title' => 'section',
						'block' => 'section',
						'wrapper' => 'true',
				),
				
				
				array(
						'title' => __('vertical middle','salonote-essence'),
						'block' => 'div',
						'classes' => 'vertical-middle'
				),
				array(
						'title' => __('not break words','salonote-essence'),
						'inline' => 'span',
						'classes' => 'no-break-words'
				),
				array(
						'title' => __('text color white','salonote-essence'),
						'block' => 'div',
						'wrapper' => 'true',
						'classes' => 'bkg-white-text'
				),
				
				array(
						'title' => __('square label block','salonote-essence'),
						'block' => 'div',
						'wrapper' => 'true',
						'classes' => 'square_label_block'
				),
				array(
						'title' => __('square label block white','salonote-essence'),
						'block' => 'div',
						'wrapper' => 'true',
						'classes' => 'square_label_block type-white'
				),

      ),
    ), //object

    //=======================================
    // list
    array(
      'title' => __('list','salonote-essence'),
      'items' => array(
        array(
            'title' => __('list icon style','salonote-essence'),
            'selector' => 'ul,ol',
            'classes' => 'list-icon'
        ),
				
				array(
            'title' => __('list checkbox','salonote-essence'),
            'selector' => 'ul,ol',
            'classes' => 'list-checkbox'
        ),
				array(
            'title' => __('list inline','salonote-essence'),
            'selector' => 'ul,ol',
            'classes' => 'list-inline'
        ),
				array(
            'title' => __('list block','salonote-essence'),
            'selector' => 'ul,ol',
            'classes' => 'list-block'
        ),
				array(
            'title' => __('list numbering','salonote-essence'),
            'selector' => 'ol',
            'classes' => 'list-numbering'
        ),
				array(
            'title' => __('list flow','salonote-essence'),
            'selector' => 'ol',
            'classes' => 'list-flow'
        ),
				array(
            'title' => __('list root','salonote-essence'),
            'selector' => 'ol',
            'classes' => 'list-root'
        ),
				
				array(
            'title' => __('question description list','salonote-essence'),
            'selector' => 'dl',
            'classes' => 'question-dl'
        ),
				array(
            'title' => __('toggle description list','salonote-essence'),
            'selector' => 'dl',
            'classes' => 'toggle-dl'
        ),
      ),
    ),// list
    
    //=======================================
    // images
    array(
      'title' => __('image','salonote-essence'),
      'items' => array(
          array(
            'title' => __('image circled','salonote-essence'),
            'selector' => 'img',
            'classes' => 'img-circled'
          ),
          array(
              'title' => __('image rounded','salonote-essence'),
              'selector' => 'img',
              'classes' => 'img-rounded'
          ),
					array(
              'title' => __('image diamond','salonote-essence'),
              'selector' => 'img',
              'classes' => 'img-diamond'
          ),
          array(
              'title' => __('image shadow','salonote-essence'),
              'selector' => 'img',
              'classes' => 'shadow-box'
          ),
        ),
    ),//images
		
		
		//=======================================
    // extend
    array(
      'title' => __('extend style','salonote-essence'),
      'items' => array(
          array(
            'title' => __('normal cover image','salonote-essence'),
            'selector' => 'img',
            'classes' => 'img-cover-block bkg-static'
          ),
				
					array(
            'title' => __('fixed cover image','salonote-essence'),
            'selector' => 'img',
            'classes' => 'img-cover-block bkg-fixed'
          ),
				
				array(
            'title' => __('parallax cover image','salonote-essence'),
            'selector' => 'img',
            'classes' => 'img-cover-block bkg-parallax'
          ),
				
					array(
            'title' => __('text on cover image','salonote-essence'),
						'wrapper' => 'true',
            'block' => 'div',
            'classes' => 'text-cover-block'
          ),
				
					
				
					array(
            'title' => __('block image','salonote-essence'),
            'selector' => 'img',
            'classes' => 'block-image'
          ),
				
					array(
            'title' => __('block side by side','salonote-essence'),
            'wrapper' => 'true',
						'block' => 'div',
            'classes' => 'block-unit'
          ),
				
					array(
            'title' => __('block wrap','salonote-essence'),
            'wrapper' => 'true',
						'block' => 'div',
            'classes' => 'block-wrap'
          ),

					array(
            'title'	  => __('vertical-rl','salonote-essence'),
						'wrapper' => 'true',
						'block'		=> 'div',
            'classes' => 'block-vertical-rl'
          ),
					array(
							'title' => __('code','salonote-essence'),
							'block' => 'code',
							'wrapper' => 'true',
							'classes' => 'pre_code-block'
					),
					array(
							'title' => __('border block','salonote-essence'),
							'block' => 'div',
							'wrapper' => 'true',
							'classes' => 'bdr-block'
					),
				
					array(
							'title' => __('overflow-block','salonote-essence'),
							'block' => 'div',
							'wrapper' => 'true',
							'classes' => 'overflow-block'
					),
				
					array(
							'title' => __('movie-block','salonote-essence'),
							'block' => 'div',
							'classes' => 'movie-block-wrapper'
					),

          
        ),
    ),//extend
		

    
    //=======================================
    // buttons
    array(
      'title' => __('button','salonote-essence'),
      'items' => array(
        array(
            'title' => __('square button','salonote-essence'),
						'wrapper' => 'true',
            'block' => 'div',
            'classes' => 'btn-item'
        ),
				array(
            'title' => __('rounded button','salonote-essence'),
						'wrapper' => 'true',
            'block' => 'div',
            'classes' => 'btn-item btn-rounded'
        ),
				array(
            'title' => __('circled button','salonote-essence'),
						'wrapper' => 'true',
            'block' => 'div',
            'classes' => 'btn-item btn-circled'
        ),
				array(
            'title' => __('moving button','salonote-essence'),
						'wrapper' => 'true',
            'block' => 'div',
            'classes' => 'btn-item btn-moving'
        ),
				
				
      ),
    ), // buttons
		
		
		
		//=======================================
    // horizon
    array(
      'title' => __('horizon','salonote-essence'),
      'items' => array(
				array(
            'title' => __('horizon style','salonote-essence'),
						'selector' => 'hr',
            'classes' => 'block-horizon'
          ),
				
        array(
            'title' => __('short horizon','salonote-essence'),
            'selector' => 'hr',
            'classes' => 'short-horizon'
        ),
				
				array(
            'title' => __('hide horizon','salonote-essence'),
            'selector' => 'hr',
            'classes' => 'hidden'
        ),
				
      ),
    ), // buttons
		
		
		//=======================================
    // width
    array(
      'title' => __('width','salonote-essence'),
      'items' => array(
        array(
            'title' => '10%',
						'selector' => 'img,div',
            'classes' => 'w-10'
        ),
				array(
            'title' => '20%',
					  'selector' => 'img,div',
            'classes' => 'w-20'
        ),
				array(
            'title' => '30%',
						'selector' => 'img,div',
            'classes' => 'w-30'
        ),
				array(
            'title' => '40%',
						'selector' => 'img,div',
            'classes' => 'w-40'
        ),
				array(
            'title' => '50%',
						'selector' => 'img,div',
            'classes' => 'w-50'
        ),
				array(
            'title' => '60%',
						'selector' => 'img,div',
            'classes' => 'w-60'
        ),
				array(
            'title' => '70%',
						'selector' => 'img,div',
            'classes' => 'w-70'
        ),
				array(
            'title' => '80%',
						'selector' => 'img,div',
            'classes' => 'w-80'
        ),
				array(
            'title' => '90%',
						'selector' => 'img,div',
            'classes' => 'w-90'
        ),
      ),
    ), // width
		
		
		//=======================================
    // class
    array(
      'title' => __('class','salonote-essence'),
      'items' => array(
        array(
            'title' => 'clearfix',
            'selector' => 'iframe, div ,img',
            'classes' => 'clearfix'
        ),
				array(
						'title' => 'span',
						'inline' => 'span',
						'classes' => 'inline-span'
				),
				array(
						'title' => 'inline-block',
						'classes' => 'inline-block'
				),
				array(
					'title' => 'container',
					'wrapper' => 'true',
					'block' => 'div',
					'classes' => 'container'
				),
				array(
					'title' => 'super_container',
					'wrapper' => 'true',
					'block' => 'div',
					'classes' => 'super_container'
				),
				array(
					'title' => 'text-center',
					'selector' => 'div',
					'classes' => 'text-center'
				),
				array(
					'title' => 'block-center',
					'wrapper' => 'true',
					'block' => 'div',
					'classes' => 'block-center'
				),
				array(
					'title' => 'bkg-right',
					'selector' => 'div,img',
					'classes' => 'bkg-right'
				),
				array(
					'title' => 'bkg-left',
					'selector' => 'div,img',
					'classes' => 'bkg-left'
				),
				array(
					'title' => 'absolute',
					'selector' => 'div,img',
					'classes' => 'absolute'
				),
				
      ),
    ), // width
    
    
    array(
        'title' => __('marker','salonote-essence'),
        'inline' => 'span',
        'classes' => 'line_marker'
    ),
  );

  $initArray['style_formats'] = json_encode( $parent_formats );
  $initArray['style_formats_merge'] = false;

  //$initArray[ 'plugins' ] = 'table,code,advlist';
	
  //$initArray[ 'toolbar_1' ] = 'bold,italic,underline,strikethrough,removeformat,blockquote,bullist,numlist,alignleft,aligncenter,alignright,forecolor,backcolor,link,unlink,fullscreen,hr,wp_adv';
  //$initArray[ 'toolbar_2' ] = 'styleselect,formatselect,fontsizeselect,fontselect,table,wp_more,media,image';
  //$initArray[ 'toolbar_3' ] = 'wp_page,wp_code,outdent,indent,alignjustify,code';
  //$initArray[ 'toolbar_4' ] = '';
	
	
	$initArray[ 'toolbar1' ] = 'bold,italic,underline,strikethrough,removeformat,blockquote,bullist,numlist,alignleft,aligncenter,alignright,outdent,indent,forecolor,backcolor,link,unlink,fullscreen,hr,wp_page,undo,wp_adv';
  $initArray[ 'toolbar2' ] = 'styleselect,formatselect,fontsizeselect,fontselect,table,wp_more,media,image';
  $initArray[ 'toolbar3' ] = 'btn_add_sample_block, btn_add_col_block, btn_add_separate_block, btn_add_dldtdd_block, btn_only_spbr,btn_add_youtube_block,btn_add_horizon_block,btn_add_editor_block, btn_add_countdown_timer';
	//$initArray[ 'toolbar3' ] = 'btn_add_sample_block, btn_only_spbr,btn_add_youtube_block,btn_add_horizon_block,btn_add_editor_block';
	$initArray[ 'toolbar4' ] = '';

  $initArray[ 'extended_valid_elements' ] = "iframe[id|class|title|style|align|frameborder|height|longdesc|marginheight|marginwidth|name|scrolling|src|width]";
  //$initArray[ 'extended_valid_elements' ] = 'dl';
  //$initArray[ 'extended_valid_elements' ] = 'dt';
  //$initArray[ 'extended_valid_elements' ] = 'dd';
	
	//$initArray[ 'fontsize_formats' ] = '0.6em 0.7em 0.8em 0.9em 1em 1.1em 1.15em 1.2em 1.3em 1.4em 1.5em 1.6em 1.7em 1.8em 1.9em 2em 2.5em 3em 4em';
	//$initArray[ 'fontsize_formats' ] = "85% 100% 116%; 138.5% 153.9% 167% 182% 197%";
	$initArray[ 'fontsize_formats' ] = "60% 70% 80% 90% 100% 110% 120% 130% 140% 150% 160% 170% 180% 190% 200% 250% 300% 400%";
  
  // add editor class
  $initArray[ 'body_class' ] = 'main-content-unit';
  $initArray[ 'end_container_on_empty_block' ] = true;
  $initArray['disabled_editors'] = false;
	
	/*------------
	 editor-style.cssのキャッシュクリア
	------------*/
	$initArray['cache_suffix'] = 'v='.time();


  return $initArray;
}
endif;
add_filter('tiny_mce_before_init', 'essence_tinymce',10);





/* Plugin Name: My TinyMCE Buttons */
add_action( 'admin_init', 'my_tinymce_button',10 );

function my_tinymce_button() {
  if ( current_user_can( 'edit_posts' ) && current_user_can( 'edit_pages' ) ) {
    add_filter( 'mce_buttons', 'my_register_tinymce_button' );
    add_filter( 'mce_external_plugins', 'my_add_tinymce_button' );
  }
}

function my_register_tinymce_button( $buttons ) {
		array_push($buttons, "btn_add_col_block" );
		array_push($buttons, "btn_add_separate_block" );
		array_push($buttons, "btn_add_sample_block" );
		array_push($buttons, "btn_only_spbr" );
    array_push($buttons, "btn_add_editor_block" );
		array_push($buttons, "btn_add_dldtdd_block" );
		array_push($buttons, "btn_add_countdown_timer" );

  return $buttons;
}

function my_add_tinymce_button( $plugin_array ) {
		$plugin_array['essence_buttons'] = esc_url( get_template_directory_uri() ) .'/lib/module/tinymce/plugins/essence_buttons/essence_buttons.js';

	
    //$plugin_array['coverimage'] = esc_url( get_template_directory_uri() ) .'/lib/module/tinymce/plugins/cover-image/cover-image.js';
  return $plugin_array;
}
