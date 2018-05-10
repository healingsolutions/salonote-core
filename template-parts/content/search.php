<?php
//search

global
  $query,
  $post_type_label,
  $post_type_set;

//initialize
$archive_class = '';

if( !($query) ){
	global $wp_query;
	$query = $wp_query;
}


$taxonomy = !empty($post_type_set['taxonomy']) ? $post_type_set['taxonomy'] : '';
$list_type = !empty($post_type_set['list_type']) ? $post_type_set['list_type'] : 'list';

if($list_type === 'grid'){
	$grid_col = !empty($post_type_set['grid_col']) ? $post_type_set['grid_col'] : $grid_col;
	$grid_col = isset($grid_col) ? $grid_col : '4';
	$grid_col = (12/$grid_col);
	
	$archive_class = ' flex-block-wrap';
}

do_action( 'essence_before_archive_content' );

?>
<div class="<?php echo $main_block_class .' '. $post_type_class; ?>">
       
       <?php
				if($post_type_set['display']['archive_title']){
				?>
        <h2 class="l-content__head text-center">
					<?php
					$_search_query = the_search_query();
					echo $_search_query . __( 'seach result' , 'salonote-essence' ) . $wp_query->found_posts . __('cases','salonote-essence');
					?>
        </h2>
          
        
        <?php
				};
				?>
        
        
        
        <?php
				if(  !empty($post_type_set['full_archive'] )){
					print_taxonomy_block($post_type_set['full_archive']);
				}
        


				echo '<div class="'.$article_class . $has_sidebar . '">';
				echo '<div class="archive-unit '.$archive_class . ' clearfix">';

						do_action( $post_type_name . '_before_archive_content' );

            if(have_posts()):
							while(have_posts()):the_post();
  
              global $loop_counter;
              global $_post_count;
              $loop_counter = 0;
              $_post_count = $query->post_count;
  
							get_template_part('/template-parts/module/'.$list_type );
							do_action( 'essence_print_archive_content' );
              ++$loop_counter;
							endwhile;
            else:
              echo __('no posts','salonote-essence');
            endif;
						do_action( $post_type_name . '_after_archive_content' );

            // pagenation
            if(function_exists('wp_pagenavi') && $post_type_set['post_count'] !== '-1') {
              echo '<div class="l-pagenavi">';
              wp_pagenavi();
              echo '</div>';
            };

				echo '</div>';
        echo '</div>';
           
				if($has_sidebar){
					get_sidebar();
				}
            ?>
        </div>
    </div>
    
<?php
do_action( 'essence_after_archive_content' );

?>

</div>
