<?php

//delete_option('insert_essence');
$opt_values = get_option('insert_essence',true);
//echo '<pre>opt_values'; print_r($opt_values); echo '</pre>';

if( !empty( $_GET['step_num'] ) ) $step_num = $_GET['step_num'];




if( !empty($opt_values['step']) ){
	$step_num = !empty( $step_num ) ? esc_html($step_num) : $opt_values['step'];
}
$step_num = !empty( $step_num ) ? esc_html($step_num) : 1;

$step_content = [];

$char_dir = CHARACTER_ESSENCE_PLUGIN_URI.'/statics/images/';
$gender 		= !empty( $opt_values['gender'] ) ? esc_attr($opt_values['gender']) : 'female' ;
$your_name 	= !empty( $opt_values['name_sei'] ) ? esc_attr($opt_values['name_sei']) : '' ;

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
		姓<input type="text" name="insert_essence[name_sei]" required >
		
		名<input type="text" name="insert_essence[name_mei]" >
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
	'title' => '自己紹介をお願いします',
	'text' => '
		[char p=l r=t src='.$char_dir.$gender.'/surprised.jpg]<span style="font-size: 1.6em;">わぁ・・・戻ったぁ・・・[/char]

		[char p=r c=t src='.$char_dir.'biz_male/normal.jpg]'. (isset( $your_name ) ? '<b>'.esc_attr($your_name).'</b>さん　ですね。' : '') .'
		改めて・・・
		サロンノートをインストールしていただいて、ありがとうございます！[/char]

		[char p=l r=t src='.$char_dir.$gender.'/speechless.jpg]ホームページ嫌い・・ホームページ苦手・・
		何をどう進めればいいか、わからない・・[/char]

		[char p=r c=t src='.$char_dir.'biz_male/seriously.jpg]大丈夫ですよ！
		サロンノートは、そんな方のために作られたものなので。
		これから、会話形式で、何をどう進めればいいか、丁寧にご説明しますね[/char]

		[char p=l r=t src='.$char_dir.$gender.'/speechless.jpg]お手柔らかにお願いします・・・[/char]

		[char p=r src='.$char_dir.'biz_male/question-2.jpg]まず、大変恐縮ではありますが、簡単で大丈夫なので、
		'.(isset( $your_name ) ? '<b>'.esc_attr($your_name).'</b>さんの、' : '').'自己紹介をお願いできますか？[/char]

		[char p=l r=t c=t src='.$char_dir.$gender.'/normal.jpg]
		私は・・・

		<div class="installer_essence_form_block" style="width:100%;">
    <textarea id="insert_essence-user_profile" class="form-control" rows="5" name="insert_essence[user_profile]">'. (!empty($opt_values['user_profile']) ? esc_attr($opt_values['user_profile']) : '' ). '</textarea>
		</div>

		<button type="submit" class="btn btn-item">伝える</button>

		[/char]
		'
);


