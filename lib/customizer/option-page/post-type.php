<?php
$thumbnail_sizes = get_all_image_sizes();


$args = array(
  'public'   => true,
  '_builtin' => false
);
$post_types = get_post_types( $args, 'names' );

$author_arr = (object)array(
  
);


//array_unshift($post_types, "author");
array_unshift($post_types, "page");
array_unshift($post_types, "post");
array_unshift($post_types, "front_page");


$field_key = 'essence_post_type';
$field_arr = array(
	
	//========================================
	'hide_header' => array(
    'label' => __('Hide Header','salonote-essence'),
    'type' => 'checkbox',
  ),
	
	'hide_footer' => array(
    'label' => __('Hide Footer','salonote-essence'),
    'type' => 'checkbox',
  ),
	'event_date' => array(
    'label' => __('Enable Future Post','salonote-essence'),
    'type' => 'checkbox',
  ),
  
	'max_container_width' => array(
    'label' => __('Max Content Width','salonote-essence'),
    'type' => 'number',
		'description' => __('px (only device width larger 980px)','salonote-essence'),
  ),
  
	
  'list_type' => array(
    'label' => __('List Type','salonote-essence'),
    'type' => 'select',
      'selecter' => array(
        'list' => __('list','salonote-essence'),
        'grid' => __('grid','salonote-essence'),
        'timeline' => __('timeline','salonote-essence'),
      ),
  ),
  'posts_per_page' => array(
    'label' => __('posts_per_page','salonote-essence'),
    'type' => 'number',
  ),
  
  //archive setting
  'grid_cols' => array(
    'label' =>  __('Number of items to display in one column','salonote-essence'),
    'type' => 'number',
    'max'  => 6
  ),
  'posts_order' => array(
    'label' => __('posts_order','salonote-essence'),
    'type' => 'select',
      'selecter' => array(
        'DESC' => __('DESC','salonote-essence'),
        'ASC' => __('ASC','salonote-essence'),
        'menu_order' => __('menu_order','salonote-essence'),
        'rand' => __('random','salonote-essence'),
      ),
  ),
  'list_show_excerpt' => array(
    'label' => __('excerpt','salonote-essence'),
    'type' => 'select',
      'selecter' => array(
        'body' =>  __('has excerpt','salonote-essence'),
        'trim' =>  __('trim','salonote-essence'),
      )
  ),
  'list_show_body' => array(
    'label' =>  __('show content','salonote-essence'),
    'type' => 'checkbox',
  ),
  
  'list_none_href' => array(
    'label' => __('LINK','salonote-essence'),
    'type' => 'select',
    'selecter' => array(
      '' =>  __('normal','salonote-essence'),
      'no_link' => __('no_link','salonote-essence'),
      'another_link' => __('another_link','salonote-essence'),
    )
  ),


	
	//list page ========================================
	
	'display_archive_title' => array(
    'label' => __('Archive Page Title','salonote-essence'),
    'type' => 'checkbox',
  ),
	'display_grid_title' => array(
    'label' => __('List Post Title','salonote-essence'),
    'type' => 'checkbox',
  ),
  'display_grid_sub_title' => array(
    'label' => __('List Post SubTitle','salonote-essence'),
    'type' => 'checkbox',
  ),
	'display_list_term' => array(
    'label' => __('Category','salonote-essence'),
    'type' => 'checkbox',
  ),
	
	
  'display_grid_thumb_caption' => array(
    'label' => __('Caption','salonote-essence'),
    'type' => 'checkbox',
  ),
  'display_post_writer' => array(
    'label' => __('Writer','salonote-essence'),
    'type' => 'checkbox',
  ),
  'display_post_gallery' => array(
    'label' => __('Gallery Label','salonote-essence'),
    'type' => 'checkbox',
  ),
  
	'full_archive' => array(
    'label' => __('Hide Sidebar','salonote-essence'),
    'type' => 'checkbox',
  ),
  'none_archive_container' => array(
    'label' => __('None Container','salonote-essence'),
    'type' => 'checkbox',
  ),
	
  
  //singular ========================================


  'display_entry_title' => array(
    'label' => __('Page Title','salonote-essence'),
    'type' => 'checkbox',
  ),
	
	'display_post_date' => array(
    'label' => __('post_date','salonote-essence'),
    'type' => 'checkbox',
  ),
  'display_entry_sub_title' => array(
    'label' => __('Page SubTitle','salonote-essence'),
    'type' => 'checkbox',
  ),
  'display_entry_excerpt' => array(
    'label' => __('Page Excerpt','salonote-essence'),
    'type' => 'checkbox',
  ),
	
	'display_next_post' => array(
    'label' => __('Prev/Next','salonote-essence'),
    'type' => 'checkbox',
  ),
	'display_other_post' => array(
    'label' => __('Other Posts','salonote-essence'),
    'type' => 'checkbox',
  ),
	
	'display_side_list' => array(
    'label' => __('Show ChildPosts in Sidebar','salonote-essence'),
    'type' => 'checkbox',
  ),
  'display_child_unit' => array(
    'label' => __('Show ChildPosts in bottom','salonote-essence'),
    'type' => 'checkbox',
  ),
  'display_index_nav' => array(
    'label' => __('Show Index Navigation','salonote-essence'),
    'type' => 'checkbox',
    'description' => __('Only if contain "headline_nav"','salonote-essence'),
  ),

	'full_pages' => array(
    'label' => __('Hide Sidebar','salonote-essence'),
    'type' => 'checkbox',
  ),
  
  'none_page_container' => array(
    'label' => __('None page container','salonote-essence'),
    'type' => 'checkbox',
  ),
	
	'show_description' => array(
    'label' => __('show header description','salonote-essence'),
    'type' => 'checkbox',
  ),
  
  //thumbnail ========================================
  'display_thumbnail' => array(
    'label' => __('Show Thumbnail','salonote-essence'),
    'type' => 'checkbox',
    ),
  'thumbnail_size' => array(
    'label' => __('Sizes','salonote-essence'),
    'type' => 'select',
    'selecter'=> $thumbnail_sizes
  ),
  'movie_thumbnail' => array(
    'label' => __('Movie Thumbnail','salonote-essence'),
    'type' => 'checkbox',
    ),
  'first_thumbnail' => array(
    'label' => __('Use First Image for Thumbnail','salonote-essence'),
    'type' => 'checkbox',
    ),
  'post_thumbnail' => array(
    'label' => __('Show Thumbnail in post content','salonote-essence'),
    'type' => 'checkbox',
    ),
  'hide_thumbnail_caption' => array(
    'label' => __('Hide Gallery Caption','salonote-essence'),
    'type' => 'checkbox',
    ),
  
);
?>

