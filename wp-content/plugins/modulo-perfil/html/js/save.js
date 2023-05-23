jQuery(document).ready(function($){

	$('#edit_profile .save').hide();
	$('#edit_profile .edit').on('click', function(){
		$('#edit_profile .input').removeClass('disabled').addClass('enable').removeAttr('readonly');
		$(this).hide();
		$('#edit_profile .save').show();
	});

	$('#edit_profile .save').on('click', function(){

		$(this).parent().append('<p class="sucess">Salvando dados...</p>');


		var data = $(this).parent().serialize();
		$.ajax({

			type      : 'post',
			url       : TaoAjaxSaveProfile.ajaxSaveProfile,
			data      : data,
			dataType  : 'html',
			success	  : function(retorno) {

				$('#edit_profile .input').removeClass('enable').addClass('disabled').attr('readonly', 'readonly');
				$('#edit_profile .save').hide();
				$('#edit_profile .edit').show();
				
				setTimeout(function() {
					$('#edit_profile .sucess').fadeOut();
				}, 1500);
				
				if( retorno == "reloggin" ){
					alert("Favor faça o login novamente \ncom sua nova senha!");
					window.location.href = TaoAjaxSaveProfile.url;
				}
					
			}
			
		});
	});

});