++$num;
$step_content[$num] = array(
	'title' => '好きな色を聞かせてください',
	'text' => '[char p=r src='.$char_dir.'biz_male/upset.jpg]自己紹介、ありがとうございます！[/char]
		
		[char p=l r=t src='.$char_dir.$gender.'/sorry.jpg]こうして会話形式で寄り添ってくれるのはわかるんですが・・
		ホームページって、いったい何からどう初めていいのか、わからないんです[/char]

		[char p=r src='.$char_dir.'biz_male/upset.jpg]そうですよね
		特にWordPress（ワードプレス）とか言われると、一気に専門用語になっちゃって、「むずかしいぃ！！」って、思っちゃいますよね・・[/char]

		[char p=l r=t src='.$char_dir.$gender.'/sorry.jpg]でもなんか、みんな使ってるし、「どんなものなのか」くらいは、ちょっとだけ興味があるんですよね[/char]

		[char p=r src='.$char_dir.'biz_male/normal.jpg]あぁ〜、わかります。
		でもきっと、いろいろむずかしいことからじゃなくって、例えばそうですね・・・
		
		<span class="h3">「好きな色」</span>とかから、決めていくのも、やりやすいですよ[/char]

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

		[char p=l src='.$char_dir.$gender.'/question.jpg]テキストの色？[/char]

		[char p=r src='.$char_dir.'biz_male/normal.jpg]今読んでいるこの文字とか、ブログ記事の文字とかをどんな色にするかも決められるんです。
		
		文字の色と、背景の色、それぞれどうしましょうか。
		ちなみに、一般的に作るには、背景は白のままにしておいて、文字の色は黒系か、濃いめの色にするのがオススメですよ。
		[/char]

		[char p=l r=t src='.$char_dir.$gender.'/understand.jpg]うーん・・・
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
	'title' => 'どんなお客様に喜ばれる？',
	'text' => '[char p=r src='.$char_dir.'biz_male/normal.jpg]
	ありがとうございます。好きな色も決まってきましたね。
	
	あ、そうだ。
	会話の途中でも、右側のナビゲーションから前の設定をやり直すこともできますよ。[/char]
	
	[char p=l r=t src='.$char_dir.$gender.'/understand.jpg]そうなんですね。
	じゃぁ、何度もやり直すことができますね[/char]
	
	[char p=r src='.$char_dir.'biz_male/seriously.jpg]
	その際に、前に設定した項目を再設定すると、その次の質問じゃなくて、一番最後の質問まで飛ぶのでご注意くださいね。[/char]
	
	
	[char p=l src='.$char_dir.$gender.'/question-2.jpg]よくわからないけれど、わかりました。[/char]
	
	
	[char p=r src='.$char_dir.'biz_male/normal.jpg]では、次はホームページを作る目的の話にうつりますね。
	例えば今回のホームページを作るにあたって、<b>どんな人に喜んでもらいたい</b>ですか？[/char]
	
	[char p=l src='.$char_dir.$gender.'/question.jpg]どんなお客様？
	それは・・<b class="h2">できるだけたくさんの困っているお客様</b>に、喜んでもらいたいです[/char]

	[char p=r src='.$char_dir.'biz_male/question.jpg]なるほど。確かに、一人でも多くの人に　っていう気持ちになりますよね。

	でも、それだとホームページを見てくれる人が、<b class="h4">「このホームページは、何を伝えたいんだろう？」</b>って、わからなくなっちゃう可能性が高いんですよ[/char]

	[char p=l src='.$char_dir.$gender.'/sad.jpg]そ・・そう言われてもなぁ・・
	要は、「伝える相手を絞れ」っていうことですか？[/char]

	[char p=r src='.$char_dir.'biz_male/seriously.jpg]「お客様を絞る」というよりは、一番伝えたいお客様を一人、想像してみるという感じに近いです。

	例えば、今いらっしゃるお客様で、一番喜んでくださった方はどういう方なのか。

	例えば、まだお客様になっていないけれど、<b>「この人、絶対受けるべきだよなぁ」</b>とか<b>「この人に届けたいなぁ」</b>といつも思ってしまうような方は、どんな人なのか・・。[/char]
	
	[char p=l src='.$char_dir.$gender.'/question-2.jpg]うーん・・・
		強いていうなら・・・・
		
		<div class="installer_essence_form_block" style="width:100%;">
    <textarea id="insert_essence-site_target" class="form-control" rows="5" name="insert_essence[site_target]">'. (!empty($opt_values['site_target']) ? esc_attr($opt_values['site_target']) : '' ). '</textarea>
		</div>
		
		かなぁ・・・
		
		<button type="submit" class="btn btn-item">伝える</button>
		
		[/char]
	'
);



++$num;

$front_body_txt = !empty($opt_values['front_body_txt']) ? esc_html( $opt_values['front_body_txt']) : '';
$front_body_txt = strip_tags($front_body_txt);

$step_content[$num] = array(
	'title' => '伝えたいメッセージ',
	'text' => '[char p=r src='.$char_dir.'biz_male/normal.jpg]徐々に具体的になってきましたね。
	疲れていないですか？
	
	この会話インストールは、<span class="h3">途中でページを閉じてしまっても、途中から再開する</span>ことができます。
	お忙しい場合は、遠慮なく離席されてくださいね。
	
	ただ、インストールが終わるまでの間は、お客様にとってはホームページは真っ白な状態なので、その辺りだけ、ご注意ください。[/char]
	
	[char p=l src='.$char_dir.$gender.'/surprised.jpg]気分転換で少し休んだとしても、早めに終わらせるに越したことはなさそうですね・・[/char]
	
	[char p=r src='.$char_dir.'biz_male/thanks.jpg]では、どんどん具体的に進めていきますね（笑）
	
	サイトを訪れてくれた方に、どんなことを伝えたいですか？
	長いメッセージでもいいので、思いのたけを聞かせて欲しいのです[/char]
	
	[char p=l src='.$char_dir.$gender.'/sad.jpg]お・・思いのたけ・・・？
	
	ちょっと待ってください。
	だって、まだどんなホームページが出来上がるか、わからないのに・・[/char]
	
	[char p=r src='.$char_dir.'biz_male/seriously.jpg]ホームページを作る時、多くの場合が「デザイン」から考えてしまうんです。
	
	もちろん、デザインはすごく重要な要素なので整えていく必要はありますが、中小規模の事業にとって、それよりも大切なものがあります。
	
	それは、<span class="h2">「伝えたい想い」</span>なんです。[/char]
	
	[char p=l src='.$char_dir.$gender.'/question.jpg]ホームページにとって、大切な・・想い・・？[/char]
	
	
	[char p=r src='.$char_dir.'biz_male/seriously.jpg]中小規模の事業にとってのホームページの役割って、多くの場合は「お客様に行動してもらうこと」なんです。
	大企業の場合は、とにかくブランドイメージをあげるという場合もありますが。
	
	行動してもらう時に、デザインと写真と文章だと、何が一番不可欠かわかりますか？[/char]
	
	[char p=l src='.$char_dir.$gender.'/understand.jpg]そうか、文章がなければそもそも、「何を行動してほしいか」が伝わらない・・[/char]
	
	[char p=r src='.$char_dir.'biz_male/seriously.jpg]そうなんですよね。
	文章できちんと想いを伝えることって、ホームページ制作の基礎だったりするんです。
	
	なので、あとでやり直すことは何度でもできるので、まずはせっかくこのサイトに訪れてくださったお客様に、どんなことを伝えたいか、文章にしてみてほしいのです。[/char]
	
	[char p=l src='.$char_dir.$gender.'/smile.jpg]
		わかりました。
		えーっと・・・
		
		<div class="installer_essence_form_block" style="width:100%;">
    <textarea id="insert_essence-front_body_txt" class="form-control" rows="15" name="insert_essence[front_body_txt]">'. wp_strip_all_tags($front_body_txt). '</textarea>
		</div>
	
		<button type="submit" class="btn btn-item">伝える</button>
		
		[/char]
	'
);


