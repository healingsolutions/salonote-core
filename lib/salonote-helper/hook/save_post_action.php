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


// saving landing-page
function salonote_landing_updated_create_child_post( $post_ID ) {
	global $post;

	// リビジョンなら作成しない。
	if ( wp_is_post_revision( $post_ID ) )
		return;
	
	
	$parent_template = get_page_template_slug($post_ID);
	if( $parent_template !== 'template/landing-list.php' )
		return;

	
	$post_type = get_post_type($post_ID);
	$post_types = get_post_types(
		array(
			'public'   => true,
			'_builtin' => true,
			'capability_type'	=> 'page'
		),
		'names','and'
	);
	
	if ( !in_array($post_type,$post_types) )
		return;
	
	
	//一番上の親要素か確認
	$parent_id = wp_get_post_parent_id( $post_ID );
	if( $parent_id > 0 )
		return;
	
	if( !empty(get_the_content( $post_ID )) )
		return;
	
	$base_saved = isset( $base_saved ) ? $base_saved : false ;
	
	//子要素がある場合は、テンプレートを作成しない
	$child_args = array(
		'post_parent' => $post_ID,
		'post_type'   => 'any', 
		'numberposts' => -1,
		'post_status' => 'any' 
	);
	$children = get_children( $child_args );
	
	if( count($children) > 0 )
		return;
	
	$bkg_color = [];
	
	$mods = get_theme_mods();
	
	$bkg_color[0] = get_theme_mod('navbar_bkg','#C13347');
	$txt_color[0] = get_theme_mod('navbar_color','white');
	
	$bkg_color[0] = get_theme_mod('btn_bkg','#333333');
	$txt_color[0] = get_theme_mod('btn_color','white');
	
	
	$args = array(
		'post_type' => 'attachment',
		'posts_per_page' => 1,
		'post_status' => 'any',
		'post_parent' => null
	); 
	$attachments = get_posts( $args );
	$base_image = !empty($attachments) ? wp_get_attachment_url( $attachments[0]->ID ) : null ;
	$base_image_id = !empty($attachments) ? $attachments[0]->ID : 0 ;
	
	$args_gallery = array(
		'post_type' => 'attachment',
		'posts_per_page' => 6,
		'post_status' => 'any',
		'post_parent' => null
	); 
	$gallery = [];
	$gallery_arr = get_posts( $args_gallery );
	foreach( $gallery_arr as $item => $image ){
		$gallery[] = $image->ID;
	}
	
	
	
	
	//
	if( $base_saved !== true ){
		
			//コンテンツがある場合は処理しない
		if( empty(get_the_content( $post_ID )) ){
			
		$limit_date = date("Y-m-d", strtotime("14 day"));
			
	$base_post = array(
		'ID'           => $post_ID,
		'post_content' => '[countdown limit="'.$limit_date.'" before_text="あと" after_text="です" sec=true mili=true]
		<img class="img-responsive img-cover-block bkg-parallax aligncenter wp-image-'.$base_image_id.' size-large" src="https://dummyimage.com/1200x680/666666/fff.gif" alt="" />
<div class="text-cover-block">
<div class="block-center">
<div class="bdr-block">
<h1 style="font-size: 200%;font-family: \'book antiqua\', palatino, serif;">
ランディングページの価値は
ページ表示から3秒で決まる</h1>
ランディングページは、<span class="line_marker">みてもらうこと</span>に価値があります。
見てもらわなければ、どんなに素晴らしい内容でも、価値がありません。
サロンノートでは、<span class="line_marker">ヘッダー・フッターの非表示</span>だけでなく、各要素で背景色を区切るような表現も、
サクッと作れちゃいます。
<div class="btn-item">

ボタンを入れて誘導することもできます

</div>
</div>
</div>
</div>
&nbsp;
<h1 style="text-align: center;"><span style="font-size: 130%;">読むか読まないかは</span>
<span style="font-size: 130%;"><span class="line_marker">自分に関係があるか</span>で判断します</span></h1>
<p style="text-align: center;">ターゲットを絞り込むことを恐れずに</p>
<p style="text-align: center;">狭い範囲の見込み顧客に確実に伝える方に意識を集中しましょう</p>
&nbsp;
<h1 style="text-align: center;"><span style="font-size: 130%;">見込み顧客を絞り込むことで得られるもの</span></h1>
&nbsp;
<div class="block-unit">

<img class="img-responsive wow fadeIn aligncenter wp-image-'.$base_image_id.' size-medium_large" src="https://dummyimage.com/720x480/666666/fff.gif" alt="" width="768" height="480" />
<div class="square_label_block">

特典１
共感を生む

</div>
<div class="block-center">
あなたの伝える内容が具体的であるほど

共感の大きさは大きくなります。
</div>
</div>
<div class="block-unit">

<img class="img-responsive wow fadeIn aligncenter wp-image-'.$base_image_id.' size-medium_large" src="https://dummyimage.com/720x480/666666/fff.gif" alt="" width="768" height="512" />
<div class="square_label_block type-white">

特典２
継続を生む

</div>
<div class="block-center">
あなたの伝える熱意が高いほど

「もう少し聞きたい」という継続性を生みます。
</div>
</div>

<hr />',
  );
			remove_action('edit_post', 'salonote_landing_updated_create_child_post');
			wp_update_post( $base_post );
			$base_saved = true;
			add_action('save_post', 'salonote_landing_updated_create_child_post');
			
		}

	}
	
	
	
	
	

	$landing_contents = array(
		array(
			'title'		=> 'ニーズの喚起',
			'content'	=> '<h2 style="text-align: center;"><strong><span style="font-size: 200%;">こんな悩みも、こんな悩みも、こんな悩みも</span></strong>
<strong><span style="font-size: 200%;">すべて解消して、こんなに素晴らしい未来を
たったこれだけで実現</span></strong></h2>
&nbsp;
<p style="text-align: center;">お金の悩み、老後の悩み、恋愛の悩み、育児の悩み
具体的な課題を取り上げて、それらを具体的に打ち消します。</p>',
			'page_template'	=> 'template/landing-list.php',
			'landing_page_info' => array(
					'bkg_color'	=>	$bkg_color[0],
					'txt_color'	=>	$txt_color[0],
			),
		),
		array(
			'title'		=> '結果',
			'content'	=> '<h2 style="text-align: center;"><span style="font-size: 200%;">だから何？　を早めに伝える工夫</span></h2>
<div class="block-center">
<p class="side_bdr_headline" style="text-align: center;"><span style="font-size: 140%;">このキャンペーンであなたが得られるすべてのもの</span></p>

</div>
[gallery link="none" size="thumbnail_L" ids="'.implode(',',$gallery).'"]'
		),
		array(
			'title'		=> '証拠',
			'content'	=> '<h2 style="text-align: center;"><span style="font-size: 200%;">あなたの商品やサービスの魅力の
<strong><span style="font-size: 110%; font-family: \'arial black\', sans-serif;">根拠</span></strong>を示しましょう</span></h2>
<div class="block-unit"><img class="alignnone size-full wp-image-'.$base_image_id.' img-responsive wow fadeIn" src="https://dummyimage.com/600x400/666/fff" alt="" width="600" height="400" /></div>
<div class="block-unit vertical-middle">
<h1>科学的な根拠</h1>
&nbsp;

信用のある第三者の言葉を借りるのも、１つの根拠の提示方法です。
<h3><strong><span style="font-size: 200%; font-family: \'book antiqua\', palatino, serif;">◯◯で、◯◯部門、連続３年ナンバーワン</span></strong></h3>
なども、根拠を示す要因になりますね。

</div>

<hr class="short-horizon" />

<div class="block-unit vertical-middle">
<h1>認知された実証結果</h1>
誰もが知っている一般的な例えを利用しても伝わりやすいですね。

しかし、それだけだと、「ほかもやっている」で終わってしまいます。

逆説的に
<h2><span style="font-size: 150%; font-family: \'book antiqua\', palatino, serif;">一般的にはこうだと言われているものが</span>
<span style="font-size: 150%; font-family: \'book antiqua\', palatino, serif;">この専門機関では、違っていた</span></h2>
という、納得を導く逆説を使うのもありです。

</div>
<div class="block-unit"><img class="alignnone size-full wp-image-'.$base_image_id.' img-responsive wow fadeIn" src="https://dummyimage.com/600x400/666/fff" alt="" width="600" height="400" /></div>

<hr class="short-horizon" />
',
			'page_template'	=> 'template/landing-list.php',
			'landing_page_info' => array(
					'bkg_color'	=>	$bkg_color[0],
					'txt_color'	=>	$txt_color[0],
			),
		),
		array(
			'title'		=> '共鳴',
			'content'	=> '<div class="block-unit"><img class="alignnone size-full wp-image-'.$base_image_id.' img-responsive wow fadeIn img-diamond" src="https://dummyimage.com/300x300/666666/fff" alt="" width="300" height="300" /></div>
<div class="block-unit vertical-middle">
<h1>山田太郎さん</h1>
<em>素晴らしい肩書き</em>

共鳴は、「口コミ」のようなものです。

口コミといっても、よく知らないだれかの意見を聞きたいわけではありません。

できれば、ある程度著名な方や、実績を残しておられる方を取り上げられたらいいですね。

それができない場合は、その方の実績を具体的にわかりやすく、表現してあげるのがコツです。

<span style="font-size: 150%;">月商10万円のダメダメサロンが</span>
<strong><span style="font-size: 200%;">たった<span style="font-family: \'book antiqua\', palatino, serif; font-size: 130%;">３ヶ月</span>で月商<span style="font-size: 120%; font-family: \'book antiqua\', palatino, serif;">120万</span>円に！</span></strong>

</div>

<hr class="short-horizon" />

<div class="block-unit"><img class="alignnone size-full wp-image-'.$base_image_id.' img-responsive wow fadeIn img-diamond" src="https://dummyimage.com/300x300/666666/fff" alt="" width="300" height="300" /></div>
<div class="block-unit vertical-middle">
<h1>山田太郎さん</h1>
<em>素晴らしい肩書き</em>

共鳴は、「口コミ」のようなものです。

口コミといっても、よく知らないだれかの意見を聞きたいわけではありません。

できれば、ある程度著名な方や、実績を残しておられる方を取り上げられたらいいですね。

それができない場合は、その方の実績を具体的にわかりやすく、表現してあげるのがコツです。

<span style="font-size: 150%;">月商10万円のダメダメサロンが</span>
<strong><span style="font-size: 200%;">たった<span style="font-family: \'book antiqua\', palatino, serif; font-size: 130%;">３ヶ月</span>で月商<span style="font-size: 120%; font-family: \'book antiqua\', palatino, serif;">120万</span>円に！</span></strong>

</div>

<hr class="short-horizon" />

<div class="block-unit"><img class="alignnone size-full wp-image-'.$base_image_id.' img-responsive wow fadeIn img-diamond" src="https://dummyimage.com/300x300/666666/fff" alt="" width="300" height="300" /></div>
<div class="block-unit vertical-middle">
<h1>山田太郎さん</h1>
<em>素晴らしい肩書き</em>

共鳴は、「口コミ」のようなものです。

口コミといっても、よく知らないだれかの意見を聞きたいわけではありません。

できれば、ある程度著名な方や、実績を残しておられる方を取り上げられたらいいですね。

それができない場合は、その方の実績を具体的にわかりやすく、表現してあげるのがコツです。

<span style="font-size: 150%;">月商10万円のダメダメサロンが</span>
<strong><span style="font-size: 200%;">たった<span style="font-family: \'book antiqua\', palatino, serif; font-size: 130%;">３ヶ月</span>で月商<span style="font-size: 120%; font-family: \'book antiqua\', palatino, serif;">120万</span>円に！</span></strong>

</div>

<hr class="short-horizon" />

<div class="block-unit"><img class="alignnone size-full wp-image-'.$base_image_id.' img-responsive wow fadeIn img-diamond" src="https://dummyimage.com/300x300/666666/fff" alt="" width="300" height="300" /></div>
<div class="block-unit vertical-middle">
<h1>山田太郎さん</h1>
<em>素晴らしい肩書き</em>

共鳴は、「口コミ」のようなものです。

口コミといっても、よく知らないだれかの意見を聞きたいわけではありません。

できれば、ある程度著名な方や、実績を残しておられる方を取り上げられたらいいですね。

それができない場合は、その方の実績を具体的にわかりやすく、表現してあげるのがコツです。

<span style="font-size: 150%;">月商10万円のダメダメサロンが</span>
<strong><span style="font-size: 200%;">たった<span style="font-family: \'book antiqua\', palatino, serif; font-size: 130%;">３ヶ月</span>で月商<span style="font-size: 120%; font-family: \'book antiqua\', palatino, serif;">120万</span>円に！</span></strong>

</div>

<hr class="short-horizon" />

&nbsp;'
		),
		array(
			'title'		=> '信頼',
			'content'	=> '<img class="img-responsive img-cover-block bkg-parallax aligncenter wp-image-'.$base_image_id.' size-large" src="https://dummyimage.com/1200x380/666666/878787.gif" alt="" />
<div class="text-cover-block">
<div class="bkg-white-text">
<p style="text-align: center;"><strong><span style="font-size: 200%; font-family: \'book antiqua\', palatino, serif;">ここで行うのは、<span style="font-size: 120%;">権威</span>づけ</span></strong></p>
あの人が言っているなら
あの人の言うことなら
そう言う心理を確実におさえておきましょう。

</div>
</div>
&nbsp;
<div class="super_container">
<div class="block-unit vertical-middle">
<h2><span style="font-size: 140%;">わたしが出会った中で</span>
<span style="font-size: 140%;">過去最高のメソッドです</span></h2>
人間には、再保証心理があります。

いいものだとわかっていても、だれかからそれを後押ししてほしい。

つまり、自分の判断を保証して欲しいのです。

それに最適なのが、「あの人が言ったから」と言う逃げ道を作ってあげる手法です。

この権威づけパートは、それに効果的です。

</div>
<div class="block-unit"><img class="alignnone size-full wp-image-'.$base_image_id.' img-responsive wow fadeIn img-circled" src="https://dummyimage.com/300x300/666/fff" alt="" width="300" height="300" /></div>
</div>

<hr class="short-horizon" />

&nbsp;'
		),
		array(
			'title'		=> 'ストーリー',
			'content'	=> '<h1>商品やサービスを買うのではなく
それを買うことで<span class="line_marker" style="font-size: 110%;">得られる感情</span>を買う</h1>
&nbsp;

お客様は、商品そのものを購入しているわけではありません。

それを買うことによって得られる喜びや満足度という感情を、買っています。

&nbsp;

喉から手が出るほど欲しいものだとしても

それを買うことで、別の何かが圧迫されて

「買わなければよかった」と思うのであれば

バランスをとって買わないという選択肢を取ります。

&nbsp;

喜んでいただくためには、大前提として素晴らしい商品やサービスであるということが大切です。

そして、お客様に伝わるように、商品の魅力を多面的に伝えることも、ここまでのセクションで取り組んできました。

&nbsp;

あとは、お客様の感情に寄り添うこと。

&nbsp;

この商品は、どんな熱意を持って作ってきたのか。

この商品を通じて、どんな夢を叶えたいのか。

この商品を使ってくれたお客様の、どんな笑顔を見たいのか。

&nbsp;

そう言った開発ストーリーなどを、熱意を持って伝えることで

お客様の最終的な決断を後押しすることにつながります。',
			'page_template'	=> 'template/keyv-landing.php',
			'landing_page_bkg_image'	=> $base_image_id,
		),
		array(
			'title'		=> 'クロージング',
			'content'	=> '<p style="text-align: center;"><span style="font-family: \'arial black\', sans-serif;"><strong><span style="font-size: 250%;">クロージングには目立つボタンを配置しましょう</span></strong></span></p>

<div class="block-center">

このページが、お客様に何をして欲しいのか、<span style="font-size: 120%;"><strong>具体的な行動を促すボタン</strong></span>を配置しましょう。

また、長いランディングページの中では、ボタンが埋れてしまうことがあります。

できるだけ、ボタンには動きのあるものを使います。
<div class="btn-item">

<span style="font-size: 160%;">いますぐ無料で資料請求する</span>

</div>
</div>',
			'landing_page_info' => array(
				'txt_color'	=> 'white',
				'bkg_color'	=>	'#ad2323',
		),
		),
		array(
			'title'		=> '追伸',
			'content'	=> '<div class="super_container">
<p class="headline_bdr-left"><strong><span style="font-size: 250%;">P.S  </span><span style="font-size: 160%;">実は、追伸は読まれています</span></strong></p>
<img class="size-full wp-image-1081 img-responsive wow fadeIn aligncenter img-circled" src="https://dummyimage.com/300x300/666666/fff" alt="" width="300" height="300" />

ここまで読んでくださり、ありがとうございます。

きっと、あなたの脳は、ちょっとお疲れモードですよね。

最後に、少しだけ、追伸を書かせてください。

&nbsp;

実は、追伸って、よく読まれるコンテンツの１つなんです。

特に、ランディングページのように、パワフルなメッセージが多い文章だと、息継ぎがなかなかできないですよね。

&nbsp;

そんな中、「これは、追伸です」と言われると

脳が少しだけ、休憩モードになります。

&nbsp;

だからこそ、追伸の文章は、頭にすっと入っていきやすいんです。

「商売とか、販売とか、関係ないメッセージですよ」

と、追伸で宣言することによって、お客様の脳に生まれた隙間に、すっとメッセージを入れ込むことができる。

&nbsp;

ぜひ、効果的に活用してみてください。

</div>'
		),
		'landing_page_info' => array(
				'bkg_color'	=>	'#f0f0f0',
		),
		'super_container'	=> true
	);


	$page_info_values = array(
		'full_size'=>1,
		'none_sidebar'=>1,
	);
	update_post_meta($post_ID,'page_info', sanitize_text_field($page_info_values) );

	$base_landing_page_arr = array(
		'none_header'	=> 1,
		'none_footer'	=> 1
	);
	update_post_meta($post_ID, 'landing_page_info', $base_landing_page_arr );

	
	
	foreach( $landing_contents as $key => $value ){
		$landing_arr = array(
			'post_parent'		=> $post_ID,
			'post_title'		=> get_the_title($post_ID) .' - '. $value['title'],
			'post_content'	=> $value['content'],
			'post_status'		=> 'publish',
			'post_type'			=> get_post_type($post_ID),
			'page_template'	=> (!empty( $value['page_template'] ) ? $value['page_template'] : 'default' )
		);
		$insert_id = wp_insert_post($landing_arr);
		
		if($insert_id && !empty($value['landing_page_info']) ) {
			$landing_page_arr = $value['landing_page_info'];
			update_post_meta($insert_id, 'landing_page_info', $landing_page_arr );
		}
		
		if($insert_id && !empty($value['landing_page_bkg_image']) ) {
			$landing_page_arr = $value['landing_page_bkg_image'];
			update_post_meta($insert_id, 'page_bkg_upload_images', $landing_page_arr );
		}
		
		if($insert_id && $value['super_container']) {
			$page_info_values = array(
				'super_container'	=>1,
			);
			update_post_meta($insert_id,'page_info', $page_info_values);
		}

	}
	
	
	
	
	
	return;
	
}
add_action( 'edit_post', 'salonote_landing_updated_create_child_post' );



?>