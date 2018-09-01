<?php
//list-part-inner
global $theme_opt;
global $post_type_set;
global $post_type_name;


// thumbnail =======================================
if(
  !empty( $post_type_set ) &&
  in_array('display_thumbnail',$post_type_set) && 
	!is_page_template('template/attachment-list.php')
	){
		
		
		//if display movie thumbnail
		//get movie id from content
		if(
			in_array('movie_thumbnail',$post_type_set)
		){
			$_the_content = get_the_content($post->ID);
			preg_match( '/\[youtube id=(\'|\")?(.+?)(\'|\")?\]/',$_the_content, $matches );
			
			if( !empty($matches[2]) ){
				$_thumbnail_url = !empty($matches[2]) ? '<img src="http://img.youtube.com/vi/'.$matches[2].'/0.jpg" />' : null ;
			}
		}

		//if display thumbnail
		if(
			empty($_thumbnail_url) &&
			has_post_thumbnail($post->ID) && 
			!empty( get_the_post_thumbnail_url($post->ID) )
		){
			$thumb_size = !empty( $post_type_set['thumbnail_size'] ) ? $post_type_set['thumbnail_size'] : 'thumbnail' ;
			$thumb_attr = array(
				'alt'   => trim( strip_tags( get_the_title() )),
				'title' => trim( strip_tags( get_the_title() )),
			);
			$_thumbnail_url = get_the_post_thumbnail($post->ID,$thumb_size,$thumb_attr);
		}// has_thumbnail
	
	
	
	
	if( !empty($_thumbnail_url) ){
	//print_thumbnail
	echo '<figure class="list_block_figure hover_figure">';
		
		echo $_thumbnail_url;
		
		//thumbnail caption =================================
		if(
			$post_type_set['list_type'] == 'grid' &&
			!empty( $post_type_set ) &&
			in_array('display_grid_thumb_caption',$post_type_set) &&
			has_excerpt()  
		){
			echo '<div class="grid_thumb_caption">'.wpautop(get_the_excerpt()).'</div>';
		}
		//^ thumbnail caption =================================
	
	echo '</figure>';
	}
}// display_thumbnail

// content =======================================
echo '<div class="list_block_inner">';


if(
  !empty( $post_type_set ) &&
  in_array('display_grid_title',$post_type_set)
){
	$_the_title = get_the_title();
	if( in_array('break_title',$theme_opt['base'])){
		$_the_title = preg_replace('/(\,|'.__(',','salonote-essence').')/', '$1<br />', $_the_title);
		$_the_title = preg_replace('/(~|〜)/', '<br /><span class="small">$1', $_the_title).'</span>';
	}
  echo '<p class="list_block_title">'.$_the_title.'</p>';
}

if(
  !empty( $post_type_set ) &&
  in_array('display_grid_sub_title',$post_type_set) &&
  !empty(get_post_meta($post->ID, 'subTitle'))
){
  echo '<p class="list_block_sub_title">'.esc_html(get_post_meta($post->ID, 'subTitle', true)).'</p>';
}

if(
  !empty( $post_type_set ) &&
  in_array('display_post_date',$post_type_set)
){
  echo '<time class="list_block_date">'.get_the_date('Y.m.d').'</time>';
}


//excerpt
if(
  !empty( $post_type_set ) &&
	$post_type_set['list_show_excerpt'] === 'body'
	&& has_excerpt()  
){
  echo '<p class="list_block_excerpt">'.get_the_excerpt().'</p>';
}elseif(
	!empty( $post_type_set ) &&
  $post_type_set['list_show_excerpt'] === 'trim'
){
  echo '<p class="list_block_excerpt">'.get_the_excerpt().'</p>';
}
elseif(
	!empty( $post_type_set ) &&
  $post_type_set['list_show_excerpt'] === 'hide'
){
	echo '';
}else{
	echo substr(get_the_excerpt(), 0, 0);
}


if(
  !empty( $post_type_set ) &&
	in_array('display_post_gallery',$post_type_set)
	&& get_post_gallery()
){
	echo '<div class="label-block has_gallery">'.__('gallery','salonote-essence').'</div>';
}

if(
  !empty( $post_type_set ) &&
	in_array('list_show_body',$post_type_set)
	&& get_the_content()
){
	echo '<div class="content-block">'.strip_tags(get_the_content(),'<img><p>').'</div>';
}



echo '</div>';




?>