++$num;
$step_content[$num] = array(
	'title' => '検索されたい言葉',
	'text' => '
		[char p=r src='.$char_dir.'biz_male/smile.jpg]色々と、具体的になってきましたね！
		
		そうだ、'.(isset($your_name) ? $your_name.'さんは、' : '').'SEO（エスイーオー）という言葉は聞いたことがありますか？[/char]

		[char p=l src='.$char_dir.$gender.'/question.jpg]一応、聞いたことはありますが、
		どういうことなのか、具体的なことはあまり詳しくないです[/char]
		
		[char p=r src='.$char_dir.'biz_male/seriously.jpg]「検索エンジン最適化」のことなんです。
		つまり、「どんな言葉で検索されたいか」ですね。[/char]
		
		[char p=l src='.$char_dir.$gender.'/question-2.jpg]検索・・？
		あの、Googleとかで調べるやつですか？[/char]
		
		[char p=r src='.$char_dir.'biz_male/normal.jpg]そうそう、それです。
		検索したとしたら、やっぱり一番上から順番に見たくなるでしょ？
		
		例えば、５ページ目に表示されていたとしても、見ないと思うんです。
		だから、検索結果である程度上位になる必要があるんですよ[/char]
		
		[char p=l src='.$char_dir.$gender.'/sorry.jpg]そもそも・・・・・
		検索しないかも[/char]
		
		[char p=r src='.$char_dir.'biz_male/normal.jpg]確かに、最近検索するという人は、減ってきていますね。
		いわゆる「まとめサイト」に載っている情報で十分ですし、SNSを使えば自動的に”自分に合った情報”がどんどん流れてきますしね。
		[/char]
		
		[char p=l src='.$char_dir.$gender.'/normal.jpg]そうですね・・。
		自分で調べるよりも、誰かに聞いたり、まとめてあるサイトを見た方が早いかも[/char]
		
		[char p=r src='.$char_dir.'biz_male/seriously.jpg]でも、そんな中で、「これは調べる」というものってないですか？[/char]
		
		[char p=l src='.$char_dir.$gender.'/question.jpg]うーん・・・何だろう
		深刻度によるかもしれません。本気度というか。[/char]
		
		[char p=r src='.$char_dir.'biz_male/smile.jpg]そう。まさにそこなんです。
		本気の人は、具体的なフレーズで調べてくれる。その人に向けてアプローチをしたいので、具体的なフレーズでの検索でいいのです[/char]
		
		
		[char p=l src='.$char_dir.$gender.'/question-2.jpg]じゃぁ・・・
		
		<div class="installer_essence_form_block" style="width:100%;">
    <input type="text" id="insert_essence-site_keywords" class="form-control" name="insert_essence[site_keywords]" value="'. (!empty($opt_values['site_keywords']) ? esc_attr($opt_values['site_keywords']) : '' ). '">
		</div>
		
		かなぁ・・・
		
		<button type="submit" class="btn btn-item">伝える</button>
		
		[/char]
		'
);




++$num;

$step_content[$num] = array(
	'title' => 'スタッフはいますか？',
	'text' => '[char p=r src='.$char_dir.'biz_male/smile.jpg]'. (!empty($opt_values['site_keywords']) ? esc_attr($opt_values['site_keywords'].'ですね！') : '' ) .'
	ありがとうございます。
	
	あとは、そうですね・・。
	'.(isset($your_name) ? $your_name.'さんのところって、' : '' ).'スタッフさんはいらっしゃりますか？[/char]
	
	[char p=l src='.$char_dir.$gender.'/question.jpg]スタッフ？
	自分も含めてですか？[/char]
	
	[char p=r src='.$char_dir.'biz_male/smile.jpg]そうですね。'.(isset($your_name) ? $your_name.'さん' : 'ご自身' ).'も含めてがいいですね。
	そのお名前を、改行で区切って教えていただけますか？[/char]
	
	[char p=l src='.$char_dir.$gender.'/question-2.jpg]それであれば
		
		<div class="installer_essence_form_block" style="width:100%;">
    <textarea id="insert_essence-site_staffs" class="form-control" rows="5" name="insert_essence[site_staffs]">'. (!empty($opt_values['site_staffs']) ? esc_attr($opt_values['site_staffs']) : $your_name ). '</textarea>
		</div>
		
		かなぁ・・・
		
		<button type="submit" class="btn btn-item">伝える</button>
		
		[/char]
	'
);







