<?php
$step = [];


$step[0] = '
[char]え？
ここに文章を入れるだけでいいの？[/char]

[char]そうなんです。
簡単な記号を覚えるだけで、誰でもキャラクター投稿ができるんです[/char]

[char]今までは、１つ１つ、キャラクターを設定しなくちゃいけなかったのに・・[/char]

[char]そうですよね
でも、この方式なら、打ち込むだけでも十分できますよ！[/char]

';
?>

<div id="installer-essence-body" class="container ">

	<h1 class="text-center h3 mb-5">サロンノートをインストールいただき、ありがとうございます。</h1>
	
	
	<div class="row">
	<div class="installer-essence-content col-9 entry_block_content">
		<div class="installer-essence-content-inner">
			<h2>はじめの設定を開始します</h2>		
			<?php
			echo apply_filters('the_content', markdown_char($step[0]));
			?>
		</div>
	</div>
	
	<div class="installer-essence-sidebar col-3">
		<div class="installer-essence-sidebar-inner">
		<div class="side_list">    
				<ul class="list-bordered">
					<li class="parent-list-item">
						<a href="http://biyou.salonote.net/1003/">キャラクター機能で、会話形式のページを作成</a>
					</li>
					<li class="parent-list-item">
						<a href="http://biyou.salonote.net/1003/">キャラクター機能で、会話形式のページを作成</a>
					</li>
					<li class="parent-list-item">
						<a href="http://biyou.salonote.net/1003/">キャラクター機能で、会話形式のページを作成</a>
					</li>
					<li class="parent-list-item">
						<a href="http://biyou.salonote.net/1003/">キャラクター機能で、会話形式のページを作成</a>
					</li>
					
				</ul>
		</div>
		</div>
	</div>
		
	</div>
</div>