// JavaScript Document

(function() {
  tinymce.create('tinymce.plugins.essence_buttons', {
  init : function( editor,  url) {
  
  var t = this;
  t.url = url;
		

	//replace shortcode before editor content set
	//エディターコンテンツが読み込まれる前に　ショートコードの置き換え
	editor.onBeforeSetContent.add(function(ed, o) {
		o.content = t._do_spot(o.content);
	});
		
	//replace shortcode as its inserted into editor (which uses the exec command)
	editor.onExecCommand.add(function(ed, cmd) {
		console.log(cmd);
			if (cmd ==='mceInsertContent'){
			tinyMCE.activeEditor.setContent( t._do_spot(tinyMCE.activeEditor.getContent()) );
		}
	});
		

	//replace the image back to shortcode on save
	//保存時にはショートコードそのものを保存する
	editor.onPostProcess.add(function(ed, o) {
		if (o.get)
			o.content = t._get_spot(o.content);
	});



		//横並びブロックを追加 =============================================
		editor.addButton( 'btn_add_col_block', {
      title: '横並びブロックを追加',
      icon: 'icon dashicons-image-grid-view',
      onclick : function() {
					editor.windowManager.open({
							title: '横並びブロック',
							body: [
									{type: 'checkbox', name: 'use_image', label: '画像あり'},
									{type: 'listbox' , name: 'grid_cols', label: '並べる数',
									'values': [
												{text: '1', value: '1'},
												{text: '2', value: '2'},
												{text: '3', value: '3'},
												{text: '4', value: '4'},
												{text: '5', value: '5'},
												{text: '6', value: '6'},
											]
									},
							],
							onsubmit: function(e) {
								editor.focus();
								

								function print_cols(attach_id,e){
									//要素の個数だけ配列を回す
									var $cols_html = '';
									for ($count = 0; $count < e.data.grid_cols; $count++){
										$cols_html += '<div class="block-unit">';
                    console.log(e.data.use_image);
											if( e.data.use_image ){
													$cols_html += '<p><img class="alignnone size-full wp-image-'+attach_id+' img-responsive wow fadeIn" src="https://dummyimage.com/600x400/666/fff" alt="" width="600" height="400" /></p>';
											}
										$cols_html += '<p>ここにテキストが入ります。</p>';
										$cols_html += '</div>';
									}
									
									$cols_html += '<hr><p></p>';
									return $cols_html;
								}

								//JSONのURLを格納する

								var current_url = location.hostname+''+location.pathname;
								var json_url = current_url.replace('wp-admin/post.php','wp-json/wp/v2/media?page=1&media_type=image');
								var attach_id = 0;
								url = '//'+json_url;
								console.log(url);
								
								$.getJSON( url, function(results) {
									var attach_id = results[0].id;
									var cols = print_cols(attach_id,e);
									editor.selection.setContent(cols);
								});

								
								//editor.selection.setContent($cols_html);
							}
					});
			}
    });
		//^ 横並びブロックを追加 =============================================
		
		
		
		
		
		//お手本挿入 =============================================
		editor.addButton( 'btn_add_sample_block', {
      text: 'お手本を挿入',
      icon: 'icon dashicons-welcome-learn-more',
      onclick : function() {
					editor.windowManager.open({
							title: 'お手本挿入',
							body: [
									{type: 'listbox' , name: 'sample_type', label: 'お手本の種類',
									'values': [
												{text: '左右に振り分けるブロック', value: 'left_right_unit'},
												{text: '固定された背景の上にコンテンツ', value: 'fixed_bkg_unit'},
												{text: '中央配置ボタン', value: 'center_btn_unit'},
											]
									},
							],
							onsubmit: function(e) {
								editor.focus();

	
								function print_sample(attach_id,e){
									

								var $sample_html = '';

								//左右に振り分けるブロック
								if( e.data.sample_type === 'left_right_unit' ){
									
									$sample_html += '<!-- wp:media-text {"mediaId":1452,"mediaType":"image","isStackedOnMobile":true} -->';
									$sample_html += '<div class="wp-block-media-text alignwide is-stacked-on-mobile">';
									$sample_html += '<figure class="wp-block-media-text__media"><img src="http://biyou.salonote.net/wp-content/uploads/2018/11/YTAyYTIxM2M0NGJjMTU2MDExOGYzYjcwMjRhY2FhNDBfbS5qcGc-1024x768.jpg" alt="" class="wp-image-1452"/></figure>';
									
									$sample_html += '<div class="wp-block-media-text__content"><!-- wp:heading -->';
									$sample_html += '<h2>左右に振り分けるブロック<br><br></h2>';
									$sample_html += '<!-- /wp:heading -->';

									$sample_html += '<!-- wp:paragraph {"placeholder":"Content…"} -->';
									$sample_html += '<p>画像とテキストを左右に振り分けることが、最も簡単に実現できます</p>';
									$sample_html += '<!-- /wp:paragraph -->';

									$sample_html += '<!-- wp:heading {"level":3} -->';
									$sample_html += '<h3 id="mce_35">モバイルでは上下に分割します</h3>';
									$sample_html += '<!-- /wp:heading -->';

									$sample_html += '<!-- wp:paragraph {"textColor":"vivid-green-cyan"} -->';
									$sample_html += '<p class="has-text-color has-vivid-green-cyan-color">ブロック単位で背景色や文字の色を変えることができます</p>';
									$sample_html += '<!-- /wp:paragraph -->';

									$sample_html += '<!-- wp:paragraph {"textColor":"very-light-gray","backgroundColor":"very-dark-gray"} -->';
									$sample_html += '<p class="has-text-color has-background has-very-light-gray-color has-very-dark-gray-background-color">ただ、現在のところ、1つのブロックの途中では、テキストの大きさを変えることができません。</p>';
									$sample_html += '<!-- /wp:paragraph -->';

									$sample_html += '<!-- wp:button {"customBackgroundColor":"#329470","align":"center","className":"is-style-squared"} -->';
									$sample_html += '<div class="wp-block-button aligncenter is-style-squared"><a class="wp-block-button__link has-background" href="http://biyou.salonote.net/salon/gallery/" style="background-color:#329470">リンクボタン<br></a></div>';
									$sample_html += '<!-- /wp:button -->';

									$sample_html += '</div></div>';
									$sample_html += '<!-- /wp:media-text -->';

									
								}

								//固定された背景の上にコンテンツ
								if( e.data.sample_type === 'fixed_bkg_unit' ){
									$sample_html += '<img class="alignnone size-full wp-image-'+attach_id+' img-responsive wow fadeIn img-cover-block bkg-fixed" src="https://dummyimage.com/1200x650/666/fff" alt="" width="1000" height="667" />';
									$sample_html += '<div class="text-cover-block">';
									$sample_html += '<div class="block-center">';
									$sample_html += '<h1>ここに固定されたコンテンツが入ります</h1>';
									$sample_html += '<p>ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。<br>ここにテキストが入ります。ここにテキストが入ります。ここにテキストが入ります。</p>';
									$sample_html += '<div class="btn-item"><p>ボタンが入ります</p></div>';
									$sample_html += '</div>';
									$sample_html += '</div>';
									$sample_html += '<hr class="short-horizon" />';
								}

								//中央配置ボタン
								if( e.data.sample_type === 'center_btn_unit' ){
									$sample_html += '<div class="block-center"><div class="btn-item"><a href="#btn">ボタンのテキスト</a></div></div>';
								}


								$sample_html += '<p></p>';
									
									
									return $sample_html;
								}

								//JSONのURLを格納する

								var current_url = location.hostname+''+location.pathname;
								var json_url = current_url.replace('wp-admin/post.php','wp-json/wp/v2/media?page=1&media_type=image');
								var attach_id = 0;
								url = '//'+json_url;
								//console.log(url);

								$.getJSON( url, function(results) {
									var attach_id = results[0].id;
									var sample_html = print_sample(attach_id,e);
									editor.selection.setContent(sample_html);
								});

							}
					});
			}
    });
		//^ お手本挿入 =============================================
		
		
		
		
		
		
		
		
		
		
		//定義リストを追加 =============================================
		editor.addButton( 'btn_add_dldtdd_block', {
      title: '定義リストを追加',
			label: '定義リストを追加',
      icon : 'icon dashicons-exerpt-view',
      onclick : function() {
				editor.focus();
				var dldtdd_text = '<dl><dt>見出し</dt><dd>中身</dd></dl>';
				editor.selection.setContent(dldtdd_text);
				}
    });
		//^ 定義リストを追加 =============================================
    
    
    //テキストブロックを追加 =============================================
		editor.addButton( 'btn_add_editor_block', {
      title: 'テキストを追加',
			label: 'テキストを追加',
      icon : 'icon dashicons-edit',
      onclick : function() {
					
				
					function textbox_replace( match, $1=null ) {
						var html_tag = $1+'\n\n';
							return html_tag;
					}

					var select_html = editor.selection.getContent()
						.replace( /<p>(.+?)<\/p>/g, textbox_replace );
				
					var select_html = select_html.replace( /<br ?\/>/g, '\n' );
				
				var select_html = select_html.replace( /<br ?\/>/g, '\n' );

				
					editor.windowManager.open({
							title: 'テキストエリア',
							body: [
									{
										type: 'textbox',
										name: 'content',
										label: 'テキストエリア',
										multiline: true,
										minWidth: 600,
										minHeight: 300,
										value: select_html,
									},
							],
							onsubmit: function(e) {
								editor.focus();
								
								
								var insert_html = e.data.content
												
								function textbox_replace( match, $1=null ) {
									tex = '<p>\n' + match;
									tex = tex.replace(/\r\n/g, '<br />');
									tex = tex.replace(/(\n|\r)/g, '<br />');
									tex = tex.replace(/(<br \/>){2,}/g, '<p>');
									tex = tex.replace(/<br \/>/g, '<br />\n');
									tex += '</p>';
									tex = tex.replace(/<p>(\r\n|\n|\r}\b)*<\/p>/g, '');
									tex = tex.replace(/<p>(\r\n|\n|\r}\b)*<br \/>/g, '<p>');
									return tex;
								}

								var insert_html = e.data.content
									.replace( e.data.content, textbox_replace );
								
								editor
									.selection.setContent(insert_html);
							}
					});
					
			},
    });
		//^ テキストブロックを追加 =============================================

		
		
		
		
		// スマホ用改行を挿入 =============================================
		editor.addButton( 'btn_only_spbr', { // 任意のボタン名
				title : 'スマホ用改行を挿入', // ボタンのタイトル（マウスオーバー時に表示される）
				icon: 'icon dashicons-image-editor-break',
				onclick : function() {
					editor.focus();
					var hr_spbr = '<span class="br onlySP">スマホ改行</span>';
					editor.selection.setContent(hr_spbr);
			}
		});
		//^ スマホ用改行を挿入 =============================================


  },
		
		

	_do_spot : function(content) {
		
		function youtube_tag( match, $1=null ) {
			var youtube_tag = '<img class="youtube" src="http:\/\/img\.youtube\.com/vi/'+$1+'/0.jpg" />';
        return youtube_tag;
		}
		
		//shop menu essence
		function shopmenu_tag( match, $1=null,$2=null ) {
			var shopmenu_tag = '<div id="'+$2+'" class="shop_menu_tag">'+$1+'</div>';
        return shopmenu_tag;
		}
		if ( ! content ) {
			return content;
		}
		
		return content
			.replace( /\[youtube id=(.+?)]/g, youtube_tag )
			.replace( /\[shop_menu label=\"?(.+?)\"? id=(.+?)]/g, shopmenu_tag )
			;
	},

	_get_spot : function(content) {
		function youtube_callback( match, $1=null ) {
			var youtube_tag = '[youtube id='+$1+']';
        return youtube_tag;
		}
		function shopmenu_callback( match, $1=null, $2=null ) {
			var shopmenu_callback = '[shop_menu label='+$2+' id='+$1+']';
        return shopmenu_callback;
		}
		if ( ! content ) {
			return content;
		}
		
		return content
			.replace( /<img class="youtube" src="http:\/\/img\.youtube\.com\/vi\/(.+?)\/0.jpg" \/>/g, youtube_callback )
			.replace( /<div id="(.+?)" class="shop_menu_tag">(.+?)<\/div>/g, shopmenu_callback );
	},
    


      
    
	//information =============================================
	getInfo : function() {
		return {
			longname : 'tinymce.plugins.essence_buttons',
			author : 'HealingSolutions',
			authorurl : 'https://www.healing-solutions.jp/',
			infourl : 'https://www.healing-solutions.jp/',
			version : "1.0"
		};
	}

    
});

  tinymce.PluginManager.add('essence_buttons', tinymce.plugins.essence_buttons);

})();