$site_staffs = !empty($opt_values['site_staffs']) ? esc_attr($opt_values['site_staffs']) : '';
$site_staffs_arr = br2array($site_staffs);


++$num;
$step_content[$num] = array(
	'title' => 'どんなページが必要？',
	'text' => '[char p=r src='.$char_dir.'biz_male/smile.jpg]スタッフさんは、
	
	'.(!empty($opt_values['site_staffs']) ? '<ul class="list-icon"><li>'.implode('</li><li>',$site_staffs_arr).'</ul>の' : '').'<b class="h4">'.count($site_staffs_arr).'</b>名ですね。[/char]
	
	[char p=l src='.$char_dir.$gender.'/question.jpg]今のところは、そうですね。
	もしかしたら、増減あるかもしれませんが[/char]
	
	[char p=r src='.$char_dir.'biz_male/smile.jpg]大丈夫ですよ。
	追加したりするのも、後からできますからね。
	
	
	あとは、'. (isset($your_name) ? $your_name.'さんの' : '') .'活動を紹介するのに、必要なページってどんなものがありますか？[/char]
	
	[char p=l src='.$char_dir.$gender.'/question.jpg]活動の紹介？
	プロフィールページとかですか？[/char]
	
	[char p=r src='.$char_dir.'biz_male/smile.jpg]そうそう。
	
	例えば、サロンだったら
	<ul class="list-icon">
	<li>サロン紹介</li>
	<li>メニュー</li>
	<li>アクセス</li>
	<li>お問い合わせ</li>
	</ul>
	とかが必要だったりしますよね。
	
	'.((!empty($opt_values['site_staffs']) && count($site_staffs_arr) > 0) ? 'スタッフさんが<b class="h4">'.count($site_staffs_arr).'</b>名なので、自動的にプロフィールページは作成できます。
	なので、プロフィールページは追加しなくても大丈夫ですよ。' : 'もし、'.$your_name.'さんの紹介ページが必要なら、プロフィールページも必要ですね。').'
	[/char]
	
	
	[char p=l src='.$char_dir.$gender.'/question-2.jpg]うーん・・・
		強いていうなら・・・・
		
		<div class="installer_essence_form_block" style="width:100%;">
    <textarea id="insert_essence-site_pages" class="form-control" rows="5" name="insert_essence[site_pages]">'. (!empty($opt_values['site_pages']) ? esc_attr($opt_values['site_pages']) : 'サロン紹介
メニュー
アクセス
お問い合わせ' ). '</textarea>
		</div>
		
		かなぁ・・・
		
		<button type="submit" class="btn btn-item">伝える</button>
		
		[/char]
		
	'
);


/*
++$num;

$site_pages = !empty($opt_values['site_pages']) ? esc_attr($opt_values['site_pages']) : '';
$site_pages_arr = br2array($site_pages);

$sample_posts = !empty($opt_values['sample_posts']) ? esc_attr($opt_values['sample_posts']) : 0;

$step_content[$num] = array(
	'title' => 'ブログ記事のサンプルは必要？',
	'text' => '[char p=r src='.$char_dir.'biz_male/smile.jpg]必要なページ数は
	
	'.(!empty($site_pages) ? '<ul class="list-icon"><li>'.implode('</li><li>',$site_pages_arr).'</ul>の' : '').'<b class="h4">'.count($site_pages_arr).'</b>件ですね。[/char]
	
	[char p=l src='.$char_dir.$gender.'/question.jpg]今のところは、そうですね。
	これも、後からでも追加できるんですか？[/char]
	
	[char p=r src='.$char_dir.'biz_male/smile.jpg]もちろん、後からでも自由に追加したり変更できますよ。
	まずは、最低限必要なものだけ教えていただければ大丈夫です。[/char]
	
	[char p=l src='.$char_dir.$gender.'/question.jpg]後から追加できるなら、よかったぁ[/char]
	
	[char p=r src='.$char_dir.'biz_male/smile.jpg]あとは、ブログ記事のサンプルを追加することもできますよ。
	事前に、どんな記事を書けばいいかサンプルが下書きで入るので、あとで困らなくていいですよ[/char]
	
	[char p=l src='.$char_dir.$gender.'/question.jpg]サンプルって・・どんなものが入るんですか？[/char]
	
	[char p=r src='.$char_dir.'biz_male/smile.jpg]例えば、
	<ul class="list-icon">
	<li>活動をはじめた理由</li>
	<li>活動をはじめてよかったこと</li>
	<li>'.$your_name.'さんの経歴</li>
	<li>キャラクターがわかる記事</li>
	</ul>
	
	とかのタイトルが、自動的に下書きで入ります。
	あとは、コツコツそのタイトルの内容を書いていくことができますよ
	[/char]
	
	[char p=l src='.$char_dir.$gender.'/question.jpg]つまり、タイトルだけが下書きで入って、中身は後から入れるということですね？
	
	それなら・・・
	
	<div class="installer_essence_form_block" style="width:100%;">
    <select id="insert_essence-sample_posts" class="form-control" name="insert_essence[sample_posts]">
		<option value="0"'.( $sample_posts == 0 ? ' selected' : '').'>いらない</option>
		<option value="10"'.( $sample_posts == 10 ? ' selected' : '').'>10記事分</option>
		<option value="20"'.( $sample_posts == 20 ? ' selected' : '').'>20記事分</option>
		<option value="30"'.( $sample_posts == 30 ? ' selected' : '').'>30記事分</option>
		</select>
	</div>

	かなぁ・・・

	<button type="submit" class="btn btn-item">伝える</button>
	[/char]
	'
);
*/

