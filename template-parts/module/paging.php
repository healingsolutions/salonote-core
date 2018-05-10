  <div class="nextprev_paging-unit">
  <?php
  if (get_previous_post()){
    echo '<div class="previous">';
      previous_post_link( '%link','%title' );
    echo '</div>';
  }

  if (get_next_post()){
    echo '<div class="next">';
      next_post_link( '%link','%title' );
    echo '</div>';
  }
  ?>      
  </div>