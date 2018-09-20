$(document).ready(function($){
  $('.shop_menu-list-view').click(function () {
		$('.shop_menu-list-view').each(function(){
			$(this).addClass('active');
		})
		$('.shop_menu-grid-view').each(function(){
			$(this).removeClass('active');
		})
		$('.shop_menu_block_id').each(function(){
			$(this).addClass('list-view').removeClass('grid-view');
		})
		$('#sidebar').height('auto');
  });
	$('.shop_menu-grid-view').click(function () {
		$('.shop_menu-grid-view').each(function(){
			$(this).addClass('active');
		})
		$('.shop_menu-list-view').each(function(){
			$(this).removeClass('active');
		})
		$('.shop_menu_block_id').each(function(){
			$(this).addClass('grid-view').removeClass('list-view');
		})
		$('#sidebar').height('auto');

  });
	
																
});


$(document).on("click", "#reserve_type-btn .btn", function () {

	var target = $(this).attr('rel');
	
	$('.reserve_type-block').each(function(){
		$(this).hide();
	});

	$('#'+target+'.reserve_type-block').show();

});


$(document).on("click", ".shop_menu_show-button.active", function () {

	var target = $(this).attr('rel');

	$('.shop_menu_show-button.active[rel='+target+']').each(function(){
		$(this).removeClass('active').addClass('disable');
	})

	$('.'+target).each(function(){
		$(this).hide();
	});
});

$(document).on("click", ".shop_menu_show-button.disable", function () {

	var target = $(this).attr('rel');

	$('.shop_menu_show-button.disable[rel='+target+']').each(function(){
		$(this).removeClass('disable').addClass('active');
	})

	$('.'+target).each(function(){
		$(this).show();
	});
});


$(document).on("click", ".shop_menu-sort-price", function () {
	if($(this).hasClass('active') ){

		$(this).removeClass('active');
		$(".shop_menu_block").html(
				$(".shop_menu_block-item").sort(function(a, b) {
						return $(a).attr('data-index') - $(b).attr('data-index');
				})
		);
	}else{
		$(this).addClass('active');
		$('.shop_menu-sort-time').removeClass('active');

		$(".shop_menu_block").html(
				$(".shop_menu_block-item").sort(function(a, b) {
						return $(a).attr('data-price') - $(b).attr('data-price');
				})
		);				 
	}
});

$(document).on("click", ".shop_menu-sort-time", function () {

	if($(this).hasClass('active') ){
		$(this).removeClass('active');

		$(".shop_menu_block").html(
				$(".shop_menu_block-item").sort(function(a, b) {
						return $(a).attr('data-index') - $(b).attr('data-index');
				})
		);
	}else{
		$(this).addClass('active');
		$('.shop_menu-sort-price').removeClass('active');
		$(".shop_menu_block").html(
				$(".shop_menu_block-item").sort(function(a, b) {
						return $(b).attr('data-time') - $(a).attr('data-time');
				})
		);				 
	}
});



$( function() {
		var $signupForm = $( '#reserve_form' );

		$signupForm.validate({
				errorElement: 'em',
				submitHandler: function (form) {
					form.submit();
				}
		});

		$signupForm.formToWizard({
				submitButton: 'SaveAccount',
				nextBtnClass: 'btn btn-item next',
				prevBtnClass: 'btn btn-item prev',
				buttonTag:    'button',
				validateBeforeNext: function(form, step) {
						var stepIsValid = true;
						var validator = form.validate();
						$(':input', step).each( function(index) {
								var xy = validator.element(this);
								stepIsValid = stepIsValid && (typeof xy == 'undefined' || xy);
						});
						return stepIsValid;
				},
				progress: function (i, count) {
						$('#progress-complete').width(''+(i/count*100)+'%');
				}
		});
});