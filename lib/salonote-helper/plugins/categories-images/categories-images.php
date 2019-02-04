<?php
/**
 * Plugin Name: Categories Images
 * Plugin URI: http://zahlan.net/blog/2012/06/categories-images/
 * Description: Categories Images Plugin allow you to add an image to category or any custom term.
 * Author: Muhammad Said El Zahlan
 * Version: 2.5.4
 * Author URI: http://zahlan.net/
 * Domain Path: /languages
 * Text Domain: categories-images
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$_plug_url = preg_replace( '/https?\:/', '', get_template_directory_uri().'/lib/salonote-helper/plugins');
define('salonte_PLUGIN_URL'  , $_plug_url.'/categories-images'  );
define('salonte_IMAGE_PLACEHOLDER', salonte_PLUGIN_URL."/images/placeholder.png");

// l10n
load_plugin_textdomain('categories-images', FALSE, 'categories-images/languages');

add_action('admin_init', 'salonte_init');
function salonte_init() {
    $salonte_taxonomies = get_taxonomies();
    if (is_array($salonte_taxonomies)) {
        $zci_options = get_option('zci_options');
        
        if (!is_array($zci_options))
            $zci_options = array();
        
        if (empty($zci_options['excluded_taxonomies']))
            $zci_options['excluded_taxonomies'] = array();
        
        foreach ($salonte_taxonomies as $salonte_taxonomy) {
            if (in_array($salonte_taxonomy, $zci_options['excluded_taxonomies']))
                continue;
            add_action($salonte_taxonomy.'_add_form_fields', 'salonte_add_texonomy_field');
            add_action($salonte_taxonomy.'_edit_form_fields', 'salonte_edit_texonomy_field');
            add_filter( 'manage_edit-' . $salonte_taxonomy . '_columns', 'salonte_taxonomy_columns' );
            add_filter( 'manage_' . $salonte_taxonomy . '_custom_column', 'salonte_taxonomy_column', 10, 3 );
        }
    }
}

function salonte_add_style() {
    echo '<style type="text/css" media="screen">
        th.column-thumb {width:60px;}
        .form-field img.taxonomy-image {border:1px solid #eee;max-width:300px;max-height:300px;}
        .inline-edit-row fieldset .thumb label span.title {width:48px;height:48px;border:1px solid #eee;display:inline-block;}
        .column-thumb span {width:48px;height:48px;border:1px solid #eee;display:inline-block;}
        .inline-edit-row fieldset .thumb img,.column-thumb img {width:48px;height:48px;}
    </style>';
}

// add image field in add form
function salonte_add_texonomy_field() {
    if (get_bloginfo('version') >= 3.5)
        wp_enqueue_media();
    else {
        wp_enqueue_style('thickbox');
        wp_enqueue_script('thickbox');
    }
    
    echo '<div class="form-field">
        <label for="taxonomy_image">' . __('Image', 'categories-images') . '</label>
        <input type="text" name="taxonomy_image" id="taxonomy_image" value="" />
        <br/>
        <button class="salonte_upload_image_button button">' . __('Upload/Add image', 'categories-images') . '</button>
    </div>'.salonte_script();
}

// add image field in edit form
function salonte_edit_texonomy_field($taxonomy) {
    if (get_bloginfo('version') >= 3.5)
        wp_enqueue_media();
    else {
        wp_enqueue_style('thickbox');
        wp_enqueue_script('thickbox');
    }
    
    if (salonte_taxonomy_image_url( $taxonomy->term_id, NULL, TRUE ) == salonte_IMAGE_PLACEHOLDER) 
        $image_url = "";
    else
        $image_url = salonte_taxonomy_image_url( $taxonomy->term_id, NULL, TRUE );
    echo '<tr class="form-field">
        <th scope="row" valign="top"><label for="taxonomy_image">' . __('Image', 'categories-images') . '</label></th>
        <td><img class="taxonomy-image" src="' . salonte_taxonomy_image_url( $taxonomy->term_id, 'medium', TRUE ) . '"/><br/><input type="text" name="taxonomy_image" id="taxonomy_image" value="'.$image_url.'" /><br />
        <button class="salonte_upload_image_button button">' . __('Upload/Add image', 'categories-images') . '</button>
        <button class="salonte_remove_image_button button">' . __('Remove image', 'categories-images') . '</button>
        </td>
    </tr>'.salonte_script();
}

// upload using wordpress upload
function salonte_script() {
    return '<script type="text/javascript">
        jQuery(document).ready(function($) {
            var wordpress_ver = "'.get_bloginfo("version").'", upload_button;
            $(".salonte_upload_image_button").click(function(event) {
                upload_button = $(this);
                var frame;
                if (wordpress_ver >= "3.5") {
                    event.preventDefault();
                    if (frame) {
                        frame.open();
                        return;
                    }
                    frame = wp.media();
                    frame.on( "select", function() {
                        // Grab the selected attachment.
                        var attachment = frame.state().get("selection").first();
                        frame.close();
                        if (upload_button.parent().prev().children().hasClass("tax_list")) {
                            upload_button.parent().prev().children().val(attachment.attributes.url);
                            upload_button.parent().prev().prev().children().attr("src", attachment.attributes.url);
                        }
                        else
                            $("#taxonomy_image").val(attachment.attributes.url);
                    });
                    frame.open();
                }
                else {
                    tb_show("", "media-upload.php?type=image&amp;TB_iframe=true");
                    return false;
                }
            });
            
            $(".salonte_remove_image_button").click(function() {
                $(".taxonomy-image").attr("src", "'.salonte_IMAGE_PLACEHOLDER.'");
                $("#taxonomy_image").val("");
                $(this).parent().siblings(".title").children("img").attr("src","' . salonte_IMAGE_PLACEHOLDER . '");
                $(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
                return false;
            });
            
            if (wordpress_ver < "3.5") {
                window.send_to_editor = function(html) {
                    imgurl = $("img",html).attr("src");
                    if (upload_button.parent().prev().children().hasClass("tax_list")) {
                        upload_button.parent().prev().children().val(imgurl);
                        upload_button.parent().prev().prev().children().attr("src", imgurl);
                    }
                    else
                        $("#taxonomy_image").val(imgurl);
                    tb_remove();
                }
            }
            
            $(".editinline").click(function() { 
                var tax_id = $(this).parents("tr").attr("id").substr(4);
                var thumb = $("#tag-"+tax_id+" .thumb img").attr("src");

                if (thumb != "' . salonte_IMAGE_PLACEHOLDER . '") {
                    $(".inline-edit-col :input[name=\'taxonomy_image\']").val(thumb);
                } else {
                    $(".inline-edit-col :input[name=\'taxonomy_image\']").val("");
                }
                
                $(".inline-edit-col .title img").attr("src",thumb);
            });
        });
    </script>';
}

// save our taxonomy image while edit or save term
add_action('edit_term','salonte_save_taxonomy_image');
add_action('create_term','salonte_save_taxonomy_image');
function salonte_save_taxonomy_image($term_id) {
    if(isset($_POST['taxonomy_image']))
        update_option('salonte_taxonomy_image'.$term_id, $_POST['taxonomy_image'], NULL);
}

// get attachment ID by image url
function salonte_get_attachment_id_by_url($image_src) {
    global $wpdb;
    $query = $wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid = %s", $image_src);
    $id = $wpdb->get_var($query);
    return (!empty($id)) ? $id : NULL;
}

// get taxonomy image url for the given term_id (Place holder image by default)
function salonte_taxonomy_image_url($term_id = NULL, $size = 'full', $return_placeholder = FALSE) {
    if (!$term_id) {
        if (is_category())
            $term_id = get_query_var('cat');
        elseif (is_tag())
            $term_id = get_query_var('tag_id');
        elseif (is_tax()) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $term_id = $current_term->term_id;
        }
    }
    
    $taxonomy_image_url = get_option('salonte_taxonomy_image'.$term_id);
    if(!empty($taxonomy_image_url)) {
        $attachment_id = salonte_get_attachment_id_by_url($taxonomy_image_url);
        if(!empty($attachment_id)) {
            $taxonomy_image_url = wp_get_attachment_image_src($attachment_id, $size);
            $taxonomy_image_url = $taxonomy_image_url[0];
        }
    }

    if ($return_placeholder)
        return ($taxonomy_image_url != '') ? $taxonomy_image_url : salonte_IMAGE_PLACEHOLDER;
    else
        return $taxonomy_image_url;
}

function salonte_quick_edit_custom_box($column_name, $screen, $name) {
    if ($column_name == 'thumb') 
        echo '<fieldset>
        <div class="thumb inline-edit-col">
            <label>
                <span class="title"><img src="" alt="Thumbnail"/></span>
                <span class="input-text-wrap"><input type="text" name="taxonomy_image" value="" class="tax_list" /></span>
                <span class="input-text-wrap">
                    <button class="salonte_upload_image_button button">' . __('Upload/Add image', 'categories-images') . '</button>
                    <button class="salonte_remove_image_button button">' . __('Remove image', 'categories-images') . '</button>
                </span>
            </label>
        </div>
    </fieldset>';
}

/**
 * Thumbnail column added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @return void
 */