++$num;
$step_content[$num] = array(
	'title' => '連絡先の電話番号',
	'text' => '[char p=r src='.$char_dir.'biz_male/smile.jpg]'. (isset( $your_name ) ? '<b>'.esc_attr($your_name).'</b>さんは、' : '') .'連絡可能な電話番号はありますか？
	例えば、予約を受け付けるような。
	
	電話での予約を受け付けない場合は、空欄にしておいてください。[/char]
	
	[char p=l src='.$char_dir.$gender.'/question-2.jpg]電話番号は
		
		<div class="installer_essence_form_block" style="width:100%;">
    <input type="text" id="insert_essence-phone_number" class="form-control" name="insert_essence[phone_number]" value="'. (!empty($opt_values['phone_number']) ? esc_attr($opt_values['phone_number']) : '' ). '">
		</div>です
		
		<button type="submit" class="btn btn-item">伝える</button>
		
		[/char]'
);


++$num;
$step_content[$num] = array(
	'title' => '住所',
	'text' => '[char p=r src='.$char_dir.'biz_male/smile.jpg]あとは、表示してもいい住所はありますか？
	郵便番号と住所を教えていただければ、ホームページに表示をしておきます。
	
	こちらも、表示したくない場合は空白で大丈夫ですよ[/char]
	
	[char p=l src='.$char_dir.$gender.'/question-2.jpg]
	
		
		<div class="installer_essence_form_block">
    郵便番号<input type="text" id="insert_essence-zip_code" class="form-control" name="insert_essence[zip_code]" value="'. (!empty($opt_values['zip_code']) ? esc_attr($opt_values['zip_code']) : '' ). '">
		</div>
		
		<div class="installer_essence_form_block" style="width:100%;">
    住所<textarea id="insert_essence-contact_address" class="form-control" name="insert_essence[contact_address]">'. (!empty($opt_values['contact_address']) ? esc_attr($opt_values['contact_address']) : '' ). '</textarea>
		</div>
		
		<button type="submit" class="btn btn-item">伝える</button>
		
		[/char]'
);


++$num;
$step_content[$num] = array(
	'title' => '営業時間や駐車場',
	'text' => '[char p=r src='.$char_dir.'biz_male/smile.jpg]ありがとうございます！
	そうだ、基本的なことではありますが、営業時間とか駐車場のことも伺っておきたいです。[/char]
	
	[char p=l src='.$char_dir.$gender.'/question-2.jpg]
		
		<div class="installer_essence_form_block" style="width:100%;">
    営業時間<textarea id="insert_essence-biz_time" class="form-control" name="insert_essence[biz_time]" placeholder="平日／10:00〜18:00 土日祝／10:00〜19:00">'. (!empty($opt_values['biz_time']) ? esc_attr($opt_values['biz_time']) : '' ). '</textarea>
		</div>
		
		<div class="installer_essence_form_block" style="width:100%;">
    定休日<textarea id="insert_essence-biz_holiday" class="form-control" name="insert_essence[biz_holiday]" placeholder="第二月曜日">'. (!empty($opt_values['biz_holiday']) ? esc_attr($opt_values['biz_holiday']) : '' ). '</textarea>
		</div>
		
		<div class="installer_essence_form_block" style="width:100%;">
    駐車場<textarea id="insert_essence-biz_parking" class="form-control" name="insert_essence[biz_parking]" placeholder="あり：２台">'. (!empty($opt_values['biz_parking']) ? esc_attr($opt_values['biz_parking']) : '' ). '</textarea>
		</div>
		
		<button type="submit" class="btn btn-item">伝える</button>
		
		[/char]
	'
);

++$num;

