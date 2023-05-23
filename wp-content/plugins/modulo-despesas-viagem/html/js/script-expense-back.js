jQuery(document).ready(function($){
	
	$('.cadastrar').on('click', function(t){
		t.preventDefault();
		$('.form-expense').fadeToggle();
	});
	
	$( "#data_ida" ).datepicker({
		changeMonth: true,
        changeYear: true,
		onClose: function( selectedDate ) {
			$( "#data_volta" ).datepicker( "option", "minDate", selectedDate );
		}
	});
	
	$( "#data_volta" ).datepicker({
		changeMonth: true,
        changeYear: true,
		onClose: function( selectedDate ) {
			$( "#data_ida" ).datepicker( "option", "maxDate", selectedDate );
		}
	});
	
	$( "#data_cat" ).datepicker({
		changeMonth: true,
        changeYear: true,
	});
	
	$( ".expense .edit" ).on('click', function(t){
		t.preventDefault();
		$(this).hide();
		$(this).parent().children('.salvar').css('display', 'inline-block');
		$(this).parent().children('#categoria').removeAttr('readonly');
	});
	
	$( ".itens_despesa_title .edit" ).on('click', function(t){
		t.preventDefault();
		$(this).hide();
		$(this).parent().children('.salvar').css('display', 'inline-block');
		$(this).parent().find('.item_despesa').removeAttr('readonly');
		$(this).parent().find('.readonly').attr('readonly', 'readonly');
	});
	
	$( ".expense .salvar, .itens_despesa_title .salvar" ).on('click', function(t){
		t.preventDefault();
		$(this).parent().submit();
	});
	
	$( ".printer" ).on('click', function(t){
		t.preventDefault();
		window.print();
	});
	
	$(document).ready(function(){
		$('.expense-table').dataTable({ 
			"paging": false,
			"language": {
            	"url": TaoExt.url_plugin+"/html/languages/pt_BR.txt"
        	} 
		});
	});
	
});