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



		//メールフォームショートコードを追加 =============================================
		editor.addButton( 'character_essence', {
      icon: 'icon dashicons-carrot',
      onclick : function() {
				
				
					//JSONのURLを格納する
					var current_url = location.hostname+'/'+location.pathname;
					var json_url = current_url.replace('wp-admin/post.php','wp-json/wp/v2/es_character');
					url = 'http://'+json_url;

					$.getJSON( url, function(results) {
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
											type: 'listbox' , name: 'characterid', label: 'フォーム名',
											'values': character_posts
										},
										{
											type: 'listbox' , name: 'type', label: 'タイプ',
											'values': [
																		{text: 'ノーマル', value: 'normal'},
																		{text: 'スマイル', value: 'smile'},
																		{text: 'happy', value: '楽しい'},
																		{text: 'seriously', value: '決め台詞'},
																		{text: 'sad', value: '悲しい'},
																		{text: 'angry', value: '怒る'},
					
																]
										},
										{
											type: 'checkbox',
											name: 'reverse',
											label: '反転',
											classes: 'true' 
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
									
									var char_content = '<div class="character char_id_'+character_id+' char_type_'+e.data.type+' char_reverse_'+e.data.reverse+'">'
									char_content += '<img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVQI12NgYAAAAAMAASDVlMcAAAAASUVORK5CYII=" width="150" height="150" />';
									
									char_content += '</div>';

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
		function callback( match, $1, $2, $3 ) {
			
			console.log('$1:'+$1+' $2:'+$2+' $3:'+$3);

			//IDがある場合 ===========================================
			if ( $1.indexOf() == -1) {
				var session_html = '<div class="character char_id_'+$1+' char_type_'+$2+' char_reverse_'+$3+'">'+$1+'</div>';
			}
			//書き出し ===========================================
			return String(session_html);
		}

		if ( ! content ) {
			return content;
		}


		//正規表現パターン
		var data = '\\[character id=(.+?) type=(.+?) reverse=(.+?)\\]';
		var pattern = new RegExp(data, 'g');

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

		function callback( match, $1, $2, $3, $4 ) {
			//IDがある場合 ===========================================
			if ( $1.indexOf() == -1) {
				var session_html = '[character id='+$1+' type='+$2+' reverse='+$3+']';
			}
			//書き出し ===========================================
			return String(session_html);
		}

		if ( ! content ) {
			return content;
		}

		//正規表現パターン
		var data = '<div class="character char_id_(.+?) char_type_(.+?) char_reverse_(.+?)">(.+?)</div>';
		var pattern = new RegExp(data, 'g');

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