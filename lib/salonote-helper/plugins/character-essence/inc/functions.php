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

add_action( 'admin_enqueue_scripts', 'character_essence_admin_style' ); //管理画面用のCSS
function character_essence_admin_style(){
	wp_enqueue_media();
  wp_enqueue_script('character_essence', CHARACTER_ESSENCE_PLUGIN_URI.'/statics/js/main.js', array(),null, true);
}


class Character_Essence_Theme_Customize
   {

    //管理画面のカスタマイズにテーマカラーの設定セクションを追加
    public static function character_essence_customize_register($wp_customize) {

			$wp_customize->add_setting( 'char_left', array( 'default' => '#57af69','sanitize_callback' => 'sanitize_hex_color' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'char_left' , array(
					'label' => '左の吹き出しの色',
					'section' => 'colors',
					'settings' => 'char_left',
			) ) );
			
			$wp_customize->add_setting( 'char_right', array( 'default' => '#56a7ad','sanitize_callback' => 'sanitize_hex_color' ) );
			$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'char_right' , array(
					'label' => '右の吹き出しの色',
					'section' => 'colors',
					'settings' => 'char_right',
			) ) );

			//リアルタイム反映
			$wp_customize->get_setting('char_left')->transport = 'postMessage';
			$wp_customize->get_setting('char_right')->transport = 'postMessage';
			
    }

}//Character_Essence_Theme_Customize

// テーマ設定やコントロールをセットアップします。
add_action( 'customize_register' , array( 'Character_Essence_Theme_Customize' , 'character_essence_customize_register' ),20 );



?>