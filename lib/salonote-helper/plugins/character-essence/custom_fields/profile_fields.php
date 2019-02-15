<?php
/**
 * Adds additional user fields
 * more info: http://justintadlock.com/archives/2009/09/10/adding-and-using-custom-user-profile-fields
 */
 
function additional_user_fields( $user ) {?>

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
    if( current_user_can('edit_users') ){
      $profile_pic = empty($_POST['user_meta_image']) ? '' : $_POST['user_meta_image'];
      update_user_meta($user_id, 'user_meta_image', $profile_pic);
    }
}
 
add_action( 'profile_update', 'save_additional_user_meta' );
add_action( 'user_register', 'save_additional_user_meta' );



?>
