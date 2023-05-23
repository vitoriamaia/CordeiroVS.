function validate(form)
{
    jQuery(form+' :input').each(function(){
        /* required */
        if ( jQuery(this).hasClass('required') && jQuery.trim( jQuery(this).val() ) == ""){
            jQuery(this).addClass('invalid');
            jQuery(this).focus();
            validateState = false; 
            return false;
        }
        else{
            jQuery(this).removeClass('invalid');
            validateState = true;
        }
		
        /* mail */
        if ( jQuery(this).hasClass('email') ){
            var er = new RegExp(/^[A-Za-z0-9_\-\.]+@[A-Za-z0-9_\-\.]{2,}\.[A-Za-z0-9]{2,}(\.[A-Za-z0-9])?/);
            if (!er.test(jQuery.trim( jQuery(this).val() ))){
                 jQuery(this).addClass('invalid');
                 jQuery(this).focus();
				 jQuery('#validate_message').html(validateMailMsg);
                 validateState = false;
                 return false;
            }
            else{
                jQuery(this).removeClass('invalid');
                validateState = true;
            }
        } 

    })
}


jQuery(document).ready(function($){
	$('#tao-form .save').on('click', function(){
		validate('#tao-form');
		if(validateState){
			$('#tao-form').append('<p class="sucess">Enviando...</p>');
			$.ajax({
			type      : 'post',
			url       : TaoAjax.ajaxSave,
			data      : $("#tao-form").serialize(),
			dataType  : 'html',
			success	  : function() {
				$('#tao-form .sucess').text('Enviado com sucesso');
				$('#tao-form input[type="text"], #tao-form input[type="email"]').val('');
				setTimeout(function() {
					$('#tao-form .sucess').fadeOut();
				}, 1500);
			}
			});
		}
    });
});