function salonte_taxonomy_columns( $columns ) {
    $new_columns = array();
    $new_columns['cb'] = $columns['cb'];
    $new_columns['thumb'] = __('Image', 'categories-images');

    unset( $columns['cb'] );

    return array_merge( $new_columns, $columns );
}

/**
 * Thumbnail column value added to category admin.
 *
 * @access public
 * @param mixed $columns
 * @param mixed $column
 * @param mixed $id
 * @return void
 */
function salonte_taxonomy_column( $columns, $column, $id ) {
    if ( $column == 'thumb' )
        $columns = '<span><img src="' . salonte_taxonomy_image_url($id, 'thumbnail', TRUE) . '" alt="' . __('Thumbnail', 'categories-images') . '" class="wp-post-image" /></span>';
    
    return $columns;
}

// Change 'insert into post' to 'use this image'
function salonte_change_insert_button_text($safe_text, $text) {
    return str_replace("Insert into Post", "Use this image", $text);
}

// Style the image in category list
if ( strpos( $_SERVER['SCRIPT_NAME'], 'edit-tags.php' ) > 0 ) {
    add_action( 'admin_head', 'salonte_add_style' );
    add_action('quick_edit_custom_box', 'salonte_quick_edit_custom_box', 10, 3);
    add_filter("attribute_escape", "salonte_change_insert_button_text", 10, 2);
}

