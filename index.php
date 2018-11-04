<?php
global $post_type_name;

get_header();

    if(is_front_page() ){
      get_template_part('template-parts/content/frontpage');
    }
		elseif( is_home() ){
			//echo 'is_home';
			get_template_part('template-parts/content/index');
		}
		elseif(is_singular()){
      //echo 'is_singular';
      get_template_part('template-parts/common/singular-content');
    }
    elseif(is_author()){
      get_template_part('template-parts/content/author');
    }
		elseif(is_tax()){
			//echo 'is_tax';
      get_template_part('template-parts/content/index');
    }
    elseif(is_archive()){
      get_template_part('template-parts/content/index');
    }
		
    elseif(is_search()){
      get_template_part('template-parts/content/search');
    }
    elseif(is_404()){
      //echo '404';
      get_template_part('template-parts/content/404');
    }
    else{
			//echo 'else';
      get_template_part('template-parts/content/index');
    }


get_footer();
?>