$font_set = [];
$font_set['mincho']      	= '"Times New Roman", "游明朝", "Yu Mincho", "游明朝体", "YuMincho", "ヒラギノ明朝 Pro W3", "Hiragino Mincho Pro", "HiraMinProN-W3", "HGS明朝E", "ＭＳ Ｐ明朝", "MS PMincho", serif;';
$font_set['gothic'] 		 	= '"Segoe UI", Verdana, 游ゴシック, "Yu Gothic", YuGothic, "ヒラギノ角ゴシック Pro", "Hiragino Kaku Gothic Pro", メイリオ, Meiryo, Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;';
$font_set['maru-gothic'] 	= '"ヒラギノ丸ゴ Pro W4","ヒラギノ丸ゴ Pro","Hiragino Maru Gothic Pro","ヒラギノ角ゴ Pro W3","Hiragino Kaku Gothic Pro","HG丸ｺﾞｼｯｸM-PRO","HGMaruGothicMPRO";';
$font_set['meiryo'] 			= '"メイリオ", Meiryo, "ヒラギノ角ゴ Pro W3", "Hiragino Kaku Gothic Pro",Osaka, "ＭＳ Ｐゴシック", "MS PGothic", sans-serif;';


$step_content[$num] = array(
	'title' => '見出しの文字はどうする？',
	'text' => '[char p=r src='.$char_dir.'biz_male/smile.jpg]見出しになるスタイルって、どういうフォントが好きですか？[/char]
	
	[char p=l src='.$char_dir.$gender.'/question.jpg]どういうフォントって言われても・・[/char]
	
	[char p=r src='.$char_dir.'biz_male/smile.jpg]例えば、
	<hr>
	
	<div style="padding:10px; background-color: white; width:100%; box-shadow: 0px 0px 7px #666666;">
	<div id="installer_essence_form-target"'. ((!empty($opt_values['headline_font'])) ? ' class="font-'.$opt_values['headline_font'].'"' : '' ). '>
	<div class="h1">あなたのお悩みに答えるお店です</div>
	</div>
	一人一人のお悩みに向き合い、丁寧に答えるお店です。
	この街で１０年間、お客様に愛されながらがんばってきました。
	</div>
	<hr>
	とか、入れる可能性があったりします。
	
	この時の、大きめの文字が見出しなんですが、以下の中から好きなスタイルを選んでみていただけますか？
	[/char]
	
	
	[char p=l src='.$char_dir.$gender.'/question-2.jpg]
		
		<div id="installer_essence_form-radio" class="installer_essence_form_block" style="width:100%;">
		
		<div class="radio">
    <label class="h1" style=\'font-family: '.$font_set['mincho'].'\'><input type="radio" name="insert_essence[headline_font]" value="mincho"'. ((!empty($opt_values['headline_font']) && $opt_values['headline_font'] === 'mincho' ) ? ' checked' : '' ). '>明朝体</label>
		</div>
		
		<div class="radio">
    <label class="h1" style=\'font-family: '.$font_set['mincho'].'\'><input type="radio" name="insert_essence[headline_font]" value="gothic"'. ((!empty($opt_values['headline_font']) && $opt_values['headline_font'] === 'gothic' ) ? ' checked' : '' ). '>ゴシック体</label>
		</div>
		
		<div class="radio">
    <label class="h1" style=\'font-family: '.$font_set['maru-gothic'].'\'><input type="radio" name="insert_essence[headline_font]" value="maru-gothic"'. ((!empty($opt_values['headline_font']) && $opt_values['headline_font'] === 'maru-gothic' ) ? ' checked' : '' ). '>丸ゴシック</label>
		</div>
		
		<div class="radio">
    <label class="h1" style=\'font-family: '.$font_set['meiryo'].'\'><input type="radio" name="insert_essence[headline_font]" value="meiryo"'. ((!empty($opt_values['headline_font']) && $opt_values['headline_font'] === 'meiryo' ) ? ' checked' : '' ). '>メイリオ</label>
		</div>

		
		</div>
		
		<button type="submit" class="btn btn-item">伝える</button>
		
		[/char]
	'
);



