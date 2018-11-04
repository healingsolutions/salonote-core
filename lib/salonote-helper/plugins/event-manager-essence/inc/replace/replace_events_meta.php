<?php
/*
Version: 1.0.0
Author:Healing Solutions
Author URI: https://www.healing-solutions.jp/
License: GPL2
*/

/*  Copyright 2016 Healing Solutions (email : info@healing-solutions.jp)
 
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
     published by the Free Software Foundation.
 
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
 
    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
require( '../../../../../wp-blog-header.php');
global $wpdb,$post_data,$opt,$item;
get_header();
?>

<div class="container" style="clear: both;">
<h1>イベント情報変更</h1>

<?php

		$args = Array(
				'post_type' => 'events',
				'post_status' => 'any',
				'posts_per_page' => -1,
		);
		$the_query = new WP_Query($args);
		if($the_query -> have_posts()):
				while($the_query -> have_posts()): $the_query -> the_post();
					$post = get_post();
					//echo '<pre>'; print_r($post); echo '</pre>';
					$post_id = get_the_ID();
					echo '<p><a href="'.get_the_permalink().'">'.get_the_title().'</a></p>';
	
	
					$event_info = [];
	
					$event_info['event_start'] = !empty( get_field( 'start_time',$post->ID) ) ? date('H:i', strtotime(get_field( 'start_time',$post->ID))) : null ;
					if( $event_info['event_start'] == '00:00' ){
						$event_info['event_start'] = null;
					}
					$event_info['event_end'] = !empty( get_field( 'end_time',$post->ID) ) ? date('H:i', strtotime(get_field( 'end_time',$post->ID))) : null ;
					if( $event_info['event_end'] == '00:00' ){
						$event_info['event_end'] = null;
					}
	
					$event_info['event_place']	=	nl2br(strip_tags(get_field( 'entry_place',$post->ID)));
					$event_info['event_map']		=	esc_html(get_field( 'entry_map',$post->ID,true));
					$event_info['event_price']	=	nl2br(get_field( 'entry_price',$post->ID,true));
					$event_info['event_owner']	=	nl2br(strip_tags(get_field( 'entry_contact',$post->ID)));
					$event_info['event_url']		=	get_field( 'entry_url',$post->ID,true);


					if(is_user_logged_in()){
						echo '<pre>'; print_r($event_info); echo '</pre>';
					}

					// データベースにある投稿を更新する
					//wp_update_post( $my_post );
					//update_post_meta($post_id, 'essence_event_information', $event_info);

				endwhile;
		endif;
		wp_reset_postdata();
	
?>

</div>
<?php	
get_footer();
?>