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
	exit; // Exit if accessed directly.
}


function wp_insert_comment( $commentdata ) {
    global $wpdb;
    $data = wp_unslash( $commentdata );
 
    $comment_author       = ! isset( $data['comment_author'] )       ? '' : $data['comment_author'];
    $comment_author_email = ! isset( $data['comment_author_email'] ) ? '' : $data['comment_author_email'];
    $comment_author_url   = ! isset( $data['comment_author_url'] )   ? '' : $data['comment_author_url'];
    $comment_author_IP    = ! isset( $data['comment_author_IP'] )    ? '' : $data['comment_author_IP'];
 
    $comment_date     = ! isset( $data['comment_date'] )     ? current_time( 'mysql' )            : $data['comment_date'];
    $comment_date_gmt = ! isset( $data['comment_date_gmt'] ) ? get_gmt_from_date( $comment_date ) : $data['comment_date_gmt'];
 
    $comment_post_ID  = ! isset( $data['comment_post_ID'] )  ? 0  : $data['comment_post_ID'];
    $comment_content  = ! isset( $data['comment_content'] )  ? '' : $data['comment_content'];
    $comment_karma    = ! isset( $data['comment_karma'] )    ? 0  : $data['comment_karma'];
    $comment_approved = ! isset( $data['comment_approved'] ) ? 1  : $data['comment_approved'];
    $comment_agent    = ! isset( $data['comment_agent'] )    ? '' : $data['comment_agent'];
    $comment_type     = ! isset( $data['comment_type'] )     ? '' : $data['comment_type'];
    $comment_parent   = ! isset( $data['comment_parent'] )   ? 0  : $data['comment_parent'];
 
    $user_id  = ! isset( $data['user_id'] ) ? 0 : $data['user_id'];
 
    $compacted = compact( 'comment_post_ID', 'comment_author', 'comment_author_email', 'comment_author_url', 'comment_author_IP', 'comment_date', 'comment_date_gmt', 'comment_content', 'comment_karma', 'comment_approved', 'comment_agent', 'comment_type', 'comment_parent', 'user_id' );
    if ( ! $wpdb->insert( $wpdb->comments, $compacted ) ) {
        return false;
    }
 
    $id = (int) $wpdb->insert_id;
 
    if ( $comment_approved == 1 ) {
        wp_update_comment_count( $comment_post_ID );
 
        foreach ( array( 'server', 'gmt', 'blog' ) as $timezone ) {
            wp_cache_delete( "lastcommentmodified:$timezone", 'timeinfo' );
        }
    }
 
    clean_comment_cache( $id );
 
    $comment = get_comment( $id );
 
    // If metadata is provided, store it.
    if ( isset( $commentdata['comment_meta'] ) && is_array( $commentdata['comment_meta'] ) ) {
        foreach ( $commentdata['comment_meta'] as $meta_key => $meta_value ) {
            add_comment_meta( $comment->comment_ID, $meta_key, $meta_value, true );
        }
    }
 
    /**
     * Fires immediately after a comment is inserted into the database.
     *
     * @since 2.8.0
     *
     * @param int        $id      The comment ID.
     * @param WP_Comment $comment Comment object.
     */
    do_action( 'wp_insert_comment', $id, $comment );
 
    return $id;
}

?>