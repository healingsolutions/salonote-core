<?php
// create custom plugin settings menu
add_action('admin_menu', 'essence_theme_option');

function essence_theme_option() {

	//create new top-level menu
  add_theme_page(
		'Essence Theme Options',     // page_title
		__('Theme Setting','salonote-essence'),// menu_title
		'edit_theme_options',				 // capability
		'essence_theme_option',			 // menu_slug
		'essence_theme_option_page_main', // function
    '',                          //icon_url
    2                            //position
	);

	//call register settings function
	add_action( 'admin_init', 'register_essence_theme_option_settings' );
}


function register_essence_theme_option_settings() {
	//register our settings
	register_setting( 'essence-theme-option-base', 'essence_base' );
	register_setting( 'essence-theme-option-post_type', 'essence_post_type' );
  register_setting( 'essence-theme-option-extention', 'essence_extention' );
}


// ==============================
function essence_theme_option_page_main() {
  get_template_part('lib/customizer/option-page/main');
}


// ==============================
function essence_theme_opiton_form($field_key = null,$fields_arr = null, $_options_value = null,$_style = 'table'){
  
  if( $_style == 'table' ){
    $style_1 = 'tr';
    $style_2 = 'th';
    $style_3 = 'td';
  }elseif( $_style == 'dldtdd' ){
    $style_1 = 'dl';
    $style_2 = 'dt';
    $style_3 = 'dd';
  }
  
  foreach( $fields_arr as $key => $field ){
	
	$_class = '';
  $value = !empty($_options_value[$key]) ? $_options_value[$key] : '' ;
  $value_key = $field_key.'['.$key.']';
    echo '<' .$style_1. ' class="key-'.$key.' '.preg_replace('/\[|\]/','_',$field_key).'label" valign="top">';

    if($field['type'] === 'text' || $field['type'] === 'number' ){
      if( $field['type'] === 'text' ){
        if( $_style == 'table' ) $_class = 'regular-text';
      }elseif( $field['type'] === 'number' ){
        $_class = 'small-text';
      }
    ?>
    
      <<?php echo $style_2;?> scope="row"><?php echo $field['label']; ?></<?php echo $style_2;?>>
      <<?php echo $style_3;?>>
      <?php
      echo '<input type="'.$field['type'].'" class="'.$_class.'" name="'.$value_key.'" value="'.esc_attr( $value ).'"';
      if( !empty($field['max']) ) echo ' max="'.$field['max'].'"' ;
      echo '/>';
      ?>
      <?php echo !empty($field['description']) ? '<p class="hint">'.esc_attr( $field['description'] ).'</p>' : ''; ?>
      </<?php echo $style_3;?>>
    
  <?php
    }elseif( $field['type'] === 'textarea' ){
  ?>
      <<?php echo $style_2;?> scope="row"><?php echo $field['label']; ?></<?php echo $style_2;?>>
      <<?php echo $style_3;?>><textarea class="large-text" name="<?php echo $value_key; ?>"><?php echo esc_attr( $value ); ?></textarea>
      <?php echo !empty($field['description']) ? '<p class="hint">'.esc_attr( $field['description'] ).'</p>' : ''; ?>
      </<?php echo $style_3;?>>
  <?php
    }elseif( $field['type'] === 'checkbox' ){
      
  ?>
      <<?php echo $style_2;?> scope="row"><?php echo $field['label']; ?></<?php echo $style_2;?>>


      <<?php echo $style_3;?>><label class="<?php echo preg_replace('/\[|\]/','_',$field_key);?>_essence_checkbox">
      <?php
      if(is_array($_options_value)){?>
        <input type="checkbox" name="<?php echo $field_key; ?>[]" value="<?php echo $key; ?>"<?php if( in_array($key,$_options_value)) echo ' checked'; ?> />
      <?php }else{ ?>
        <input type="checkbox" name="<?php echo $field_key; ?>[]" value="<?php echo $key; ?>"<?php if( $key == $_options_value) echo ' checked'; ?> />
      <?php
                 }
      ?>
      
      <?php echo !empty($field['description']) ? '<span class="hint">'.esc_attr( $field['description'] ).'</span>' : ''; ?></label>
      </<?php echo $style_3;?>>
  <?php
    }elseif( $field['type'] === 'select' ){
  ?>
      <<?php echo $style_2;?> scope="row"><?php echo $field['label']; ?></<?php echo $style_2;?>>
      <<?php echo $style_3;?>>
        <select name="<?php echo $value_key; ?>">
          <option value="">---</option>
          <?php
            foreach($field['selecter'] as $item_key => $item_label){
              echo '<option value="'.$item_key.'"';
              if( $value == $item_key ){
                echo ' selected';
              }
              echo '>'.$item_label.'</option>';
            }
          ?>
        </select>
      <?php echo !empty($field['description']) ? '<span class="hint">'.esc_attr( $field['description'] ).'</span>' : ''; ?>
      </<?php echo $style_3;?>>
  <?php
    }
  echo '</'.$style_1.'>';
  }//foreach
  
}



?>