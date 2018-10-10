// JavaScript Document

(function() {
  tinymce.create('tinymce.plugins.character_essence', {
  init : function( editor,  url) {
  
		var t = this;
		t.url = url;


		//replace shortcode before editor content set
		//エディターコンテンツが読み込まれる前に　ショートコードの置き換え
		editor.onBeforeSetContent.add(function(ed, o) {
			o.content = t._do_spot(o.content);
		});


		//replace the image back to shortcode on save
		//保存時にはショートコードそのものを保存する
		editor.onPostProcess.add(function(ed, o) {
			if (o.get)
				o.content = t._get_spot(o.content);
		});



		//キャラクターを追加 =============================================
		editor.addButton( 'character_essence', {
			title: 'キャラクターを追加',
			label: 'キャラクターを追加',
      icon: 'icon dashicons-format-status',
      onclick : function() {
				
				
					//JSONのURLを格納する
					var current_url = location.hostname+''+location.pathname;
					var json_url = current_url.replace('wp-admin/post.php','wp-json/wp/v2/es_character');
					$url = '//'+json_url;
					$.getJSON( $url, function(results) {
						var character_posts = [];	
						$.each(results, function(i, value) {
							var posts = {};
							posts['text']   = value.title.rendered;
							posts['value']  = String(value.id);
							character_posts.push(posts);
						});
						//console.log(character_posts);
						
						editor.windowManager.open({
								title: 'キャラクター',
							
								body: [
										{
											type: 'listbox' , name: 'characterid', label: 'キャラクター',
											'values': character_posts
										},
										{
											type: 'listbox' , name: 'type', label: '表情',
											'values': [
													{text: 'ノーマル', value: 'normal'},
													{text: 'スマイル', value: 'smile'},
													{text: '楽しい', value: 'happy'},
													{text: '嬉しい', value: 'pleased'},
													{text: '決め台詞', value: 'seriously'},
													{text: '合っている', value: 'correct'},
													{text: '間違っている', value: 'mistaken'},
													{text: 'わかった', value: 'understand'},
													{text: 'わからない', value: 'question'},
													{text: 'お礼を言う', value: 'thanks'},
													{text: 'お礼を言う', value: 'thanks'},
													{text: '怒る', value: 'angry'},
													{text: 'おどろく', value: 'surprised'},
													{text: 'あせる', value: 'panicked'},
													{text: '呆れる', value: 'speechless'},
													{text: '困る', value: 'upset'},
													{text: '悲しい', value: 'sad'},
													{text: '苦しい', value: 'trying'},
													{text: 'あやまる', value: 'sorry'},
													{text: '寝る', value: 'sleep'},
																]
										},
										{
											type: 'listbox' , name: 'position', label: 'キャラクターの位置',
											'values': [
																		{text: '左', value: 'left'},
																		{text: '右', value: 'right'},
																]
										},
										{
											type: 'checkbox',
											name: 'reverse',
											label: '反転',
											classes: 'true' 
										},
										{
											type: 'textbox',
											name: 'content',
											label: '会話内容',
											multiline: true,
											minWidth: 600,
											minHeight: 300,
											
										},
								],
								onsubmit: function(e) {
									editor.focus();
									//console.log(e.data);
									
									var character_id = e.data.characterid;
									
									if( character_id == null) return;
									
									/*
									var character_code = '[character id='+character_id;
									if( e.data.type ){
										 character_code += ' type='+e.data.type;
									}
									if( e.data.reverse ){
										 character_code += ' reverse=1';
									}
									char_short_code += ']';
									*/
									
									var current_url = location.hostname+''+location.pathname;
									var json_url = current_url.replace('wp-admin/post.php','wp-content/themes/salonote-essence/lib/salonote-helper/plugins/character-essence/statics/json/character.json');
									$url = '//'+json_url;
									
									//console.log($url);
									
									var char_data = '';
									var type = e.data.type;
									
									$.ajax({
										url: $url,
										dataType: 'json',
										async: false,
										//data: {'data': 'data' },
										success: function(results) {
											char_data = results;
										}
									});
									console.log([char_data]);
									
									var char_img = char_data[character_id]['images'][type];
									
									var char_txt = e.data.content.replace(/\r\n/g, "<br />");
									char_txt = char_txt.replace(/(\n|\r)/g, "<br />");
									char_txt = char_txt.replace(/^(\n|\r)/g, "");
									
									var char_content = '<div id="char_id_'+character_id+'" class="character_essence char_type_'+e.data.type+' char_reverse_'+e.data.reverse+' char_position_'+e.data.position+'"><img src="'+char_img+'" /><div class="char_content"><p>'+char_txt+'</p></div></div><p>&nbsp;</p>';

									editor.selection.setContent(char_content);
								}//onsubmit

						});
						
					})// get json	
					.done(function(character_posts) {

					})
					.fail(function(character_posts) {
						
					})
					.always(function(character_posts) {
						
					});

				
			} // onclick

    });
		//^ キャラクターショートコードを追加 =============================================

  },


	

	// Replace view tags with their text.
	// ショートコードの開始タグの置き換えコールバック
	_do_spot : function( content ) {
		function callback( match, $1, $2, $3, $4, $5, $6) {
			
			//console.log(match);

			//IDがある場合 ===========================================
			if ( $1.indexOf() == -1) {
				
				var char_txt = $6.replace(/\r\n/g, "<br />");
				char_txt = char_txt.replace(/(\n\n|\r\r)/g, "<br />");
				
				var session_html = '<div id="char_id_'+$1+'" class="character_essence char_type_'+$2+' char_reverse_'+$3+' char_position_'+$4+'"><img src="'+$5+'" /><div class="char_content"><p>'+char_txt+'</p></div></div>';
			}
			//書き出し ===========================================
			return String(session_html);
		}

		if ( ! content ) {
			return content;
		}


		//正規表現パターン
		var data = '\\[character id=(.+?) type=(.+?) reverse=(.+?) position=(.+?) src="(.+?)"](.+?)\\[\\/character]';
		var pattern = new RegExp(data, 'gs');

		return content
			.replace( pattern , callback );
	},




	/*
	_do_spot_original : function(content) {
		return content.replace(/\[section([^\]]*)\]/g, function(a,b){
			return '<img src="/wp-content/plugins/tinymce-graphical-shortcode/tinymce-plugin/icitspots/images/t.gif" class="wpSpot mceItem" title="icitspot'+tinymce.DOM.encode(b)+'" />';
		});
	},
	*/

	_get_spot : function(content) {

		function callback( match, $1, $2, $3, $4, $5, $6 ) {
			//IDがある場合 ===========================================
			if ( $1.indexOf() == -1) {
				
				var char_txt = $6.replace(/\r\n/g, "<br />");
				char_txt = char_txt.replace(/(\n\n|\r\r)/g, "<br />");
				
				var session_html = '[character id='+$1+' type='+$2+' reverse='+$3+' position='+$4+' src="'+$5+'"]'+char_txt+'[/character]';
			}
			//書き出し ===========================================
			return String(session_html);
		}

		if ( ! content ) {
			return content;
		}

		//正規表現パターン
		var data = '<div id="char_id_(.+?)" class="character_essence char_type_(.+?) char_reverse_(.+?) char_position_(.+?)"><img src="(.+?)" /><div class="char_content"><p>(.+?)</p></div></div>';
		var pattern = new RegExp(data, 'gs');

		return content
			.replace( pattern , callback );
	},
    


      
    
	//information =============================================
	getInfo : function() {
		return {
			longname : 'tinymce.plugins.character_essence',
			author : 'HealingSolutions',
			authorurl : 'https://www.healing-solutions.jp/',
			infourl : 'https://www.healing-solutions.jp/',
			version : "1.0"
		};
	}

    
});

  tinymce.PluginManager.add('character_essence', tinymce.plugins.character_essence);

})();