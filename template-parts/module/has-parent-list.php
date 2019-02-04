<?php
//if has brother posts

global $theme_opt;
global $post_type_set;
global $page_info;
global $post_type_name;


$_child_class = [];

if(
  empty( $post_type_set ) &&
  !in_array('display_side_list',$post_type_set )
){
	return;
}
	

  
function child_list_func($post,$_child_class = null){
  
  global $post_type_set;
	global $_current_page;
	global $post_taxonomies;

	$page_sub_info = get_post_meta($post->ID,'page_info',true);
	if( !empty($page_sub_info['exclude_list'])) return;

    
  ?>
  <li class="<?php echo implode(' ',$_child_class);?>">
    <a href="<?php the_permalink(); ?>">
		<?php
		echo '<div class="side_list_content';
		//thumbnail
		if(
			!empty( $post_type_set ) &&
			in_array('side_thumbnail',$post_type_set)&&
			has_post_thumbnail()
		){
			echo ' has_thumbnail';
		}
		echo '">';
		?>
			
		<span>
		<?php the_title(); ?>
    <?php
		// post date
		if(
			!empty( $post_type_set ) &&
			in_array('display_post_date',$post_type_set)
		){
			echo '<time class="list_block_date">'.get_the_date('Y.m.d').'</time>';
		}
		echo '</span>';
	
		if(
			!is_tax() &&
			!empty( $post_type_set ) &&
			in_array('display_list_term',$post_type_set) &&
      !empty ($post_taxonomies[0])
		){
			$term_list = wp_get_post_terms($post->ID, $post_taxonomies[0], array('fields' => 'all') );
			echo isset( $term_list[0]->name ) ? '<span class="taxonomy_label label-block">'.esc_attr($term_list[0]->name).'</span>' : '' ;
		}
	
		echo '</div>';
	
		//thumbnail
		if(
			!empty( $post_type_set ) &&
			in_array('side_thumbnail',$post_type_set)
		){
			echo '<figure class="list_block_thumbnail"><picture>'. get_the_post_thumbnail($post->ID,array(80,80),array('class'=>'img-responsive')) .'</picture></figure>';
		}
	
	
	
    ?>
		
    </a>
  </li>
  <?php
}//func
  


$posts_per_page = isset($post_type_set['posts_per_page']) ? $post_type_set['posts_per_page'] : '10' ;
$posts_order = isset($post_type_set['posts_order']) ?$post_type_set['posts_order'] : 'DESC' ;
$event_date = isset($post_type_set['event_date']) ?$post_type_set['event_date'] : null ;

if($event_date){
  $orderby = 'meta_key';
}elseif($posts_order == 'menu_order'){
  $orderby = 'menu_order';
  $posts_order = 'ASC';
}else{
  $orderby = 'post_date';
}



if( $post_type_name !== 'page' && $post_type_name !== 'front_page'  ){
  $type_obj = get_post_type_object($post_type_name);
  $has_archive = isset($type_obj->has_archive) ? $type_obj->has_archive : false ;
}else{
  $has_archive = true;
}


if( is_singular() && $has_archive == true){
	//only level one ancestors
	$_ancestors = array_reverse($post->ancestors);
  if($_ancestors){
      foreach($_ancestors as $post_anc_id){
          $post_id = $post_anc_id;
      }
  } else {
      $post_id = $post->ID;
  }
	
	if( $post_type_name !== 'page' && $post_type_name !== 'post'){
		$post_id = 0;
	}

	
  $parent_args = array(
      'post_type' 			=> $post_type_name,
      'post_status' 		=> 'publish',
      'orderby' 				=> $orderby,
      'order' 					=> $posts_order,
      'posts_per_page'  => $posts_per_page,
      'paged' 					=> 0,
      'post__in' 				=> array($post_id)
  );
  $parent_query = new WP_Query( $parent_args );

  $child_args = array(
          'post_type' 			=> $post_type_name,
          'post_status' 		=> 'publish',
          'orderby' 				=> $orderby,
			    'order' 					=> $posts_order,
          'posts_per_page'  => $posts_per_page,
          'paged' 					=> 0,
          'post_parent' 		=> $post_id
          //'post__not_in' => array($post_id)
      );
  $child_query = new WP_Query( $child_args );
  
  if( is_single() && empty($post_type_name) ){
    $child_args = array(
          'post_type' 			=> 'post',
          'post_status' 		=> 'publish',
          'orderby' 				=> $orderby,
			    'order' 					=> $posts_order,
          'posts_per_page'  => $posts_per_page,
          'paged' 					=> 0,
          'post__not_in' 		=> array($post_id)
      );
      $child_query = new WP_Query( $child_args );
  }

  
  if( $child_query -> have_posts()):?>

    <div class="side_list has_parent_list">

        <ul class="list-bordered">
        
        <?php
				//display parent posts
				if( $parent_query -> have_posts()): while( $parent_query -> have_posts()) : $parent_query -> the_post();
	
	
					$page_sub_info = get_post_meta($post->ID,'page_info',true);
						if( !empty($page_sub_info['exclude_list'])) continue;//exclude_list
					?>
					<li><a class="link_color" href="<?php the_permalink(); ?>"><?php the_title(); ?>

					<?php
					if(
						!empty( $post_type_set ) &&
						in_array('display_post_date',$post_type_set)
					){
						echo '<time class="list_block_date">'.get_the_date('Y.m.d').'</time>';
					}
	
					//thumbnail
					if(
						!empty( $post_type_set ) &&
						in_array('side_thumbnail',$post_type_set)
					){
						echo '<figure class="list_block_thumbnail"><picture>'. get_the_post_thumbnail($post->ID,array(80,80),array('class'=>'img-responsive')) .'</picture></figure>';
					}
	
					?>


					</a></li>
        <?php 
				
				endwhile;endif;?>
        
        <?php
				//display child posts
				$_child_class[] = 'parent-list-item';
	
				while( $child_query -> have_posts()) : $child_query -> the_post();
				
        child_list_func($post,$_child_class);

          $sub_child_args = array(
                'post_type' 			=> $post_type_name,
                'post_status' 		=> 'publish',
                'orderby' 				=> $orderby,
                'order' 					=> $posts_order,
                'posts_per_page'  => $posts_per_page,
                'paged' 					=> 0,
                'post_parent'		  => $post->ID
                //'post__not_in' => array($post_id)
              );
          $sub_child_query = new WP_Query( $sub_child_args );
          if( $sub_child_query -> have_posts() ):
						$_child_class = array('child-list-item');
            while( $sub_child_query -> have_posts()) : $sub_child_query -> the_post();
              child_list_func($post,$_child_class);
            endwhile;
          endif;
				endwhile;
				?>
        
        
        </ul>
</div>

<?php
$args = null;
wp_reset_query();
?>

<?php endif;
};
?>