<?php

//delete_option('insert_essence');

$opt_values = get_option('insert_essence',true);
//echo '<pre>opt_values'; print_r($opt_values); echo '</pre>';

if( !empty( $_GET['step_num'] ) ) $step_num = $_GET['step_num'];



$step_num = !empty( $step_num ) ? esc_html($step_num) : $opt_values['step'];
$step_num = !empty( $step_num ) ? esc_html($step_num) : 1;

$step_content = [];

$char_dir = CHARACTER_ESSENCE_PLUGIN_URI.'/statics/images/';
$gender = !empty( $opt_values['gender'] ) ? esc_attr($opt_values['gender']) : 'female' ;


$num = 1;

$step_content[$num] = array(
	'title' => 'まずは性別を教えてください',
	'text' => '
		[char p=l r=t c=t src='.$char_dir.'mystery/mystery_01.jpg]<span style="font-size: 2.2em;">こ・・・こ・・・こ・・・
		このページは、なんですかぁ！！？</span>[/char]

		[char p=r c=t src='.$char_dir.'biz_male/normal.jpg]おっと！
		驚かせてしまってすみません
		サロンノートをインストールしていただいて、ありがとうございます！
		[/char]

		[char p=l r=t c=t src='.$char_dir.'mystery/mystery_01.jpg]あなたはダレ！
		わたしはどこ？[/char]

		[char p=r c=t src='.$char_dir.'biz_male/seriously.jpg]大丈夫ですよ！落ち着いてください。
		サロンノートは、そんな方のために作られたものなので。
		これから、会話形式で、何をどう進めればいいか、丁寧にご説明しますね[/char]

		[char p=l r=t c=t src='.$char_dir.'mystery/mystery_01.jpg]ま・・まずは、わたしの正体を戻してからにしてください（汗）[/char]

		[char p=r src='.$char_dir.'biz_male/question.jpg]そうですね。失礼しました。
		では、まず、お名前と性別を伺ってもいいですか？[/char]

		[char p=l r=t c=t src='.$char_dir.'mystery/mystery_01.jpg]えーっと・・・
		わたしの名前は・・
		
		<div class="installer_essence_form_block">
		<input type="text" name="insert_essence[your_name]" required >
		で、
		
		<input type="radio" name="insert_essence[gender]" value="female" required >女性
		
		<input type="radio" name="insert_essence[gender]" value="male" required >男性
		
		です。
		</div>
		
		<button type="submit" class="btn btn-item">伝える</button>

		[/char]
		'
);

++$num;
$step_content[$num] = array(
	'title' => 'ホームページの目的を聞かせてください',
	'text' => '
		[char p=l r=t src='.$char_dir.$gender.'/surprised.jpg]<span style="font-size: 1.6em;">わぁ・・・戻ったぁ・・・[/char]

		[char p=r c=t src='.$char_dir.'biz_male/normal.jpg]<b>'.esc_attr($opt_values['your_name']).'</b>さん　ですね。
		改めて・・・
		サロンノートをインストールしていただいて、ありがとうございます！[/char]

		[char p=l r=t src='.$char_dir.$gender.'/speechless.jpg]ホームページ嫌い・・ホームページ苦手・・
		何をどう進めればいいか、わからない・・[/char]

		[char p=r c=t src='.$char_dir.'biz_male/seriously.jpg]大丈夫ですよ！
		サロンノートは、そんな方のために作られたものなので。
		これから、会話形式で、何をどう進めればいいか、丁寧にご説明しますね[/char]

		[char p=l r=t src='.$char_dir.$gender.'/speechless.jpg]お手柔らかにお願いします・・・[/char]

		[char p=r src='.$char_dir.'biz_male/question-2.jpg]<b>'.esc_attr($opt_values['your_name']).'</b>さんは、どんなホームページを作りたいですか？[/char]

		[char p=l r=t c=t src='.$char_dir.$gender.'/normal.jpg]
		うーん・・・そうですね・・
		<div class="installer_essence_form_block">
		<input id="purpose_shop" type="radio" name="insert_essence[purpose]" value="shop" required '.(( !empty($opt_values['purpose']) && $opt_values['purpose'] === 'shop' ) ? ' checked' : '' ).'><label for="purpose_shop">お店の紹介</label>
		<input id="purpose_blog" type="radio" name="insert_essence[purpose]" value="blog" required '.(( !empty($opt_values['purpose']) && $opt_values['purpose'] === 'blog' ) ? ' checked' : '' ).'><label for="purpose_blog">ブログを書きたい</label>
		<input id="purpose_test" type="radio" name="insert_essence[purpose]" value="test" required '.(( !empty($opt_values['purpose']) && $opt_values['purpose'] === 'test' ) ? ' checked' : '' ).'><label for="purpose_test">まずは使ってみたい</label>
		</div>
		
		です！
		<button type="submit" class="btn btn-item">伝える</button>

		[/char]
		'
);

