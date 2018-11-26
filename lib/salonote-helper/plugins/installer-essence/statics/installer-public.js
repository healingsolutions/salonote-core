// JavaScript Document


$(document).ready( function($) {
	
	function rgb2hex ( rgb ) {
		return "#" + rgb.map( function ( value ) {
			return ( "0" + value.toString( 16 ) ).slice( -2 ) ;
		} ).join( "" ) ;
	}


	$('.installer_colorpicker').each( function() {
		//
		// Dear reader, it's actually very easy to initialize MiniColors. For example:
		//
		//  $(selector).minicolors();
		//
		// The way I've done it below is just for the demo, so don't get confused
		// by it. Also, data- attributes aren't supported at this time...they're
		// only used for this demo.
		//


		$(this).minicolors({
			control: $(this).attr('data-control') || 'hue',
			defaultValue: $(this).attr('data-defaultValue') || '',
			format: $(this).attr('data-format') || 'hex',
			keywords: $(this).attr('data-keywords') || '',
			inline: $(this).attr('data-inline') === 'true',
			letterCase: $(this).attr('data-letterCase') || 'lowercase',
			opacity: $(this).attr('data-opacity'),
			position: $(this).attr('data-position') || 'bottom',
			swatches: $(this).attr('data-swatches') ? $(this).attr('data-swatches').split('|') : [],
			change: function(value, opacity) {
				if( !value ) return;
				if( opacity ) value += ', ' + opacity;
				if( typeof console === 'object' ) {
					console.log(value);
				};
			},
			theme: 'bootstrap'
		});

	});


	$(".installer_colorpicker").change( function() {
		var target = $(this).attr('data-target');
		var tar_attr = $(this).attr('data-attr');
		var bg_color = $(this).next('.minicolors-input-swatch').children('.minicolors-swatch-color').css('background-color');

		$('#'+target).css(tar_attr,bg_color);
		console.log(target + rgb2hex(bg_color));
		// $(this).val() で値を参照することができます。
	});


	$( '#installer_essence_form-radio input:radio' ).change( function() {
		var radioval = $(this).val();
		$('#installer_essence_form-target').removeClass();
		$('#installer_essence_form-target').addClass('font-'+radioval);
	
	}); 


	$('.installer_essence_form_block textarea').each( function() {
		var textarea_content = $(this).val().replace(/<br \/>/g, '');
		$(this).val(textarea_content);
	})
	

});

