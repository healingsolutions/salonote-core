<?php
global $post_type_set;
global $post_taxonomies;

if(
	!empty( $post_type_set ) &&
	in_array('display_list_term',$post_type_set)
){


	if( is_singular() && is_object($post_taxonomies) ){
		echo '<div class="entry-taxonomy-block">';
		foreach($post_taxonomies as $tax_item){
			echo get_the_term_list($post->ID ,$tax_item, '<span>', '</span><span>', '</span>');
		}
		echo '</div>';
	}

	elseif( is_tax() ){
		echo '<div class="term-list-block">';
		single_term_title();
		echo '</div>';
	}
	
	elseif( is_archive() ){
		// get taxonomy objects of the post type
		$post_type_taxonomies = get_object_taxonomies( $post_type, 'objects' );
		


		if ( !empty($post_type_taxonomies) ) {
			foreach( $post_type_taxonomies as $post_type_taxonomy ) {
				
				if( is_object($post_type_taxonomy) ){
					
					$_term_html = '';
					
					
					// get terms by taxonomy name
					$terms = get_terms( $post_type_taxonomy->name );
					if ( ! is_wp_error( $terms ) ) {
						foreach ( $terms as $term ) {
							$term_link = !empty(get_term_link( $term )) ? get_term_link( $term ) : get_category_link( $term ) ;
							if ( is_wp_error( $term_link )) continue;
							$_term_html .= '<li><a href="' . esc_url( $term_link ) . '">' . $term->name . '</a></li>';
						}
					}
					
					if( !empty($_term_html) ){
						echo '<div class="term-list-block"><ul>'.$_term_html.'</ul></div>';
					}
					
				}

			}
		}
	}

	
	
	
}

?>