// New menu submenu for plugin options in Settings menu
add_action('admin_menu', 'salonte_options_menu');
function salonte_options_menu() {
    add_options_page(__('Categories Images settings', 'categories-images'), __('Categories Images', 'categories-images'), 'manage_options', 'zci-options', 'zci_options');
    add_action('admin_init', 'salonte_register_settings');
}

// Register plugin settings
function salonte_register_settings() {
    register_setting('zci_options', 'zci_options', 'salonte_options_validate');
    add_settings_section('zci_settings', __('Categories Images settings', 'categories-images'), 'salonte_section_text', 'zci-options');
    add_settings_field('salonte_excluded_taxonomies', __('Excluded Taxonomies', 'categories-images'), 'salonte_excluded_taxonomies', 'zci-options', 'zci_settings');
}

// Settings section description
function salonte_section_text() {
    echo '<p>'.__('Please select the taxonomies you want to exclude it from Categories Images plugin', 'categories-images').'</p>';
}

// Excluded taxonomies checkboxs
function salonte_excluded_taxonomies() {
    $options = get_option('zci_options');
    $disabled_taxonomies = array('nav_menu', 'link_category', 'post_format');
    foreach (get_taxonomies() as $tax) : if (in_array($tax, $disabled_taxonomies)) continue; ?>
        <input type="checkbox" name="zci_options[excluded_taxonomies][<?php echo $tax ?>]" value="<?php echo $tax ?>" <?php checked(isset($options['excluded_taxonomies'][$tax])); ?> /> <?php echo $tax ;?><br />
    <?php endforeach;
}

// Validating options
function salonte_options_validate($input) {
    return $input;
}

// Plugin option page
function zci_options() {
    if (!current_user_can('manage_options'))
        wp_die(__( 'You do not have sufficient permissions to access this page.', 'categories-images'));
        $options = get_option('zci_options');
    ?>
    <div class="wrap">
        <?php screen_icon(); ?>
        <h2><?php _e('Categories Images', 'categories-images'); ?></h2>
        <form method="post" action="options.php">
            <?php settings_fields('zci_options'); ?>
            <?php do_settings_sections('zci-options'); ?>
            <?php submit_button(); ?>
        </form>
    </div>
<?php
}

// display taxonomy image for the given term_id
function salonte_taxonomy_image($term_id = NULL, $size = 'full', $attr = NULL, $echo = TRUE) {
    if (!$term_id) {
        if (is_category())
            $term_id = get_query_var('cat');
        elseif (is_tag())
            $term_id = get_query_var('tag_id');
        elseif (is_tax()) {
            $current_term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $term_id = $current_term->term_id;
        }
    }
    
    $taxonomy_image_url = get_option('salonte_taxonomy_image'.$term_id);
    if(!empty($taxonomy_image_url)) {
        $attachment_id = salonte_get_attachment_id_by_url($taxonomy_image_url);
        if(!empty($attachment_id))
            $taxonomy_image = wp_get_attachment_image($attachment_id, $size, FALSE, $attr);
        else {
            $image_attr = '';
            if(is_array($attr)) {
                if(!empty($attr['class']))
                    $image_attr .= ' class="'.$attr['class'].'" ';
                if(!empty($attr['alt']))
                    $image_attr .= ' alt="'.$attr['alt'].'" ';
                if(!empty($attr['width']))
                    $image_attr .= ' width="'.$attr['width'].'" ';
                if(!empty($attr['height']))
                    $image_attr .= ' height="'.$attr['height'].'" ';
                if(!empty($attr['title']))
                    $image_attr .= ' title="'.$attr['title'].'" ';
            }
            $taxonomy_image = '<img src="'.$taxonomy_image_url.'" '.$image_attr.'/>';
        }
    }
    else{
        $taxonomy_image = '';
    }

    if ($echo)
        echo $taxonomy_image;
    else
        return $taxonomy_image;
}