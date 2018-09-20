<?php
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

if ( ! defined( 'ABSPATH' ) ) {
	//exit; // Exit if accessed directly.
}

function comment_block($comment){

  ?>
<div class="cd-timeline-block">
			<?php
      if( !empty($comment->comment_author_email) ){
        echo '<div class="cd-timeline-img cd-picture user_avatar">'.get_avatar( $comment->comment_author_email, 200 ).'</div>';
      }else{
        echo '<div class="cd-timeline-img cd-picture">
                <img src="'. get_stylesheet_directory_uri() . '/statics/vertical-timeline/img/cd-icon-picture.svg" alt="Picture">
              </div>';
      }
      ?>

			<div class="cd-timeline-content">
				<?php
            $user_info = get_userdata($comment->user_id);
            if( $user_info ) echo '<h2>'.$user_info->user_nicename.'</h2>';
        ?>
        <?php echo $comment->comment_content; ?>
				<span class="cd-date">
          <span class="cd-year"><?php echo date('Y', strtotime($comment->comment_date)); ?></span><br>
          <span class="cd-month-date"><?php echo date('m-d', strtotime($comment->comment_date)); ?></span><br>
          <span class="cd-timestamp"><?php echo date('H:i:s', strtotime($comment->comment_date)); ?></span>
        </span>
        
  </div>
</div>
<?php
}

add_filter('template_redirect','check_thread_function');
function check_thread_function(){
  global $post;
  if ( !empty($post->post_type)&& $post->post_type === 'es_contact') {
    $_post_fields = get_post_meta($post->ID,'post_fields');
    if( !empty($_post_fields[0]['thread'])){
      add_filter('the_content','print_contact_timeline');
    }else{
      wp_redirect( home_url() ); exit;
    }
  }
}

function print_contact_timeline($contact){
  global $post;
  if ($post->post_type === 'es_contact') {
    
    echo '<link rel="stylesheet" href="'.MAILFORM_ESSENCE_PLUGIN_URI.'/statics/vertical-timeline/css/style.css" type="text/css" media="all" />';
    echo '<script type="text/javascript" src="'.MAILFORM_ESSENCE_PLUGIN_URI . '/statics/vertical-timeline/js/main.js"></script>';
    echo '<script type="text/javascript" src="'.MAILFORM_ESSENCE_PLUGIN_URI . '/statics/vertical-timeline/js/modernizr.js"></script>';

    echo '<div class="cd-timeline-wrapper">';
    
    echo '
    <div class="essence-mailform-contact-qrcode">
      <img src="//api.qrserver.com/v1/create-qr-code/?data='. get_the_permalink($post->ID) .'&size=120x120" alt="QRコード" />
      <p>スマホで確認</p>
    </div>';
    
    echo '<section id="cd-timeline" class="cd-container">';
    
    
    $page = get_page($post->ID);
    $ticket = $page->post_name;
    
    $post_fields = get_post_meta( $post->ID , 'post_fields');
    $ticket_date = get_the_date('Y-m-d H:i:s',$post->ID, true);
    
    
    ?>
    
    <div class="cd-timeline-block">
			<?php
      if( !empty($comment->comment_author_email) ){
        echo '<div class="cd-timeline-img cd-picture user_avatar">'.get_avatar( $comment->comment_author_email, 200 ).'</div>';
      }else{
        echo '<div class="cd-timeline-img cd-picture">
                <img src="'. MAILFORM_ESSENCE_PLUGIN_URI . '/statics/vertical-timeline/img/cd-icon-picture.svg" alt="Picture">
              </div>';
      }
      ?>

			<div class="cd-timeline-content">
				<h2><?php echo get_the_title($post->ID); ?></h2>
        
        <table class="table table-striped table-bordered">
          <tbody>
            <?php
            if( is_array($post_fields[0]) ){
              foreach( $post_fields[0] as $label => $value ){
                echo '
                <tr>
                <th>'.$label.'</th><td>'.$value.'</td>
                </tr>
                ';
              }
            }
            ?>
          </tbody>
        </table>
        <p>お問合せ番号：<?php echo $ticket; ?></p>
				<span class="cd-date">
          <span class="cd-year"><?php echo date('Y', strtotime($ticket_date)); ?></span><br>
          <span class="cd-month-date"><?php echo date('m-d', strtotime($ticket_date)); ?></span><br>
          <span class="cd-timestamp"><?php echo date('H:i:s', strtotime($ticket_date)); ?></span>
        </span>
        
			</div>
		</div>
    
    
    
    <?php

    
    $comments      = array_reverse( get_comments($post->ID));
    $comment_arr   = array();
    $child_comment = array();
 
    foreach ( $comments as $comment_tmp ){
 
      if( $comment_tmp->comment_parent == 0 ){
        $comment_id = $comment_tmp->comment_ID;
        $comment_arr[$comment_id][] = $comment_tmp;
      }
      if( $comment_tmp->comment_parent != 0 ){
        $parent_id = $comment_tmp->comment_parent;
        $comment_arr[$parent_id]['child'][] = $comment_tmp;
      }
    }
    
    

    foreach ( $comment_arr as $key=>$comment_item ){
      
      $comment = $comment_item[0];
      if(is_user_logged_in()){
        //echo '<pre>'; print_r($comment); echo '</pre>';
      }
      
      comment_block($comment);
    ?>
    
		

    <?php
      
      if( !empty( $comment_item['child'] ) && is_array($comment_item['child']) ){
        foreach( $comment_item['child'] as $key => $comment ){
          echo '<div class="child_comment_block">';
          comment_block($comment);
          echo '</div>';
        }
      }
      
    };//endforeach
    echo '</section>';
    
    
    
    $time = current_time('mysql');

    $data = array(
        'comment_post_ID' => $post->ID,
        'comment_author' => 'healingsolutions',
        'comment_author_email' => 'info@healing-solutions.jp',
        'comment_author_url' => 'http://',
        'comment_content' => 'content here',
        'comment_type' => '',
        'comment_parent' => 0,
        'user_id' => 1,
        'comment_date' => $time,
        'comment_approved' => 1,
    );
    if(is_user_logged_in()){
      //echo '<pre>'; print_r($data); echo '</pre>';
    }

    //echo $comment_id = wp_insert_comment($data);

    
    $args = array(
      'comment_field'        => '<p class="comment-form-comment"><label for="comment"></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
      'must_log_in'          => '<p class="must-log-in"><a href="' . wp_login_url( apply_filters( 'the_permalink', get_permalink( $post->ID ) ) ) . '">ログイン</a></p>',
      'comment_notes_after'  => '<p class="form-allowed-tags">' . sprintf( __( 'You may use these <abbr title="HyperText Markup Language">HTML</abbr> tags and attributes: %s' ), ' <code>' . allowed_tags() . '</code>' ) . '</p>',
      'id_form'              => 'commentform',
      'id_submit'            => 'submit',
      'title_reply'          => 'メッセージ送信',
      'title_reply_to'       => '返信する',
      'cancel_reply_link'    => __( 'Cancel reply' ),
      'label_submit'         => '送信',
      'format'               => 'xhtml',
    );
    comment_form($args);
    
    
    echo '</div>';
  }
  
  return $contact;
}

?>