++$num;
$step_content[$num] = array(
	'title' => '普通のテキストはどうする？',
	'text' => '[char p=r src='.$char_dir.'biz_male/smile.jpg]見出しになるスタイルが決まったらって、次は全体で使うフォントを決めましょうか。
	
	見出しのフォントと並べてみてみて、その下に入る文字はどういうフォントが好きですか？
	
	例えば、
	<hr>
	<div style="padding:10px; background-color: white; width:100%; box-shadow: 0px 0px 7px #666666;">
	<div'. ((!empty($opt_values['headline_font'])) ? ' class="font-'.$opt_values['headline_font'].'"' : '' ). '>
	<div class="h1">あなたのお悩みに答えるお店です</div>
	</div>
	
	<div id="installer_essence_form-target"'. ((!empty($opt_values['body_font'])) ? ' class="font-'.$opt_values['body_font'].'"' : '' ). '>
	<p>
	一人一人のお悩みに向き合い、丁寧に答えるお店です。
	この街で１０年間、お客様に愛されながらがんばってきました。
	</p>
	</div>
	
	</div>
	
	<hr>
	とか、入れる可能性があったりします。
	
	この時の、大きめの文字が見出しなんですが、以下の中から好きなスタイルを選んでみていただけますか？
	[/char]
	
	
	[char p=l src='.$char_dir.$gender.'/question-2.jpg]
		
		<div id="installer_essence_form-radio" class="installer_essence_form_block" style="width:100%;">
		
		<div class="radio">
    <label class="h1" style=\'font-family: '.$font_set['mincho'].'\'><input type="radio" name="insert_essence[body_font]" value="mincho"'. ((!empty($opt_values['body_font']) && $opt_values['body_font'] === 'mincho' ) ? ' checked' : '' ). '>明朝体</label>
		</div>
		
		<div class="radio">
    <label class="h1" style=\'font-family: '.$font_set['mincho'].'\'><input type="radio" name="insert_essence[body_font]" value="gothic"'. ((!empty($opt_values['body_font']) && $opt_values['body_font'] === 'gothic' ) ? ' checked' : '' ). '>ゴシック体</label>
		</div>
		
		<div class="radio">
    <label class="h1" style=\'font-family: '.$font_set['maru-gothic'].'\'><input type="radio" name="insert_essence[body_font]" value="maru-gothic"'. ((!empty($opt_values['body_font']) && $opt_values['body_font'] === 'maru-gothic' ) ? ' checked' : '' ). '>丸ゴシック</label>
		</div>
		
		<div class="radio">
    <label class="h1" style=\'font-family: '.$font_set['meiryo'].'\'><input type="radio" name="insert_essence[body_font]" value="meiryo"'. ((!empty($opt_values['body_font']) && $opt_values['body_font'] === 'meiryo' ) ? ' checked' : '' ). '>メイリオ</label>
		</div>

		
		</div>
		
		<button type="submit" class="btn btn-item">伝える</button>
		
		[/char]
	'
);

++$num;
$step_content[$num] = array(
	'title' => 'ナビゲーションのフォントは？',
	'text' => '[char p=r src='.$char_dir.'biz_male/smile.jpg]ナビゲーションも、フォントを決めることができるんです[/char]
	
	[char p=l src='.$char_dir.$gender.'/question.jpg]イメージが想像つかない・・・[/char]
	
	[char p=r src='.$char_dir.'biz_male/smile.jpg]例えば、
	<hr>
	
	<div id="installer_essence_form-target"'. ((!empty($opt_values['nav_font'])) ? ' class="font-'.$opt_values['nav_font'].'"' : '' ). '>
	<nav id="header_nav" class="navbar-block" style=" width:100%;">
		<div class="container">
			<div class="menu-gnav-container-has_top_nav container nav-super_view">
				<ul class="menu" style="overflow: visible; width:100%;">

					<li class="menu-item">
						<a href="#"><span class="main_nav">Salon</span><span class="sub_nav">サロン</span></a>
					</li>

					<li class="menu-item">
						<a href="#"><span class="main_nav">Menu</span><span class="sub_nav">メニュー</span></a>
					</li>
					
					<li class="menu-item">
						<a href="#"><span class="main_nav">Style</span><span class="sub_nav">スタイル</span></a>
					</li>
					
					<li class="menu-item">
						<a href="#"><span class="main_nav">Staff</span><span class="sub_nav">スタッフ</span></a>
					</li>
					
					<li class="menu-item">
						<a href="#"><span class="main_nav">Access</span><span class="sub_nav">アクセス</span></a>
					</li>
					
					<li class="menu-item">
						<a href="#"><span class="main_nav">Blog</span><span class="sub_nav">ブログ</span></a>
					</li>
					
					<li class="menu-item">
						<a href="#"><span class="main_nav">Contact</span><span class="sub_nav">お問い合わせ</span></a>
					</li>

				</ul>
			</div>
		</div>
	</nav>
	</div>
	<hr>
	とか、入れる可能性があったりします。
	
	この時の、上にある大きい方の文字について、以下の中から好きなスタイルを選んでみていただけますか？
	[/char]
	
	
	[char p=l src='.$char_dir.$gender.'/question-2.jpg]
		
		<div id="installer_essence_form-radio" class="installer_essence_form_block" style="width:100%;">
		
		<div class="radio">
    <label class="h4" style=\'font-family: '.$font_set['mincho'].'\'><input type="radio" name="insert_essence[nav_font]" value="mincho"'. ((!empty($opt_values['nav_font']) && $opt_values['nav_font'] === 'mincho' ) ? ' checked' : '' ). '>明朝体</label>
		</div>
		
		<div class="radio">
    <label class="h4" style=\'font-family: '.$font_set['mincho'].'\'><input type="radio" name="insert_essence[nav_font]" value="gothic"'. ((!empty($opt_values['nav_font']) && $opt_values['nav_font'] === 'gothic' ) ? ' checked' : '' ). '>ゴシック体</label>
		</div>
		
		<div class="radio">
    <label class="h4" style=\'font-family: '.$font_set['maru-gothic'].'\'><input type="radio" name="insert_essence[nav_font]" value="maru-gothic"'. ((!empty($opt_values['nav_font']) && $opt_values['nav_font'] === 'maru-nav_font' ) ? ' checked' : '' ). '>丸ゴシック</label>
		</div>
		
		<div class="radio">
    <label class="h4" style=\'font-family: '.$font_set['meiryo'].'\'><input type="radio" name="insert_essence[nav_font]" value="meiryo"'. ((!empty($opt_values['nav_font']) && $opt_values['nav_font'] === 'meiryo' ) ? ' checked' : '' ). '>メイリオ</label>
		</div>

		
		</div>
		
		<button type="submit" class="btn btn-item">伝える</button>
		
		[/char]
	'
);