$purpose_arr = array(
	'shop' => 'お店の紹介に使いたい',
	'blog' => 'ブログを書きたい',
	'test' => 'まずは使ってみたい',
); 


++$num;
$step_content[$num] = array(
	'title' => '好きな色を聞かせてください',
	'text' => '
		[char p=l r=t src='.$char_dir.$gender.'/normal.jpg]ホームページの目的は、<b>'. (!empty($opt_values['purpose']) ? esc_attr($purpose_arr[$opt_values['purpose']]) : 'よくわからない' ). '</b>です。[/char]

		[char p=r src='.$char_dir.'biz_male/smile.jpg]<b class="h3">'. (!empty($opt_values['purpose']) ? esc_attr($purpose_arr[$opt_values['purpose']]) : 'よくわからない' ). '</b>と言う気持ち、大切ですね。
		その思いに応えられるように、ぼくたちも頑張りますね。[/char]

		[char p=l r=t src='.$char_dir.$gender.'/sorry.jpg]寄り添ってくれるのはわかるんですが・・
		ホームページって、いったい何からどう初めていいのか、わからないんです[/char]

		[char p=r src='.$char_dir.'biz_male/upset.jpg]そうですよね
		特にWordPress（ワードプレス）とか言われると、一気に専門用語になっちゃって、「むずかしいぃ！！」って、思っちゃいますよね・・[/char]

		[char p=l r=t src='.$char_dir.$gender.'/sorry.jpg]でもなんか、みんな使ってるし、「どんなものなのか」くらいは、ちょっとだけ興味があるんですよね[/char]

		[char p=r src='.$char_dir.'biz_male/normal.jpg]あぁ〜、わかります。
		でもきっと、いろいろむずかしいことからじゃなくって、例えばそうですね・・・
		
		「好きな色」とかから、決めていくのも、やりやすいですよ[/char]

		[char p=l src='.$char_dir.$gender.'/question.jpg]好きな色・・・・ですか？
		えー・・・急に言われてもなぁ・・・[/char]
		
		[char p=r src='.$char_dir.'biz_male/seriously.jpg]仮に決めてみるだけでも、大丈夫です。
		設定なんて、あとから変えられるので。
		まずは、「とりあえず」で、全く問題ないですよ[/char]
		
		[char p=l r=t src='.$char_dir.$gender.'/sorry.jpg]うーん・・・それなら・・・
		
		<div class="installer_essence_form_block">
    <input type="text" id="insert_essence-nav_bkg_color" class="form-control installer_colorpicker" name="insert_essence[nav_bkg_color]" data-position="bottom left" value="'. (!empty($opt_values['nav_bkg_color']) ? esc_attr($opt_values['nav_bkg_color']) : '#e36262' ). '">
		</div>
		かなぁ・・・
		
		
		<button type="submit" class="btn btn-item">伝える</button>

		[/char]
		'
);



++$num;
$step_content[$num] = array(
	'title' => 'ナビゲーションの色',
	'text' => '
		[char p=r src='.$char_dir.'biz_male/smile.jpg]好きな色は、<div style="height:30px; width:30px; display:block; background-color: '. (!empty($opt_values['nav_bkg_color']) ? esc_attr($opt_values['nav_bkg_color']) : '#e36262' ). '"></div> '. (!empty($opt_values['nav_bkg_color']) ? esc_attr($opt_values['nav_bkg_color']) : '#e36262' ). 'ですね。
		素敵な色ですね！[/char]

		[char p=l src='.$char_dir.$gender.'/question.jpg]ホームページって、自分の好きな色で作っていってもいいんですか？[/char]

		[char p=r src='.$char_dir.'biz_male/seriously.jpg]もちろんです！
		ただ、気をつけなくちゃいけないこととしては、色のコントラストですね。
		例えば、背景色が薄い上に、薄い色の文字を載せてしまったら、読みづらいですよね。
		
		<div style="background-color: gray; color: #CCCCCC; padding: 1em 3em; margin-bottom: 1em;">こんな風な色の組み合わせだと、読みづらいですね</div>
		
		なので、ある程度の色のコントラストをつけておく必要があります。[/char]

		[char p=l r=t src='.$char_dir.$gender.'/understand.jpg]なるほど。見てみると、確かにそうですね。[/char]

		[char p=r src='.$char_dir.'biz_male/normal.jpg]じゃぁ、例えば
		<div id="nav_txt_color" style="padding: 1em 3em; margin-bottom: 1em; display:block; background-color: '. (!empty($opt_values['nav_bkg_color']) ? esc_attr($opt_values['nav_bkg_color']) : '#e36262' ). '; color: '. (!empty($opt_values['nav_txt_color']) ? esc_attr($opt_values['nav_txt_color']) : '#FFFFFF' ). '">テキスト　テキスト　テキスト</div>
		このうえに文字を乗せるとしたら、何色の文字にするのがいいでしょうか。
		[/char]

		[char p=l src='.$char_dir.$gender.'/question-2.jpg]うーん・・・
		それなら、この色かなぁ・・。
		
		<div class="installer_essence_form_block">
    <input type="text" id="insert_essence-nav_txt_color" class="form-control installer_colorpicker" data-target="nav_txt_color" data-attr="color" name="insert_essence[nav_txt_color]" data-position="bottom left" value="'. (!empty($opt_values['nav_txt_color']) ? esc_attr($opt_values['nav_txt_color']) : '#FFFFFF' ). '">
		</div>
		
		<button type="submit" class="btn btn-item">伝える</button>
		
		[/char]
		'
);



