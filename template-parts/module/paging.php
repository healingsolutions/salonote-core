  <div class="nextprev_paging-unit">
  <?php
  global $post_type_set;
    
    
  if (get_previous_post()){
    $previous_post = get_previous_post();
    echo '<div class="previous">';
    
      //thumbnail
      if(
        !empty( $post_type_set ) &&
        in_array('side_thumbnail',$post_type_set)&&
        has_post_thumbnail($previous_post->ID)
      ){
        echo '<figure class="list_block_thumbnail"><picture>'. get_the_post_thumbnail($previous_post->ID,array(100,100),array('class'=>'img-responsive')) .'</picture></figure>';
      }

      previous_post_link( '%link','%title' );
    echo '</div>';
  }

  if (get_next_post()){
    $next_post = get_next_post();
    echo '<div class="next">';
    
      //thumbnail
      if(
        !empty( $post_type_set ) &&
        in_array('side_thumbnail',$post_type_set)&&
        has_post_thumbnail($next_post->ID)
      ){
        echo '<figure class="list_block_thumbnail"><picture>'. get_the_post_thumbnail($next_post->ID,array(100,100),array('class'=>'img-responsive')) .'</picture></figure>';
      }
    
      next_post_link( '%link','%title' );
    echo '</div>';
  }
  ?>      
  </div>