<div class="wrap">
<h1><?php _e('Theme Setting','salonote-essence'); ?></h1>
<style>
  .essence-post_type-tab{
    display: block;
    border-bottom: 4px solid #A8BBCA;
  }
  .essence-post_type-tab > div{
    display: inline-block;

    padding: 6px 15px;
    margin-right: -5px;
    margin-bottom:  -4px;
    border-radius: 4px;
    border: 4px solid #A8BBCA;
    border-bottom: none;
    /* background-color: #F1F1F1; */
    background-color:#939393;
    color: #D6D6D6;
    cursor: pointer;
  }
  .essence-post_type-tab > div.active{
    background-color: #60A96A;
    color: #FFFFFF;
    font-weight: 700;
  }
  .form-content dl{
    display: inline-flex;
    width: 24%;
    min-width: 300px;
    height: 60px;
    margin: 0;
    padding: 10px;
    box-sizing: border-box;
    border: 2px solid #F1F1F1;
    background-color: #FFFFFF;
    vertical-align: middle;
  }
  .form-content dl > *{
    display: inline-block;
  }
  .form-content dl dd{
    float: right;
  }
	
	.form-content dl p{
    display: inline-block;
		margin: 0;
  }
  

</style>
<script>
   
//enable multiple checkbox
(function ($) {

    var selectorStr = [];

    $.fn.shiftcheckbox = function()
    {
        var prevChecked = [];
        var classname = this.attr('class');
        var endChecked  = [];  // wheather checked 'end point'
        var startStatus = [];  // status of 'start point' (checked or not)
        prevChecked[classname] = null;
        selectorStr[classname] = this;
        endChecked[classname]  = null;
        startStatus[classname] = null;

        this.bind("click", function(event) {
            var val = $(this).find('[type=checkbox]').val();
            var checkStatus = $(this).find('[type=checkbox]').prop('checked');
            if ( checkStatus == undefined ) checkStatus = false;

            //get the checkbox number which the user has checked

            //check whether user has pressed shift
            if (event.shiftKey) {
                if (prevChecked[classname] != null) {  // if check 'end point' with ShiftKey

                    //get the current checkbox number
                    var ind = 0, found = 0, currentChecked;
                    currentChecked = getSelected(val,classname);
    
                    if (currentChecked < prevChecked[classname]) {
                        $(selectorStr[classname]).each(function(i) {
                            if (i >= currentChecked && i <= prevChecked[classname]) {
                                $(this).find('[type=checkbox]').prop('checked' , startStatus[classname]);
                            }
                        });
                    } else {
                        $(selectorStr[classname]).each(function(i) {
                            if (i >= prevChecked[classname] && i <= currentChecked) {
                                $(this).find('[type=checkbox]').prop('checked' , startStatus[classname]);
                            }
                        });
                    }
    
                    prevChecked[classname] = currentChecked;
                    endChecked[classname]  = true;
                }
                else {                                 // if check 'start point' with ShiftKey
                    prevChecked[classname] = getSelected(val,classname);
                    endChecked[classname]  = null;
                    startStatus[classname] = checkStatus;
                }
            } else {                                   // considered to be 'start point'(if not press ShiftKey)
                    prevChecked[classname] = getSelected(val,classname);
                    endChecked[classname]  = null;
                    startStatus[classname] = checkStatus;
            }
        });
        this.bind("keyup", function(event) {
            if (endChecked[classname]) {
                    prevChecked[classname] = null;
            }
        });

    };


    function getSelected(val,classname)
    {
        var ind = 0, found = 0, checkedIndex;

        $(selectorStr[classname]).each(function(i) {
            if (val == $(this).find('[type=checkbox]').val() && found != 1) {
                checkedIndex = ind;
                found = 1;
            }
            ind++;
        });

        return checkedIndex;
    };
})(jQuery);
  
  jQuery(function($){
    $('.essence-post_type-tab > div').on('click', function() {
      $('.essence-post_type-tab > div').removeClass('active');
      $(this).addClass('active');
      $('.form-content').hide();
      var tab_content = $(this).attr('rel');
      $('#'+tab_content).show();
    });
    
    $('#front_page-form').show();
    $('#front_page-tab').addClass('active');
    
		$('dl.key-hide_header').before('<hr style="clear:both; width:100%; display:block;" ><h3><?php _e('Common Setting','salonote-essence'); ?></h3>');
		$('dl.key-list_type').before('<hr style="clear:both; width:100%; display:block;" ><h3><?php _e('Archice Setting','salonote-essence'); ?></h3>');
    $('dl.key-display_entry_title').before('<hr style="clear:both; width:100%; display:block;" ><h3><?php _e('Singular Setting','salonote-essence'); ?></h3>');
    $('dl.key-display_thumbnail').before('<hr style="clear:both; width:100%; display:block;" ><h3><?php _e('Thumbnail Setting','salonote-essence'); ?></h3>');
    
    <?php
    foreach($post_types as $post_type){
      echo "$('.essence_post_type_".$post_type."__essence_checkbox').shiftcheckbox();".PHP_EOL;
    }
    ?>
    
  });
  
 
  
  
  </script>
  <form method="post" action="options.php">
    <?php settings_fields( 'essence-theme-option-post_type' ); ?>
    <?php do_settings_sections( 'essence-theme-option-post_type' ); ?>
