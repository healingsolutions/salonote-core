<?php

add_action( 'show_user_profile', 'essence_user_profile_fields' );
add_action( 'edit_user_profile', 'essence_user_profile_fields' );

function essence_user_profile_fields( $user ) {
?>
    <h3><?php _e('Extract Profile','salonote-essence'); ?></h3>

    <table class="form-table">
    <tr>
        <th><label for="display_shortcode"><?php _e('Use Developer Mode','salonote-essence'); ?></label></th>
        <td>
            <input type="checkbox" name="display_shortcode" id="display_shortcode" value="1"
						<?php
						 if( get_the_author_meta( 'display_shortcode', $user->ID ) == 1 ){
							 echo ' checked';
						 };
						?> />
            <span class="description"><?php _e('When display Customizer, Show action hook guide','salonote-essence'); ?></span>
        </td>
    </tr>
    
    </table>
<?php }

add_action( 'personal_options_update', 'save_essence_user_profile_fields' );
add_action( 'edit_user_profile_update', 'save_essence_user_profile_fields' );

function save_essence_user_profile_fields( $user_id ) {
    if ( !current_user_can( 'edit_user', $user_id )) { 
        return false; 
    }
    if ( !empty($_POST['display_shortcode']) ){
      update_user_meta( $user_id, 'display_shortcode', $_POST['display_shortcode'] );
    }
    
}
?>