++$num;
$step_content[$num] = array(
	'title' => 'ページ全体の色',
	'text' => '
		[char p=r src='.$char_dir.'biz_male/smile.jpg]
		
		これで、基本の色が大体決まりましたね！
		
		<div style="1em 3em; margin-bottom: 1em; padding:1em; display:block; background-color: '. (!empty($opt_values['nav_bkg_color']) ? esc_attr($opt_values['nav_bkg_color']) : '#e36262' ). '; color: '. (!empty($opt_values['nav_txt_color']) ? esc_attr($opt_values['nav_txt_color']) : '#FFFFFF' ). '">ここに、背景色と文字色が入ったテキストが入ります</div>
		
		こんな感じになりました！[/char]

		[char p=l src='.$char_dir.$gender.'/question.jpg]こんなに簡単に、色って設定できるものなんですねぇ[/char]

		[char p=r src='.$char_dir.'biz_male/seriously.jpg]ついでに、普通のテキストの色も決めちゃいましょうか。[/char]

		[char p=l r=t src='.$char_dir.$gender.'/understand.jpg]テキストの色？[/char]

		[char p=r src='.$char_dir.'biz_male/normal.jpg]今読んでいるこの文字とか、ブログ記事の文字とかをどんな色にするかも決められるんです。
		
		文字の色と、背景の色、それぞれどうしましょうか。
		ちなみに、一般的に作るには、背景は白のままにしておいて、文字の色は黒系か、濃いめの色にするのがオススメですよ。
		[/char]

		[char p=l r=t src='.$char_dir.$gender.'/question.jpg]うーん・・・
		それなら、この色かなぁ・・。
		
		<div class="installer_essence_form_block">
		
		<label for="insert_essence-body_bkg_color">全体の背景色　<span class="small hint">(最初の値は、#FFFFFF)</span></label>
		<input type="text" id="insert_essence-body_bkg_color" class="form-control installer_colorpicker" data-target="installer-essence-body" data-attr="background-color" name="insert_essence[body_bkg_color]" data-position="bottom left" value="'. (!empty($opt_values['body_bkg_color']) ? esc_attr($opt_values['body_bkg_color']) : '#FFFFFF' ). '">
		
		<label for="insert_essence-body_txt_color">文字の色　<span class="small hint">(最初の値は、#333333)</span></label>
    <input type="text" id="insert_essence-body_txt_color" class="form-control installer_colorpicker" data-target="installer-essence-body" data-attr="color" name="insert_essence[body_txt_color]" data-position="bottom left" value="'. (!empty($opt_values['body_txt_color']) ? esc_attr($opt_values['body_txt_color']) : '#333333' ). '">
		
		
		<label for="insert_essence-body_txt_color">リンクの色　<span class="small hint">(最初の値は、#1f8dd6)</span></label>
    <input type="text" id="insert_essence-body_link_color" class="form-control installer_colorpicker" data-target="installer-essence-body a" data-attr="color" name="insert_essence[body_link_color]" data-position="bottom left" value="'. (!empty($opt_values['body_link_color']) ? esc_attr($opt_values['body_link_color']) : '#1f8dd6' ). '">
		</div>
		
		<button type="submit" class="btn btn-item">伝える</button>
		
		[/char]
		'
);



++$num;
$step_content[$num] = array(
	'title' => '業種や活動',
	'text' => '
	'
);


++$num;
$step_content[$num] = array(
	'title' => '検索されたい言葉',
	'text' => '
		[char p=r src='.$char_dir.'biz_male/smile.jpg]
		ではそろそろ、さらに本格的な内容に入りましょうか。
		SEO（エスイーオー）という言葉は、聞いたことがありますか？[/char]

		[char p=l r=t src='.$char_dir.$gender.'/question.jpg]一応、聞いたことはありますが、
		どういうことなのか、具体的なことはあまり詳しくないです[/char]

		'
);



++$num;
$step_content[$num] = array(
	'title' => 'どんなページが必要？',
	'text' => '
	'
);

++$num;
$step_content[$num] = array(
	'title' => 'スタッフはいますか？',
	'text' => '
	'
);

++$num;
$step_content[$num] = array(
	'title' => 'オススメしたいメニューは？',
	'text' => '
	'
);


++$num;
$step_content[$num] = array(
	'title' => '見出し画像',
	'text' => '
	'
);

++$num;
$step_content[$num] = array(
	'title' => 'ブログ記事のサンプルは必要？',
	'text' => '
	'
);

++$num;
$step_content[$num] = array(
	'title' => '営業時間や駐車場',
	'text' => '
	'
);

++$num;
$step_content[$num] = array(
	'title' => '文字はどうする？',
	'text' => '
	'
);





++$num;
$step_content[$num] = array(
	'title' => '設定を反映します',
	'text' => '
	'
);


?>

<style>
<?php
if( !empty($opt_values['body_bkg_color']) && !empty($opt_values['body_txt_color']) ){
	echo 'body #installer-essence-body{
						background-color: '. (!empty($opt_values['body_bkg_color']) ? esc_attr($opt_values['body_bkg_color']) : '#333333' ). ';
						color: '. (!empty($opt_values['body_txt_color']) ? esc_attr($opt_values['body_txt_color']) : '#333333' ). ';
					} ';
}
?>

</style>

<div id="installer-essence-body" class="main-content-unit container has_sidebar">
	
	<div class="row">
	<div class="installer-essence-content col-12 col-md-9 entry_block_content">
		<div class="installer-essence-content-inner">
			
			<form action="" method="post">
			<?php
			wp_nonce_field( 'action_nonce_insert_essence', 'nonce_insert_essence' );
				
			if( empty($opt_values['step']) ){
				echo '<h1 class="text-center">サロンノートのインストール　ありがとうございます。</h1>';
			}
				
			
			if( $step_num >= $opt_values['step'] ){
				echo '<input type="hidden" name="insert_essence[step]" value="'.($step_num+1).'">';
				$reset_txt = '';
			}else{
				$reset_txt = '[char p=r src='.$char_dir.'biz_male/seriously.jpg]すでに設定いただいた部分ですが、もう一度やり直しましょうか。
				ちなみに、この質問に回答すると、次の質問ではなく、最新の質問に一気に飛ぶのでご注意くださいね。
				[/char]';
			}
			
				
			if( !empty($step_content[$step_num]) ){
				echo '<h2>'.$step_content[$step_num]['title'].'</h2>';
			}
				
			

			if( !empty($step_content[$step_num]['text']) ){
				echo apply_filters('the_content', markdown_char($reset_txt . $step_content[$step_num]['text']));
			}
			?>
			</form>
		</div>
	</div>

	<div class="installer-essence-sidebar col-12 col-md-3">
		<div id="sidebar" class="installer-essence-sidebar-inner fit-sidebar">
		<div class="side_list">    
				<ul class="list-bordered">
					<?php
					foreach( $step_content as $key => $value ){
						echo '<li class="parent-list-item';
						
						if( $key == $step_num ) echo ' current' ;
						if( $key < $opt_values['step'] ) echo ' step_done' ;
						if( $key > $opt_values['step'] ) echo ' step_disable' ;
						echo '"><a href="'. get_bloginfo('url') .'/?step_num='.$key.'">'.$key.'. '. $value['title'].'</a>
									</li>';
					}
					?>	
				</ul>
			
			<form action="" method="post" class="text-center">
				<?php
				wp_nonce_field( 'action_nonce_insert_essence', 'nonce_insert_essence' );
				?>
				<input type="hidden" name="insert_essence[installer_end]" value="done">
				<button type="submit" class="btn btn-item">会話設定を終了する</button>
			</form>
			
		</div>
		</div>
	</div>
		
	</div>
</div>