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

function create_salonote_site( $values ){

	$opt_values = get_option('insert_essence',true);
	

	
	$essence_base = [];

	if( !empty($opt_values) && is_array($opt_values) ){
		$values = array_merge($opt_values, $values);
	}
	$values['installer_end'] = 'done';

	update_option('insert_essence', $values);
	
	// user
	$user = wp_get_current_user();
	$user_id = $user->ID; 
	
	if( !empty($values['name_sei']) ){
		update_user_meta( $user_id, 'last_name', $values['name_sei'] );
	}
	if( !empty($values['name_mei']) ){
		update_user_meta( $user_id, 'first_name', $values['name_mei'] );
	}
	
	if( !empty($values['user_profile']) ){
		update_user_meta( $user_id, 'description', $values['user_profile'] );
	}

	//colors
	if( !empty($values['nav_bkg_color']) ){
		set_theme_mod( 'navbar_bkg', $values['nav_bkg_color'] );
		set_theme_mod( 'caption_bkg', $values['nav_bkg_color'] );
		set_theme_mod( 'bdr_color', $values['nav_bkg_color'] );
		set_theme_mod( 'list_icon_color', $values['nav_bkg_color'] );
		set_theme_mod( 'horizon_bdr_bkg', $values['nav_bkg_color'] );
		set_theme_mod( 'footer_bkg', $values['nav_bkg_color'] );
		set_theme_mod( 'btn_bkg', $values['nav_bkg_color'] );
	}
	
	
	if( !empty($values['nav_txt_color']) ){
		set_theme_mod( 'navbar_color', $values['nav_txt_color'] );
		set_theme_mod( 'footer_logo', $values['nav_txt_color'] );
		set_theme_mod( 'footer_color', $values['nav_txt_color'] );
		set_theme_mod( 'btn_color', $values['nav_txt_color'] );
	}
	
	
	if( !empty($values['body_bkg_color']) ){
		set_theme_mod( 'background_color', $values['body_bkg_color'] );
	}
	
	if( !empty($values['body_txt_color']) ){
		set_theme_mod( 'text_color', $values['body_txt_color'] );
	}
	
	if( !empty($values['body_link_color']) ){
		set_theme_mod( 'link_color', $values['body_link_color'] );
	}
	
	set_theme_mod( 'slide_text', '#FFFFFF' );
	set_theme_mod( 'slide_shadow', '#333333' );
	set_theme_mod( 'band_bkg', '#F2F2F2' );
	set_theme_mod( 'list_bdr_color', '#efefef' );
	
	// content ============
	if( !empty($values['site_target']) ){
		$essence_base['description'] = $values['site_target'].'のためのサイト';
		$essence_base[] = 'header_h1_txt';
	}
	if( !empty($values['site_keywords']) ){
		$essence_base['keywords'] = $values['site_keywords'];
	}
	
	//staff ===============
	if( !empty($values['site_staffs']) ){
		$essence_base[] = 'enable_staff';
	}
	
	
	//phone
	if( !empty($values['phone_number']) ){
		$essence_base['tel_number'] = $values['phone_number'];
	}
	//zip_code
	if( !empty($values['zip_code']) ){
		$essence_base['zip_code'] = $values['zip_code'];
	}
	//contact_address
	if( !empty($values['contact_address']) ){
		$essence_base['contact_address'] = $values['contact_address'];
	}
	
	//biz_time
	if( !empty($values['biz_time']) ){
		$essence_base['biz_time'] = $values['biz_time'];
	}
	
	//biz_holiday
	if( !empty($values['biz_holiday']) ){
		$essence_base['biz_holiday'] = $values['biz_holiday'];
	}
	
	//biz_parking
	if( !empty($values['biz_parking']) ){
		$essence_base['biz_parking'] = $values['biz_parking'];
	}
	
	
	
	//fonts ===============
	if( !empty($values['headline_font']) ){
		$essence_base['logo_font'] = $values['headline_font'];
		$essence_base['headline_font'] = $values['headline_font'];
	}
	if( !empty($values['body_font']) ){
		$essence_base['body_font'] = $values['body_font'];
	}
	if( !empty($values['nav_font']) ){
		$essence_base['nav_font'] = $values['nav_font'];
	}
	
	$essence_base[] = 'container';
	$essence_base[] = 'BreadCrumb';
	$essence_base[] = 'fitSidebar';
	$essence_base[] = 'sp_none_float_img';
	$essence_base[] = 'BreadCrumb';

	update_option('essence_base',$essence_base);
	
	
	//post_type
	$essence_post_type = array(
		'front_page' => array(
			'list_type' => 'timeline',
			'posts_per_page' => 7,
			'grid_cols' => 4,
			
			'full_pages',
		),
		
		'post' => array(

			'list_type' => 'timeline',
			'posts_per_page' => 7,
			'grid_cols' => 4,
			'posts_order' => 'DESC',

			'display_archive_title',
			'display_grid_title',
			'display_grid_sub_title',
			'display_list_term',
			'display_thumbnail',
			'display_grid_thumb_caption',
			'display_post_gallery',

			'display_entry_title',
			'display_post_date',
			'display_entry_sub_title',

			'display_entry_excerpt',
			'display_next_post',
			'display_other_post',
			
			'thumbnail_size' => 'thumbnail_M'
			
		),
		
		'page' => array(

			'grid_cols' => 4,

			'display_thumbnail',

			'display_entry_title',
			'display_child_unit',
			'full_pages',
			
			'thumbnail_size' => 'thumbnail_M'
			
		),
		
		'events' => array(

			'list_type' => 'calendar',
			'posts_per_page' => 7,
			'grid_cols' => 4,
			'posts_order' => 'DESC',
			
			'event_date',

			'display_archive_title',
			'display_grid_title',
			'display_grid_sub_title',
			'display_list_term',
			'display_thumbnail',
			'display_grid_thumb_caption',
			'display_post_gallery',
			'full_archive',

			'display_entry_title',
			'display_post_date',
			'display_entry_sub_title',

			'display_entry_excerpt',
			'display_next_post',
			'display_other_post',
			
			'thumbnail_size' => 'thumbnail_M'
			
		),
		
		
		'staff' => array(

			'list_type' => 'grid',
			'posts_per_page' => -1,
			'grid_cols' => 4,
			'posts_order' => 'menu_order',
			
			'list_position_excerpt' => 'side',
			
			'list_show_excerpt',
			'related_list_show_excerpt',

			'display_archive_title',
			'display_grid_title',
			'display_grid_sub_title',
			'display_list_term',
			'display_thumbnail',
			'display_grid_thumb_caption',
			'display_post_gallery',
			'full_archive',

			'display_entry_title',
			'display_entry_sub_title',
			'post_thumbnail',

			'display_entry_excerpt',
			'display_other_post',
			
			
			'thumbnail_size' => 'profile'
			
		),
	
	
	);
	
	update_option('essence_post_type',$essence_post_type);
	
	//extention
	$essence_extention = [];
	$essence_extention[] = 'use_content_fade';
	$essence_extention[] = 'use_colorbox';
	
	update_option('essence_extention',$essence_extention);
	
	
	
	
	// add posts 

	//pages ===============
	if( !empty($values['site_pages']) ){
		$site_pages = !empty($opt_values['site_pages']) ? esc_attr($opt_values['site_pages']) : '';
		$site_pages_arr = br2array($site_pages);
		
		
		$menu_name = 'グローバルナビ';
		$menu_exists = wp_get_nav_menu_object( $menu_name );
		if( !$menu_exists){
			$menu_id = wp_create_nav_menu($menu_name);
			
			$locations = get_theme_mod('nav_menu_locations');
			$locations['Header'] = $menu_id;
			$locations['FooterSiteMap'] = $menu_id;
			set_theme_mod( 'nav_menu_locations', $locations );
		}
		
		

		foreach($site_pages_arr as $page_key => $page_item){
			$page_args = array(
				'post_title'	=> $page_item,
				'post_type'		=> 'page',
				'post_status'	=> 'publish'
			);
			$page_id = wp_insert_post($page_args);

			
			$thumbnail_array = get_posts( 'post_type=attachment&orderby=rand&post_mime_type=image' );
			if( !empty($thumbnail_array) ){
				set_post_thumbnail( $page_id, $thumbnail_array[0]->ID );
			}
			
			
			if( !$menu_exists && $page_id){
				wp_update_nav_menu_item($menu_id, 0, array(
						'menu-item-title' =>  $page_item,
						'menu-item-url' => get_post_permalink($page_id), 
						'menu-item-status' => 'publish'
					)
				);
			}
			
		};

		
	}
	

	
	//front-page
	$thumbnail_array = get_posts( 'post_type=attachment&orderby=rand&post_mime_type=image&posts_per_page=7' );
	$_use_files = [];
	foreach( $thumbnail_array as $thumb_key => $thumb_item ){
		$_use_files[$thumb_key]['url'] 	= get_post_meta( $thumb_item->ID, '_wp_attached_file', true );
		$_use_files[$thumb_key]['id'] 	= $thumb_item->ID;
	}
	
	
	
	$note_body_txt = isset($opt_values['front_body_txt']) ? $opt_values['front_body_txt'] : 'プロフィール
ルノワールは、1841年、フランス中南部の磁器の町リモージュで生まれた。7人兄弟の6番目であったが、上の2人は早世し、他に兄2人、姉1人、弟1人がいた。父レオナールは仕立屋、母マルグリットはお針子であった。後の印象派の画家たちがブルジョワ階級出身だったのに対し、ルノワールは1人労働者階級出身であった。
1844年、一家でパリに移住した。ルーヴル美術館の近くで、当時は貧しい人が暮らす下町であった。
幼い頃から絵への興味を示していたが、美声でもあったルノワールは、1850年頃（9歳前後）、作曲家のシャルル・グノーが率いるサン・トゥスタッシュ教会（英語版）の聖歌隊に入り、グノーから声楽を学んだ。ルノワールの歌手としての才能を高く評価したグノーは、ルノワールの両親にルノワールをオペラ座の合唱団に入れることを提案したが、父親の知人からルノワールを磁器工場の徒弟として雇いたいという申出があったことから、グノーの提案を断り、聖歌隊も辞めた。
1854年、磁器工場に入り、磁器の絵付職人の見習いとなるが、産業革命や機械化の影響は伝統的な磁器絵付けの世界にも影響し、1858年に職人としての仕事を失うこととなった。ルノワールは、後に次のように回想している。

出会い
ルノワールは、画家になることを決意し、1861年11月、シャルル・グレールのアトリエ（画塾）に入った。ここでクロード・モネ、アルフレッド・シスレー、フレデリック・バジールら、後の印象派の画家たちと知り合った。また、近くにアトリエを持っていたアンリ・ファンタン＝ラトゥールとも知り合った。グレール自身は、保守的なアカデミズムの画家であったが、生徒たちに、安い費用で、モデルを使って自由に描くことを許していたので、様々な傾向の画学生が集まっていた。
ルノワールは、後に、グレールは「弟子にとって何の助けにもなってくれなかった」が、「弟子たちに思うようにさせる」という長所はあったと振り返っている。
グレールが、画塾で制作中のルノワールの色遣いを見て、「君、絵具を引っかき回すのが、楽しいんだろうね。」と言うと、ルノワールが「もちろんです。楽しくなければやりません。」と応えたというエピソードが知られている。グレールの保守的な指導に飽き足らない点で、モネやルノワールは共感を深めていった。もっとも、ルーヴル美術館を毛嫌いするモネと異なり、ルノワールは、友人アンリ・ファンタン＝ラトゥールとともにルーヴルに行き、18世紀フランスの画家たちを好んで研究した

アングル様式の確立
印象派は、筆触分割の手法を用いて色彩の輝きを捉えようとしたが、この手法においては、はっきりした輪郭線に規定された形態を表現することは難しかった。
実際、モネやシスレーは、草野や水面など、明確な形態を持たない自然の風景に主な関心を寄せ、建物を描く場合でも、ゆらめく影のように光の表現に溶け込んでおり、明確な形態は放棄されている。しかし、もともと人物、特に若い女性の健康な肉体の輝きに魅力を感じていたルノワールは、印象派のあまりに感覚主義的な態度には飽き足りなかった。ルノワールは、後に画商アンブロワーズ・ヴォラールに次のように語っている

リウマチと作品への影響
1897年、自転車から落ちて右腕を骨折し、これが原因で慢性関節リウマチを発症した。その後は、療養のため冬を南フランスで過ごすことが多くなった。
1899年、友人の画家ドゥコンシーの勧めで、カーニュ＝シュル＝メールのサヴルン・ホテルに滞在し、この町に惹かれるようになった。そして、パリ、エッソワ、カーニュの3箇所を行き来するようになった
1900年、パリ万国博覧会の「フランス絵画100周年記念展」にルノワールの作品11点が展示された。同年8月、レジオンドヌール勲章5等勲章を受章した。これも同じ年、ベルネーム＝ジューヌ画廊で大規模な個展を開催した。
ベルネーム＝ジューヌ兄弟は、1890年代初めから、積極的に印象派の作品を扱い、ルノワールとも親交を築いており、1901年と1910年にはルノワールがベルネーム＝ジューヌの家族の肖像画を描いている。
1901年、エッソワで、アリーヌとの間に、三男クロードが生まれた。
その頃、リューマチで階段を上がるのも難しくなったことから、モンマルトルのコーランクール通り（フランス語版）に移った


引用：wikipedia';

	$note_body = br2array($note_body_txt,2);
	
	$_insert_text = create_salonote_body($note_body , $_use_files, 'left_right');
	//echo '<pre>_insert_text'; print_r($_insert_text); echo '</pre>';
	
	$front_page_args = array(
		'post_title'	=> 'HOME',
		'post_type'		=> 'page',
		'post_status'	=> 'publish',
		'post_content'=> $_insert_text,
	);
	$front_page_id = wp_insert_post($front_page_args);
	
	update_option( 'page_on_front', $front_page_id);
  update_option( 'show_on_front', 'page' );
	
	
	//front-page
	$posts_page_args = array(
		'post_title'	=> 'ブログ',
		'post_type'		=> 'page',
		'post_status'	=> 'publish',
	);
	$posts_page_id = wp_insert_post($posts_page_args);
	update_option( 'page_for_posts', $posts_page_id);
	
	if( !$menu_exists && $page_id){
		wp_update_nav_menu_item($menu_id, 0, array(
				'menu-item-title' =>  'ブログ',
				'menu-item-url' => get_post_permalink($posts_page_id), 
				'menu-item-status' => 'publish'
			)
		);
	}
	
	
	$thumbnail_array = get_posts( 'post_type=attachment&orderby=rand&post_mime_type=image&posts_per_page=3' );
	$es_slider_upload_images = [];
	foreach( $thumbnail_array as $slide_key => $slide_item ){
		$es_slider_upload_images[$slide_key]['image'] = $slide_item->ID;
		$es_slider_upload_images[$slide_key]['text'] = !empty($values['site_target']) ? esc_attr($values['site_target']).'のためのサイト' : 'スライド見出し';
		$es_slider_upload_images[$slide_key]['textarea'] = !empty($values['site_target']) ? esc_attr($values['site_target']).'に喜んでもらいたくて、このサイトを始めました。' : 'スライド本文';
	}
	update_post_meta( $front_page_id, 'es_slider_upload_images', $es_slider_upload_images );
	update_post_meta( $front_page_id, 'es_slider_info', array('height'=>'65vh'));

	
	
	//staff ===============
	if( !empty($values['site_staffs']) ){
		
		$site_staffs = !empty($opt_values['site_staffs']) ? esc_attr($opt_values['site_staffs']) : '';
		$site_staffs_arr = br2array($site_staffs);
		
		foreach($site_staffs_arr as $staff_key => $staff_item){
			$staff_args = array(
				'post_title'	=> $staff_item,
				'post_type'		=> 'staff',
				'post_status'	=> 'publish'
			);
			$page_id = wp_insert_post($staff_args);
			
			$thumbnail_array = get_posts( 'post_type=attachment&orderby=rand&post_mime_type=image' );
			if( !empty($thumbnail_array) ){
				set_post_thumbnail( $page_id, $thumbnail_array[0]->ID );
			}
		};

	}
	
	//posts ===============
	if( !empty($values['sample_posts']) ){
		$sample_posts = !empty($opt_values['sample_posts']) ? esc_attr($opt_values['sample_posts']) : 0;
	}
	
	
	//widgets
	$widgets_opt = array(
 
		/* 消すウィジェット */	
		'widget_recent-posts'    => array( 1 => array( '_multiwidget' => 1 ) ),
		'widget_search'          => array( 1 => array( '_multiwidget' => 1 ) ),
		'widget_recent-comments' => array( 1 => array( '_multiwidget' => 1 ) ),
		'widget_archives'        => array( 1 => array( '_multiwidget' => 1 ) ),
		'widget_meta'            => array( 1 => array( '_multiwidget' => 1 ) ),

		/* 表示するウィジェット */

		'widget_essence_custom_list_widget'=> array(
			2 => array(
				'widget_title' => 'BLOG',
				'post_type_name' => 'post',
				'enable_title',
				'enable_thumbnail',
				'list_type' => 'grid',
				'list_count' => 8
			),
			3 => array(
				'widget_title' => 'STAFF',
				'post_type_name' => 'staff',
				'enable_title',
				'enable_thumbnail',
				'list_type' => 'grid',
				'list_count' => 8
			),
			'_multiwidget' => 1
		),
		

		/* ウィジェットの表示順 (TwentyTwelve 用) */
		'sidebars_widgets'       => array(
			
			'wp_inactive_widgets' => array(),
			'front_page_after_content' => array(
				0 => 'essence_custom_list_widget-2',
				1 => 'essence_custom_list_widget-3',
			),
		),
 
	);

	foreach ( $widgets_opt as $key => $value ) {
			update_option( $key, $value );
	}
	
	
	wp_safe_redirect( get_bloginfo('url') ); exit;

}


?>