<?php
  
  echo '<div class="essence-post_type-tab">';
  foreach($post_types as $post_type){
    
    if( $post_type !== 'front_page' ){
      $obj = get_post_type_object($post_type);
      echo '<div id="'.$post_type.'-tab" rel="'.$post_type.'-form">'.$obj->label.'</div>';
    }else{
      echo '<div id="front_page-tab" rel="'.$post_type.'-form">'.__('front-page','salonote-essence').'</div>';
    }
    
  }
  echo '</div>';
  foreach($post_types as $post_type):
  
  
  
  $obj = get_post_type_object($post_type);
  echo '<div id="'.$post_type.'-form" class="form-content" style="display:none">';
  
  if( $post_type !== 'front_page' ){
    $obj = get_post_type_object($post_type);
    echo '<h2>'.$obj->label.'</h2>';
  }else{
    echo '<h2>'.__('front-page','salonote-essence').'</h2>';
  }
    
    
    $field_key_set = '';
    $field_key_set = $field_key.'['.$post_type.']';
    $_options_value = !empty(get_option($field_key)) ? get_option($field_key) : '' ;
    
    $_options_value_arr = !empty( $_options_value[$post_type] ) ? $_options_value[$post_type] : null ;

?>

    <table class="form-table">
      <?php
      essence_theme_opiton_form($field_key_set,$field_arr,$_options_value_arr,'dldtdd');
      ?>
    </table>

</div>
  <?php
endforeach;
?>
  <?php submit_button(); ?>
  </form>
</div>