++$num;

$custom_text = '';
$upload_images = !empty($opt_values['upload_images']) ?$opt_values['upload_images'] : null;
if(is_user_logged_in()){
	//echo '<pre>upload_images'; print_r($upload_images); echo '</pre>';
}

if( $upload_images ){
	foreach( $upload_images as $key => $item ){
		$custom_text .= '<li class="upload_images_wrap" id=img_'.$item.'>
		<div class="upload_images_item">
		<a href="#" class="upload_images_remove" title="画像を削除する"><span class="dashicons dashicons-dismiss"></span></a><div class="upload_images_bkg">'.wp_get_attachment_image( $item, 'thumbnail' ) .'
		<input type="hidden" name="insert_essence[upload_images][]" value="'.$item.'" />
		</div></div>
		</li>';
	}
}
$step_content[$num] = array(
	'title' => '使いたい画像を教えてください',
	'text' => '[char p=r src='.$char_dir.'biz_male/smile.jpg]必要な画像を登録してください
		<div class="image-upload-wrap">
			<ul class="image-preview-wrapper upload_images">'.preg_replace('/(?:\n|\r|\r\n)/', '', $custom_text ).'</ul>
			<input id="upload_image_button-1" type="button" class="btn btn-item upload_image_button" rel="multiple" data-name="insert_essence[upload_images]" value="画像アップロード" />
		</div>
 
		<button type="submit" class="btn btn-item">伝える</button>
		[/char]
	'
);


++$num;

$custom_text = '';
$headline_images = !empty($opt_values['headline_images']) ?$opt_values['headline_images'] : null;

if( $headline_images ){
	foreach( $headline_images as $key => $item ){
		$custom_text .= '<li class="upload_images_wrap" id=img_'.$item.'>
		<div class="upload_images_item">
		<div class="upload_images_bkg">'.wp_get_attachment_image( $item, 'thumbnail' ) .'
		</div></div>
		</li>';
	}
}
$step_content[$num] = array(
	'title' => '見出し画像',
	'text' => '[char p=r src='.$char_dir.'biz_male/smile.jpg]ありがとうございます。
	'. (!empty($upload_images) ? count($upload_images) : '') .'件の画像を登録しました。
		[/char]
		
		
		[char p=r src='.$char_dir.'biz_male/smile.jpg]では、見出し画像をいくつか選択していただけますか？
		<div class="image-upload-wrap">
			<ul class="image-preview-wrapper upload_images">'.preg_replace('/(?:\n|\r|\r\n)/', '', $custom_text ).'</ul>
			<input id="upload_image_button-1" type="button" class="btn btn-item upload_image_button" rel="multiple" data-name="insert_essence[headline_images]" value="画像アップロード" />
		</div>
 
		<button type="submit" class="btn btn-item">伝える</button>
		[/char]
	'
);


++$num;
$step_content[$num] = array(
	'title' => '設定を反映します',
	'text' => '[char p=r src='.$char_dir.'biz_male/smile.jpg]それでは、これで設定を反映していきますね。[/char]
	
	[char p=l src='.$char_dir.$gender.'/happy.jpg]ドキドキしますね。


		<input type="hidden" name="insert_essence[finish]" value="1">
		<button type="submit" class="btn btn-item">反映します</button>
		
		[/char]
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
	<div class="installer-essence-content col-12 col-md-8 entry_block_content">
		<div class="installer-essence-content-inner">
			
			<form action="" method="post">
			<?php
			wp_nonce_field( 'action_nonce_insert_essence', 'nonce_insert_essence' );
				
			if( empty($opt_values['step']) ){
				echo '<h1 class="text-center">サロンノートのインストール　ありがとうございます。</h1>';
				$opt_values_step = 0;
			}else{
				$opt_values_step = $opt_values['step'];
			}
				
			
			if( $step_num >= $opt_values_step ){
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

	<div class="installer-essence-sidebar col-12 col-md-4">
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
