<?php
/**
 * Adds additional user fields
 * more info: http://justintadlock.com/archives/2009/09/10/adding-and-using-custom-user-profile-fields
 */
 
function additional_user_fields( $user ) { ?>
 
 
    <table class="form-table">
 
        <tr>
            <th><label for="user_meta_image">拡張プロフィール画像</label></th>
            <td>
                <!-- Outputs the image after save -->
                <img id="user_image_block" src="<?php echo esc_url( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" style="width:150px;"><br />
                <!-- Outputs the text field and displays the URL of the image retrieved by the media uploader -->
                <input type="hidden" name="user_meta_image" id="user_meta_image" value="<?php echo esc_url_raw( get_the_author_meta( 'user_meta_image', $user->ID ) ); ?>" class="regular-text" />
                <!-- Outputs the save button -->
                <input type='button' class="additional-user-image button-primary" value="プロフィールを設定" id="uploadimage"/><br />
            </td>
        </tr>
 
    </table><!-- end form-table -->
<?php } // additional_user_fields
 
add_action( 'show_user_profile', 'additional_user_fields' );
add_action( 'edit_user_profile', 'additional_user_fields' );

/**
* Saves additional user fields to the database
*/
function save_additional_user_meta( $user_id ) {
 
    // only saves if the current user can edit user profiles
    if ( !current_user_can( 'edit_user', $user_id ) )
        return false;
 
    update_usermeta( $user_id, 'user_meta_image', $_POST['user_meta_image'] );
}
 
add_action( 'personal_options_update', 'save_additional_user_meta' );
add_action( 'edit_user_profile_update', 'save_additional_user_meta' );






function character_essence_admin_inline_js(){

	?>
	<script>
	/*
	 * Adapted from: http://mikejolley.com/2012/12/using-the-new-wordpress-3-5-media-uploader-in-plugins/
	 */
	jQuery(document).ready(function($){
	// Uploading files
	var file_frame;

		$('.additional-user-image').on('click', function( event ){

			event.preventDefault();

			// If the media frame already exists, reopen it.
			if ( file_frame ) {
				file_frame.open();
				return;
			}

			// Create the media frame.
			file_frame = wp.media.frames.file_frame = wp.media({
				title: $( this ).data( 'uploader_title' ),
				button: {
					text: $( this ).data( 'uploader_button_text' ),
				},
				multiple: false  // Set to true to allow multiple files to be selected
			});

			// When an image is selected, run a callback.
			file_frame.on( 'select', function() {
				// We set multiple to false so only get one image from the uploader
				attachment = file_frame.state().get('selection').first().toJSON();
				
				//console.log(attachment);
				$('#user_meta_image').val(attachment.url);
				$('#user_image_block').attr('src',attachment.url);
				
				// Do something with attachment.id and/or attachment.url here
			});

			// Finally, open the modal
		file_frame.open();
			
		});

		$('.user-profile-picture td').html('拡張プロフィールに置き換えました');
	});
	</script>
	<?php
}
add_action( 'admin_print_footer_scripts', 'character_essence_admin_inline_js' );



// Apply filter
add_filter( 'get_avatar' , 'character_essence_custom_avatar' , 1 , 5 );

function get_attachment_id_from_src($image_src)
{
    global $wpdb;
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
    $id = $wpdb->get_var($query);
    return $id;
}

function character_essence_custom_avatar( $avatar, $id_or_email, $size, $default, $alt ) {
    $user = false;

    if ( is_numeric( $id_or_email ) ) {

        $id = (int) $id_or_email;
        $user = get_user_by( 'id' , $id );

    } elseif ( is_object( $id_or_email ) ) {

        if ( ! empty( $id_or_email->user_id ) ) {
            $id = (int) $id_or_email->user_id;
            $user = get_user_by( 'id' , $id );
        }

    } else {
        $user = get_user_by( 'email', $id_or_email );	
    }

    if ( $user && is_object( $user ) ) {

        if ( $user->data->ID == '1' ) {
            $alt = 'YOUR_NEW_IMAGE_URL';
						$default_avatar = get_the_author_meta( 'user_meta_image', $user->data->ID );
					
						if( !empty($default_avatar) ){
							$avatar_id = get_attachment_id_from_src($default_avatar);
							$avatar = wp_get_attachment_image_src($avatar_id,$size);	
							$avatar = "<img alt='{$alt}' src='{$avatar[0]}' class='avatar avatar-{$size} photo' height='{$size}' width='{$size}' />";
							
						}
        }

    }

    return $avatar;
}
?>
