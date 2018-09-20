<?php
global $theme_opt;
global $post_type_name;
global $post_type_set;
global $page_info;

global $page;
global $paged;

$post_id = get_the_ID();

if( get_the_content() || has_post_thumbnail() ){
echo '<div class="entry_block_content';
if( has_post_thumbnail() ) echo ' has_thumbnail';
echo '">';
echo '<header>';


// title =======================================
if(
  !empty( $post_type_set ) &&
  in_array('display_entry_title',$post_type_set )&&
  empty( $page_info['disable_title'] )
){
	$_the_title = get_the_title();
	if( in_array('break_title',$theme_opt['base'])){
		$_the_title = preg_replace('/(\,|】|'.__(',','salonote-essence').')/', '$1<br />', $_the_title);
		$_the_title = preg_replace('/(~|〜)/', '<br /><span class="small">$1', $_the_title).'</span>';
	}
  echo '<h1 class="entry_block_title">'.$_the_title;
	
	//paged
  if( $paged >= 2 || $page >= 2 ){
		echo '<span class="entry_block_sub_title ml-3">'.max( $paged, $page ) . __(' page','salonote-essence').'目</span>';
  }
	
	echo '</h1>';
	
	
	
}

// sub_title =======================================
if(
  !empty( $post_type_set ) &&
  in_array('display_entry_sub_title',$post_type_set )
){
	
	$_sub_title = get_post_meta($post_id, 'subTitle',true);
	if( !empty($_sub_title) ){
		echo '<h2 class="entry_block_sub_title">'.$_sub_title.'</h2>';
	}
  
}


/*-------------------------------------------*/
/*	taxonomy_list
/*-------------------------------------------*/
get_template_part('template-parts/module/taxonomy_list');


echo '<div class="staff_page-block grid-inner row">';

	
// thumbnail =======================================
if(
  !empty( $post_type_set ) &&
  in_array('post_thumbnail',$post_type_set )&&
	$page === 1 &&
  has_post_thumbnail()
){
	
  echo '<div class="entry_post_thumbnail col-12 col-md-4">';
	$thumb_attr = array(
		'class'	=> 'img-responsive mb-5',
		'alt'   => trim( strip_tags( get_the_title() )),
		'title' => trim( strip_tags( get_the_title() )),
	);
	$_thumbnail_url = get_the_post_thumbnail($post_id,'profile',$thumb_attr);
	
	echo '<figure>';
	
	echo $_thumbnail_url;
	
	echo '</figure>';
	
	echo '</div>';
}

echo '<div class="staff_profile_block col-12'. (has_post_thumbnail() ? ' col-md-8' : '') .'">';

	
$staff_profile_value = get_post_meta($post->ID,'staff_profile',true);
if( $staff_profile_value ){
	
	$staff_profile_arr = array(
    'skill'					=> __('得意なスタイル','salonote-essence'),
    'birthday'			=> __('生年月日','salonote-essence'),
		'blad'					=> __('血液型','salonote-essence'),
    'hobby'					=> __('趣味','salonote-essence'),
		'dream'					=> __('夢','salonote-essence'),
		'goal'					=> __('目標','salonote-essence'),
		'favorit_artist'=> __('好きなアーティスト','salonote-essence'),
		'favorit_words'	=> __('好きな言葉','salonote-essence'),
		'reason'				=> __('美容師になったきっかけ','salonote-essence'),
    'workday'				=> __('出勤','salonote-essence'),
    'blog'					=> __('ブログ','salonote-essence'),
    'twitter'				=> __('Twitter','salonote-essence'),
		'facebook'			=> __('Facebook','salonote-essence'),
		'instagram'			=> __('Instagram','salonote-essence'),
		
  );

	echo '
	<table class="staff_profile_values table table-striped">
	<thead></thead>
	<tbody>
	';
		foreach($staff_profile_value as $key => $value){
			$_field_key = str_replace( 'staff_' , '' , $key );
			if( empty($value) ) continue;
			echo '<tr>';
			echo '<th>'. $staff_profile_arr[$_field_key] .'</th>';
			
			if(strpos($value,'http') !== false){
				echo '<td><a href="'. ($value ? $value : '') .'" target="_blank">'. ($value ? $value : '') .'</a></td>';
			}else{
				echo '<td>'. ($value ? $value : '') .'</td>';
			}
			
			echo '</tr>';
		}
	echo '
	</tbody>
	</table>
	';
}
// excerpt =======================================
if(
  !empty( $post_type_set ) &&
  in_array('display_entry_excerpt',$post_type_set )&&
  has_excerpt()
){
  echo '<div class="entry_block_excerpt">'.nl2br($post->post_excerpt).'</div>';
}
	
	
echo '</div>';
echo '</div>';
	
echo '</header>';


the_content('more...',true);

}// if has content

// content footer widget
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar('content_inner')): 
	//dynamic_sidebar('content_inner');
endif;


get_paged_nav_title($post);

$num = array(
    'before' => '<div class="pagination paging_arrows">',
    'after' => '</div>',
    'link_before' => '<span>',
    'link_after' => '</span>',
    'next_or_number' => 'number',
    'separator' => '',
    'pagelink' => '%',
    'echo' => 1
);
wp_link_pages($num);

comments_template();

// post_type widget
if(!function_exists('dynamic_sidebar') || !dynamic_sidebar($post_type_name . '_after_content')): 
	dynamic_sidebar( $post_type_name . '_after_content');
endif;

if( get_the_content() ) echo '</div>';
?>